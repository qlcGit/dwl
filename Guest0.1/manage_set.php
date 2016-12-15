<?php
/**
* Guest Vertion1.0
* ================================================
* Copy 2010-2016 QLC
* Author DWL
* Date 2016-10-15
*/
session_start();
define('IN_H',true);//定义常量用来授权调用includes里的文件
define('SCRIPT',substr(basename(__FILE__),0,-4));//定义常量用来指定本页的内容
require dirname(__FILE__).'/includes/common.inc.php';//引入公共文件
_manage_login();//必须是管理员才能登录
//修改tg_system
if ($_GET['action']=='set') {
	if (!!$_rows = _fetch_array("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}'")) {
		_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);//为了防止COOKIE伪造还要比对唯一标识符
		$_clean=array();
		$_clean['webname']=$_POST['webname'];
		$_clean['article']=$_POST['article'];
		$_clean['blog']=$_POST['blog'];
		$_clean['photo']=$_POST['photo'];
		$_clean['skin']=$_POST['skin'];
		$_clean['string']=$_POST['string'];
		$_clean['post']=$_POST['post'];
		$_clean['reply']=$_POST['reply'];
		$_clean['code']=$_POST['code'];
		$_clean['register']=$_POST['register'];
		$_clean=_mysql_string($_clean);
		//写入数据库
		_query("UPDATE tg_system SET
									tg_webname='{$_clean['webname']}',
									tg_article='{$_clean['article']}',
									tg_blog='{$_clean['blog']}',
									tg_photo='{$_clean['photo']}',
									tg_skin='{$_clean['skin']}',
									tg_string='{$_clean['string']}',
									tg_post='{$_clean['post']}',
									tg_reply='{$_clean['reply']}',
									tg_code='{$_clean['code']}',
									tg_register='{$_clean['register']}'
							WHERE 
									tg_id=1
							LIMIT
									1
		");
		//判断是否修改成功
		if (_affected_rows() == 1) {
			_close();
			_location('恭喜你，修改成功!','manage_set.php');
		} else {
			_close();
			_location('很遗憾，没有任何数据修改!','manage_set.php');
		}
	} else {
		_alert_back('异常！');
	}
}
//读取tg_system
if (!!$_rows=_fetch_array("SELECT tg_webname,tg_article,tg_blog,tg_photo,tg_skin ,tg_string,tg_post,tg_reply,tg_code,tg_register FROM tg_system WHERE tg_id=1 LIMIT 1")) {
	$_html=array();
	$_html['webname']=$_rows['tg_webname'];
	$_html['article']=$_rows['tg_article'];
	$_html['blog']=$_rows['tg_blog'];
	$_html['photo']=$_rows['tg_photo'];
	$_html['skin']=$_rows['tg_skin'];
	$_html['string']=$_rows['tg_string'];
	$_html['post']=$_rows['tg_post'];
	$_html['reply']=$_rows['tg_reply'];
	$_html['code']=$_rows['tg_code'];
	$_html['register']=$_rows['tg_register'];
	$_html=_html($_html);
	//文章
	if ($_html['article']==10) {
		$_html['article_html']='<select name="article"><option value="10" selected="selected">每页10篇</option><option value="15">每页15篇</option></select>';
	} elseif ($_html['article']==15) {
		$_html['article_html']='<select name="article"><option value="10">每页10篇</option><option value="15" selected="selected">每页15篇</option></select>';
	}
	//blog
	if ($_html['blog']==15) {
		$_html['blog_html']='<select name="blog"><option value="15" selected="selected">每页15人</option><option value="20">每页20人</option></select>';
	} elseif ($_html['blog']==20) {
		$_html['blog_html']='<select name="blog"><option value="15">每页15人</option><option value="20" selected="selected">每页20人</option></select>';
	}
	//相册
	if ($_html['photo']==8) {
		$_html['photo_html']='<select name="photo"><option value="8" selected="selected">每页8张</option><option value="12">每页12张</option></select>';
	} elseif ($_html['photo']==12) {
		$_html['photo_html']='<select name="photo"><option value="8">每页8张</option><option value="12" selected="selected">每页12张</option></select>';
	}
	//皮肤
	if ($_html['skin']==1) {
		$_html['skin_html']='<select name="skin"><option value="1" selected="selected">1号皮肤</option><option value="2">2号皮肤</option></option><option value="3">3号皮肤</option></select>';
	} elseif ($_html['skin']==2) {
		$_html['skin_html']='<select name="skin"><option value="1">1号皮肤</option><option value="2" selected="selected">2号皮肤</option><option value="3">3号皮肤</option></select>';
	}elseif ($_html['skin']==3) {
		$_html['skin_html']='<select name="skin"><option value="1">1号皮肤</option><option value="2">2号皮肤</option><option value="3" selected="selected">3号皮肤</option></select>';
	}
	//发帖
	if ($_html['post']==30) {
		$_html['post_html']='<input type="radio" name="post" value="30" checked="checked"> 30秒　<input type="radio" name="post" value="60"> 1分钟　<input type="radio" name="post" value="180"> 3分钟';
	} elseif ($_html['post']==60) {
		$_html['post_html']='<input type="radio" name="post" value="30"> 30秒　<input type="radio" name="post" value="60" checked="checked"> 1分钟　<input type="radio" name="post" value="180">  3分钟';
	} elseif ($_html['post']==180) {
		$_html['post_html']='<input type="radio" name="post" value="30"> 30秒　<input type="radio" name="post" value="60"> 1分钟　<input type="radio" name="post" value="180" checked="checked"> 3分钟';
	}
	//回帖
	if ($_html['reply']==15) {
		$_html['reply_html']='<input type="radio" name="reply" value="15" checked="checked"> 15秒　<input type="radio" name="reply" value="30"> 30秒　<input type="radio" name="reply" value="45"> 45秒';
	} elseif ($_html['reply']==30) {
		$_html['reply_html']='<input type="radio" name="reply" value="15"> 15秒　<input type="radio" name="reply" value="30" checked="checked"> 30秒　<input type="radio" name="reply" value="45"> 45秒';
	} elseif ($_html['reply']==45) {
		$_html['reply_html']='<input type="radio" name="reply" value="15"> 15秒　<input type="radio" name="reply" value="30"> 30秒　<input type="radio" name="reply" value="45" checked="checked"> 45秒';
	}
	//验证码
	if ($_html['code']==1) {
		$_html['code_html']='<input type="radio" name="code" value="1" checked="checked"> 启用　<input type="radio" name="code" value="0"> 禁用';
	} else {
		$_html['code_html']='<input type="radio" name="code" value="1"> 启用　<input type="radio" name="code" value="0" checked="checked"> 禁用';
	}
	//注册
	if ($_html['register']==1) {
		$_html['register_html']='<input type="radio" name="register" value="1" checked="checked"> 启用　<input type="radio" name="register" value="0"> 禁用';
	} else {
		$_html['register_html']='<input type="radio" name="register" value="1"> 启用　<input type="radio" name="register" value="0" checked="checked"> 禁用';
	}
} else {
	_alert_back('系统表读取错误！请联系管理员！');
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
	<?php require ROOT_PATH.'includes/manage.inc.php';?>
	<div id="member_main">
		<h2>后台管理中心</h2>
		<form action="?action=set" method="post">
			<dl>
				<dd>网　站　名　称：<input type="text" name="webname" class="text" value="<?php echo $_html['webname']?>"></dd>
				<dd>文章每页列表数：<?php echo $_html['article_html'];?></dd>
				<dd>博客每页列表数：<?php echo $_html['blog_html'];?></dd>
				<dd>相册每页列表数：<?php echo $_html['photo_html'];?></dd>
				<dd>站点默认皮肤：<?php echo $_html['skin_html'];?></dd>
				<dd>非法字符过滤：<input type="text" name="string" class="text" value="<?php echo $_html['string']?>">　(*请用'|'隔开)</dd>
				<dd>每次发帖限制：<?php echo $_html['post_html'];?></dd>
				<dd>每次回帖限制：<?php echo $_html['reply_html'];?></dd>
				<dd>是否启用验证：<?php echo $_html['code_html'];?></dd>
				<dd>是否开放注册：<?php echo $_html['register_html'];?></dd>
				<dd><input type="submit" value="修改系统设置" class="submit"></dd>
			</dl>
		</form>
	</div>
</div>
<?php require ROOT_PATH.'includes/footer.inc.php';?>
</body>
</html>
