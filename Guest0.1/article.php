 <?php
/**
* Guest Vertion1.0
* ================================================
* Copy 2010-2016 QLC
* Author DWL
* Date 2016-9-28
*/
session_start();
define('IN_H',true);//定义常量用来授权调用includes里的文件
define('SCRIPT',substr(basename(__FILE__),0,-4));//定义常量用来指定本页的内容
require dirname(__FILE__).'/includes/common.inc.php';//引入公共文件
//禁止回帖
if (isset($_POST['send'])) {
	if (!!$_rows = _fetch_array("SELECT tg_uniqid,tg_reply_time FROM tg_user WHERE tg_username='{$_COOKIE['username']}'  LIMIT 1")) {
		_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
		if ($_POST['username_sub'] == $_SESSION['admin'] && $_SESSION['admin'] == $_COOKIE['username']) {
			_alert_back('管理员不能禁止自己或其他管理员!');
		}
		if (!!_query("UPDATE tg_article SET tg_denyreply='{$_POST['deny']}' WHERE tg_username='{$_POST['username_sub']}'")) {
			_close();
			_location('允许回帖设置成功!','article.php?id='.$_POST['id']);
		} else {
			_close();
			_alert_back('禁止回帖设置失败!');
		}
	}
}
//删除主题帖以及回帖
if ($_GET['action']=='delete' && isset($_GET['id'])) {
	if (!!$_rows = _fetch_array("SELECT tg_uniqid,tg_reply_time FROM tg_user WHERE tg_username='{$_COOKIE['username']}'  LIMIT 1")) {
		_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
		_query("DELETE FROM tg_article WHERE tg_id='{$_GET['id']}' OR tg_reid='{$_GET['id']}'");
		if (!!_affected_rows()) {
			_close();
			_location('帖子删除成功!','index.php');
		} else {
			_close();
			_alert_back('帖子删除失败!');
		}
	} else {
		_alert_back('非法登录!');
	}
}
//处理精华帖
if ($_GET['action']=='nice' && isset($_GET['id'])) {
	if (!!$_rows = _fetch_array("SELECT tg_uniqid,tg_reply_time FROM tg_user WHERE tg_username='{$_COOKIE['username']}'  LIMIT 1")) {
		//为了防止COOKIE伪造还要比对唯一标识符
		_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
		//设置或取消精华帖
		_query("UPDATE tg_article SET tg_nice='{$_GET['on']}' WHERE tg_id='{$_GET['id']}'");
		if (_affected_rows() == 1) {
			_close();
			_location('精华帖操作成功!','article.php?id='.$_GET['id']);
		} else {
			_close();
			_alert_back('精华帖操作失败!');
		}
	} else {
		_alert_back('非法登录!');
	}
}
//处理回帖
if ($_GET['action']=='reply') {
	//验证码防止恶意注册、跨站攻击
	_check_code($_POST['yzm'],$_SESSION['code']);
	if (!!$_rows = _fetch_array("SELECT tg_uniqid,tg_reply_time FROM tg_user WHERE tg_username='{$_COOKIE['username']}'  LIMIT 1")) {
		_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);//为了防止COOKIE伪造还要比对唯一标识符
		_timed(time(),$_rows['tg_reply_time'],$_system['reply']);//验证规定发帖时间
		//接收数据
		$_clean=array();
		$_clean['reid']=$_POST['reid'];
		$_clean['type']=$_POST['type'];
		$_clean['title']=$_POST['title'];
		$_clean['content']=$_POST['content'];
		$_clean['username']=$_COOKIE['username'];
		$_clean=_mysql_string($_clean);
		//写入数据库
		_query("INSERT INTO tg_article (
											tg_reid,
											tg_username,
											tg_type,
											tg_title,
											tg_content,
											tg_date
										) 
								VALUES (
											'{$_clean['reid']}',
											'{$_clean['username']}',
											'{$_clean['type']}',
											'{$_clean['title']}',
											'{$_clean['content']}',
											NOW()
										)"
		);
		if (_affected_rows() == 1) {
			$_clean['time']=time();
			_query("UPDATE tg_user SET tg_reply_time='{$_clean['time']}' WHERE tg_username='{$_COOKIE['username']}'");
			_query("UPDATE tg_article SET tg_commentcount=tg_commentcount+1 WHERE tg_reid=0 AND tg_id='{$_clean['reid']}'");
			_close();
			//_session_destroy();
			_location('回帖发表成功!','article.php?id='.$_clean['reid']);
		} else {
			_close();
			//_session_destroy();
			_alert_back('回帖发表失败!');
		}
	} else {
		_alert_back('非法登录!');
	}
}
//读取数据
if (isset($_GET['id'])) {
	if (!!$_rows=_fetch_array("SELECT tg_id,tg_username,tg_denyreply,tg_type,tg_title,tg_content,tg_readcount,tg_commentcount,tg_nice,tg_last_modify,tg_date FROM tg_article WHERE tg_reid=0 AND tg_id='{$_GET['id']}'")) {
		//累计阅读量
		_query("UPDATE tg_article SET tg_readcount=tg_readcount+1 WHERE tg_id='{$_GET['id']}'");
		$_html=array();
		$_html['reid']=$_rows['tg_id'];
		$_html['username_sub']=$_rows['tg_username'];
		$_html['denyreply']=$_rows['tg_denyreply'];
		$_html['type']=$_rows['tg_type'];
		$_html['title']=$_rows['tg_title'];
		$_html['content']=$_rows['tg_content'];
		$_html['readcount']=$_rows['tg_readcount'];
		$_html['commentcount']=$_rows['tg_commentcount'];
		$_html['nice']=$_rows['tg_nice'];
		$_html['last_modify_date']=$_rows['tg_last_modify'];
		$_html['date']=$_rows['tg_date'];
		// $_html=_html($_html);
		//拿出用户名查找用户信息
		if (!!$_rows=_fetch_array("SELECT tg_id,tg_face,tg_switch,tg_autograph,tg_email,tg_url,tg_sex FROM tg_user WHERE tg_username='{$_html['username_sub']}'")) {
			//提取用户信息
			$_html['userid']=$_rows['tg_id'];
			$_html['face']=$_rows['tg_face'];
			$_html['switch']=$_rows['tg_switch'];
			$_html['autograph']=$_rows['tg_autograph'];
			$_html['email']=$_rows['tg_email'];
			$_html['url']=$_rows['tg_url'];
			$_html['sex']=$_rows['tg_sex'];
			$_html=_html($_html);
			//创建全局变量，做个带参的分页
			global $_id;
			$_id='id='.$_html['reid'].'&';
			//主题贴操作
			if ($_html['username_sub']==$_COOKIE['username'] || isset($_SESSION['admin'])) {
				$_html['sub_modify']='[<a href="article_modify.php?id='.$_html['reid'].'">修改</a>]';
				$_html['sub_delete']='[<a href="?action=delete&id='.$_html['reid'].'" id="deny">删除</a>]';
				if ($_html['denyreply'] == 0) {
					$_html['sub_denyreply']='<dd class="deny">回　帖：<input type="radio" name="deny" value="0" checked="checked">禁止 <input type="radio" name="deny" value="1">允许　<input type="submit" name="send" value="提交"></dd>';
				} elseif ($_html['denyreply'] == 1) {
					$_html['sub_denyreply']='<dd class="deny">回　帖：<input type="radio" name="deny" value="0">禁止 <input type="radio" name="deny" value="1" checked="checked">允许　<input type="submit" name="send" value="提交"></dd>';
				}
			}
			//读取最后修改信息
			if ($_html['last_modify_date']!='0000-00-00 00:00:00') {
				$_html['last_modify_date_string']='本帖已由 [ '.$_html['username_sub'].' ] 于 '.$_html['last_modify_date'].' 修改';
			}
			//给楼主回复
			if ($_COOKIE['username'] && $_html['denyreply']==1) {
				$_html['re']='<span>[ <a href="#ree" name="re" title="回复1楼的'.$_html['username_sub'].'">回复</a> ]</span>';
			}
			//个性签名
			if ($_html['switch']==1) {
				$_html['autograph_html']='<p class="autograph">'.$_html['autograph'].'</p>';
			}
			//读取回帖
			_page("SELECT tg_id FROM tg_article WHERE tg_reid='{$_html['reid']}'",$_system['article']);//分页模块调用
			//从数据库提取数据获取结果集
			$_result=_query("SELECT tg_username,tg_type,tg_title,tg_content,tg_date FROM tg_article  WHERE tg_reid='{$_html['reid']}' ORDER BY tg_date ASC LIMIT $_pagenum,$_pagesize");
		} else {
			//这个用户已被删除
			$_html['username_sub']=' 用户已被删除 ';
			$_html['autograph']=' 用户已被删除 ';
			$_html['email']='　用户已被删除';
			$_html['url']='　用户已被删除';
			$_html['sex']=' 秘密 ';
			$_html=_html($_html);
			_page("SELECT tg_id FROM tg_article WHERE tg_reid='{$_html['reid']}'",$_system['article']);//分页模块调用
			//从数据库提取数据获取结果集
			$_result=_query("SELECT tg_username,tg_type,tg_title,tg_content,tg_date FROM tg_article  WHERE tg_reid='{$_html['reid']}' ORDER BY tg_date ASC LIMIT $_pagenum,$_pagesize");
			//作业
			//7.帖子模糊搜索和精确查找
			//8.个人中心相册功能
		}	
	} else {
		_alert_back('主题不存在');
	}
} else {
	_alert_back('非法操作');
}
?>
<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="UTF-8">
<?php require ROOT_PATH.'includes/title.inc.php';?> 
<script src="js/code.js"></script>
<script src="js/article.js"></script>
</head>
<body>
<?php require ROOT_PATH.'includes/header.inc.php';?>
<div id="article">
	<h2>帖子详情</h2>
	<?php
		if (!empty($_html['nice'])) {
	?>
	<img src="images/nice.jpg" alt="精华帖" class="nice">
	<?php
		}
		if ($_html['readcount']>=400 && $_html['commentcount']>=20) {
	?>
	<img src="images/hot.jpg" alt="热帖" class="hot">
	<?php
		}
		if ($_page==1) {
	?>
	<div id="subject">
	    <form method="post" name="sub">
	    	<input type="hidden" value="<?php echo $_html['reid']?>" name="id">
	    	<input type="hidden" value="<?php echo $_html['username_sub'];?>" name="username_sub">
			<dl>
				<dd class="user"><?php echo $_html['username_sub'];?> (<?php echo $_html['sex'];?>) [楼主]</dd>
				<dt><img src="<?php echo $_html['face'];?>" alt="<?php echo $_html['username_sub'];?>"></dt>
				<dd class="message"><a href="javascript:;" name="message" title="<?php echo $_html['userid'];?>">发消息</a></dd>
				<dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $_html['userid'];?>">加为好友</a></dd>
				<?php
					if (!empty($_html['userid'])) {
				?>
				<dd class="guest"><a href="guest.php?id=<?php echo $_html['userid'];?>" name="guest" title="<?php echo $_html['userid'];?>">写留言</a></dd>
				<?php } else {?>
				<dd class="guest"><a href="javascript:;" name="guest" title="<?php echo $_html['userid'];?>">写留言</a></dd>
				<?php }?>
				<dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $_html['userid'];?>">给他送花</a></dd>
				<dd class="email">邮　件： <a href="mailto:<?php echo $_html['email'];?>"><?php echo $_html['email'];?></a></dd>
				<dd class="url">网　址： <a href="<?php echo $_html['url'];?>" target="_blank"><?php echo $_html['url'];?></a></dd>
				<?php echo $_html['sub_denyreply'];?>
			</dl>
		</form>
		<div class="content">
			<div class="user">
				<span>
					<?php
					if ($_SESSION['admin'] && !empty($_html['userid'])) {
						if (empty($_html['nice'])) {
					?>
						[ <a href="article.php?action=nice&on=1&id=<?php echo $_html['reid']?>">设置精华</a> ]
					<?php
						} else {?>
						[ <a href="article.php?action=nice&on=0&id=<?php echo $_html['reid']?>">取消精华</a> ]
					<?php 
						}
					}?>
					<?php echo $_html['sub_modify'];?>　<?php echo $_html['sub_delete'];?>　1#
				</span>
				<?php echo $_html['username_sub'];?>　|　发表于：<?php echo $_html['date'];?> 
			</div>
			<h3>主题：<?php echo $_html['title'];?>　<img src="images/icon<?php echo $_html['type'];?>.png" alt="icon">　<?php echo $_html['re'];?></h3>
			<div class="detail">
				<?php echo _ubb($_html['content']);?>
				<?php echo $_html['autograph_html'];?> 
			</div>
			<div class="read">
				<p><?php echo $_html['last_modify_date_string'];?></p>
				阅读量：(<?php echo $_html['readcount'];?>)　|　评论量：(<?php echo $_html['commentcount'];?>)
			</div>
		</div>
	</div>
	<?php }?>
	<p class="line"></p>
	<?php 
		$_i=2;
		while (!!$_rows=_fetch_array_list($_result)) {
			$_html['username']=$_rows['tg_username'];
			$_html['type']=$_rows['tg_type'];
			$_html['retitle']=$_rows['tg_title'];
			$_html['content']=$_rows['tg_content'];
			$_html['date']=$_rows['tg_date'];
			//拿出用户名查找用户信息
			if (!!$_rows=_fetch_array("SELECT tg_id,tg_face,tg_switch,tg_autograph,tg_email,tg_url,tg_sex FROM tg_user WHERE tg_username='{$_html['username']}'")) {
				//提取用户信息
				$_html['userid']=$_rows['tg_id'];
				$_html['face']=$_rows['tg_face'];
				$_html['switch']=$_rows['tg_switch'];
				$_html['autograph']=$_rows['tg_autograph'];
				$_html['email']=$_rows['tg_email'];
				$_html['url']=$_rows['tg_url'];
				$_html['sex']=$_rows['tg_sex'];
				$_html=_html($_html);
				//楼层
				if ($_page==1 && $_i==2) {
					if ($_html['username']==$_html['username_sub']) {
						$_html['username_html']=$_html['username'].' (楼主)';
					} else {
						$_html['username_html']=$_html['username'].' (沙发)';
					}
				} else {
					$_html['username_html']=$_html['username'];
				}
				//跟帖回复
				if ($_COOKIE['username'] && $_html['denyreply']==1) {
					$_html['re']='<span>[ <a href="#ree" name="re" title="回复'.($_i+($_page-1)*$_pagesize).'楼的'.$_html['username'].'">回复</a> ]</span>';
				}
			} else {
				$_html['username_html'] = ' 用户已被删除 '.' (沙发)';
				$_html['username']=' 此用户已不存在 ';
				$_html['sex']=' 未知 ';
			}
	?>
	<div class="reply">
		<dl>
			<dd class="user"><?php echo $_html['username_html'];?> (<?php echo $_html['sex'];?>)</dd>
			<dt><img src="<?php echo $_html['face'];?>" alt="<?php echo $_html['username'];?>"></dt>
			<dd class="message"><a href="javascript:;" name="message" title="<?php echo $_html['userid'];?>">发消息</a></dd>
			<dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $_html['userid'];?>">加为好友</a></dd>
			<?php
				if (!empty($_html['userid'])) {
			?>
			<dd class="guest"><a href="guest.php?id=<?php echo $_html['userid'];?>" name="guest" title="<?php echo $_html['userid'];?>">写留言</a></dd>
			<?php } else {?>
			<dd class="guest"><a href="javascript:;" name="guest" title="<?php echo $_html['userid'];?>">写留言</a></dd>
			<?php }?>
			<dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $_html['userid'];?>">给他送花</a></dd>
			<dd class="email">邮　件：<a href="mailto:<?php echo $_html['email'];?>"><?php echo $_html['email'];?></a></dd>
			<dd class="url">网　址：<a href="<?php echo $_html['url'];?>" target="_blank"><?php echo $_html['url'];?></a></dd>
		</dl>
		<div class="content">
			<div class="user">
				<span><?php echo $_i+($_page-1)*$_pagesize;?>#</span><?php echo $_html['username'];?>　|　发表于：<?php echo $_html['date'];?>
			</div>
			<h3>主题：<?php echo $_html['retitle'];?>　<img src="images/icon<?php echo $_html['type'];?>.png" alt="icon">　<?php echo $_html['re'];?></h3>
			<div class="detail">
				<?php echo _ubb($_html['content']);?>
				<?php 
					//个性签名
					if ($_html['switch']==1) {
						echo '<p class="autograph">'._ubb($_html['autograph']).'</p>';
					}
				?>
			</div>
		</div>
	</div>
	<p class="line"></p>
	<?php 
		$_i++;
	}
		_free_result($_result);
		_paging(1);
	?>
	<?php if (isset($_COOKIE['username']) && $_html['denyreply']==1 && !empty($_html['userid'])) {?>
	<a name="ree"></a>
	<form method="post" action="?action=reply">
		<input type="hidden" name="reid" value="<?php echo $_html['reid'];?>">
		<input type="hidden" name="type" value="<?php echo $_html['type'];?>">
		<dl>
			<dd>标　　题：<input type="text" name="title" class="text" value="RE：<?php echo $_html['title'];?>">　(*必填，2-40位)</dd>
			<dd id="q">贴　　图：　<a href="javascript:;">Ｑ图系列[1]</a>　<a href="javascript:;">Ｑ图系列[2]</a>　<a href="javascript:;">Ｑ图系列[3]</a></dd>
			<dd>
				<?php include ROOT_PATH.'includes/ubb.inc.php';?>
				<textarea name="content" rows="9"></textarea>
			</dd>
			<dd><span>验证码:</span><input type="text" name="yzm" class="text yzm">　<img src="code.php" id="code">　<input type="submit" class="submit" value="回复帖子"></dd>
		</dl>
	</form>
	<?php }?>
</div>
<?php require ROOT_PATH.'includes/footer.inc.php';?>
</body>
</html>