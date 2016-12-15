<?php
/**
* Guest Vertion1.0
* ================================================
* Copy 2010-2016 QLC
* Author DWL
* Date 2016-9-23
*/
//防止恶意调用
if(!defined('IN_H')) {
	exit('Access Denied!');
}
define("ROOT_PATH",substr(dirname(__FILE__),0,-8));//转换硬路径并定义为常量:提高性能
//拒绝低版本
if (PHP_VERSION < '4.1.0') {
	exit('版本太低！');
}
//引入函数库
require  ROOT_PATH.'includes/global.func.php';
require  ROOT_PATH.'includes/mysql.func.php';
define("START_TIME", _runtime());//执行耗时
//$_GLOBALS['start_time']=_runtime();
// usleep(2000000);
//数据库连接
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', 'JGdwl19871992');
define('DB_NAME', 'testguest');
_connect();
_select_db();
_set_names(); 
//短信提醒
$_message=_fetch_array("SELECT COUNT(tg_id) AS count FROM tg_message WHERE tg_state=0 AND tg_touser='{$_COOKIE['username']}'");
if (empty($_message['count'])) {
	$_message_html='<strong class="noread"><a href="member_message.php">(0)</a></strong>';
} else {
	$_message_html='<strong class="read"><a href="member_message.php">('.$_message['count'].')</a></strong>';
}
//网站系统初始化
//读取tg_system
if (!!$_rows=_fetch_array("SELECT tg_webname,tg_article,tg_blog,tg_photo,tg_skin ,tg_string,tg_post,tg_reply,tg_code,tg_register FROM tg_system WHERE tg_id=1 LIMIT 1")) {
	$_system=array();
	$_system['webname']=$_rows['tg_webname'];
	$_system['article']=$_rows['tg_article'];
	$_system['blog']=$_rows['tg_blog'];
	$_system['photo']=$_rows['tg_photo'];
	$_system['skin']=$_rows['tg_skin'];
	$_system['string']=$_rows['tg_string'];
	$_system['post']=$_rows['tg_post'];
	$_system['reply']=$_rows['tg_reply'];
	$_system['code']=$_rows['tg_code'];
	$_system['register']=$_rows['tg_register'];
	$_system=_html($_system);
	//如果有skin的COOKIE就替代系统数据库的皮肤
	if ($_COOKIE['skin']) {
		$_system['skin']=$_COOKIE['skin'];
	}
} else {
	_alert_back('系统表异常！请管理员检查！');
}
?>
