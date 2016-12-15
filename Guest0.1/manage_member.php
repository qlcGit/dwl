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
define('SCRIPT',substr(basename(__FILE__),0,-4));//定义常量用来指定本页的内容
require dirname(__FILE__).'/includes/common.inc.php';//引入公共文件
//删除会员
if ($_GET['action']=='del' && isset($_GET['id'])) {
	if (!!$_rows = _fetch_array("SELECT tg_uniqid,tg_username FROM tg_user WHERE tg_username='{$_COOKIE['username']}'  LIMIT 1")) {
		//为了防止COOKIE伪造还要比对唯一标识符
		_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
		$_rows = _fetch_array("SELECT tg_username FROM tg_user WHERE tg_id='{$_GET['id']}' LIMIT 1");
		if ($_rows['tg_username'] == $_COOKIE['username']) {
			_location('不能删除自己!','?');
		} else {
			_query("DELETE FROM tg_user WHERE tg_id='{$_GET['id']}'");
			_close();
			_location('会员删除成功!',$_SERVER["HTTP_REFERER"]);
		}
	} else {
		_alert_back('非法登录!');
	}
}
_manage_login();//必须是管理员才能登录
_page("SELECT tg_id FROM tg_user",15);//分页模块调用
//读取数据
$_result=_query("SELECT tg_id,tg_username,tg_email,tg_reg_time FROM tg_user ORDER BY tg_reg_time DESC LIMIT $_pagenum,$_pagesize");
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
	<?php require ROOT_PATH.'includes/manage.inc.php';?>
	<div id="member_main">
		<h2>会员列表中心</h2>
		<form action="?action=delete" method="post">
			<table>
				<tr><th>ID</th><th>会员名</th><th>邮件</th><th>注册时间</th><th>操作</th></tr>
<?php 
	$_html=array();
	while (!!$_rows=_fetch_array_list($_result)) {
		$_html['id']=$_rows['tg_id'];
		$_html['username']=$_rows['tg_username'];
		$_html['email']=$_rows['tg_email'];
		$_html['reg_time']=$_rows['tg_reg_time'];
		$_html=_html($_html);
?>
				<tr><td><?php echo $_html['id'];?></td><td><?php echo $_html['username'];?></td><td><?php echo $_html['email'];?></td><td><?php echo $_html['reg_time'];?></td><td>[ <a href="?action=del&id=<?php echo $_html['id']?>" onclick="return confirm('你真的要删除吗？') ? true : false;">删</a> ]</td></tr>
<?php }?>
			</table>
		</form>
		<?php
			_free_result($_result);
			_paging(2);
		?>
	</div>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>	
</body>
</html>