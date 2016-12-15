<?php
/**
* Guest Vertion1.0
* ================================================
* Copy 2010-2016 QLC
* Author DWL
* Date 2016-10-18
*/
define('IN_H',true);//定义常量用来授权调用includes里的文件
define('SCRIPT',substr(basename(__FILE__),0,-4));//定义常量用来指定本页的内容
require dirname(__FILE__).'/includes/common.inc.php';
$_skinurl=$_SERVER['HTTP_REFERER'];
//必须从上一页点击且传过来ID才可以
if (empty($_skinurl) || !isset($_GET['id'])) {
	_alert_back('非法操作！');
} else {
	//最好判断id必须是1、2、3中的一种
	//生成一个cookie用来保存皮肤的种类
	setcookie('skin',$_GET['id']);
	_location(null,$_skinurl);
}
?>