<?php
/**
* Guest Vertion1.0
* ================================================
* Copy 2010-2016 QLC
* Author DWL
* Date 2016-9-28
*/
session_start();
define('IN_H',true);
define('SCRIPT',substr(basename(__FILE__),0,-4));
require dirname(__FILE__).'/includes/common.inc.php';
_manage_login();//必须是管理员才能登录
//添加目录
if ($_GET['action']=='adddir') {
	if (!!$_rows = _fetch_array("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}'")) {	
		_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
		include ROOT_PATH.'includes/check.func.php';
		$_clean=array();
		$_clean['name']=_check_dir_name($_POST['name'],2,40);
		$_clean['type']=$_POST['type'];
		if (!empty($_clean['type'])) {
			$_clean['password']=_check_dir_password($_POST['password'],6);
		}
		$_clean['content']=$_POST['content'];
		$_clean['cover']=$_POST['url'];
		$_clean['dir']=time();
		$_clean=_mysql_string($_clean);
		//先检查主目录是否存在
		if (!is_dir('photo')) {
			mkdir('photo',0777);
		}
		//在主目录里创建相册目录
		if (!is_dir('photo/'.$_clean['dir'])) {
			mkdir('photo/'.$_clean['dir']);
		}
		//把当前目录信息写入数据库
		if (empty($_clean[type])) {
			_query("INSERT INTO tg_dir (tg_name,tg_type,tg_content,tg_cover,tg_dir,tg_date) VALUES ('{$_clean['name']}','{$_clean['type']}','{$_clean['content']}','{$_clean['cover']}','photo/{$_clean['dir']}',NOW())");
		} else {
			_query("INSERT INTO tg_dir (tg_name,tg_type,tg_password,tg_content,tg_cover,tg_dir,tg_date) VALUES ('{$_clean['name']}','{$_clean['type']}','{$_clean['password']}','{$_clean['content']}','{$_clean['cover']}','photo/{$_clean['dir']}',NOW())");
		}
		if (_affected_rows() == 1) {
			_close();
			_location('目录添加成功!','photo.php');
		} else {
			_close();
			_alert_back('目录添加失败!');
		}
	} else {
		_alert_back('非法登录!');
	}
}
?>
<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="UTF-8">
<?php require ROOT_PATH.'includes/title.inc.php';?>
<script src="js/photo_add_dir.js"></script>
</head>
<body>
<?php require ROOT_PATH.'includes/header.inc.php';?>
<div id="photo">
	<h2>添加相册目录</h2>
	<form action="?action=adddir" method="post">
		<dl>
			<dd>相册名称：<input type="text" name="name" class="text"></dd>
			<dd>相册类型：<input type="radio" name="type" value="0" checked="checked"> 公开　<input type="radio" name="type" value="1"> 私密</dd>
			<dd>相册封面：<input type="text" readonly="readonly" name="url" id="url" class="text">　<a href="javascript:;" id="up">上传</a></dd>
			<dd id="pass">相册密码：<input type="password" name="password" class="text"></dd>
			<dd>相册简介：<textarea name="content"></textarea></dd>
			<dd><input type="submit" value="添加目录" class="submit"></dd>
		</dl>
	</form>
</div>
<?php require ROOT_PATH.'includes/footer.inc.php';?>
</body>
</html>