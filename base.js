 /*
	javascript基础库:2016/6/17
*/

//前台调用
var $ = function (args) {
	return new Base(args);
};

//基础构造函数
//实现连缀功能:最后返回对象,然后在对象中添加方法或函数
function Base(args) {
	//创建数组保存获取的节点和节点数组,每次new时保持变量数组私有
	this.elements = [];
	//模拟CSS选择器
	if (typeof args == 'string') {
		//CSS模拟
		if (args.indexOf(' ') != -1) {
			var elements = args.split(' '); //把元素节点拆开分别保存到数组
			var childElements = []; //存放临时节点对象的数组,解决被覆盖问题
			var node = [];          //存放父节点数组   
			for (var i = 0;i < elements.length;i++) {
				if (node.length == 0) node.push(document); //如果默认没有父节点就把document放入
				switch (elements[i].charAt(0)) {
					case '#':
						childElements = []; //清理掉上一次循环临时节点以便父节点失效
						childElements.push(this.getId(elements[i].substring(1)));
						node = childElements;//因为要清理父节点所以创建node节点
						break;
					case '.':
						childElements = [];
						for (var j = 0;j < node.length;j++) {
							var temps = this.getClass(elements[i].substring(1),node[j]);
							for (k = 0;k < temps.length;k++) {
								childElements.push(temps[k]);
							}
						}
						node = childElements;
						break;
					default:
						childElements = [];
						for (var j = 0;j < node.length;j++) {
							var temps = this.getTagName(elements[i],node[j]);
							for (k = 0;k < temps.length;k++) {
								childElements.push(temps[k]);
							}
						}
						node = childElements;
				}
			}
			this.elements = childElements;
		}else {
			//find模拟
			switch (args.charAt(0)) {
				case '#':
					this.elements.push(this.getId(args.substring(1)));
					break;
				case '.':
					this.elements = this.getClass(args.substring(1));
					break;
				default:
					this.elements = this.getTagName(args);
			}
		}
	}else if (typeof args == 'object') {
		//args是一个对象,undefined也是一个对象,区别于typeof返回的带单引号的'undefined'
		if (args != undefined) {
			this.elements[0] = args;
		}
	}else if (typeof args == 'function') {
		//DOM加载
		this.ready(args);
	}
}

//备用DOM加载方法
Base.prototype.ready = function(fn) {
	addDomLoaded(fn);
};

//获取ID节点
Base.prototype.getId = function(id) {
	return document.getElementById(id);
};

//获取Tag节点
Base.prototype.getTagName = function (tag,parentName) {
	var node = null;
	var temps = [];
	if (parentName != undefined) {
		node = parentName;
	}else {
		node = document;
	}
	var tags = node.getElementsByTagName(tag);
	for(var i = 0;i < tags.length;i++) {
		temps.push(tags[i]);
	}
	return temps;
};

//获取class节点
Base.prototype.getClass = function (className,parentName) {
	var node = null;
	var temps = [];
	// var all = [];
	if (parentName != undefined) {
		node = parentName;
	}else {
		node = document;
	}
	var all = node.getElementsByTagName('*');
	for(var i = 0;i<all.length;i++) {
		// if (all[i].className == className) {对于多个class获取无效
		if ((new RegExp('(\\s|^)'+ className +'(\\s|$)')).test(all[i].className)) {
			temps.push(all[i]);
		}
	}
	return temps;
};

//设置CSS选择器子节点
Base.prototype.find = function (str) {
	var childElements = [];
	for (var i = 0; i < this.elements.length; i++) {
		switch (str.charAt(0)) {
			case '#':
				childElements.push(this.getId(str.substring(1)));
				break;
			case '.':
				var temps = this.getClass(str.substring(1),this.elements[i])
				for (var j = 0;j < temps.length;j++) {
					childElements.push(temps[j]);
				}
				break;
			default:
				var temps = this.getTagName(str,this.elements[i]);
				for(var j = 0;j < temps.length;j++) {
					childElements.push(temps[j]);
				}
		}
	}
	this.elements = childElements;
	return this;
};

//获取某一个节点,并且返回这个节点对象
Base.prototype.ge = function (num) {
	return this.elements[num];
};

//获取某一个节点,并且返回Base对象
Base.prototype.eq = function (num) {
	var element = this.elements[num];
	this.elements = [];
	this.elements[0] = element;
	return this;
};

//获取第一个节点,并且返回这个节点对象
Base.prototype.first = function (num) {
	return this.elements[0];
};

//获取最后一个节点,并且返回这个节点对象
Base.prototype.last = function (num) {
	return this.elements[this.elements.length - 1];
};

//获取某组节点的数量
Base.prototype.length = function () {
	return this.elements.length;
};

//获取某一个节点的属性
Base.prototype.attr = function (attr,value) {
	for(var i = 0;i < this.elements.length; i++) {
		if (arguments.length == 1) {
			return this.elements[i].getAttribute(attr);
		} else if (arguments.length == 2) {
			this.elements[i].setAttribute(attr,value);
		}
	}
	return this;
};

//获取某一个节点在节点数组中的索引
Base.prototype.index = function () {
	var children = this.elements[0].parentNode.children;
	for(var i = 0; i <= children.length; i++) {
		if (this.elements[0] == children[i]) return i;
	}
};

//设置某一个节点的透明度
Base.prototype.opacity = function(num) {
	for (var i = 0; i < this.elements.length; i++) {
		this.elements[i].style.opacity = num / 100;
		this.elements[i].style.filter = 'alpha(opacity=' + num + ')';
	}
	return this;
};

//获取当前元素节点的下一个元素节点
Base.prototype.next = function () {
	for (var i = 0; i < this.elements.length; i++) {
		this.elements[i] = this.elements[i].nextSibling;
		if (this.elements[i] == null) throw new Error('找不到下一个节点!');
		if (this.elements[i].nodeType == 3) this.next();
	}
	return this;
};


//获取当前元素节点的上一个元素节点
Base.prototype.prev = function () {
	for (var i = 0; i < this.elements.length; i++) {
		this.elements[i] = this.elements[i].previousSibling;
		if (this.elements[i] == null) throw new Error('找不到上一个节点!');
		if (this.elements[i].nodeType == 3) this.prev();
	}
	return this;
};

//添加class
Base.prototype.addClass = function (className) {
	for (var i = 0; i < this.elements.length; i++) {
		if (!hasClass(this.elements[i],className)) {
			this.elements[i].className += ' ' + className;
		}
	}
	return this;
};

//移除class
Base.prototype.removeClass = function (className) {
	for (var i = 0; i < this.elements.length; i++) {
		if (hasClass(this.elements[i],className)) {
			this.elements[i].className = this.elements[i].className.replace(new RegExp('(\\s|^)'+className+'(\\s|$)'),' ');
		}
	}
	return this;
}

//添加link和style的CSS规则
Base.prototype.addRule = function (num,selectorText,cssText,position) {
	var sheet = document.styleSheets[num];
	insertRule(sheet,selectorText,cssText,position);
	return this;
};

//移除link和style的CSS规则
Base.prototype.removeRule = function (num,index) {
	var sheet = document.styleSheets[num];
	deleteRule(sheet,index);
	return this;
};

//设置CSS
Base.prototype.css = function (attr,value) {
	for (var i = 0; i < this.elements.length; i++) {
		if (arguments.length == 1) {
			return getStyle(this.elements[i],attr);
		}
		this.elements[i].style[attr] = value;
	}
	return this;
};

//设置表单字段元素
Base.prototype.form = function (name) {
	for (var i = 0; i < this.elements.length; i++) {
		this.elements[i] = this.elements[i][name];
	}
	return this;
};

//获取表单字段内容
Base.prototype.value = function (str) {
	for (var i = 0; i < this.elements.length; i++) {
		if (arguments.length == 0) {
			return this.elements[i].value;
		}
		this.elements[i].value = str;
	}
	return this;
};

//设置innerHTML
Base.prototype.html = function (str) {
	for (var i = 0; i < this.elements.length;i++) {
		if (arguments.length == 0) {
			return this.elements[i].innerHTML;
		}
		this.elements[i].innerHTML = str;
	}
	return this;
};

//设置innerText
Base.prototype.text = function (str) {
	for (var i = 0; i < this.elements.length;i++) {
		if (arguments.length == 0) {
			return getInnerText(this.elements[i]);
		}
		setInnerText(this.elements[i],str);
	}
	return this;
};

//设置鼠标移入移出方法
Base.prototype.hover = function (over,out) {
	for (var i = 0; i < this.elements.length;i++) {
		// this.elements[i].onmouseover = over;
		// this.elements[i].onmouseout = out;
		addEvent(this.elements[i],'mouseover',over);
		addEvent(this.elements[i],'mouseout',out);
	}
	return this;
};

//设置事件发生器
Base.prototype.bind = function (event,fn) {
	for (var i = 0; i < this.elements.length; i++) {
		addEvent(this.elements[i],event,fn);
	}
	return this;
};

//设置点击切换方法
Base.prototype.toggle = function () {
	for (var i = 0; i < this.elements.length; i++) {
		// tog(this.elements[i],arguments);

		//闭包
		(function(element,args) {
			var count = 0; //传进参数(函数)个数计数器
		 	addEvent(element,'click',function() {
		 		args[count++ % args.length].call(this);

			});
		})(this.elements[i],arguments);
	}
	return this;
};
//解决点击切换计数器共享问题:点击对象分别计数
// function tog(element,args) {
// 	var count = 0; //传进参数(函数)个数计数器
// 	addEvent(element,'click',function() {
// 		args[count++ % args.length].call(this);
// 		//count++;
// 		//if (count >= args.length) count = 0;
// 	});
// }

//设置显示
Base.prototype.show = function () {
	for (var i = 0; i < this.elements.length; i++) {
		this.elements[i].style.display = 'block';
	}
	return this;
};

//设置隐藏
Base.prototype.hide = function () {
	for (var i = 0; i < this.elements.length; i++) {
		this.elements[i].style.display = 'none';
	}
	return this;
};

//设置物体居中
Base.prototype.center = function(width,height) {
	var left = (getInner().width -width)/2 + getScroll().left;
	var top = (getInner().height -height)/2 + getScroll().top;
	for (var i = 0; i < this.elements.length; i++) {
		this.elements[i].style.top = top + 'px';
		this.elements[i].style.left = left + 'px';
	}
	return this;
};

//锁屏功能
Base.prototype.lock = function() {
	for (var i = 0; i < this.elements.length; i++) {
		fixedScroll.top = getScroll().top;
		fixedScroll.left = getScroll().left;

		this.elements[i].style.width = getInner().width + getScroll().left + 'px';
		this.elements[i].style.height = getInner().height + getScroll().top + 'px';
		this.elements[i].style.display = 'block';
		//兼容低版本火狐
		parseFloat(sys.firefox < 4) ? document.body.style.overflow = 'hidden' : document.documentElement.style.overflow = 'hidden';

		//禁止选中文本和拖动f
		//火狐和Opera
		addEvent(this.elements[i],'mousedown',preDef);
		//google
		addEvent(this.elements[i],'mouseup',preDef);
		//IE
		addEvent(this.elements[i],'selectstart',preDef);

		addEvent(window,'scroll',fixedScroll);
	}
	return this;
};

//解除锁屏功能
Base.prototype.unlock = function() {
	for (var i = 0; i < this.elements.length; i++) {
		this.elements[i].style.display = 'none';
		parseFloat(sys.firefox < 4) ? document.body.style.overflow = 'auto' : document.documentElement.style.overflow = 'auto';
		//火狐和Opera
		removeEvent(this.elements[i],'mousedown',preDef);
		//google
		removeEvent(this.elements[i],'mouseup',preDef);
		//IE
		removeEvent(this.elements[i],'selectstart',preDef);

		removeEvent(window,'scroll',fixedScroll);
	}
	return this;
};

//触发点击事件
Base.prototype.click = function (fn) {
	for (var i = 0; i < this.elements.length; i++) {
		//this.elements[i].onclick = fn;
		addEvent(this.elements[i],'click',fn);
	}
	return this;
};

//触发浏览器窗口改变事件
Base.prototype.resize = function(fn) {
	for (var i = 0; i < this.elements.length; i++) {
		var element = this.elements[i];
		// window.onresize = function() {
		// 	fn();

		// 	//弹窗拖到哪里就在哪里
		// 	if (element.offsetLeft > getInner().width - element.offsetWidth) {
		// 		element.style.left = getInner().width - element.offsetWidth + 'px';
		// 	}
		// 	if (element.offsetTop > getInner().height - element.offsetHeight) {
		// 		element.style.top = getInner().height - element.offsetHeight + 'px';
		// 	}
		// };
		addEvent(window,'resize',function() {
			fn();
			//弹窗拖到哪里就在哪里
			if (element.offsetLeft > getInner().width + getScroll().left - element.offsetWidth) {
				element.style.left = getInner().width + getScroll().left - element.offsetWidth + 'px';
				//防止窗口缩小后图片缩到窗口内
				if (element.offsetLeft <= 0 + getScroll().left) {
					element.style.left = 0 + getScroll().left + 'px';
				}
			}
			if (element.offsetTop > getInner().height + getScroll().top - element.offsetHeight) {
				element.style.top = getInner().height + getScroll().top - element.offsetHeight + 'px';
				//防止窗口缩小后图片缩到窗口内
				if (element.offsetTop <= 0 + getScroll().top) {
					element.style.top = 0 + getScroll().top + 'px';
				}
			}
		});
	}
	return this;
};

//插件入口
Base.prototype.extend = function(name,fn) {
	Base.prototype[name]=fn;
};

//拖拽功能
// Base.prototype.drag = function() {
// };