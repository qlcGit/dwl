<?php
/**
* Guest Vertion1.0
* ================================================
* Copy 2010-2016 QLC
* Author DWL
* Date 2016-9-27
*/
define('IN_H',true);//定义常量用来授权调用includes里的文件
define('SCRIPT',substr(basename(__FILE__),0,-4));//定义常量用来指定本页的内容
require dirname(__FILE__).'/includes/common.inc.php';//引入公共文件
//开始激活处理
if (!isset($_GET['active'])) {
	_alert_back('非法操作');
}
if (isset($_GET['action']) && isset($_GET['active']) && isset($_GET['action']) == 'ok') {
	$_active = mysql_real_escape_string($_GET['active']);
	if (_fetch_array("SELECT tg_active FROM tg_user WHERE tg_active='$_active' LIMIT 1")) {
		_query("UPDATE tg_user SET tg_active=NULL WHERE tg_active='$_active' LIMIT 1");
		if (_affected_rows() == 1) {
			_close();
			_location('账户激活成功','login.php');
		} else {
			_close();
			_location('账户激活失败','register.php');
		}
	} else {
		_alert_back('非法操作');
	}
}
?>
<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="UTF-8">
<?php require ROOT_PATH.'includes/title.inc.php';?>
</head>
<body>
<?php require ROOT_PATH.'includes/header.inc.php';?>
<div id="active">
	<h2>激活账户</h2>
	<p>本页面是为了模拟你的邮件的功能,点击超级链接激活的你的账户</p>
	<p><a href="active.php?action=ok&amp;active=<?php echo $_GET['active'];?>"><?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']?>?action=ok&amp;active=<?php echo $_GET['active'];?></a></p>
</div>
<?php require ROOT_PATH.'includes/footer.inc.php';?>
</body>
</html>