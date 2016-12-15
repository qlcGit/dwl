$(function () {
	var img = document.getElementsByTagName('img');
	for (var i=0,len=img.length;i<len;i++) {
		img[i].onclick = function () {
			_opener(this.alt);
		};
	}
});
function _opener(src) {
	opener.document.getElementById('faceimg').src = src;
	opener.document.register.face.value = src;
}