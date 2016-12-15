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
//删除相片
if ($_GET['action']=='delete' && isset($_GET['id'])) {
	if (!!$_rows = _fetch_array("SELECT tg_uniqid,tg_reply_time FROM tg_user WHERE tg_username='{$_COOKIE['username']}'  LIMIT 1")) {
		_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
		//取得图片的发布者
		if (!!$_rows = _fetch_array("SELECT tg_username,tg_url,tg_id,tg_sid FROM tg_photo WHERE tg_id='{$_GET['id']}' LIMIT 1")) {
			$_html=array();
			$_html['username']=$_rows['tg_username'];
			$_html['url']=$_rows['tg_url'];
			$_html['id']=$_rows['tg_id'];
			$_html['sid']=$_rows['tg_sid'];
			$_html=_html($_html);
			//判断删除图片身份是否合法
			if ($_html['username']==$_COOKIE['username'] || isset($_SESSION['admin'])) {
				//首先删除图片的数据库信息
				_query("DELETE FROM tg_photo WHERE tg_id='{$_html['id']}'");
				if (_affected_rows() == 1) {
					//开始删除图片物理地址
					if (file_exists($_html['url'])) {
						unlink($_html['url']);
					} else {
						_alert_back('磁盘里已不存在此图!');
					}
					_close();
					_location('删除成功!','photo_show.php?id='.$_html['sid']);
				} else {
					_close();
					_alert_back('删除失败!');
				}
				
		} else {
			_alert_back('非法操作!');
		}
		} else {
			_alert_back('不存在此图片');
		}
	} else {
		_alert_back('非法登录!');
	}
}
//取值
if (isset($_GET['id'])) {
	if (!!$_rows=_fetch_array("SELECT tg_id,tg_name,tg_type FROM tg_dir WHERE tg_id='{$_GET['id']}' LIMIT 1")) {
		$_dirhtml=array();
		$_dirhtml['id']=$_rows['tg_id'];
		$_dirhtml['name']=$_rows['tg_name'];
		$_dirhtml['type']=$_rows['tg_type'];
		$_dirhtml=_html($_dirhtml);
		//对比加密相册的验证信息
		if ($_POST['password']) {
			if (!!$_rows=_fetch_array("SELECT tg_id FROM tg_dir WHERE tg_password='".sha1($_POST['password'])."' LIMIT 1")) {
				//设置cookie
				setcookie('photo'.$_dirhtml['id'],$_dirhtml['name']);
				//慢一拍，重定向
				_location(null,'photo_show.php?id='.$_dirhtml['id']);
			} else {
				_alert_back('相册密码不正确！');
			}
		}
	} else {
		_alert_back('不存在此相册！');
	}
} else {
	_alert_back('非法操作！');
}
$_percentage=0.3;
global $_id;
$_id='id='.$_dirhtml['id'].'&';
//分页模块调用
_page("SELECT tg_id FROM tg_photo WHERE tg_sid='{$_dirhtml['id']}'",$_system['photo']);
//从数据库获取结果集
$_result=_query("SELECT tg_id,tg_username,tg_name,tg_url,tg_readcount,tg_commentcount FROM tg_photo WHERE tg_sid='{$_dirhtml['id']}' ORDER BY tg_date DESC LIMIT $_pagenum,$_pagesize");
?>
<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="UTF-8">
<?php require ROOT_PATH.'includes/title.inc.php';?>
</head>
<body>
<?php require ROOT_PATH.'includes/header.inc.php';?>
<div id="photo">
	<h2><?php echo $_dirhtml['name'];?></h2>
	<?php 
		//验证私密和cookie
		if (empty($_dirhtml['type']) || $_COOKIE['photo'.$_dirhtml['id']]==$_dirhtml['name'] || $_SESSION['admin']) {
			$_html=array();
			while (!!$_rows=_fetch_array_list($_result)) {
				$_html['id']=$_rows['tg_id'];
				$_html['username']=$_rows['tg_username'];
				$_html['name']=$_rows['tg_name'];
				$_html['url']=$_rows['tg_url'];
				$_html['readcount']=$_rows['tg_readcount'];
				$_html['commentcount']=$_rows['tg_commentcount'];
				$_html=_html($_html);
	?>
	<dl>
		<dt><a href="photo_detail.php?id=<?php echo $_html['id'];?>"><img src="thumb.php?filename=<?php echo $_html['url'];?>&percentage=<?php echo $_percentage;?>" alt="缩略图"></a></dt>
		<dd><a href="photo_detail.php?id=<?php echo $_html['id'];?>"><?php echo $_html['name'];?></a></dd>
		<dd>阅(<strong><?php echo $_html['readcount'];?></strong>) 评(<strong><?php echo $_html['commentcount'];?></strong>) 上传者 (<?php echo $_html['username'];?>)</dd>
		<?php  
			if ($_html['username']==$_COOKIE['username'] || isset($_SESSION['admin'])) {
		?>
		<dd>[<a href="photo_show.php?action=delete&id=<?php echo $_html['id']?>">删除</a>]</dd>
		<?php  }?>
	</dl>
	<?php  	}
			_free_result($_result);
			_paging(1);
	?>
	<p><a href="photo_add_img.php?id=<?php echo $_dirhtml['id'];?>">上传图片</a></p>
	<?php 
	} else {
		echo '<form action="photo_show.php?id='.$_dirhtml['id'].'" method="post">';
		echo '<p>请输入密码：<input type="password" name="password">　<input type="submit" value="确认"></p>';
		echo '</form>';
	}
	?>
</div>
<?php require ROOT_PATH.'includes/footer.inc.php';?>
</body>
</html>