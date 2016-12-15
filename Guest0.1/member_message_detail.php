<?php
/**
* Guest Vertion1.0
* ================================================
* Copy 2010-2016 QLC
* Author DWL
* Date 2016-10-3
*/
session_start();
define('IN_H',true);//定义常量用来授权调用includes里的文件
define('SCRIPT',substr(basename(__FILE__),0,-4));//定义常量用来指定本页的内容
require dirname(__FILE__).'/includes/common.inc.php';//引入公共文件
//判断是否登录
if (!isset($_COOKIE['username'])) {
	_alert_close('请先登录!');
}
//删除短信模块
if ($_GET['action']=='delete' && isset($_GET['id'])) {
	//验证短信是否合法
	if (!!$_rows=_fetch_array("SELECT tg_id FROM tg_message WHERE tg_id='{$_GET['id']}' LIMIT 1")) {
		if (!!$_rows2 = _fetch_array("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}'")) {
			_uniqid($_rows2['tg_uniqid'],$_COOKIE['uniqid']);//为了防止COOKIE伪造还要比对唯一标识符
			_query("DELETE FROM tg_message WHERE tg_id='{$_GET['id']}' LIMIT 1");//删除单个短信
			if (_affected_rows() == 1) {
				_close();
				_location('删除成功!','member_message.php');
			} else {
				_close();
				_alert_back('删除失败!');
			}
		} else {
			_alert_back('非法登录!');
		}
	} else {
		_alert_back('此短信不存在,无法删除!');
	}
}
//处理ID
if (isset($_GET['id'])) {
	$_rows=_fetch_array("SELECT tg_id,tg_fromuser,tg_content,tg_date,tg_state FROM tg_message WHERE tg_id='{$_GET['id']}' LIMIT 1");
	if ($_rows) {
		//将状态设置为1表示短信已读
		if (empty($_rows['tg_state'])) {
			_query("UPDATE tg_message SET tg_state=1 WHERE tg_id='{$_GET['id']}' LIMIT 1");
			if (!_affected_rows()) {
				_alert_back('异常!');
			}
		}
		$_html=array();
		$_html['id']=$_rows['tg_id'];
		$_html['fromuser']=$_rows['tg_fromuser'];
		$_html['content']=$_rows['tg_content'];
		$_html['date']=$_rows['tg_date'];
		$_html=_html($_html);
	} else {
		_alert_back('此短信不存在');
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
<script src="js/member_message_detail.js"></script>
</head>
<body>
<?php require ROOT_PATH.'includes/header.inc.php';?>
<div id="member">
	<?php require ROOT_PATH.'includes/member.inc.php';?>
	<div id="member_main">
		<h2>短信详情</h2>
		<dl>
			<dd><span>发信人:</span><?php echo $_html['fromuser']?></dd>
			<dd>内　　容：<strong><?php echo $_html['content']?></strong></dd>
			<dd>发信时间：<?php echo $_html['date']?></dd>
			<dd class="button"><input type="button" value="返回列表" id="return" ">　<input type="button" id="delete" value="删除短信" name="<?php echo $_html['id']?>"></dd>
		</dl>
	</div>
</div>
<?php require ROOT_PATH.'includes/footer.inc.php';?>
</body>
</html>