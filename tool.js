/*
	二次封装：2016-06-27 基础函数库
*/

//浏览器检测
(function () {
	window.sys = {};                           //让外部可以访问保存浏览器信息对象
	var ua = navigator.userAgent.toLowerCase();//获取浏览器信息字符串
	var s;									   //浏览器信息数组浏览器名称+版本

	//alert(ua);
	//alert(ua.match(/msie ([\d.]+)/));

	// if ((/opr\/([\d.]+)/).test(ua)) {
	// 	s = ua.match(/opr\/([\d.]+)/);
	// 	sys.opera = s[1];
	// }

	// if ((/version\/([\d.]+).*safari/).test(ua)) {
	// 	s = ua.match(/version\/([\d.]+).*safari/);
	// 	sys.safari = s[1];
	// }

	(s = ua.match(/opr\/([\d.]+)/)) ? sys.opera = s[1] :
	(s = ua.match(/msie ([\d.]+)/)) ? sys.ie = s[1] :
	(s = ua.match(/firefox\/([\d.]+)/)) ? sys.firefox = s[1] :
	(s = ua.match(/chrome\/([\d.]+)/)) ? sys.chrome = s[1] :
	(s = ua.match(/version\/([\d.]+).*safari/)) ? sys.safari = s[1] : 0;

	if (/applewebkit/.test(ua)) sys.webkit = ua.match(/applewebkit\/([\d.]+)/)[1];

	
})();


//DOM加载
function addDomLoaded(fn) {
	var isReady = false;
	var timer = null;
	function doReady() {
		if (timer) clearInterval(timer);
		if (isReady) return;
		isReady = true;
		fn();
	}

	if ((sys.opera && sys.opera < 9)||(sys.firefox && sys.firefox < 3)||(sys.webkit && sys.webkit < 525)) {
		//目前主流浏览器判断的都是complete这种方法类似onload即图片加载完成后才加载
		//用于非主流浏览器向下兼容即可
		// timer = setInterval(function() {
		// 	if (/loaded|complete/.test(document.readyState)) {
		// 		doReady();
		// 	}
		// },1);

		timer = setInterval(function() {
			if (document && document.getElementById && document.getElementsByTagName && document.body) {
				doReady();
			}
		},1);
	}else if (document.addEventListener) {
		addEvent(document,'DOMContentLoaded',function() { //W3C
			fn();
			removeEvent(document,'DOMContentLoaded',arguments.callee);
		});
	}else if (sys.ie && sys.ie < 9) {
		var timer = null;
		timer = setInterval(function() {
			try {
				document.documentElement.doScroll('left');
				doReady();
			}catch(e) {};
		},1);
	}
};

//跨浏览器添加事件绑定
function addEvent(obj,type,fn) {
	if (obj.addEventListener) {
		obj.addEventListener(type,fn,false);
	}else {
		//解决IE 1.无法删除事件拒绝使用attachEvent 2.无法顺序执行 3.传递this和event问题 4.重复函数屏蔽
		//创建一个存放事件的哈希表(散列表)
		if(!obj.events) obj.events = {};
		if (!obj.events[type]) {
			//创建一个存放事件处理函数的数组
			obj.events[type] = [];
			//把第一次事件处理函数存储到第一个位置上
			if(obj['on' + type]) obj.events[type][0] = fn;
		} else {
			if (addEvent.equal(obj.events[type],fn)) return false;
		}
		obj.events[type][addEvent.ID++] = fn;
		//最后执行事件处理函数
		obj['on' + type] = addEvent.exec;
	}
}
//为每个事件分配一个ID计数器
addEvent.ID = 1;
//执行事件处理函数:传递this和event问题
addEvent.exec = function(event) {
	var e = event || addEvent.fixEvent(window.event);
	var es = this.events[e.type];
	for (var i in es) {
		es[i].call(this,e);
	}
};
//同一个函数多次出现进行屏蔽
addEvent.equal = function(es,fn) {
	for (var i in es) {
		if (es[i] == fn) return true;
	}
	return false;
};
//把IE常用的event对象配对到W3C中
addEvent.fixEvent = function (event) {
	event.preventDefault = addEvent.fixEvent.preventDefault;
	event.stopPropagation = addEvent.fixEvent.stopPropagation;
	event.target = event.srcElement;
	return event;
}
//IE阻止默认行为
addEvent.fixEvent.preventDefault = function() {
	this.returnValue = false;
}
//IE取消冒泡
addEvent.fixEvent.stopPropagation = function() {
	this.cancelBubble = true;
}
//获取event事件
// function getEvent(event) {
// 	return event || window.event;
// }

//阻止默认行为
function preDef(e) {
	e.preventDefault();
	// var e = getEvent(event);
	// if (typeof e.preventDefault != 'undefined') {
	// 	e.preventDefault();//W3C
	// }else {
	// 	e.returnValue = false;
	// }
}

//跨浏览器移除事件绑定
function removeEvent(obj,type,fn) {
	if (obj.removeEventListener) {
		obj.removeEventListener(type,fn,false);
	}else {
		if (obj.events) {
			for (var i in obj.events[type]) {
				if (obj.events[type][i] == fn) {
					delete obj.events[type][i];
				}
			}
		}
	}
}

//跨浏览器获取style
function getStyle(element,attr) {
	var value;
	if (typeof window.getComputedStyle != 'undefined') {//W3C
		value = window.getComputedStyle(element,null)[attr];
	}else if (typeof element.currentStyle != 'undefined') {//IE
		value = element.currentStyle[attr];
	}
	return value;
}

//跨浏览器获取视口大小
function getInner() {
	if(typeof window.innerWidth != 'undefined') {
		return {
			width : window.innerWidth,
			height : window.innerHeight
		}
	}else {
		return {
			width : document.documentElement.clientWidth,
			height : document.documentElement.clientHeight
		}
	}
}

//跨浏览器获取滚动条位置:物体不随滚动条的滚动而滚动
function getScroll() {
	return {
		top : document.documentElement.scrollTop || document.body.scrollTop,
		left : document.documentElement.scrollLeft || document.body.scrollLeft
	}
}

//判断class是否存在
function hasClass(element,className) {
	return element.className.match(new RegExp('(\\s|^)'+className+'(\\s|$)'));
}

//跨浏览器添加link规则
function insertRule(sheet,selectorText,cssText,position) {
	if (typeof sheet.insertRule != 'undefined') {//W3C
		sheet.insertRule(selectorText+'{'+cssText+'}',position);
	}else if (typeof sheet.addRule != 'undefined') {//IE
		sheet.addRule(selectorText,cssText,position);
	}
}

//跨浏览器移除link规则
function deleteRule(sheet,index) {
	if (typeof sheet.deleteRule != 'undefined') {//W3C
		sheet.deleteRule(index);
	}else if (typeof sheet.removeRule != 'undefined') {//IE
		sheet.removeRule(index);
	}
}

//跨浏览器获取innerText
function getInnerText(element) {
	return (typeof element.textContent == 'string') ? element.textContent : element.innerText;
}

//跨浏览器设置innerText
function setInnerText(element,text) {
	if (typeof element.textContent == 'string') {
		element.textContent = text;
	} else {
		element.innerText = text;
	}
}

//获取某一个元素到最外层顶点的位置
function offsetTop(element) {
	var top = element.offsetTop;
	var parent = element.offsetParent;
	while (parent != null) {
		top += parent.offsetTop;
		parent = parent.offsetParent;
	}
	return top;
}

//删除前后空格
function trim(str) {
	return str.replace(/(^\s*)|(\s*$)/g,'');
}

//某一个值是否存在于某一个数组中
function inArray(array,value) {
	for(var i in array) {
		if (array[i] === value) return true;
	}
	return false;
}

//获取某一个节点的上一个节点的索引
function prevIndex(current,parent) {
	var length = parent.children.length;
	if (current == 0) return length -1;
	return parseInt(current) - 1;
};

//获取某一个节点的下一个节点的索引
function nextIndex (current,parent) {
	var length = parent.children.length;
	if (current == length - 1) return 0;
	return parseInt(current) + 1;
};

//锁屏滚动固定
function fixedScroll() {
	setTimeout(function() {
		window.scrollTo(fixedScroll.left,fixedScroll.top);
	},100);
};

//创建cookie
function setCookie(name,value,expires,path,domain,secure) {
	var cookieName = encodeURIComponent(name) + '=' + encodeURIComponent(value);
	if (expires instanceof Date) {
		cookieName += ';expires=' + expires;
	}
	if (path) cookieName += ';path=' + path;
	if (domain) cookieName += ';domain=' + domain;
	if (secure) cookieName += ';secure';
	document.cookie = cookieName;
};

// user=%E8%91%A3%E6%96%87%E9%BE%99; url=qlc.com; email=yuzhishuisheng%40gmail.com
// 1.得到cookieName:user=|url=|email=
// 2.得到cookieStart:user=0,url=34,email=47,不是三个其中一个得到值为-1
// 3.得到cookieEnd:user=32,url=45,email=-1|79,不是三个其中一个得到值为-1
// 4.得到cookieValue:cookieStart+(user=).length,cookieEnd
//获取cookie值
function getCookie(name) {
	var cookieName = encodeURIComponent(name) + '=';
	var cookieStart = document.cookie.indexOf(cookieName);
	var cookieValue = null;
	if (cookieStart > -1) {
		var cookieEnd = document.cookie.indexOf(';',cookieStart);
		if (cookieEnd == -1) {
			cookieEnd = document.cookie.length;
		}
		cookieValue = decodeURIComponent(document.cookie.substring(cookieStart + cookieName.length,cookieEnd));
	}
	return cookieValue;
};

//删除cookie值
function unsetCookie(name) {
	document.cookie = name + "=;expires=" + new Date(0);
};

//设置失效天数
function setCookieDate(day) {
	var date = null;
	if (typeof day == 'number' && day > 0) {
		date = new Date();
		date.setDate(date.getDate() + day);
	}else {
		throw new Error('您传递的天数不合法！必须是大于0的数字');
	}
	return date;
};