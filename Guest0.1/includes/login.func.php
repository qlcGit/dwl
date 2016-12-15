<?php
/**
* Guest Vertion1.0
* ================================================
* Copy 2010-2016 QLC
* Author DWL
* Date 2016-9-28
*/
//防止恶意调用
if(!defined('IN_H')) {
	exit('Access Denied!');
}
//判断函数是否存在
if (!function_exists('_alert_back')) {
	exit('_alert_back()函数不存在,请检查!');
}
//生成登录cookie
function _setcookies($_username,$_uniqid,$_time) {
	switch ($_time) {
		case '0'://浏览器进程
			setcookie('username',$_username);
			setcookie('uniqid',$_uniqid);
			break;
		case '1'://一天
			setcookie('username',$_username,time()+86400);
			setcookie('uniqid',$_uniqid,time()+86400);
			break;
		case '2'://一周
			setcookie('username',$_username,time()+604800);
			setcookie('uniqid',$_uniqid,time()+604800);
			break;
		case '3'://一月
			setcookie('username',$_username,time()+2592000);
			setcookie('uniqid',$_uniqid,time()+2592000);
			break;	
	}
}
//检验用户名
function _check_username($_string,$_min_num,$_max_num) {
	//去掉两边空格
	$_string=trim($_string);
	//长度小于4位或大于20位
	if (mb_strlen($_string,'utf-8')<$_min_num || mb_strlen($_string,'utf-8')>$_max_num) {
		_alert_back('用户名长度不得小于'.$_min_num.'位或大于'.$_max_num.'位');
	}
	//限制敏感字符
	$_char_pattern = '/[<>\'\"\ ]/';
	if (preg_match($_char_pattern,$_string)) {
		_alert_back('用户名不得包含敏感字符!');
	}
	return mysql_real_escape_string($_string);
}
//检验用户密码
function _check_password($_string,$_min_num) {
	//判断密码
	if (strlen($_string)<$_min_num) {
		_alert_back('密码不得小于'.$_min_num.'位!');
	}

	return sha1($_string);
}
//检验用户有效期
function _check_time($_string) {
	$_time = array('0','1','2','3');
	if (!in_array($_string, $_time)) {
		_alert_back('保留方式不正确');
	}
	return $_string;
}
?>