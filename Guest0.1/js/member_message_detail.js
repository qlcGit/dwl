$(function () {
	var ret = document.getElementById('return');
	var del = document.getElementById('delete');
	ret.onclick = function () {
		history.back();
	};
	del.onclick = function () {
		if (confirm('确定要删除此条短信吗？')) {
			location.href = '?action=delete&id='+this.name;
		}
	};
});