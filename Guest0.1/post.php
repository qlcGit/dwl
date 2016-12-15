<?php
/**
* Guest Vertion1.0
* ================================================
* Copy 2010-2016 QLC
* Author DWL
* Date 2016-9-23
*/
session_start();
define('IN_H',true);
define('SCRIPT',substr(basename(__FILE__),0,-4));
require dirname(__FILE__).'/includes/common.inc.php';
//判断是否登录
if (!isset($_COOKIE['username'])) {
	_location('发帖前请先登录!','login.php');
}
//将帖子写入数据库
if ($_GET['action']=='post') {
	_check_code($_POST['yzm'],$_SESSION['code']);
	if (!!$_rows = _fetch_array("SELECT tg_uniqid,tg_post_time FROM tg_user WHERE tg_username='{$_COOKIE['username']}'  LIMIT 1")) {
		_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
		//验证规定发帖时间
		_timed(time(),$_rows['tg_post_time'],$_system['post']);
		include ROOT_PATH.'includes/check.func.php';
		$_clean=array();
		$_clean['username']=$_COOKIE['username'];
		$_clean['type']=$_POST['type'];
		$_clean['title']= _check_post_title($_POST['title'],2,40);
		$_clean['content']=_check_post_content($_POST['content'],10);
		$_clean=_mysql_string($_clean);
		_query("INSERT INTO tg_article (
											tg_username,
											tg_type,
											tg_title,
											tg_content,
											tg_date
										) 
								VALUES (
											'{$_clean['username']}',
											'{$_clean['type']}',
											'{$_clean['title']}',
											'{$_clean['content']}',
											NOW()
										)"
		);
		if (_affected_rows() == 1) {
			//获取刚刚新增的ID
			$_clean['id']=_insert_id();
			$_clean['time']=time();
			_query("UPDATE tg_user SET tg_post_time='{$_clean['time']}' WHERE tg_username='{$_COOKIE['username']}'");
			_close();
			_location('帖子发表成功!','article.php?id='.$_clean['id']);
		} else {
			_close();
			_alert_back('帖子发表失败!');
		}
	}
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
	<h2>发表帖子</h2>
	<form action="?action=post" name="post" method="post">
		<dl>
			<dt>请认真填写内容</dt>
			<dd>
				类　　型：
				<?php 
					foreach (range(1,20) as $_num) {
						if ($_num==1) {
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
			<dd>标　　题：<input type="text" name="title" class="text">　(*必填，2-40位)</dd>
			<dd id="q">贴　　图：　<a href="javascript:;">Ｑ图系列[1]</a>　<a href="javascript:;">Ｑ图系列[1]</a>　<a href="javascript:;">Ｑ图系列[1]</a></dd>
			<dd>
				<?php include ROOT_PATH.'includes/ubb.inc.php';?>
				<textarea name="content" rows="9"></textarea>
			</dd>
			<dd><span>验证码:</span><input type="text" name="yzm" class="text yzm">　<img src="code.php" id="code">　<input type="submit" class="submit" value="发表帖子"></dd>
		</dl>
	</form>
</div>
<?php require ROOT_PATH.'includes/footer.inc.php';?>	
</body>
</html>