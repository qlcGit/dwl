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
?>
<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="UTF-8">
<?php require ROOT_PATH.'includes/title.inc.php';?>
<script src="js/opener.js"></script>
</head>
<body>
<div id="face">
	<h3>选择头像</h3>
	<dl>
	<?php foreach (range(1, 9) as $number) {?>
	<dd><img src="images/face/m0<?php echo $number;?>.gif" alt="images/face/m0<?php echo $number;?>.gif" title="头像<?php echo $number;?>" ></dd>
	<?php }?>
</dl>
	<dl>
	<?php foreach (range(10, 64) as $number) {?>
	<dd><img src="images/face/m<?php echo $number;?>.gif" alt="images/face/m<?php echo $number;?>.gif" title="头像<?php echo $number;?>"</dd>
	<?php }?>
</dl>
</div>
</body>
</html>