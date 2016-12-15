<?php
/**
* Guest Vertion1.0
* ================================================
* Copy 2010-2016 QLC
* Author DWL
* Date 2016-10-02
*/
define('IN_H',true);//定义常量用来授权调用includes里的文件
define('SCRIPT',substr(basename(__FILE__),0,-4));//定义常量用来指定本页的内容
require dirname(__FILE__).'/includes/common.inc.php';//引入公共文件
//判断是否登录
if (!isset($_COOKIE['username'])) {
	_location('请先登录!','login.php');
}
//验证好友模块
if ($_GET['action']=='check' && isset($_GET['id'])) {
	if (!!$_rows = _fetch_array("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}' LIMIT 1")) {
		_query("UPDATE tg_friend SET tg_state=1 WHERE tg_id='{$_GET['id']}'");//修改表字段state
		if (_affected_rows()==1) {
			_close();
			_location('好友验证成功!','member_friend.php');
		} else {
			_close();
			_alert_back('好友验证失败!');
		}
	} else {
		_alert_back('非法登录!');
	}
}
//删除好友模块
if ($_GET['action']=='delete' && isset($_POST['ids'])) {
	$_clean=array();
	$_clean['ids']=_mysql_string(implode(',',$_POST['ids']));
	if (!!$_rows = _fetch_array("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}' LIMIT 1")) {	
		//为了防止COOKIE伪造还要比对唯一标识符
		_uniqid($_rows2['tg_uniqid'],$_COOKIE['uniqid']);
		_query("DELETE FROM tg_friend WHERE tg_id IN ({$_clean['ids']})");
		if (_affected_rows()) {
			_close();
			_location('好友删除成功!','member_friend.php');
		} else {
			_close();
			_alert_back('好友删除失败!');
		}
	} else {
		_alert_back('非法登录!');
	}
}
//分页模块调用
_page("SELECT tg_id FROM tg_friend WHERE tg_touser='{$_COOKIE['username']}' OR tg_fromuser='{$_COOKIE['username']}'",15);
//从数据库提取数据获取结果集
$_result=_query("SELECT tg_id,tg_touser,tg_fromuser,tg_content,tg_date,tg_state FROM tg_friend WHERE tg_touser='{$_COOKIE['username']}' OR tg_fromuser='{$_COOKIE['username']}' ORDER BY tg_date DESC LIMIT $_pagenum,$_pagesize");
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
	<?php require ROOT_PATH.'includes/member.inc.php';?>
	<div id="member_main">
		<h2>好友设置中心</h2>
		<form action="?action=delete" method="post">
			<table>
				<tr><th>好友</th><th>请求内容</th><th>时间</th><th>状态</th><th>操作</th></tr>
				<?php 
					$_html=array();
					while (!!$_rows=_fetch_array_list($_result)) {
						$_html['id']=$_rows['tg_id'];
						$_html['touser']=$_rows['tg_touser'];
						$_html['fromuser']=$_rows['tg_fromuser'];
						$_html['content']=$_rows['tg_content'];
						$_html['date']=$_rows['tg_date'];
						$_html['state']=$_rows['tg_state'];
						$_html=_html($_html);
						if ($_html['touser']==$_COOKIE['username']) {
							$_html['friend']=$_html['fromuser'];
							if (empty($_html['state'])) {
								$_html['state_html']='<a href="?action=check&id='.$_html['id'].'" style="color:red;">你未验证</a>';
							} else {
								$_html['state_html']='<span style="color:green;">通过</span>';
							}
						} elseif ($_html['fromuser']==$_COOKIE['username']) {
							$_html['friend']=$_html['touser'];
							if (empty($_html['state'])) {
								$_html['state_html']='<span style="color:blue;">对方未验证</span>';
							} else {
								$_html['state_html']='<span style="color:green;">通过</span>';
							}
						}
				 ?>
				<tr><td><?php echo $_html['friend'];?></td><td title="<?php echo $_html['content']?>"><?php echo  _title($_html['content'],14);?></td><td><?php echo $_html['date'];?></td><td><?php echo $_html['state_html'];?></td><td><input type="checkbox" name="ids[]" value="<?php echo $_html['id'];?>"></td></tr>
				<?php 
					}
					_free_result($_result);
				 ?>
				<tr><td colspan="5">全选　<input type="checkbox" name="chkall" id="all">　<input type="submit" value="批删除"></td></tr>
			</table>
		</form>
		<?php _paging(2);?>
	</div>
</div>
<?php require ROOT_PATH.'includes/footer.inc.php';?>
</body>
</html>