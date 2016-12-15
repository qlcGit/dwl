$(function () {
	//验证码点击局部更新
	code();
	//头像
	var faceimg = document.getElementById("faceimg");
	//表单验证
	var fm = document.getElementsByTagName('form')[0];

	if (faceimg != null) {
		faceimg.onclick = function () {
			window.open('face.php','face','width=400,height=400,top=0,left=0,scrollbars=1');
		};
	}
	if (fm != undefined) {
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
			if (fm.password.value != fm.notpassword.value) {
				alert('密码确认必须一致');
				fm.notpassword.value = '';
				fm.notpassword.focus();
				return false;
			}
			//密码提示与回答
			if (fm.question.value.length < 2 || fm.question.value.length > 20) {
				alert('密码提示不得小于2位或大于20位');
				fm.question.value = '';
				fm.question.focus();
				return false;
			}
			if (fm.answer.value.length < 2 || fm.answer.value.length > 20) {
				alert('密码提示不得小于2位或大于20位');
				fm.answer.value = '';
				fm.answer.focus();
				return false;
			}
			if (fm.answer.value.length == fm.question.value.length) {
				alert('密码提示与回答不得相同');
				fm.answer.value = '';
				fm.answer.focus();
				return false;
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
	}
});