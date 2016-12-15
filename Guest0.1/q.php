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
//开始初始化并判断是否提交数据
if (isset($_GET['num']) && isset($_GET['path'])) {
	if(!is_dir(ROOT_PATH.$_GET['path'])) {
		_alert_back('非法操作');
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
<script src="js/qopener.js"></script>
</head>
<body>
<div id="q">
	<h3>选择Q图</h3>
	<dl>
		<?php foreach (range(1, $_GET['num']) as $number) {?>
		<dd><img src="<?php echo $_GET['path'].Q.$number;?>.gif" alt="<?php echo $_GET['path'].Q.$number;?>.gif" title="头像<?php echo $number;?>" ></dd>
		<?php }?>
	</dl>
</div>
</body>
</html>