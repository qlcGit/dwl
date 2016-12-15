<?php
/**
* Guest Vertion1.0
* ================================================
* Copy 2010-2016 QLC
* Author DWL
* Date 2016-10-02
*/
session_start();
define('IN_H',true);//定义常量用来授权调用includes里的文件
define('SCRIPT','member_message');//定义常量用来指定本页的内容
require dirname(__FILE__).'/includes/common.inc.php';//引入公共文件
//判断是否登录
if (!isset($_COOKIE['username'])) {
	_location('请先登录!','login.php');
}
//批删除短信模块
if ($_GET['action']=='delete' && isset($_POST['ids'])) {
	$_clean=array();
	$_clean['ids']=_mysql_string(implode(',',$_POST['ids']));
	if (!!$_rows = _fetch_array("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}'")) {	
		_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);//为了防止COOKIE伪造还要比对唯一标识符
		_query("DELETE FROM tg_message WHERE tg_id IN ({$_clean['ids']})");
		if (_affected_rows()) {
			_close();
			_location('删除成功!','member_message.php');
		} else {
			_close();
			_alert_back('删除失败!');
		}
	} else {
		_alert_back('非法登录!');
	}
}
_page("SELECT tg_id FROM tg_message WHERE tg_touser='{$_COOKIE['username']}'",15);//分页模块调用
//从数据库提取数据获取结果集
$_result=_query("SELECT tg_id,tg_fromuser,tg_content,tg_date,tg_state FROM tg_message WHERE tg_touser='{$_COOKIE['username']}' ORDER BY tg_date DESC LIMIT $_pagenum,$_pagesize");
?>
<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="UTF-8">
<?php require ROOT_PATH.'includes/title.inc.php';?> 
<script src="js/member_message.js"></script>
</head>
<body>
<?php require ROOT_PATH.'includes/header.inc.php';?>
<div id="member">
	<?php require ROOT_PATH.'includes/member.inc.php';?>
	<div id="member_main">
		<h2>短信管理中心</h2>
		<form action="?action=delete" method="post">
			<table>
				<tr><th>发信人</th><th>短信内容</th><th>时间</th><th>状态</th><th>操作</th></tr>
<?php 
	$_html=array();
	while (!!$_rows=_fetch_array_list($_result)) {
		$_html['id']=$_rows['tg_id'];
		$_html['fromuser']=$_rows['tg_fromuser'];
		$_html['content']=$_rows['tg_content'];
		$_html['date']=$_rows['tg_date'];
		$_html=_html($_html);
		if (empty($_rows['tg_state'])) {
			$_html['state']='<img src="images/read.gif" alt="未读" title="未读">';
			$_html['content_html']='<strong>'._title($_html['content'],18).'</strong>';
		} else {
			$_html['state']='<img src="images/noread.gif" alt="已读" title="已读">';
			$_html['content_html']=_title($_html['content'],18);
		}
		
?>
				<tr><td><?php echo $_html['fromuser'];?></td><td><a href="member_message_detail.php?id=<?php echo $_html['id'];?>" title="<?php echo $_html['content'];?>"><?php echo $_html['content_html'];?></a></td><td><?php echo $_html['date'];?></td><td><?php echo $_html['state'];?></td><td><input type="checkbox" name="ids[]" value="<?php echo $_html['id'];?>"></td></tr>
<?php 
	}
	_free_result($_result);
?>
				<tr><td colspan="5">全选　<input type="checkbox" name="chkall" id="all">　<input type="submit" value="批删除"></td></tr>
			</table>
		</form>
		<?php _paging(2);?> 
	</div>
</div>
<?php require ROOT_PATH.'includes/footer.inc.php';?>
</body>
</html>