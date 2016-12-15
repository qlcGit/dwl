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
define('SCRIPT','flower');//定义常量用来指定本页的内容
require dirname(__FILE__).'/includes/common.inc.php';//引入公共文件
//判断是否登录
if (!isset($_COOKIE['username'])) {
	_alert_close('请先登录!');
}
//送花
if ($_GET['action']=='write') {
	_check_code($_POST['yzm'],$_SESSION['code']);//验证码防止恶意注册、跨站攻击
	if (!!$_rows = _fetch_array("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}' LIMIT 1")) {
		_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);//为了防止COOKIE伪造还要比对唯一标识符
		include ROOT_PATH.'includes/check.func.php';//引入文件
		$_clean=array();
		$_clean['touser']=$_POST['touser'];
		$_clean['fromuser']=$_COOKIE['username'];
		$_clean['flower']=$_POST['flower'];
		$_clean['content']=_check_content($_POST['content']);
		$_clean=_mysql_string($_clean);
		//写入表
		_query("INSERT INTO tg_flower (
											tg_touser,
											tg_fromuser,
											tg_flower,
											tg_content,
											tg_date
										) 
								VALUES (
											'{$_clean['touser']}',
											'{$_clean['fromuser']}',
											'{$_clean['flower']}',
											'{$_clean['content']}',
											NOW()
										)"
		);

		if (_affected_rows() == 1) {
			_close();
			//_session_destroy();
			_alert_close('送花成功!');
		} else {
			_close();
			//_session_destroy();
			_alert_back('送花失败!');
		}
	} else {
		_alert_close('非法登录!');
	}	
}
//获取数据
if (isset($_GET['id'])) {
	if (!!$_rows=_fetch_array("SELECT tg_username FROM tg_user WHERE tg_id='{$_GET['id']}' LIMIT 1")) {
		$_html=array();
		$_html['touser']=$_rows['tg_username'];
		$_html=_html($_html);
	} else {
		_alert_close('不存在此用户!');
	}
} else {
	_alert_close('非法操作!');
}
?>
<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="UTF-8">
<?php require ROOT_PATH.'includes/title.inc.php';?>
<script src="js/code.js"></script>
<script src="js/message.js"></script>
</head>
<body>
<div id="message">
	<h3>送花</h3>
	<form action="?action=write" method="post">
		<input type="hidden" name="touser" value="<?php echo $_html['touser'];?>">
		<dl>
			<dd>
				<input type="text" class="text" readonly="readonly" value="To：<?php echo $_html['touser'];?>">
				<select name="flower">
				<?php 
				foreach (range(1,100) as $_num) {
					echo '<option value="'.$_num.'"> x '.$_num.' 朵</option>';
				}
				?>
				</select>
			</dd>
			<dd><textarea name="content">真的很是欣赏你,送你的花，希望你收下！！！</textarea></dd>
			<dd>验 证 码：<input type="text" name="yzm" class="text yzm"><img src="code.php" id="code">　<input type="submit" class="submit" value="送花"></dd>
		</dl>
	</form>
</div>
</body>
</html>
