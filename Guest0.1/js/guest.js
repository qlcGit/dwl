$(function () {
	//验证码点击局部更新
	code();
	//表单验证
	var fm = document.getElementsByTagName('form')[0];
	var del = document.getElementById('delete');
	var ja = document.getElementsByTagName('guest');
	del.onclick = function () {
		return confirm('你真的要删除吗？') ? true : false;
	};
	fm.onsubmit = function () {
		//验证码
		if (fm.content.value.length <10 || fm.content.value.length >200) {
			alert('留言内容不得小于10位且不得大于200位');
			fm.content.focus();
			return false;
		}
		//验证码
		if (fm.yzm.value.length != 4) {
			alert('验证码必须是4位');
			fm.yzm.focus();
			return false;
		}
		return true;
	};
});