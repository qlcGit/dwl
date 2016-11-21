//名值对转换
// function params(date) {
// 	var arr=[];
// 	for(var i in date) {
// 		//alert(date[i]);
// 		arr.push(encodeURIComponent(i)+'='+encodeURIComponent(date[i]));

// 	}
// 	return arr.join('&');
// }

//封装Ajax
function ajax(obj) {
	var xhr = new XMLHttpRequest();
	obj.url = obj.url+'?rand='+ Math.random();
	// obj.date = params(obj.date);
	obj.date = (function(date) {
		var arr=[];
		for(var i in date) {
			//alert(date[i]);
			arr.push(encodeURIComponent(i)+'='+encodeURIComponent(date[i]));

		}
		return arr.join('&');
	})(obj.date);
	if(obj.method === 'get')obj.url += obj.url.indexOf('?')==-1?'?'+obj.date:'&'+obj.date;
	//alert(obj.url);
	//异步判断
	if (obj.async === true) {
		xhr.onreadystatechange = function() {
			if(xhr.readyState == 4) {
				callback();
			}
		};
	}
	xhr.open(obj.method,obj.url,obj.async);
	if (obj.method === 'post') {
		xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xhr.send(obj.date);
	}else {
		xhr.send(null);
	}
	//同步判断
	if (obj.async === false) {
		callback();
	}
	function callback() {
		if(xhr.status == 200) {
			obj.success(xhr.responseText);   //回调传参
		}else {
			alert('获取数据错误!错误代号: '+ xhr.status + ', 错误信息: '+ xhr.statusText)
		}
	}
}