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
define('SCRIPT',substr(basename(__FILE__),0,-4));//定义常量用来指定本页的内容
require dirname(__FILE__).'/includes/common.inc.php';//引入公共文件
_login_state();//登录状态判断
//开始处理登录状态
if ($_GET['action'] == 'login') {
	if (!empty($_system['code'])) {
		_check_code($_POST['yzm'],$_SESSION['code']);//验证码防止恶意注册、跨站攻击
	}
	include ROOT_PATH.'includes/login.func.php';//引入文件
	//创建数组保存提交过来的数据
	$_clean=array();
	$_clean['username']=_check_username($_POST['username'],2,20);
	$_clean['password']=_check_password($_POST['password'],6);
	$_clean['time']=_check_time($_POST['time']);
	//数据库验证
	if (!!$_rows=_fetch_array("SELECT tg_username,tg_uniqid,tg_level FROM tg_user WHERE tg_username='{$_clean['username']}' AND tg_password='{$_clean['password']}' AND tg_active='' LIMIT 1")) {
		//登陆成功后更新登录信息
		_query("UPDATE tg_user SET
									tg_last_time=NOW(),
									tg_last_ip='{$_SERVER["REMOTE_ADDR"]}',
									tg_login_count=tg_login_count+1
								WHERE
									tg_username='{$_rows['tg_username']}'
									");
		_setcookies($_rows['tg_username'],$_rows['tg_uniqid'],$_clean['time']);
		if ($_rows['tg_level']==1) {
			$_SESSION['admin']=$_rows['tg_username'];
		}
		_close();
		_location(null,'member.php');
	} else {
		_close();
		_location('用户名密码不正确或该账户未被激活!','login.php');
	}
}
?>
<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="UTF-8">
<?php require ROOT_PATH.'includes/title.inc.php';?>
<script src="js/code.js"></script>
<script src="js/login.js"></script>
</head>
<body>
<?php require ROOT_PATH.'includes/header.inc.php';?>
<div id="login">
	<h2>登录</h2>
	<form action="login.php?action=login" name="login" method="post">
		<dl>
			<dt>请认真填写内容</dt>
			<dd>用户名称：<input type="text" name="username" class="text"></dd>
			<dd>密　　码：<input type="password" name="password" class="text"></dd>
			<dd>保　　留：<input type="radio" name="time" value="0" checked="checked">不保留 <input type="radio" name="time" value="1">一天 <input type="radio" name="time" value="2">一周 <input type="radio" name="time" value="3">一个月</dd>
			<?php if (!empty($_system['code'])) {?>
			<dd><span>验证码:</span><input type="text" name="yzm" class="text yzm"><img src="code.php" id="code"></dd>
			<?php }?>
			<dd><input type="submit" class="button" value="登录"><input type="submit" id="location" class="button location" value="注册"></dd>
		</dl>
	</form>
</div>
<?php require ROOT_PATH.'includes/footer.inc.php';?>
</body>
</html>