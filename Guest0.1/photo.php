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
//删除目录
if ($_GET['action']=='delete' && isset($_GET['id'])) {
	if (!!$_rows = _fetch_array("SELECT tg_uniqid,tg_reply_time FROM tg_user WHERE tg_username='{$_COOKIE['username']}'  LIMIT 1")) {
		//为了防止COOKIE伪造还要比对唯一标识符
		_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
		if (!!$_rows = _fetch_array("SELECT tg_dir FROM tg_dir WHERE tg_id='{$_GET['id']}' LIMIT 1")) {
			$_html=array();
			$_html['url']=$_rows['tg_dir'];
			$_html=_html($_html);
			//最后删除磁盘目录回滚机制
			if (_affected_rows() == 1) {
				//开始删除图片物理地址
				if (file_exists($_html['url'])) {
					if(_removeDir($_html['url'])) {
						//首先删除图片的数据库信息--省略判断可以自己做
						_query("DELETE FROM tg_photo WHERE tg_sid='{$_GET['id']}'");
						//然后删除目录数据库
						_query("DELETE FROM tg_dir WHERE tg_id='{$_GET['id']}'");
						_close();
						_location('目录删除成功!','photo.php');
					} else {
						_close();
						_alert_back('目录删除失败!');
					}
				} else {
					_alert_back('磁盘里已不存在此图!');
				}
			} 
		} else {
			_alert_back('不存在此目录!');
		}
	} else {
		_alert_back('非法登录!');
	}
}
_page("SELECT tg_id FROM tg_dir",$_system['photo']);//分页模块调用
//从数据库获取结果集
$_result=_query("SELECT tg_id,tg_name,tg_type,tg_cover FROM tg_dir ORDER BY tg_date DESC LIMIT $_pagenum,$_pagesize");
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
	<h2>相册列表</h2>
	<?php 
		$_html=array();
		while (!!$_rows=_fetch_array_list($_result)) {
			$_html['id']=$_rows['tg_id'];
			$_html['name']=$_rows['tg_name'];
			$_html['type']=$_rows['tg_type'];
			$_html['cover']=$_rows['tg_cover'];
			$_html=_html($_html);
			if (empty($_html['type'])) {
				$_html['type_html']='(公开)';
			} else {
				$_html['type_html']='(私密)';
			}
			if (empty($_html['cover'])) {
				$_html['cover_html']='';
			} else {
				$_html['cover_html']='<img src="'.$_html['cover'].'" alt="'.$_html['name'].'">';
			}
			//统计相册的照片数量
			$_html['photo']=_fetch_array("SELECT count(*) AS count FROM tg_photo WHERE tg_sid='{$_html['id']}'");
	?>
	<dl>
		<dt><a href="photo_show.php?id=<?php echo $_html['id'];?>"><?php echo $_html['cover_html'];?></a></dt>
		<dd><a href="photo_show.php?id=<?php echo $_html['id'];?>"><?php echo $_html['name'];?> <?php echo '['.$_html['photo']['count'].'张]'.$_html['type_html'];?></a></dd>
		<?php if (isset($_SESSION['admin']) && isset($_COOKIE['username'])) {?>
		<dd>[<a href="photo_dir_modify.php?id=<?php echo $_html['id'];?>">修改</a>] [<a href="?action=delete&id=<?php echo $_html['id']?>" onclick="return confirm('你真的要删除吗？') ? true : false;">删除</a>]</dd>
		<?php }?>
	</dl>
	<?php }
		_free_result($_result);
		_paging(1);
	?>
	<?php if (isset($_SESSION['admin']) && isset($_COOKIE['username'])) {?>
	<p><a href="photo_add_dir.php">添加目录</a></p>
	<?php }?>
</div>
<?php require ROOT_PATH.'includes/footer.inc.php';?>
</body>
</html>