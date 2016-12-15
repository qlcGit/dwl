 <?php
/**
* Guest Vertion1.0
* ================================================
* Copy 2010-2016 QLC
* Author DWL
* Date 2016-9-28
*/
session_start();
define('IN_H',true);//定义常量用来授权调用includes里的文件
define('SCRIPT',substr(basename(__FILE__),0,-4));//定义常量用来指定本页的内容
require dirname(__FILE__).'/includes/common.inc.php';//引入公共文件
//判断是否登录
if (!isset($_COOKIE['username'])) {
	_location('请先登录!','login.php');
}
//删除留言
if ($_GET['action']=='delete') {
	_query("DELETE FROM tg_word WHERE id='{$_GET['id']}' LIMIT 1");
	if (_affected_rows() == 1) {
		_close();
		_location('删除留言成功!','?');
	} else {
		_close();
		_alert_back('删除留言失败!');
	}
}
//留言处理
if ($_GET['action']=='word') {
	_check_code($_POST['yzm'],$_SESSION['code']);//验证码防止恶意注册、跨站攻击
	if (!!$_rows = _fetch_array("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}' LIMIT 1")) {
		_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);//为了防止COOKIE伪造还要比对唯一标识符
		include ROOT_PATH.'includes/check.func.php';//引入文件
		$_clean=array();
		$_clean['touser']=$_POST['touser'];
		$_clean['fromuser']=$_COOKIE['username'];
		$_clean['content']=_check_content($_POST['content']);
		$_clean=_mysql_string($_clean);
		//写入表
		_query("INSERT INTO tg_word (touser,fromuser,content,date) VALUES ('{$_clean['touser']}','{$_clean['fromuser']}','{$_clean['content']}',NOW())");
		if (_affected_rows() == 1) {
			_close();
			_location('留言成功!','?');
		} else {
			_close();
			_alert_back('留言失败!');
		}
	} else {
		_alert_close('非法登录!');
	}	
}
//读取数据
_page("SELECT id FROM tg_word",10);//分页模块调用
//从数据库提取数据获取结果集
$_rows=_fetch_array("SELECT tg_username FROM tg_user WHERE tg_id='{$_GET['id']}' LIMIT 1");
$_result=_query("SELECT id,fromuser,touser,content,date FROM tg_word ORDER BY date DESC LIMIT $_pagenum,$_pagesize");
?>
<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="UTF-8">
<?php require ROOT_PATH.'includes/title.inc.php';?> 
<script src="js/code.js"></script>
<script src="js/guest.js"></script>
</head>
<body>
<?php require ROOT_PATH.'includes/header.inc.php';?>
<div id="guest">
	<h2>留言详情</h2>
	<table>
		<tr><th>From</th><th>To</th><th>留言内容</th><th>时间</th><th>操作</th></tr>
<?php 
	$_html=array();
	$_html['touser']=$_rows['tg_username'];
	while (!!$_rows=_fetch_array_list($_result)) {
		$_html['id']=$_rows['id'];
		$_html['from']=$_rows['fromuser'];
		$_html['to']=$_rows['touser'];
		$_html['content']=$_rows['content'];
		$_html['content_html']=_title($_html['content'],30);
		$_html['date']=$_rows['date'];
		$_html=_html($_html);
		if ($_COOKIE['username']==$_html['from']) {
			$_html_op='<a href="?action=delete&id='.$_html['id'].'" id="delete">删除</a>';
		} else {
			$_html_op='无权操作';
		}
?>
		<tr><td><?php echo $_html['from'];?></td><td><?php echo $_html['to'];?></td><td><a href="javascript:;" title="<?php echo $_html['content'];?>"><?php echo $_html['content_html'];?></a></td><td><?php echo $_html['date'];?></td><td><?php echo $_html_op;?></td></tr>
<?php }?>
	</table>
	<?php 
	_free_result($_result);
	_paging(2); 
	?> 
	<form action="?action=word" method="post">
		<input type="hidden" name="touser" value="<?php echo $_html['touser'];?>">
		<dl>
			<dd><input type="text" class="text" readonly="readonly" value="To：<?php echo $_html['touser'];?>"></dd>
			<dd>留　言：<textarea name="content" autofocus></textarea></dd>
			<dd>验 证 码：<input type="text" name="yzm" class="text yzm"><img src="code.php" id="code">　<input type="submit" class="submit" value="发送"></dd>
		</dl>
	</form>
</div>
<?php require ROOT_PATH.'includes/footer.inc.php';?>
</body>
</html>