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
//判断是否提交数据并开始处理
if ($_GET['action']=='register') {
	if (empty($_system['register'])) {
		exit('本网站不能非法注册！');
	}
	_check_code($_POST['yzm'],$_SESSION['code']);//验证码防止恶意注册、跨站攻击
	include ROOT_PATH.'includes/check.func.php';//引入文件
	//创建数组保存提交过来的数据
	$_clean=array();
	//通过唯一标识符防止恶意注册、跨站攻击,存入数据库的唯一标识符有登录cookie验证的作用
	$_clean['uniqid']=_check_uniqid($_POST['uniqid'],$_SESSION['uniqid']);
	$_clean['active']=_sha1_uniqid();//另一个唯一标识符，用来对刚注册的用户进行激活处理，方可登录
	$_clean['username']=_check_username($_POST['username'],2,20);
	$_clean['password']=_check_password($_POST['password'],$_POST['notpassword'],6);
	$_clean['question']= _check_question($_POST['question'],2,20);
	$_clean['answer']= _check_answer($_POST['question'],$_POST['answer'],2,20);
	$_clean['sex']=_check_sex($_POST['sex']);
	$_clean['face']=_check_face($_POST['face']);
	$_clean['email']=_check_email($_POST['email'],6,40);
	$_clean['qq']=_check_qq($_POST['qq']);
	$_clean['url']=_check_url($_POST['url'],40);
	//新增前判断用户名重复
	_is_repeat(
		"SELECT tg_username FROM tg_user WHERE tg_username='{$_clean['username']}' LIMIT 1",
		"对不起，此用户已被注册!"
	);
	//新增注册用户:在引号里可以直接放变量，但是数组变量要加{}.
	//e.g:INSERT INTO tg_user (tg_username) VALUES ('{$_clean['username']}')
	_query(
				"INSERT INTO tg_user (
										tg_uniqid,
										tg_active,
										tg_username,
										tg_password,
										tg_question,
										tg_answer,
										tg_email,
										tg_qq,
										tg_url,
										tg_sex,
										tg_face,
										tg_reg_time,
										tg_last_time,
										tg_last_ip
									)
							VALUES (
										'{$_clean['uniqid']}',
										'{$_clean['active']}',
										'{$_clean['username']}',
										'{$_clean['password']}',
										'{$_clean['question']}',
										'{$_clean['answer']}',
										'{$_clean['email']}',
										'{$_clean['qq']}',
										'{$_clean['url']}',
										'{$_clean['sex']}',
										'{$_clean['face']}',
										NOW(),
										NOW(),
										'{$_SERVER["REMOTE_ADDR"]}'
									)"
	);
	if (_affected_rows() == 1) {
		$_clean['id']=_insert_id();//获取刚刚新增的ID
		//模拟邮箱激活系统
		_close();
		_set_xml('new.xml',$_clean);//生成XML
		_location('恭喜你，注册成功!','active.php?active='.$_clean['active']);
	} else {
		_close();
		_location('很遗憾，注册失败!','register.php');
	}
} else {
	$_SESSION['uniqid']=$_uniqid=_sha1_uniqid();//唯一标识符发生器
}
?>
<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="UTF-8">
<?php require ROOT_PATH.'includes/title.inc.php';?>
<script src="js/code.js"></script>
<script src="js/register.js"></script>
</head>
<body>
<?php require ROOT_PATH.'includes/header.inc.php';?>
<div id="register">
	<h2>会员注册</h2>
	<?php if (!empty($_system['register'])) {?>
	<form action="register.php?action=register" name="register" method="post">
	<input type="hidden" name="uniqid" value="<?php echo $_uniqid;?>">
		<dl>
			<dt>请认真填写内容</dt>
			<dd>用户名称：<input type="text" name="username" class="text">   (*必填，至少两位)</dd>
			<dd>密　　码：<input type="password" name="password" class="text">                (*必填，至少六位)</dd>
			<dd>确认密码：<input type="password" name="notpassword" class="text"> (*必填，同上)</dd>
			<dd>密码提示：<input type="text" name="question" class="text">     (*必填，至少两位)</dd>
			<dd>密码回答：<input type="text" name="answer" class="text">     (*必填，至少两位)</dd>
			<dd>性　　别：<input type="radio" name="sex" value="男" checked="checked">男　<input type="radio" name="sex" value="女">女</dd>
			<dd class="faced"><input type="hidden" name="face" value="images/face/m01.gif"><img src="images/face/m01.gif" alt="头像选择" id="faceimg"></dd>
			<dd>电子邮件：<input type="text" name="email" class="text"> (*必填，激活账户)</dd>
			<dd>　ＱＱ　：<input type="text" name="qq" class="text"></dd>
			<dd>主页地址：<input type="text" name="url" class="text" value="http://"></dd>
			<dd><span>验证码:</span><input type="text" name="yzm" class="text yzm"><img src="code.php" id="code"></dd>
			<dd><input type="submit" class="submit" value="注册"></dd>
		</dl>
	</form>
	<?php } else {
		echo '<h4>本站关闭了注册功能!</h4>';
	}?>
</div>
<?php require ROOT_PATH.'includes/footer.inc.php';?>
</body>
</html>