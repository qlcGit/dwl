<?php
/**
* Guest Vertion1.0
* ================================================
* Copy 2010-2016 QLC
* Author DWL
* Date 2016-10-15
*/
session_start();
define('IN_H',true);//定义常量用来授权调用includes里的文件
define('SCRIPT',substr(basename(__FILE__),0,-4));//定义常量用来指定本页的内容
require dirname(__FILE__).'/includes/common.inc.php';//引入公共文件
_manage_login();//必须是管理员才能登录
?>
<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="UTF-8">
<?php require ROOT_PATH.'includes/title.inc.php';?>
</head>
<body>
<?php require ROOT_PATH.'includes/header.inc.php';?>
<div id="member">
	<?php require ROOT_PATH.'includes/manage.inc.php';?>
	<div id="member_main">
		<h2>后台管理中心</h2>
		<dl>
			<dd>服务器主机名称：<?php echo $_SERVER['SERVER_NAME']?></dd>
			<dd>服务器版本：<?php echo $_ENV['OS']?></dd>
			<dd>通信协议名称/版本：<?php echo $_SERVER['SERVER_PROTOCOL']?></dd>
			<dd>服务器IP：<?php echo $_SERVER['SERVER_ADDR']?></dd>
			<dd>客户端IP：<?php echo $_SERVER['REMOTE_ADDR']?></dd>
			<dd>服务器端口：<?php echo $_SERVER['SERVER_PORT']?></dd>
			<dd>客户端端口：<?php echo $_SERVER['REMOTE_PORT']?></dd>
			<dd>管理员邮箱：<?php echo $_SERVER['SERVER_ADMIN']?></dd>
			<dd>Host头部内容：<?php echo $_SERVER['HTTP_HOST']?></dd>
			<dd>服务器主目录：<?php echo $_SERVER['DOCUMENT_ROOT']?></dd>
			<dd>脚本执行的绝对路径：<?php echo $_SERVER['SCRIPT_FILENAME']?></dd>
			<dd>Apache及PHP版本：<?php echo $_SERVER['SERVER_SOFTWARE']?></dd>
		</dl>
	</div>
</div>
<?php require ROOT_PATH.'includes/footer.inc.php';?>
</body>
</html>
