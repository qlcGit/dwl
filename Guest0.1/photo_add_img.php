<?php
/**
* Guest Vertion1.0
* ================================================
* Copy 2010-2016 QLC
* Author DWL
* Date 2016-9-28
*/
session_start();
define('IN_H',true);
define('SCRIPT',substr(basename(__FILE__),0,-4));
require dirname(__FILE__).'/includes/common.inc.php';
//必须是会员才能进入
if (!$_COOKIE['username']) {
	_alert_back("必须是会员才能进入！");
}
//图片信息写入表
if ($_GET['action']=='addimg') {
	if (!!$_rows = _fetch_array("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}'  LIMIT 1")) {
		_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
		include ROOT_PATH.'includes/check.func.php';
		$_clean=array();
		$_clean['id']=$_POST['id'];
		$_clean['name']=_check_dir_name($_POST['name'],2,40);
		$_clean['url']=_check_img_url($_POST['url']);
		$_clean['content']=$_POST['content'];
		$_clean['sid']=$_POST['sid'];
		$_clean=_mysql_string($_clean);
		//写入数据库
		_query("INSERT INTO tg_photo (
											tg_id,
											tg_name,
											tg_url,
											tg_content,
											tg_sid,
											tg_username,
											tg_date
										) 
								VALUES (
											'{$_clean['id']}',
											'{$_clean['name']}',
											'{$_clean['url']}',
											'{$_clean['content']}',
											'{$_clean['sid']}',
											'{$_COOKIE['username']}',
											NOW()
										)"
		);
		if (_affected_rows() == 1) {
			_close();
			_location('图片添加成功!','photo_show.php?id='.$_clean['sid']);
		} else {
			_close();
			_location('图片添加失败!','photo_add_img.php');
		}
	} else {
		_alert_back('非法登录!');
	}
}
//取值
if (isset($_GET['id'])) {
	if (!!$_rows=_fetch_array("SELECT tg_id,tg_dir FROM tg_dir WHERE tg_id='{$_GET['id']}' LIMIT 1")) {
		$_html=array();
		$_html['id']=$_rows['tg_id'];
		$_html['dir']=$_rows['tg_dir'];
		$_html=_html($_html);
	} else {
		_alert_back('不存在此相册！');
	}
} else {
	_alert_back('非法操作！');
}
?>
<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="UTF-8">
<?php require ROOT_PATH.'includes/title.inc.php';?>
<script src="js/photo_add_img.js"></script>
</head>
<body>
<?php require ROOT_PATH.'includes/header.inc.php';?>
<div id="photo">
	<h2>上传图片</h2>
	<form action="?action=addimg" method="post">
		<input type="hidden" name="sid" value="<?php echo $_html['id'];?>">
		<dl>
			<dd>图片名称：<input type="text" name="name" class="text"></dd>
			<dd>图片地址：<input type="text" readonly="readonly" name="url" id="url" class="text">　<a href="javascript:;" title="<?php echo $_html['dir'];?>" id="up">上传</a></dd>
			<dd>图片简介：<textarea name="content"></textarea></dd>
			<dd><input type="submit" value="添加图片" class="submit"></dd>
		</dl>
	</form>
</div>
<?php require ROOT_PATH.'includes/footer.inc.php';?>
</body>
</html>