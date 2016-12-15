$(function () {
	var skins=document.getElementById('skins');
	if (skins != null) {
		skins.onmouseover = function() {
			inskin();
		};
		skins.onmouseout = function() {
			outskin();
		};
	}
});
function inskin() {
	var skin=document.getElementById('skin');
	skin.style.display='block';
}
function outskin() {
	var skin=document.getElementById('skin');
	skin.style.display='none';
}
