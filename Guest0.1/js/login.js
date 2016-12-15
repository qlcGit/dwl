$(function () {
	//验证码点击局部更新
	code();
	//表单验证
	var fm = document.getElementsByTagName('form')[0];
	var reg = document.getElementById('location');
	reg.onclick = function () {
		location.href='register.php';
		return false;
	};
	fm.onsubmit = function () {
		//用户名验证
		if (fm.username.value.length < 2 || fm.username.value.length > 20) {
			alert('用户名不得小于2位或大于20位');
			fm.username.value = '';//清空
			fm.username.focus();//聚焦
			return false;
		}
		if (/[<>\'\"\ ]/.test(fm.username.value)) {
			alert('用户名不得包含非法字符');
			fm.username.value = '';
			fm.username.focus();
			return false;
		}
		//密码验证
		if (fm.password.value.length < 6) {
			alert('密码不得小于6位');
			fm.password.value = '';
			fm.password.focus();
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
});