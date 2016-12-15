<?php
/**
* Guest Vertion1.0
* ================================================
* Copy 2010-2016 QLC
* Author DWL
* Date 2016-9-23
*核心函数库
*/
//删除非空目录
function _removeDir($dirName) {
    if(!is_dir($dirName)) {
        return false;
    }
    $handle = @opendir($dirName);
    while(($file = @readdir($handle)) !== false) {
        if($file != '.' && $file != '..') {
            $dir = $dirName . '/' . $file;
            is_dir($dir) ? _removeDir($dir) : @unlink($dir);
        }
    }
    closedir($handle);
   
    return rmdir($dirName) ;
}
//检查非法登录
function _manage_login() {
	if ((!isset($_COOKIE['username'])) || (!isset($_SESSION['admin']))) {
		_alert_back('非法登录！');
	}
}
//登录状态判断
function _login_state() {
	if (isset($_COOKIE['username'])) {
		_alert_back('用户已登录,无法进行本操作');
	}
}
//验证规定发帖时间
function _timed($_nowtime,$_pretime,$_second) {
	if ($_nowtime-$_pretime<$_second) {
		_alert_back('请阁下休息一会儿再发帖！');
	}
}
/**
* _runtime()是用来获取执行耗时
* @access public
* @return float 表示返回浮点型
*/
function _runtime() {
	$_mtime = explode(' ', microtime());
	return $_mtime[0] + $_mtime[1];
}
/**
* _alert_back()是JS弹窗
* @access public
* @return void
*/
function _alert_back($_info) {
	echo "<script>alert('$_info');history.back();</script>";
	exit();
}
function _alert_close($_info) {
	echo "<script>alert('$_info');window.close();</script>";
	exit();
}
//限制内容显示的长度
function _title($_string,$_strlen) {
	if (mb_strlen($_string,'utf-8')>$_strlen) {
		$_string=mb_substr($_string,0,$_strlen,'utf-8');
	}
	return $_string;
}
//跳转
function _location($_info,$_url) {
	if (!empty($_info)) {
		echo "<script>alert('$_info');location.href='$_url';</script>";
		exit();
	} else {
		header('Location:'.$_url);
	}
}
//为了防止COOKIE伪造还要比对唯一标识符
function _uniqid($_mysql_uniqid,$_cookie_uniqid) {
	if ($_mysql_uniqid != $_cookie_uniqid) {
		_alert_back('唯一标识符异常');
	}
}
//转义特殊字符为HTML实体
function _html($_string) {
	if (is_array($_string)) {
		foreach ($_string as $key => $value) {
			$_string[$key]=_html($value);//用递归代替htmlspecialchars($value)
		}
	} else {
		$_string= htmlspecialchars($_string);
	}
	return $_string;
}
//转义SQL语句中使用的字符串中的特殊字符
function _mysql_string($_string) {
	if (is_array($_string)) {
		foreach ($_string as $key => $value) {
			$_string[$key]=_mysql_string($value);
		}
	} else {
		$_string= mysql_real_escape_string($_string);
	}
	return $_string;
}
//服务器内存会话销毁
function _session_destroy() {
	if (session_start()) {
		session_destroy();
	}
}
//删除cookies
function _unsetcookies() {
	setcookie('username','',time()-1);
	setcookie('uinqid','',time()-1);
	_session_destroy();
	_location(null,'index.php');
}
//创造加密的唯一标识符
function _sha1_uniqid() {
	return mysql_real_escape_string(sha1(uniqid(rand(),true)));
}
//检查验证码
function _check_code($_first_code,$_end_code) {
	if ($_first_code!=$_end_code) {
		_alert_back('验证码不正确!');
	}
}
/**
* _code()是验证码函数
* @access public
*默认参数：验证码大小为75,25,位数4，无边框
* @param int $_width:验证码宽度
* @param int $_height:验证码高度
* @param int $_rnd_code:验证码位数
* @param boolean $_rnd_code:验证码边框
* @return void
*/
function _code($_width=75,$_height=25,$_rnd_code=4,$_flag=false) {
	//创建验证码
	for ($i=0;$i<$_rnd_code;$i++) { 
		$_nmsg .= dechex(mt_rand(0,15));
	}
	//全局变量跨页面传递
	$_SESSION['code']=$_nmsg;
	// echo $_SESSION['code'];
	//创建图像
	$_img=imagecreatetruecolor($_width,$_height);
	//分配颜色
	$_white=imagecolorallocate($_img,255,255,255);
	//填充
	imagefill($_img,0,0,$_white);
	if ($_flag) {
		//黑色边框
		$_black=imagecolorallocate($_img,0,0,0);
		imagerectangle($_img,0,0,$_width-1,$_height-1,$_black);
	}
	//随机画出6个线条
	for ($i=0;$i<6;$i++) { 
		$_rnd_color=imagecolorallocate($_img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
		imageline($_img,mt_rand(0,$_width),mt_rand(0,$_height),mt_rand(0,$_width),mt_rand(0,$_height),$_rnd_color);
	}
	//随机雪花
	for ($i=0;$i<50;$i++) { 
		$_rnd_color=imagecolorallocate($_img,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));
		imagestring($_img,1,mt_rand(1,$_width),mt_rand(1,$_height), '*', $_rnd_color);
	}
	//输出验证码
	for ($i=0,$len=strlen($_SESSION['code']);$i<$len;$i++) { 
		$_rnd_color=imagecolorallocate($_img,mt_rand(0,100),mt_rand(0,150),mt_rand(0,200));
		imagestring($_img,mt_rand(3,5),$i*$_width/$len+mt_rand(1,10),mt_rand(1,$_height/2),$_SESSION['code'][$i],$_rnd_color);
	}
	//输出图像
	header('Content-type: image/png');
	imagepng($_img);
	//销毁图像
	imagedestroy($_img);
} 
//分页模块:1.分页参数初始化$_sql:获取总条数&$_pagesize:指定条数/每页
function _page($_sql,$_size) {
	global $_page,$_pagenum,$_pagesize,$_num,$_pageabsolute;
	if (isset($_GET['page'])) {
		$_page=$_GET['page'];
		if (empty($_page) || $_page<=0 || !is_numeric($_page)) {
			$_page=1;
		} else {
			$_page=intval($_page);
		}
	} else {
		$_page=1;
	} 
	$_pagesize=$_size;
	$_num=_num_rows(_query($_sql));
	if ($_num==0) {
		$_pageabsolute=1;
	} else {
		$_pageabsolute=ceil($_num/$_pagesize);
	}
	if ($_page>$_pageabsolute) {
		$_page=$_pageabsolute;
	}
	$_pagenum=($_page - 1) * $_pagesize;
}
//2.分页函数:$_type有两个值1:文本分页&2:数字分页
function _paging($_type) {
	global $_pageabsolute,$_pagesize,$_num,$_pagenum,$_page,$_id;
	if ($_type == 1) {
		echo '	<div id="page_num">';
		echo '<ul>';
			for ($i=0;$i<$_pageabsolute;$i++) {
				if ($_page==($i+1)) {
					echo '<li><a href="'.SCRIPT.'.php?'.$_id.'page='.($i+1).'" class="selected">'.($i+1).'</a></li>';
				} else {
					echo '<li><a href="'.SCRIPT.'.php?'.$_id.'page='.($i+1).'">'.($i+1).'</a></li>';
				} 
			}
		echo '</ul>';
		echo '</div>';
	} elseif ($_type==2) {
		echo '<div id="page_text">';
		echo '<ul>';
				echo '<li>'.$_page.'/'.$_pageabsolute.' | </li>';
			if ($_page<$_pageabsolute) {
				echo '<li>共有<strong>'.$_pagesize.'</strong>条数据 | </li>';
			} elseif ($_page==$_pageabsolute) {
				echo '<li>共有<strong>'.($_num-$_pagesize*($_pageabsolute-1)).'</strong>条数据 | </li>';
			}
				
			if ($_page==1) {
				echo '<li>首页 | </li>';
				echo '<li>上一页 | </li>';	
			} else {
				echo '<li><a href="'.SCRIPT.'.php">首页</a> | </li>';
				echo '<li><a href="'.SCRIPT.'.php?'.$_id.'page='.($_page-1).'">上一页</a> | </li>';
			}
			if ($_page==$_pageabsolute) {
				echo '<li>下一页 | </li>';
				echo '<li>尾页 | </li>';	
			} else {
				echo '<li><a href="'.SCRIPT.'.php?'.$_id.'page='.($_page+1).'">下一页</a> | </li>';
				echo '<li><a href="'.SCRIPT.'.php?'.$_id.'page='.$_pageabsolute.'">尾页</a> | </li>';
			}
		echo '</ul>';
	    echo '</div>';
	} else {
		_paging(2);
	}
}
//获取XML
function _get_xml($_xmlfile) {
	$_html=array();
	if (file_exists($_xmlfile)) {
		$_xml=file_get_contents($_xmlfile);
		preg_match_all('/<vip>(.*)<\/vip>/s',$_xml,$_dom);
		foreach ($_dom[1] as $_value) {
			preg_match_all('/<id>(.*)<\/id>/s',$_value,$_id);
			preg_match_all('/<username>(.*)<\/username>/s',$_value,$_username);
			preg_match_all('/<sex>(.*)<\/sex>/s',$_value,$_sex);
			preg_match_all('/<face>(.*)<\/face>/s',$_value,$_face);
			preg_match_all('/<email>(.*)<\/email>/s',$_value,$_email);
			preg_match_all('/<url>(.*)<\/url>/s',$_value,$_url);
			$_html['id']=$_id[1][0];
			$_html['username']=$_username[1][0];
			$_html['sex']=$_sex[1][0];
			$_html['face']=$_face[1][0];
			$_html['email']=$_email[1][0];
			$_html['url']=$_url[1][0];
		}
	} else {
		echo '文件不存在';
	}
	return $_html;
}
//生成XML
function _set_xml($_xmlfile,$_clean) {
	$_fp=@fopen($_xmlfile,'w');
	if (!$_fp) {
		exit('文件不存在！');
	}
	flock($_fp,LOCK_EX);
	$_string="<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n";
	fwrite($_fp,$_string,strlen($_string));
	$_string="<vip>\r\n";
	fwrite($_fp,$_string,strlen($_string));
	$_string="\t<id>{$_clean['id']}</id>\r\n";
	fwrite($_fp,$_string,strlen($_string));
	$_string="\t<username>{$_clean['username']}</username>\r\n";
	fwrite($_fp,$_string,strlen($_string));
	$_string="\t<sex>{$_clean['sex']}</sex>\r\n";
	fwrite($_fp,$_string,strlen($_string));
	$_string="\t<face>{$_clean['face']}</face>\r\n";
	fwrite($_fp,$_string,strlen($_string));
	$_string="\t<email>{$_clean['email']}</email>\r\n";
	fwrite($_fp,$_string,strlen($_string));
	$_string="\t<url>{$_clean['url']}</url>\r\n";
	fwrite($_fp,$_string,strlen($_string));
	$_string="</vip>";
	fwrite($_fp,$_string,strlen($_string));
	flock($_fp,LOCK_UN);
	fclose($_fp);
}
//解析ubb代码
function _ubb($_string) {
	$_string=nl2br($_string);
	$_string=preg_replace('/\[size=(.*)\](.*)\[\/size\]/U','<span style="font-size:\1px">\2</span>',$_string);
	$_string=preg_replace('/\[b\](.*)\[\/b\]/U','<strong>\1</strong>',$_string);
	$_string=preg_replace('/\[i\](.*)\[\/i\]/U','<em>\1</em>',$_string);
	$_string=preg_replace('/\[u\](.*)\[\/u\]/U','<span style="text-decoration:underline">\1</span>',$_string);
	$_string=preg_replace('/\[s\](.*)\[\/s\]/U','<span style="text-decoration:line-through">\1</span>',$_string);
	$_string=preg_replace('/\[color=(.*)\](.*)\[\/color\]/U','<span style="color:\1">\2</span>',$_string);
	$_string=preg_replace('/\[url\](.*)\[\/url\]/U','<a href="\1" target="_blank">\1</a>',$_string);
	$_string=preg_replace('/\[email\](.*)\[\/email\]/U','<a href="mailto:\1">\1</a>',$_string);
	$_string=preg_replace('/\[img\](.*)\[\/img\]/U','<img src="\1" alt="图片">',$_string);
	$_string=preg_replace('/\[flash\](.*)\[\/flash\]/U','<embed style="width:480px;height:400px" src="\1">',$_string);
	return $_string;
}
//缩略图程序
function _thumb($_filename,$_percentage) {
	header('Content-type: image/png');
	$_n=explode('.',$_filename);//截取文件扩展名
	list($width,$height)=getimagesize($_filename);//获得原图的尺寸并赋给变量
	//微缩图：表面大小改变，容量也改变(14+'px')
	$_width=$width*$_percentage;
	$_height=$height*$_percentage;
	$im=imagecreatetruecolor($_width, $_height);//创建新尺寸画布
	switch ($_n[1]) {
		case 'jpg':$_im=imagecreatefromjpeg($_filename);
			break;
		case 'png':$_im=imagecreatefrompng($_filename);
			break;
		case 'gif':$_im=imagecreatefromgif($_filename);
			break;
	}
	//载入原图并把原图重新采样复制到新画布上
	imagecopyresampled($im, $_im, 0, 0, 0, 0, $_width, $_height, $width, $height);
	//输出新图
	imagejpeg($im);
	//销毁
	imagedestroy($im);
	imagedestroy($_im);
}
?>