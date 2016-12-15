function code() {
	//验证码点击局部更新
	var code = document.getElementById('code');
	if (code == null) {
		return;
	}
	code.onclick = function () {
		this.src = 'code.php?tm='+Math.random();
	};
}