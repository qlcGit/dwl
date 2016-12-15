$(function () {
	code();
	//表单验证
	var fm = document.getElementsByTagName('form')[0];
	fm.onsubmit = function () {
		//验证码
		if (fm.yzm.value.length != 4) {
			alert('验证码必须是4位');
			fm.yzm.focus();
			return false;
		}
		//密码验证
		if (fm.content.value.length < 10 || fm.content.value.length > 200) {
			alert('短信内容不得小于10位或者不得大于200位');
			fm.content.focus();
			return false;
		}
		return true;
	};
});