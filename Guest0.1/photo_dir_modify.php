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
_manage_login();
if ($_GET['action']=='modify') {
	if (!!$_rows = _fetch_array("SELECT tg_uniqid,tg_reply_time FROM tg_user WHERE tg_username='{$_COOKIE['username']}'  LIMIT 1")) {
		_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
		include ROOT_PATH.'includes/check.func.php';
		//处理提交的修改数据
		$_clean=array();
		$_clean['id']=$_POST['id'];
		$_clean['name']=_check_dir_name($_POST['name'],2,40);
		$_clean['type']=$_POST['type'];
		if (!empty($_clean['type'])) {
			$_clean['password']=_check_dir_password($_POST['password'],6);
		}
		$_clean['cover']=$_POST['url'];
		$_clean['content']=$_POST['content'];
		$_clean=_mysql_string($_clean);
		//更新数据库
		if (empty($_clean[type])) {
			_query("UPDATE tg_dir SET tg_name='{$_clean['name']}',tg_type='{$_clean['type']}',tg_password=NULL,tg_cover='{$_clean['cover']}',tg_content='{$_clean['content']}' WHERE tg_id='{$_clean['id']}' LIMIT 1");
		} else {
			_query("UPDATE tg_dir SET tg_name='{$_clean['name']}',tg_type='{$_clean['type']}',tg_password='{$_clean['password']}',tg_cover='{$_clean['cover']}',tg_content='{$_clean['content']}' WHERE tg_id='{$_clean['id']}' LIMIT 1");
		}
		if (_affected_rows() == 1) {
			_close();
			_location('目录修改成功!','photo.php');
		} else {
			_close();
			_alert_back('目录修改失败!');
		}
	} else {
		_alert_back('非法登录!');
	}
}
//读取数据
if (isset($_GET['id'])) {
	if (!!$_rows=_fetch_array("SELECT tg_id,tg_name,tg_type,tg_cover,tg_content FROM tg_dir WHERE tg_id='{$_GET['id']}' LIMIT 1")) {
		$_html=array();
		$_html['id']=$_rows['tg_id'];
		$_html['name']=$_rows['tg_name'];
		$_html['type']=$_rows['tg_type'];
		$_html['cover']=$_rows['tg_cover'];
		$_html['content']=$_rows['tg_content'];
		$_html=_html($_html);
	} else {
		_alert_back('不存在此相册！');
	}
} else {
	_alert_back('非法操作！');
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
	<h2>修改相册目录</h2>
	<form action="?action=modify" method="post">
		<dl>
			<dd>相册名称：<input type="text" name="name" class="text" value="<?php echo $_html['name'];?>"></dd>
			<dd>相册类型：<input type="radio" name="type" value="0" <?php if ($_html['type']==0) echo 'checked="checked"'?>> 公开　<input type="radio" name="type" value="1" <?php if ($_html['type']==1) echo 'checked="checked"'?>> 私密</dd>
			<dd id="pass" <?php if ($_html['type']==1) echo 'style="display:block"'?>>相册密码：<input type="password" name="password" class="text"></dd>
			<dd>相册封面：<input type="text" name="url" id="url" class="text" value="<?php echo $_html['cover'];?>">　<a href="javascript:;" id="up">上传</a></dd>
			<dd>相册简介：<textarea name="content"><?php echo $_html['content'];?></textarea></dd>
			<dd><input type="submit" value="修改目录" class="submit"></dd>
		</dl>
		<input type="hidden" value="<?php echo $_html['id'];?>" name="id">
	</form>
</div>
<?php require ROOT_PATH.'includes/footer.inc.php';?>
</body>
</html>