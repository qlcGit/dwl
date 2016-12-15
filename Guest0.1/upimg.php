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
//必须是会员才能进入
if (!$_COOKIE['username']) {
	_alert_back("必须是会员才能进入！");
}
//执行上传图片功能
if ($_GET['action']=='up') {
	if (!!$_rows = _fetch_array("SELECT tg_uniqid,tg_reply_time FROM tg_user WHERE tg_username='{$_COOKIE['username']}'  LIMIT 1")) {
		_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
		//设置上传图片的类型
		$_files=array('image/jpeg','image/pjpeg','image/png','image/x-png','image/gif');
		//判断类型是否是数组里的一种
		if (is_array($_files)) {
			if (!in_array($_FILES['userfile']['type'],$_files)) {
				_alert_back('上传图片必须是jpg、png、gif中的一种');
			}
		}
		//判断文件错误类型
		if ($_FILES['userfile']['error']>0) {
			switch ($_FILES['userfile']['error']) {
				case 1:_alert_back('超过系统设定的大小');
					break;
				case 2:_alert_back('超过MAX_FILE_SIZE 选项指定的值');
					break;
				case 3:_alert_back('文件只有部分被上传');
					break;
				case 4:_alert_back('没有文件被上传');
					break;
			}
			exit;
		}
		//判断配置大小
		if ($_FILES['userfile']['size']>1000000) {
			_alert_back('上传文件不得超过1M');
			exit;
		}
		//获取文件扩展名
		$_n=explode('.',$_FILES['userfile']['name']);
		$_name=$_POST['dir'].'/'.time().'.'.$_n[1];
		//移动文件
		if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
			if (!@move_uploaded_file($_FILES['userfile']['tmp_name'],$_name)) {
				_alert_back('移动失败！');
			} else {
				//_alert_close('上传成功！');
				echo "<script>alert('上传成功！');window.opener.document.getElementById('url').value='$_name';window.close();</script>";
				exit();
			}
		} else {
			_alert_back('上传的临时文件不存在！');
		}
		
	} else {
		_alert_back('非法登录!');
	}
}
//接收dir
if (!isset($_GET['dir'])) {
	_alert_back('非法操作！');
}
?>
<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="UTF-8">
<?php require ROOT_PATH.'includes/title.inc.php';?>
</head>
<body>
<div id="upimg">
	<form enctype="multipart/form-data" action="?action=up" method="post">
		<input type="hidden" name="MAX_FILE_SIZE" value="1000000">
		<input type="hidden" name="dir" value="<?php echo $_GET['dir'];?>">
		选择图片：<input type="file" name="userfile">
		<input type="submit" value="上传">
	</form>
</div>
</body>
</html>