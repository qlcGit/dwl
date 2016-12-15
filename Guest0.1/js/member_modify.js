$(function () {
	//验证码点击局部更新
	code();
	//表单验证
	var fm = document.getElementsByTagName('form')[0];
	fm.onsubmit = function () {
		//密码验证
		if (fm.password.value != '') {
			if (fm.password.value.length < 6) {
				alert('密码不得小于6位');
				fm.password.value = '';
				fm.password.focus();
				return false;
			}
		}
		//邮箱验证
		if (!/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/.test(fm.email.value)) {
			alert('邮件格式不正确');
			fm.email.value = '';
			fm.email.focus();
			return false;
		}
		//QQ验证
		if (fm.qq.value != '') {
			if (!/^[1-9]{1}[\d]{4,9}$/.test(fm.qq.value)) {
				alert('QQ号码不正确');
				fm.qq.value = '';
				fm.qq.focus();
				return false;
			}
		}
		//URL验证
		if (fm.url.value != '') {
			if (!/^http(s)?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/.test(fm.url.value)) {
				alert('url不正确');
				fm.url.value = '';
				fm.url.focus();
				return false;
			}
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