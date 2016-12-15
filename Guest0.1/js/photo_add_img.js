$(function () {
	var up = document.getElementById('up');
	var fm = document.getElementsByTagName('form')[0];
	fm.onsubmit = function() {
		if (fm.name.value.length < 2 || fm.name.value.length > 40) {
			alert('图片名不得小于2位或大于40位');
			fm.name.focus();
			return false;
		}
		if (fm.url.value == '') {
			alert('地址不得为空！');
			fm.url.focus();
			return false;
		}
		return true;
	};
	up.onclick = function() {
		centerWindow('upimg.php?dir='+this.title,'up',400,200);
	};
});

function centerWindow(url,name,width,height) {
	var left = (screen.width - width) / 2;
	var top = (screen.height - height) / 2;
	window.open(url,name,'width='+width+',height='+height+',top='+top+',left='+left);
}

