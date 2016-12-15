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
$_html=_html(_get_xml('new.xml'));//获取XML数据
_page('SELECT tg_id FROM tg_article WHERE tg_reid=0',$_system['article']);//分页模块调用
//读取帖子
//从数据库获取结果集
$_result=_query("SELECT tg_id,tg_type,tg_title,tg_readcount,tg_commentcount FROM tg_article WHERE tg_reid=0 ORDER BY tg_date DESC LIMIT $_pagenum,$_pagesize");
//最新图片,找到最新时间且非公开的图片
$_photo=_fetch_array("SELECT tg_id AS id,tg_name AS name,tg_url AS url FROM tg_photo WHERE tg_sid in (SELECT tg_id FROM tg_dir WHERE tg_type=0) ORDER BY tg_date DESC LIMIT 1");
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
<div id="list">
	<h2>帖子列表</h2>
	<a href="post.php" class="post">发表帖子</a>
	<ul class="article">
		<?php 
			$_htmllist=array();
			while (!!$_rows=_fetch_array_list($_result)) {
				$_htmllist['id']=$_rows['tg_id'];
				$_htmllist['type']=$_rows['tg_type'];
				$_htmllist['title']=$_rows['tg_title'];
				$_htmllist['readcount']=$_rows['tg_readcount'];
				$_htmllist['commentcount']=$_rows['tg_commentcount'];
				$_htmllist=_html($_htmllist);
				echo '<li class="icon'.$_htmllist['type'].'"><em>阅读数(<strong>'.$_htmllist['readcount'].'</strong>) 评论数(<strong>'.$_htmllist['commentcount'].'</strong>)</em><a href="article.php?id='.$_htmllist['id'].'">'._title($_htmllist['title'],40).'</a></li>';
			}
			_free_result($_result);
		?>	
	</ul>
	<?php _paging(2);?>
</div>
<div id="user">
	<h2>新近会员</h2>
	<dl>
		<dd class="user"><?php echo $_html['username'];?> (<?php echo $_html['sex'];?>)</dd>
		<dt><img src="<?php echo $_html['face'];?>"></dt>
		<dd class="message"><a href="javascript:;" name="message" title="<?php echo $_html['id'];?>">发消息</a></dd>
		<dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $_html['id'];?>">加为好友</a></dd>
		<dd class="guest"><a href="guest.php?id=<?php echo $_html['id'];?>" name="guest" title="<?php echo $_html['id'];?>">写留言</a></dd>
		<dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $_html['id'];?>">给他送花</a></dd>
		<dd class="email">邮　件：<a href="mailto:<?php echo $_html['email'];?>"><?php echo $_html['email'];?></a></dd>
		<dd class="url">网　址：<a href="<?php echo $_html['url'];?>" target="_blank"><?php echo $_html['url'];?></a></dd>
	</dl>
</div>
<div id="pics">
	<h2>最新图片</h2>
	<a href="photo_detail.php?id=<?php echo $_photo['id'];?>"><img src="thumb.php?filename=<?php echo $_photo['url'];?>&percentage=0.8" alt="<?php echo $_photo['name'];?>"></a>
</div>
<?php require ROOT_PATH.'includes/footer.inc.php';?>
</body>
</html>