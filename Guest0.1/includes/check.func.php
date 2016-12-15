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
//判断函数是否存在
if (!function_exists('_alert_back')) {
	exit('_alert_back()函数不存在,请检查!');
}
function _check_uniqid($_first_uniqid,$_end_uniqid) {
	// _alert_back($_first_uniqid.'\n'.$_end_uniqid);
	if (strlen($_first_uniqid) != 40 || ($_first_uniqid != $_end_uniqid)) {
		_alert_back('唯一标识符不一致');
	}
	return mysql_real_escape_string($_first_uniqid);
}
/**
* _check_username()检测并过滤用户名
* @access public
* @param string $_string:用户名
* @param int $_min_num:最小位数
* @param int $_max_num:最大位数
* @return string
*/
function _check_username($_string,$_min_num,$_max_num) {
	global $_system;
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
	//限制敏感用户名
	$_mg = explode('|',$_system['string']);
	foreach ($_mg as $value) {
		$_mg_string .= '['.$value.']'.'\n';
	}
	if (in_array($_string,$_mg)) {
		_alert_back($_mg_string.'以上敏感用户名不得注册!');
	}
	return mysql_real_escape_string($_string);
}
/**
* _check_password()验证密码
* @access public
* @param string $_first_pass
* @param string $_end_pass
* @param int $_min_num
* @return string $_first_pass返回一个加密后密码
*/
function _check_password($_first_pass,$_end_pass,$_min_num) {
	//判断密码
	if (strlen($_first_pass)<$_min_num) {
		_alert_back('密码不得小于'.$_min_num.'位!');
	}
	if ($_first_pass!=$_end_pass) {
		_alert_back('密码不一致!');
	}
	return mysql_real_escape_string(sha1($_first_pass));
}
//判断密码
function _check_modify_password($_string,$_min_num) {
	if (!empty($_string)) {
		if (strlen($_string)<$_min_num) {
		_alert_back('密码不得小于'.$_min_num.'位!');
		}
	} else {
		//返回null后密码栏才为空
		return null;
	}
	return mysql_real_escape_string(sha1($_string));
}
/**
* _check_question()密码提示函数
* @access public
* @param string  $_string
* @param int $_min_num
* @param int $_max_num
* @return string 返回密码提示
*/
function _check_question($_string,$_min_num,$_max_num) {
	$_string=trim($_string);
	//长度小于4位或大于20位
	if (mb_strlen($_string,'utf-8')<$_min_num || mb_strlen($_string,'utf-8')>$_max_num) {
		_alert_back('问题提示不得小于'.$_min_num.'位或大于'.$_max_num.'位');
	}
	return mysql_real_escape_string($_string);
}
function _check_answer($_ques,$_answ,$_min_num,$_max_num) {
	$_answ=trim($_answ);

	//长度小于4位或大于20位
	if (mb_strlen($_answ,'utf-8')<$_min_num || mb_strlen($_answ,'utf-8')>$_max_num) {
		_alert_back('密码回答不得小于'.$_min_num.'位或大于'.$_max_num.'位');
	}

	if ($_ques==$_answ) {
		_alert_back('密码提示与回答不得一致');
	}
	//加密返回
	return mysql_real_escape_string(sha1($_answ));
}
function _check_sex($_string) {
	return mysql_real_escape_string($_string);
}
function _check_face($_string) {
	return mysql_real_escape_string($_string);
}
/**
* _check_email检测邮件格式
* @access public
* @param string $_string
* @return string
*/
function _check_email($_string,$_min_num,$_max_num) {
	if (!preg_match('/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/',$_string)) {
		_alert_back('邮件格式不正确!');
	}
	if (strlen($_string)<$_min_num || strlen($_string)>$_max_num) {
		_alert_back('邮件长度不合法!');
	}
	return mysql_real_escape_string($_string);
}
/**
* _check_qq检测QQ格式
* @access public
* @param string $_string
* @return string
*/
function _check_qq($_string) {
	if (empty($_string)) {
		return null;
	} else {
		if (!preg_match('/^[1-9]{1}[0-9]{4,9}$/',$_string)) {
			_alert_back('QQ号码不正确');
		}
	}
	return mysql_real_escape_string($_string);
}
/**
* _check_url()网址验证
* @access public
* @param string $_string
* @return string
*/
function _check_url($_string,$_max_num) {
	if (empty($_string) || ($_string=='http://')) {
		return null;
	} else {
		if (!preg_match('/^http(s)?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/',$_string)) {
			_alert_back('URL不正确');
		}
		if (strlen($_string)>$_max_num) {
			_alert_back('URL太长');
		}
	}
	return mysql_real_escape_string($_string);
}
function _check_content($_string) {
	if (mb_strlen($_string,'utf-8')<10 || mb_strlen($_string,'utf-8')>200) {
		_alert_back('短信内容不得小于10位或者不得大于200位');
	}
	return $_string;
}
function _check_post_title($_string,$_min,$_max) {
	if (mb_strlen($_string,'utf-8')<$_min || mb_strlen($_string,'utf-8')>$_max) {
		_alert_back('帖子标题不得小于'.$_min.'位或者不得大于'.$_max.'位');
	}
	return $_string;
}
function _check_post_content($_string,$_num) {
	if (mb_strlen($_string,'utf-8')<$_num) {
		_alert_back('帖子内容不得小于'.$_num.'位');
	}
	return $_string;
}
function _check_post_autograph($_string,$_num) {
	if (mb_strlen($_string,'utf-8')>$_num) {
		_alert_back('回帖内容不得大于'.$_num.'位');
	}
	return $_string;
}
function _check_dir_name($_string,$_min,$_max) {
	if (mb_strlen($_string,'utf-8')<$_min || mb_strlen($_string,'utf-8')>$_max) {
		_alert_back('名称不得小于'.$_min.'位或不得大于'.$_max.'位');
	}
	return $_string;
}
function _check_dir_password($_string,$_min) {
	if (strlen($_string)<$_min_num) {
		_alert_back('密码不得小于'.$_min_num.'位!');
	}
	return sha1($_string);
}
function _check_img_url($_string) {
	if (empty($_string)) {
		_alert_back('地址不得为空！');
	}
	return $_string;
}
?>