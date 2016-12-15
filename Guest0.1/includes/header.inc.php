<?php
/**
* Guest Vertion1.0
* ================================================
* Copy 2010-2016 QLC
* Author DWL
* Date 2016-9-23
*/
//防止恶意调用
if(!defined('IN_H')) {
	exit('Access Denied!');
}
?>
<!-- <script src="js/jquery.min.js"></script> -->
<!-- <script src="js/skin.js"></script> -->
<div id="header">
	<h1><a href="index.php">董文龙</a></h1>
	<ul>
		<li><a href="index.php">首页</a></li>
		<?php 
			if (isset($_COOKIE['username'])) {
				echo '<li><a href="member.php">'.$_COOKIE['username'].'·个人中心</a> '.$_message_html.' </li>';
				echo "\n";
			} else {
				echo '<li><a href="register.php">注册</a></li>';
				echo "\n";
				echo "\t\t";
				echo '<li><a href="login.php">登录</a></li>';
				echo "\n";
			}
		 ?>
		<li><a href="blog.php">博友</a></li>
		<li><a href="photo.php">相册</a></li>
		<li class="skin" id="skins">
			<a href="javascript:;">风格</a>
			<dl id="skin">
				<dd><a href="skin.php?id=1">1号皮肤</a></dd>
				<dd><a href="skin.php?id=2">2号皮肤</a></dd>
				<dd><a href="skin.php?id=3">3号皮肤</a></dd>
			</dl>
		</li>
		<?php
			if (isset($_COOKIE['username']) && isset($_SESSION['admin'])) {
				echo '<li><a href="manage.php" class="manage">管理</a></li>';
			}
			if (isset($_COOKIE['username'])) {
				echo '<li><a href="logout.php">退出</a></li>';
			}
		?> 
	</ul>
</div>
