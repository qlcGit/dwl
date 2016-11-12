/*
	插件:2016-10-31
*/	

//拖动插件
$().extend('animate',function(obj) {

	for (var i = 0; i < this.elements.length; i++) {
		
		var element = this.elements[i];

		var attr = obj['attr'] == 'x' ? 'left' : obj['attr'] == 'y' ? 'top' : 
		            obj['attr'] == 'w' ? 'width' : obj['attr'] == 'h' ? 'height' : 
		            obj['attr'] == 'o' ? 'opacity' : obj['attr'] != undefined ? obj['attr'] : 'left';  //x和y轴高度和宽度可选参数left和top两种值


		var start = obj['start'] != undefined ? obj['start'] :
		    attr == 'opacity' ? parseFloat((element,attr)) * 100 : parseInt(getStyle(element,attr));//可选参数默认CSS起始位置


		var t = obj['t'] != undefined ? obj['t'] : 10; //可选参数默认10毫秒
		var step = obj['step'] != undefined ? obj['step'] : 20;//可选参数默认每10毫秒20像素
		var alter = obj['alter'];
		var target = obj['target'];
		var mul = obj['mul'];
 		
		var speed = obj['speed'] != undefined ? obj['speed'] : 6; //可选参数默认缓冲速度6
		var type = obj['type'] == 0 ? 'constant' : obj['type'] == 1 ? 'buffer' : 'buffer'; //可选参数0表示匀速1表示缓冲默认缓冲

		if (alter != undefined && target == undefined) {
			target = alter + start;
		}else if (alter == undefined && target == undefined && mul == undefined) {
			throw new Error('alter增量或目标量必须传一个！');
		}

		if (start > target) step = -step;

		if (attr == 'opacity') {
			element.style.opacity = parseInt(start) / 100;
			element.style.filter = 'alpha(opacity=' + parseInt(start) + ')';
		} else {
			//element.style[attr] = start + 'px';
		}
		//加载同步动画前先判断，不然单个动画target无法传值
		if (mul == undefined) {
			mul = {};
			mul[attr] = target;
		}
		
		clearInterval(element.timer);
		//每个动画添加定时器
		element.timer = setInterval(function() {
			//创建一个布尔值这个值可以了解多个动画是否都执行完毕
			var flag = true; //表示都执行完毕
			
			//同步队列动画
			for(var i in mul) {
				attr = i == 'x' ? 'left' : i == 'y' ? 'top' : i == 'w' ? 'width' : i == 'h' ? 'height' : i == 'o' ? 'opacity' : i != undefined ? i : 'left';
				target = mul[i];

				if (type == 'buffer') {
					step = attr == 'opacity' ? (target - parseFloat(getStyle(element,attr)) * 100)/speed :
											   (target - parseInt(getStyle(element,attr)))/speed;
					step = step > 0 ? Math.ceil(step) : Math.floor(step);
				}

				if (attr == 'opacity') {
					if (step == 0) {
						setOpacity();
					}else if (step > 0 && Math.abs(parseFloat(getStyle(element,attr)) * 100 - target) <= step) {
						setOpacity();
					}else if (step < 0 && (parseFloat(getStyle(element,attr)) * 100 - target) <= Math.abs(step)) {
						setOpacity();
					} else {
						var temp = parseFloat(getStyle(element,attr)) * 100;
						element.style.opacity = parseInt(temp + step) / 100;
						element.style.filter = 'alpha(opacity='+ parseInt(temp + step) +')';
					}
					if (parseInt(target) != parseInt(parseFloat(getStyle(element,attr))*100)) flag = false;

				}else {
					if (step == 0) {
						setTarget();
					}else if (step > 0 && Math.abs(parseInt(getStyle(element,attr)) - target) <= step) {
						setTarget();
					}else if (step < 0 && (parseInt(getStyle(element,attr)) - target) <= Math.abs(step)) {
						setTarget();
					} else {
						element.style[attr] = parseInt(getStyle(element,attr)) + step + 'px';
					}
					
					//判断多个动画是否都执行完毕
					if (parseInt(target) != parseInt(getStyle(element,attr))) flag = false;
				}
			}

			if (flag) {
				clearInterval(element.timer);
				if (obj.fn != undefined) obj.fn();
			}

		},t);

		function setTarget() {
			element.style[attr] = target + 'px';
		}

		function setOpacity() {
			element.style.opacity = parseInt(target) / 100;
			element.style.filter = 'alpha(opacity='+ parseInt(target) +')';
		}
	}
	return this;
});
