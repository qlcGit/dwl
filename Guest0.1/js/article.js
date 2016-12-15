$(function () {
	code();
	var ubb = document.getElementById('ubb');
	var deny = document.getElementById('deny');
	var fm = document.getElementsByTagName('form')[1];
	var font = document.getElementById('font');
	var html = document.getElementsByTagName('html')[0];
	var color = document.getElementById('color');
	var message = document.getElementsByName('message');
	var friend = document.getElementsByName('friend');
	var flower = document.getElementsByName('flower');
	var re = document.getElementsByName('re');
	var q = document.getElementById('q');
	if (deny != null) {
		deny.onclick = function () {
			return confirm('你真的要删除吗？') ? true : false;
		};
	}
	if (fm != undefined) {
		fm.onsubmit = function () {
			//标题验证
			if (fm.title.value.length < 2 || fm.title.value.length > 40) {
				alert('标题不得小于2位或大于40位');
				fm.title.value = '';//清空
				fm.title.focus();//聚焦
				return false;
			}
			//内容验证
			if (fm.content.value.length < 10) {
				alert('内容不得小于10位');
				fm.content.value = '';//清空
				fm.content.focus();//聚焦
				return false;
			}
			//验证码
			if (fm.yzm.value.length != 4) {
				alert('验证码必须是4位');
				fm.yzm.value = '';
				fm.yzm.focus();
				return false;
			}
			return true;
		};
	}
	for (var i = 0,len = message.length; i < len; i++) {
		message[i].onclick = function () {
			centerWindow('message.php?id='+this.title,'message',300,500);
		};
	}
	for (var i = 0,len1 = friend.length; i < len1; i++) {
		friend[i].onclick = function () {
			centerWindow('friend.php?id='+this.title,'friend',300,500);
		};
	}
	for (var i = 0,len2 = flower.length; i < len2; i++) {
		flower[i].onclick = function () {
			centerWindow('flower.php?id='+this.title,'flower',300,500);
		};
	}
	for (var i = 0,len3 = re.length; i < len3; i++) {
		re[i].onclick = function () {
			fm.title.value=this.title;
		};
	}
	if (q != null) {
		var qa = q.getElementsByTagName('a');
		qa[0].onclick = function() {
			window.open('q.php?num=22&path=images/qpic/1/','q','width=400,height=400,scrollbars=1');
		}
		qa[1].onclick = function() {
			window.open('q.php?num=15&path=images/qpic/2/','q','width=400,height=400,scrollbars=1');
		}
		qa[2].onclick = function() {
			window.open('q.php?num=24&path=images/qpic/3/','q','width=400,height=400,scrollbars=1');
		}
  	}
	if (font != null) {
		html.onmouseup = function() {
			font.style.display = 'none';
			color.style.display = 'none';
		};
	}
	if (ubb != null) {
		var ubbimg = ubb.getElementsByTagName('img');
		ubbimg[0].onclick = function() {
			font.style.display = 'block';
		};
		ubbimg[1].onclick = function() {
			content('[b][/b]');
		};
		ubbimg[2].onclick = function() {
			content('[i][/i]');
		};
		ubbimg[3].onclick = function() {
			content('[u][/u]');
		};
		ubbimg[4].onclick = function() {
			content('[s][/s]');
		};
		ubbimg[5].onclick = function() {
			color.style.display = 'block';
			fm.t.focus();
		};
		ubbimg[6].onclick = function() {
			var url = prompt('请输入网址：','http://');
			if (url) {
				if (/^http(s)?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/.test(url)) {
					content('[url]'+url+'[/url]');
				} else {
					alert('网址不合法!');
				}
			}
		};
		ubbimg[7].onclick = function() {
			var email = prompt('请输入邮件地址：','@');
			if (email) {
				if (/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/.test(email)) {
					content('[email]'+email+'[/email]');
				} else {
					alert('电子邮件不合法!');
				}
			}
		};
		ubbimg[8].onclick = function() {
			var img = prompt('请输入图片地址：','');
			if (img) {
				content('[img]'+img+'[/img]');
			}
		};
		ubbimg[9].onclick = function() {
			var flash = prompt('请输入flash网址：','http://');
			if (flash) {
				if (/^http(s)?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+/.test(flash)) {
					content('[flash]'+flash+'[/flash]');
				} else {
					alert('视频地址不合法!');
				}
			}
		};
		ubbimg[13].onclick = function() {
			fm.content.rows += 2;
		};
		ubbimg[14].onclick = function() {
			fm.content.rows -= 2;
		};
	}
	function content(string) {
		fm.content.value += string;
	};
	if (fm != undefined) {
		fm.t.onclick = function() {
			showcolor(this.value);
		};
	}
});
function font(size) {
	document.getElementsByTagName('form')[0].content.value += '[size='+size+'][/size]';
}
function showcolor(value) {
	document.getElementsByTagName('form')[0].content.value += '[color='+value+'][/color]';
}
function centerWindow(url,name,height,width) {
	var top = (screen.height - height) / 2;
	var left = (screen.width - width) / 2;
	window.open(url,name,'height='+height+',width='+width+',top='+top+',left='+left);
}