$(function () {
	var message = document.getElementsByName('message');
	var friend = document.getElementsByName('friend');
	var flower = document.getElementsByName('flower');
	for (var i = 0,len = message.length; i < len; i++) {
		message[i].onclick = function () {
			centerWindow('message.php?id='+this.title,'message',500,300);
		};
	}
	for (var i = 0,len1 = friend.length; i < len1; i++) {
		friend[i].onclick = function () {
			centerWindow('friend.php?id='+this.title,'friend',500,300);
		};
	}
	for (var i = 0,len2 = flower.length; i < len2; i++) {
		flower[i].onclick = function () {
			centerWindow('flower.php?id='+this.title,'flower',500,300);
		};
	}
});
function centerWindow(url,name,width,height) {
	var left = (screen.width - width) / 2;
	var top = (screen.height - height) / 2;
	window.open(url,name,'width='+width+',height='+height+',top='+top+',left='+left);
}