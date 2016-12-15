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
//数据库链接
function _connect() {
	global $_conn;//全局变量意图将此变量在函数外也能访问
	if (!$_conn=@mysql_connect(DB_HOST,DB_USER,DB_PASSWORD)) {
		exit('数据库连接失败');
	}
}
//选择数据库
function _select_db() {
	if (!mysql_select_db(DB_NAME)) {
		exit('指定数据库不存在');
	}
}
//选择字符集
function _set_names() {
	if (!mysql_query('SET NAMES UTF8')) {
		exit('字符集设置错误');
	}
}
//返回查找到的结果集
function _query($_sql) {
	if (!$_result=mysql_query($_sql)) {
		exit('SQL错误');
	}
	return $_result;
}
//提取关联结果
function _fetch_array($_sql) {
	return mysql_fetch_array(_query($_sql),MYSQL_ASSOC);
}
function _fetch_array_list($_result) {
	return mysql_fetch_array($_result,MYSQL_ASSOC);
}
//判断用户重复
function _is_repeat($_sql,$_info) {
	if (_fetch_array($_sql)) {
		_alert_back($_info);
	}
}
//关闭
function _close() {
	if (!mysql_close()) {
		exit('关闭异常');
	}
}
//数据库改变影响行数
function _affected_rows() {
	return mysql_affected_rows();
}
//销毁结果集
function _free_result($_result) {
	return mysql_free_result($_result);
}
function _num_rows($_result) {
	return mysql_num_rows($_result);
}
//获取刚刚新增的ID
function _insert_id() {
	return mysql_insert_id();
}
?>