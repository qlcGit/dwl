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
//防止非HTML页面调用
if(!defined('SCRIPT')) {
	exit('Script Error!');
}
?>
<title><?php echo $_system['webname'];?></title>
<link rel="shortcut icon" href="Open file.ico">
<link rel="stylesheet" href="styles/<?php echo $_system['skin'] ?>/basic.css">
<link rel="stylesheet" href="styles/<?php echo $_system['skin'] ?>/<?php echo SCRIPT?>.css">
<script src="js/jquery.min.js"></script> 
<script src="js/skin.js"></script> 