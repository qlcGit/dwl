<?php
/**
* Guest Vertion1.0
* ================================================
* Copy 2010-2016 QLC
* Author DWL
* Date 2016-9-29
*/
session_start();
define('IN_H',true);
define('SCRIPT',substr(basename(__FILE__),0,-4));
require dirname(__FILE__).'/includes/common.inc.php';
if ($_GET['action']=='modify') {
	_check_code($_POST['yzm'],$_SESSION['code']);//验证码防止恶意注册、跨站攻击
	if (!!$_rows = _fetch_array("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}'")) {	
		_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);//为了防止COOKIE伪造还要比对唯一标识符
		include ROOT_PATH.'includes/check.func.php';
		$_clean=array();
		// $_clean['username']=_check_username($_POST['username'],2,20);
		$_clean['password']=_check_modify_password($_POST['password'],6);
		$_clean['sex']=_check_sex($_POST['sex']);
		$_clean['face']=_check_face($_POST['face']);
		$_clean['email']=_check_email($_POST['email'],6,40);
		$_clean['qq']=_check_qq($_POST['qq']);
		$_clean['url']=_check_url($_POST['url'],40);
		$_clean['switch']=$_POST['switch'];
		$_clean['autograph']=_check_post_autograph($_POST['autograph'],200);
		// print_r($_clean);
		//修改数据写入数据库
		if (empty($_clean['password'])) {
			_query("UPDATE tg_user SET
										tg_sex='{$_clean['sex']}',
										tg_face='{$_clean['face']}',
										tg_switch='{$_clean['switch']}',
										tg_autograph='{$_clean['autograph']}',
										tg_email='{$_clean['email']}',
										tg_qq='{$_clean['qq']}',
										tg_url='{$_clean['url']}'
									WHERE 
										tg_username='{$_COOKIE['username']}'
								      	");
		} else {
			_query("UPDATE tg_user SET
										tg_password='{$_clean['password']}',
										tg_sex='{$_clean['sex']}',
										tg_face='{$_clean['face']}',
										tg_switch='{$_clean['switch']}',
										tg_autograph='{$_clean['autograph']}',
										tg_email='{$_clean['email']}',
										tg_qq='{$_clean['qq']}',
										tg_url='{$_clean['url']}'
									WHERE 
										tg_username='{$_COOKIE['username']}'
								      	");
		}
	}
	//判断是否修改成功
	if (_affected_rows() == 1) {
		_close();
		_location('恭喜你，修改成功!','member.php');
	} else {
		_close();
		_location('很遗憾，没有任何数据修改!','member_modify.php');
	}
}
//不可直接登录
if (isset($_COOKIE['username'])) {
	//获取数据
	$_rows=_fetch_array("SELECT tg_username,tg_sex,tg_face,tg_switch,tg_autograph,tg_email,tg_url,tg_qq FROM tg_user WHERE tg_username='{$_COOKIE['username']}'");
	if ($_rows) {
		$_html=array();
		$_html['username']=$_rows['tg_username'];
		$_html['sex']=$_rows['tg_sex'];
		$_html['face']=$_rows['tg_face'];
		$_html['switch']=$_rows['tg_switch'];
		$_html['autograph']=$_rows['tg_autograph'];
		$_html['email']=$_rows['tg_email'];
		$_html['url']=$_rows['tg_url'];
		$_html['qq']=$_rows['tg_qq'];
		$_html=_html($_html);
		//性别选择
		if ($_html['sex']=='男') {
			$_html['sex_html']='<input type="radio" name="sex" value="男" checked="checked">男　<input type="radio" name="sex" value="女">女';
		}elseif ($_html['sex']=='女') {
			$_html['sex_html']='<input type="radio" name="sex" value="男">男 <input type="radio" name="sex" value="女" checked="checked">女';
		}
		//头像选择
		$_html['face_html']='<select name="face">';
		foreach (range(1, 9) as $number) {
			if ($_html['face']=='images/face/m0'.$number.'.gif') {
				$_html['face_html'] .= '<option value="images/face/m0'.$number.'.gif" selected="selected">images/face/m0'.$number.'.gif</option>';
			} else {
				$_html['face_html'] .= '<option value="images/face/m0'.$number.'.gif">images/face/m0'.$number.'.gif</option>';
			}
			
		}
		foreach (range(10,54) as $number) {
			if ($_html['face']=='images/face/m'.$number.'.gif') {
				$_html['face_html'] .= '<option value="images/face/m'.$number.'.gif" selected="selected">images/face/m'.$number.'.gif</option>';
			} else {
				$_html['face_html'] .= '<option value="images/face/m'.$number.'.gif">images/face/m'.$number.'.gif</option>';
			}
			
		}
		$_html['face_html'] .= '</select>';
		//签名开关
		if ($_html['switch']==1) {
			$_html['switch_html']='<input type="radio" name="switch" value="1" checked="checked"> 启用　<input type="radio" name="switch" value="0"> 禁用';
		} elseif ($_html['switch']==0) {
			$_html['switch_html']='<input type="radio" name="switch" value="1"> 启用　<input type="radio" name="switch" value="0" checked="checked"> 禁用';
		}
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
<script src="js/code.js"></script>
<script src="js/member_modify.js"></script>
</head>
<body>
<?php require ROOT_PATH.'includes/header.inc.php';?>
<div id="member">
	<?php require ROOT_PATH.'includes/member.inc.php';?>
	<div id="member_main">
		<h2>会员管理中心</h2>
		<!-- 提交给自己省略member_modify.php -->
		<form action="?action=modify" method="post">
			<dl>
				<dd>用户名称：<?php echo $_html['username']?></dd>
				<dd>密　　码：<input type="password" name="password" class="text">　(*留空则不修改)</dd>
				<dd>性　　别：<?php echo $_html['sex_html']?></dd>
				<dd>头　　像：<?php echo $_html['face_html']?></dd>
				<dd>电子邮件：<input type="text" class="text" name="email" value="<?php echo $_html['email']?>"></dd>
				<dd>主　　页：<input type="text" class="text" name="url" value="<?php echo $_html['url']?>"></dd>
				<dd>Ｑ　　Ｑ：<input type="text"  class="text" name="qq" value="<?php echo $_html['qq']?>"></dd>
				<dd>个性签名：<?php echo $_html['switch_html']?>
					<p><textarea name="autograph"><?php echo $_html['autograph']?></textarea></p>
				</dd>
				<dd><span>验证码:</span><input type="text" name="yzm" class="text yzm"><img src="code.php" id="code">　<input type="submit" class="submit" value="修改资料"></dd>
			</dl>
		</form>
	</div>
</div>
<?php require ROOT_PATH.'includes/footer.inc.php';?>
</body>
</html>
