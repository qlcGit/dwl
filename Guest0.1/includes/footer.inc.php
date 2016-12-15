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
_close();
?>
<div id="footer">
	<p>本程序执行时间:<?php echo round(_runtime()-START_TIME,4);?>秒</p>
	<p>版权所有 翻版必究</p>
	<p>本程序由<span>QLC Web俱乐部</span>提供</p>
</div>
