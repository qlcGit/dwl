<?php
/**
* Guest Vertion1.0
* ================================================
* Copy 2010-2016 QLC
* Author DWL
* Date 2016-9-23
*/
session_start();
define('IN_H',true);//定义常量用来授权调用includes里的文件
define('SCRIPT',substr(basename(__FILE__),0,-4));//定义常量用来指定本页的内容
require dirname(__FILE__).'/includes/common.inc.php';//引入公共文件
//判断是否登录
if (!isset($_COOKIE['username'])) {
	_location('发帖前请先登录!','login.php');
}
//修改(还需判断权限和删除主题帖、回复贴自己做)
if ($_GET['action']=='modify') {
	_check_code($_POST['yzm'],$_SESSION['code']);//验证码防止恶意注册、跨站攻击
	if (!!$_rows = _fetch_array("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}'  LIMIT 1")) {
		_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);//为了防止COOKIE伪造还要比对唯一标识符
		include ROOT_PATH.'includes/check.func.php';//引入文件
		////接收数据开始修改
		$_clean=array();
		$_clean['id']=$_POST['id'];
		$_clean['type']=$_POST['type'];
		$_clean['title']= _check_post_title($_POST['title'],2,40);
		$_clean['content']=_check_post_content($_POST['content'],10);
		$_clean=_mysql_string($_clean);
		//执行SQL
		_query("UPDATE tg_article SET 
										tg_type='{$_clean['type']}',
										tg_title='{$_clean['title']}',
										tg_content='{$_clean['content']}',
										tg_last_modify=NOW()
								WHERE 
										tg_id='{$_clean['id']}'"
		);
		if (_affected_rows() == 1) {
			_close();
			_location('帖子修改成功!','article.php?id='.$_clean['id']);
		} else {
			_close();
			_alert_back('帖子修改失败!');
		}
	} else {
		_alert_back('非法登录!');
	}
}
//读取数据
if (isset($_GET['id'])) {
	if (!!$_rows=_fetch_array("SELECT tg_username,tg_type,tg_title,tg_content FROM tg_article WHERE tg_reid=0 AND tg_id='{$_GET['id']}'")) {
		$_html=array();
		$_html['id']=$_GET['id'];
		$_html['username']=$_rows['tg_username'];
		$_html['type']=$_rows['tg_type'];
		$_html['title']=$_rows['tg_title'];
		$_html['content']=$_rows['tg_content'];
		$_html=_html($_html);
		//判断权限
		if (!isset($_SESSION['admin'])) {
			if ($_COOKIE['username']!=$_html['username']) {
				_alert_back('你没有权限修改！');
			}
		}
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
<script src="js/post.js"></script>
</head>
<body>
<?php require ROOT_PATH.'includes/header.inc.php';?>
<div id="post">
	<h2>修改帖子</h2>
	<form action="?action=modify" name="modify" method="post">
		<input type="hidden" value="<?php echo $_html['id'];?>" name="id">
		<dl>
			<dt>请认真修改内容</dt>
			<dd>
				类　　型：
				<?php 
					foreach (range(1,20) as $_num) {
						if ($_num==$_html['type']) {
							echo '<label for="type'.$_num.'"><input type="radio" name="type" id="type'.$_num.'" value="'.$_num.'" checked="checked"></label> ';
						} else {
							echo '<label for="type'.$_num.'"><input type="radio" name="type" id="type'.$_num.'" value="'.$_num.'"> ';
						}
						echo '<img src="images/icon'.$_num.'.png" alt="类型"></label>　';
						if ($_num==10) {
							echo '<br />　　　　　 ';
						}
					} 
				?>
			</dd>
			<dd>标　　题：<input type="text" name="title" value="<?php echo $_html['title'];?>" class="text">　(*必填，2-40位)</dd>
			<dd id="q">贴　　图：　<a href="javascript:;">Ｑ图系列[1]</a>　<a href="javascript:;">Ｑ图系列[1]</a>　<a href="javascript:;">Ｑ图系列[1]</a></dd>
			<dd>
				<?php include ROOT_PATH.'includes/ubb.inc.php';?>
				<textarea name="content" rows="9"><?php echo $_html['content'];?></textarea>
			</dd>
			<dd><span>验证码:</span><input type="text" name="yzm" class="text yzm">　<img src="code.php" id="code">　<input type="submit" class="submit" value="修改帖子"></dd>
		</dl>
	</form>
</div>
<?php require ROOT_PATH.'includes/footer.inc.php';?>
</body>
</html>