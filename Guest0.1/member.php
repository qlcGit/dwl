<?php
/**
* Guest Vertion1.0
* ================================================
* Copy 2010-2016 QLC
* Author DWL
* Date 2016-9-29
*/
session_start();
define('IN_H',true);//定义常量用来授权调用includes里的文件
define('SCRIPT',substr(basename(__FILE__),0,-4));//定义常量用来指定本页的内容
require dirname(__FILE__).'/includes/common.inc.php';//引入公共文件
//不可直接登录
if (isset($_COOKIE['username'])) {
	//获取数据
	$_rows=_fetch_array("SELECT tg_username,tg_sex,tg_face,tg_email,tg_url,tg_qq,tg_level,tg_reg_time FROM tg_user WHERE tg_username='{$_COOKIE['username']}' LIMIT 1");
	if ($_rows) {
		$_html=array();
		$_html['username']=$_rows['tg_username'];
		$_html['sex']=$_rows['tg_sex'];
		$_html['face']=$_rows['tg_face'];
		$_html['email']=$_rows['tg_email'];
		$_html['url']=$_rows['tg_url'];
		$_html['qq']=$_rows['tg_qq'];
		$_html['reg_time']=$_rows['tg_reg_time'];
		switch ($_rows['tg_level']) {
			case 0:
				$_html['level']='普通会员';
				break;
			case 1:
				$_html['level']='管理员';
				break;
			default:
				$_html['level']='出错';
		}
		$_html=_html($_html);
	}
} else {
	_alert_back('非法登录');
}
?>
<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="UTF-8">
<?php require ROOT_PATH.'includes/title.inc.php';?>
</head>
<body>
<?php require ROOT_PATH.'includes/header.inc.php';?>
<div id="member">
	<?php require ROOT_PATH.'includes/member.inc.php';?>
	<div id="member_main">
		<h2>会员管理中心</h2>
		<dl>
			<dd>用户名称：<?php echo $_html['username']?></dd>
			<dd>性　　别：<?php echo $_html['sex']?></dd>
			<dd>头　　像：<?php echo $_html['face']?></dd>
			<dd>电子邮件：<?php echo $_html['email']?></dd>
			<dd>主　　页：<?php echo $_html['url']?></dd>
			<dd>Ｑ　　Ｑ：<?php echo $_html['qq']?></dd>
			<dd>注册时间：<?php echo $_html['reg_time']?></dd>
			<dd>身　　份：<?php echo $_html['level']?></dd>
		</dl>
	</div>
</div>
<?php require ROOT_PATH.'includes/footer.inc.php';?>	
</body>
</html>