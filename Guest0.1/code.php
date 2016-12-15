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
require dirname(__FILE__).'/includes/common.inc.php';//引入公共文件
_code();//运行验证码函数
?>