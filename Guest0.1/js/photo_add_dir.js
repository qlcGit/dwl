$(function () {
	var fm = document.getElementsByTagName('form')[0];
	var pass = document.getElementById('pass');
	var up = document.getElementById('up');
	fm[1].onclick = function() {
		pass.style.display = 'none';
	};
	fm[2].onclick = function() {
		pass.style.display = 'block';
	};
	up.onclick = function() {
		centerWindow('upcover.php','up',400,200);
	};
	fm.onsubmit = function() {
		//用户名验证
		if (fm.name.value.length < 2 || fm.name.value.length > 20) {
			alert('相册名不得小于2位或大于20位');
			fm.name.value = '';
			fm.name.focus();
			return false;
		}
		//密码验证
		if (fm[2].checked) {
			if (fm.password.value.length < 6) {
				alert('密码不得小于6位');
				fm.password.value = '';
				fm.password.focus();
				return false;
			}
		}
		return true;
	};
});
function centerWindow(url,name,width,height) {
	var left = (screen.width - width) / 2;
	var top = (screen.height - height) / 2;
	window.open(url,name,'width='+width+',height='+height+',top='+top+',left='+left);
}