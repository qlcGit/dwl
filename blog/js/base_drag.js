/*
	插件:2016-06-27
	
*/	

//拖动插件
$().extend('drag',function() {
	var tags = arguments; //外部调用就可以不用数组了
	for (var i = 0; i < this.elements.length; i++) {
		//拖拽流程
		//1.先点下去mousedown
		//2.点下的物体被选中进行mousemove
		//3.抬起鼠标mouseup
		//点击用oDiv即可move和up是全局区域也就是文档区域应该用document
		// this.elements[i].onmousedown = function(e) {
		addEvent(this.elements[i],'mousedown',function(e) {	
			//var e = getEvent(e);
			if(trim(this.innerHTML).length == 0) e.preventDefault();
			var _this = this;
			var diffX = e.clientX - _this.offsetLeft;
			var diffY = e.clientY - _this.offsetTop;

			//自定义拖拽区域
			var flag = false;
			for (var i = 0;i < tags.length;i++) {
				if (e.target == tags[i]) {
					flag = true;  //只要有一个true就跳出
					break;
				}
			}

			//限定可拖动区域
			if(flag) {
				//document.onmousemove = function(e)
				addEvent(document,'mousemove',move);
				//document.onmouseup = function()
				addEvent(document,'mouseup',up);
			}else {
				removeEvent(document,'mousemove',move);
				removeEvent(document,'mouseup',up);
			}

			function move(e) {
				//var e = getEvent(e);
				var left = e.clientX - diffX;
				var top = e.clientY - diffY;

				//防止拖拽溢出
				if (left < 0) {
					left = 0;
				} else if (left <= getScroll().left) {
					left = getScroll().left;
				} else if (left > getInner().width + getScroll().left - _this.offsetWidth) {
					left = getInner().width + getScroll().left - _this.offsetWidth;
				}
				if (top < 0) {
					top = 0;
				} else if (top <= getScroll().top) {
					top = getScroll().top;
				} else if (top > getInner().height + getScroll().top - _this.offsetHeight) {
					top = getInner().height + getScroll().top - _this.offsetHeight;
				}
				_this.style.left = left + 'px';
				_this.style.top = top + 'px';
				//IE限制弹出窗口向下溢出
				if(typeof _this.setCapture != 'undefined') {
					_this.setCapture();
				} 
			}

			function up() {
				removeEvent(document,'mousemove',move);
				this.onmousemove = null;
				this.onmouseup = null;

				//IE限制弹出窗口向下溢出
				if (typeof _this.releaseCapture != 'undefined') {
					_this.releaseCapture();
				}
			}
		});
	}
	return this;
});
