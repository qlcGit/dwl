<?php
/**
* Guest Vertion1.0
* ================================================
* Copy 2010-2016 QLC
* Author DWL
* Date 2016-9-28
*/
session_start();
define('IN_H',true);//定义常量用来授权调用includes里的文件
define('SCRIPT',substr(basename(__FILE__),0,-4));//定义常量用来指定本页的内容
require dirname(__FILE__).'/includes/common.inc.php';//引入公共文件
_page("SELECT tg_id FROM tg_user",$_system['blog']);//分页模块调用
//从数据库获取结果集
$_result=_query("SELECT tg_id,tg_username,tg_sex,tg_face FROM tg_user ORDER BY tg_reg_time DESC LIMIT $_pagenum,$_pagesize");
?>
<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="UTF-8">
<?php require ROOT_PATH.'includes/title.inc.php';?> 
<script src="js/blog.js"></script>
</head>
<body>
<?php require ROOT_PATH.'includes/header.inc.php';?>
<div id="blog">
	<h2>博友列表</h2>
	<?php 
		$_html=array();
		while (!!$_rows=_fetch_array_list($_result)) {
			$_html['id']=$_rows['tg_id'];
			$_html['username']=$_rows['tg_username'];
			$_html['sex']=$_rows['tg_sex'];
			$_html['face']=$_rows['tg_face'];
			$_html=_html($_html);
	?>
	<dl>
			<dd class="user"><?php echo $_html['username'];?>(<?php echo $_html['sex'];?>)</dd>
			<dt><img src="<?php echo $_html['face'];?>"></dt>
			<dd class="message"><a href="javascript:;" name="message" title="<?php echo $_html['id'];?>">发消息</a></dd>
			<dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $_html['id'];?>">加为好友</a></dd>
			<dd class="guest"><a href="guest.php?id=<?php echo $_html['id'];?>" name="guest" title="<?php echo $_html['id'];?>">写留言</a></dd>
			<dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $_html['id'];?>">给他送花</a></dd>
		</dl>
	<?php }
		_free_result($_result);
		_paging(1);
	?>　　
</div>
<?php require ROOT_PATH.'includes/footer.inc.php';?>
</body>
</html>