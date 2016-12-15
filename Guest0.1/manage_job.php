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
define('SCRIPT','manage_job');//定义常量用来指定本页的内容
require dirname(__FILE__).'/includes/common.inc.php';//引入公共文件
_manage_login();//必须是管理员才能登录
//判断是否提交数据并添加管理员
if ($_GET['action']=='add') {
	if (!!$_rows = _fetch_array("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}'")) {	
		_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);//为了防止COOKIE伪造还要比对唯一标识符
		$_clean=array();
		$_clean['username']=$_POST['manage'];
		$_clean=_mysql_string($_clean);	
		//更新
		_query("UPDATE tg_user SET tg_level=1 WHERE tg_username='{$_clean['username']}'");
		if (_affected_rows() == 1) {
			_close();
			_location('管理员添加成功!','manage_job.php');
		} else {
			_close();
			_alert_back('管理员添加失败!');
		}
	} else {
		_alert_back('非法登录!');
	}
}
//辞职
if ($_GET['action']=='job' && isset($_GET['id'])) {
	if (!!$_rows = _fetch_array("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}'")) {	
		_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);//为了防止COOKIE伪造还要比对唯一标识符
		_query("UPDATE tg_user SET tg_level=0 WHERE tg_id='{$_GET['id']}' AND tg_username='{$_COOKIE['username']}'");
		if (_affected_rows() == 1) {
			_close();
			_session_destroy();
			_location('辞职成功!','index.php');
		} else {
			_close();
			_alert_back('辞职失败!');
		}
	} else {
		_alert_back('非法登录!');
	}
}
_page("SELECT tg_id FROM tg_user WHERE tg_level=1",15);//分页模块调用
//读取数据
$_result=_query("SELECT tg_id,tg_username,tg_email,tg_reg_time FROM tg_user WHERE tg_level=1 ORDER BY tg_reg_time DESC LIMIT $_pagenum,$_pagesize");
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
		<h2>职务设置</h2>
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
					if ($_COOKIE['username']==$_html['username']) {
						$_job_html='<a href="?action=job&id='.$_html['id'].'">辞职</a>';
					} else {
						$_job_html='无权操作';
					}
			?>
			<tr><td><?php echo $_html['id'];?></td><td><?php echo $_html['username'];?></td><td><?php echo $_html['email'];?></td><td><?php echo $_html['reg_time'];?></td><td><?php echo $_job_html;?></td></tr>
			<?php }?>
		</table>
		<form action="?action=add" method="post">
			<input type="text" name="manage" class="text">　<input type="submit" value="添加管理员">
		</form>
		<?php
			_free_result($_result);
			_paging(2);
		?>		
	</div>
</div>
<?php require ROOT_PATH.'includes/footer.inc.php';?>
</body>
</html>