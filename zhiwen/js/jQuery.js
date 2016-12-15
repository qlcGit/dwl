$(function () {
 	$('#search_button').button({
 		icons:{
 			primary:'ui-icon-search',
 			//secondary:'ui-icon-triangle-1-s',
 		}
 	});
 	$('#question_button').button({
 		icons:{
 			primary:'ui-icon-lightbulb',
 			//secondary:'ui-icon-triangle-1-s',
 		}
 	}).click(function() {
 		if ($.cookie('user')) {
 			$('#question').dialog('open');
 		} else {
 			$('#error').dialog('open');
 			setTimeout(function() {
 				$('#error').dialog('close');
 				$('#login').dialog('open');
 			},1000);
 		}
 	});

 	$.ajax({
 		url : 'show_content.php',
 		type : 'POST',
 		success : function (response,status,xhr) {
 			var json = $.parseJSON(response);
 			var html = '';
 			var arr = [];
 			var summary = [];
 			$.each(json,function(index, value) {
 				html += '<h4>' + value.user + ' 发表于 ' + value.date + '</h4><h3>' + value.title + '</h3><div class="editor">' + value.content + '</div><div class="bottom"><span class="comment" date-id="'+ value.id +'">'+ value.count +'条评论</span> <span class="up">收起</span></div><hr noshade="noshade" size="1"><div class="comment_list"></div>';
 			});
 			$('.content').append(html);

 			//1.字符串方法
 			$.each($('.editor'),function(index, value) {
 				arr[index] = $(value).html();
 				summary[index] = arr[index].substr(0,200);

 				if (summary[index].substring(199,200) == '<') {
 					summary[index] = replacePos(summary[index],200,'');
 				}
 				if (summary[index].substring(198,200) == '</') {
 					summary[index] = replacePos(summary[index],200,'');
 					summary[index] = replacePos(summary[index],199,'');
 				}
 				if (arr[index].length > 200) {
 					summary[index] += '...<span class="down">显示全部</span>';
 					$(value).html(summary[index]);
 				}
 				$('.bottom .up').hide();
 			});

 			//动态绑定第二次失效
 			// $.each($('.editor .down'),function(index, value) {
 			// 	$(this).click(function() {
 			// 		$('.editor').eq(index).html(arr[index]);
 			// 		$(this).hide();
 			// 		$('.bottom .up').eq(index).show();
 			// 	});	
 			// });	
 			// $.each($('.bottom .up'),function(index, value) {
 			// 	$(this).click(function() {
 			// 		$('.editor').eq(index).html(summary[index]);
 			// 		$(this).hide();
 			// 		$('.editor .down').eq(index).show();
 			// 	});	
 			// });

 			//采取委托绑定
 			$.each($('.editor'),function(index, value) {
 				$(this).on('click', '.down', function() {
 					$('.editor').eq(index).html(arr[index]);
 					$(this).hide();
 					$('.bottom .up').eq(index).show();
 				});	
 			});	
 			$.each($('.bottom'),function(index, value) {
 				$(this).on('click', '.up', function() {
 					$('.editor').eq(index).html(summary[index]);
 					$(this).hide();
 					$('.editor .down').eq(index).show();
 				});	
 			});

 			$.each($('.bottom'),function(index, value) {
 				$(this).on('click','.comment',function() {
 					var comment_this = this;
 					if($.cookie('user')) {
 						if (!$('.comment_list').eq(index).has('form').length) {
 							$.ajax({
 								url : 'show_comment.php',
 								type : 'POST',
 								data : {
 									titleid : $(comment_this).attr('date-id'),
 								},
 								beforeSend : function (jqXHR,settings) {
 									$('.comment_list').eq(index).append('<dl class="comment_load"><dd>正在加载评论</dd></dl>');
 								},
 								success : function (response,status) {
 									$('.comment_list').eq(index).find('.comment_load').hide();
 									var json_comment = $.parseJSON(response);
 									$.each(json_comment,function(index2, value) {
						 				$('.comment_list').eq(index).append('<dl class="comment_content"><dt>'+ value.user +'</dt><dd>'+ value.comment +'</dd><dd class="date">'+ value.date +'</dd></dl>');
						 			});
 									$('.comment_list').eq(index).append('<form><dl class="comment_add"><dt><textarea name="comment"></textarea></dt><dd><input type="hidden" name="titleid" value="'+ $(comment_this).attr('date-id') +'"><input type="hidden" name="user" value="'+ $.cookie('user') +'"><input type="button" value="发表"></dd></dl></form>');
 									$('.comment_list').eq(index).find('input[type=button]').button().click(function() {
			 							var _this = this;
			 							$('.comment_list').eq(index).find('form').ajaxSubmit({
			 								url : 'add_comment.php',
			 								type : 'POST',
			 								beforeSubmit : function(formData,jqForm,options) {
							 					$('#loading').dialog('open');
							 					$(_this).button('disable');
							 				},
							 				success : function(responseText, statusText) {
							 					if(responseText) {
							 						$(_this).button('enable');
							 						$('#loading').css('background','url(image/###) no-repeat 20px center').html('评论新增成功!');	
							 						setTimeout(function() {
							 							var date = new Date();
							 							$('#loading').dialog('close');
							 							$('.comment_list').eq(index).prepend('<dl class="comment_content"><dt>'+ $.cookie('user') +'</dt><dd>'+ $('.comment_list').eq(index).find('textarea').val() +'</dd><dd class="date">'+date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate()+' '+date.getHours()+':'+date.getMinutes()+':'+date.getSeconds()+'</dd></dl>')
							 							$('.comment_list').eq(index).find('form').resetForm();
							 							$('#loading').css('background','url(image/###) no-repeat 20px center').html('数据交互中......');
							 						},1000)
							 					}
							 				},
			 							});
			 						});	
 								},
 							});
 						}
 						if ($('.comment_list').eq(index).is(':hidden')) {
 							$('.comment_list').eq(index).show();
 						}else {
 							$('.comment_list').eq(index).hide();
 						}
 					}else {
 						$('#error').dialog('open');
 						setTimeout(function() {
 							$('#error').dialog('close');
 							$('#login').dialog('open');
 						},1000)
 					}
 				});
 			});

 			//2.指定高度方法
 			// $.each($('.editor'), function(index,value) {
 			// 	arr[index] = $(value).height();
 			// 	if ($(value).height() > 158) {
 			// 		$(value).next('.bottom').find('.up').hide();
 			// 	}
 			// 	$(value).height(158);
 			// });

 			// $.each($('.bottom .down'),function(index, value) {
 			// 	$(this).click(function() {
 			// 		$(this).parent().prev().height(arr[index]);
 			// 		$(this).hide();
 			// 		$(this).parent().find('.up').show();
 			// 	});	
 			// });	

 			// $.each($('.bottom .up'),function(index, value) {
 			// 	$(this).click(function() {
 			// 		$(this).parent().prev().height(158);
 			// 		$(this).hide();
 			// 		$(this).parent().find('.down').show();
 			// 	});	
 			// });
 		},
 	});

 	$('#question').dialog({
 		autoOpen:false,
 		modal:true,
 		resizable:false,
 		width:550,
 		height:350,
 		buttons:{
 			'发布':function() {
 				$(this).ajaxSubmit({
 					url : 'add_content.php',
 					type : 'POST',
 					data : {
 						user : $.cookie('user'),
 					},
 					beforeSubmit:function(formData,jqForm,options) {
	 					$('#loading').dialog('open');
	 					$('#question').dialog('widget').find('button').eq(1).button('disable');
	 				},
	 				success:function(responseText, statusText) {
	 					if(responseText) {
	 						$('#question').dialog('widget').find('button').eq(1).button('enable');
	 						$('#loading').css('background','url(image/###) no-repeat 20px center').html('发布成功!');	
	 						setTimeout(function() {
	 							$('#loading').dialog('close');
	 							$('#question').dialog('close');
	 							$('#question').resetForm();
	 							$('#loading').css('background','url(image/###) no-repeat 20px center').html('数据交互中......');
	 						},1000)
	 					}
	 				},
 				});
 			}
 		}
 	});

 	//百度UEditor
 	UE.getEditor('container',{
 		toolbars: [
		    ['fullscreen', 'source', 'undo', 'redo'],
		    ['bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc']
		]
 	});

 	$('#error').dialog({
 		autoOpen:false,
 		modal:true,
 		closeOnEscape:false,
 		resizable:false,
 		draggable:false,
 		width:180,
 		height:50,
 	}).parent().find('.ui-widget-header').hide();

 	$('#member,#logout').hide();
 	if($.cookie('user')) {
 		toggleLog();
 	}else {
 		$('#member,#logout').hide();
 		$('#reg_a,#login_a').show();
 	}
 	function toggleLog() {
 		$('#member,#logout').show();
 		$('#reg_a,#login_a').hide();
 		$('#member').html($.cookie('user'));
 	}

 	$('#logout').click(function() {
 		$.removeCookie('user');
 		window.location.href = '/jquery/';
 	});

 	$('#loading').dialog({
 		autoOpen:false,
 		modal:true,
 		closeOnEscape:false,
 		resizable:false,
 		draggable:false,
 		width:180,
 		height:50,
 	}).parent().find('.ui-widget-header').hide();

 	$('#reg_a').click(function() {
 		$('#reg').dialog('open');
 	});

 	$('#reg').dialog({
 		autoOpen:false,
 		modal:true,
 		resizable:false,
 		width:320,
 		height:340,
 		buttons:{
 			'提交':function() {
 				$(this).submit();
 			}
 		}
 	}).buttonset().validate({
 		submitHandler : function (form) {
 			$(form).ajaxSubmit({
 				url:'add.php',
 				type:'POST',
 				beforeSubmit:function(formData,jqForm,options) {
 					$('#loading').dialog('open');
 					$('#reg').dialog('widget').find('button').eq(1).button('disable');
 				},
 				success:function(responseText, statusText) {
 					//alert(responseText);
 					if(responseText) {
 						$('#reg').dialog('widget').find('button').eq(1).button('enable');
 						$('#loading').css('background','url(image/###) no-repeat 20px center').html('新增数据成功!');
 						$.cookie('user',$('#user').val());
 						setTimeout(function() {
 							$('#loading').dialog('close');
 							$('#reg').dialog('close');
 							$('#reg').resetForm();
 							$('#reg span.star').html('*').removeClass('succ');
 							$('#loading').css('background','url(image/###) no-repeat 20px center').html('数据交互中......');
 							toggleLog();
 						},1000)
 					}
 				},
 			});
 		},

 		showErrors : function (errorMap,errorList) {
 			var errors = this.numberOfInvalids();
 			if (errors > 0) {
 				$('#reg').dialog('option','height',errors * 20 + 340);
 			} else {
 				$('#reg').dialog('option','height',340);
 			}

 			this.defaultShowErrors();
 		},

 		highlight : function (element,errorClass) {
 			$(element).css('border','1px solid #630');
 			$(element).parent().find('span').html('*').removeClass('succ');
 		},
 		unhighlight : function (element,errorClass) {
 			$(element).css('border','1px solid #ccc');
 			$(element).parent().find('span').html('&nbsp;').addClass('succ');
 		},

  		errorLabelContainer : 'ol.reg_error',
 		wrapper : 'li',

 		rules: {
 			user: {
 				required : true,
 				minlength : 2,
 				remote : {
 					url : 'is_user.php',
 					type : 'POST',
 				}
 			},
 			pass: {
 				required : true,
 				minlength : 6,
 			},
 			email: {
 				required : true,
 				email : true,
 			},
 			date: {
 				date : true,
 				//可写可不写
 			},
 		},
 		messages:{
 			user:{
 				required : '账号不得为空',
 				minlength : jQuery.validator.format('账号不得小于{0}位'),
 				remote : '账号被占用!'
 			},
 			pass:{
 				required : '密码不得为空',
 				minlength : jQuery.validator.format('账号不得小于{0}位'),
 			},
 			email:{
 				required : '邮箱不得为空',
 				minlength : '请输入正确的邮箱',
 			},
 		}
 	}); 
 	//$('#reg').parent().find('button').eq(1).button('disable');
 	//$('#reg').dialog('widget').find('button').eq(1).button('disable');
 	//$('#reg input[type=radio]').button();
 	//$('#reg').buttonset();
 	$('#date').datepicker({
 		changeMonth:true,
 		changeYear:true,
 		yearSuffix:'',
 		//maxDate:0,
 		yearRange:'1950:2020',
 	});
 	$('#reg input[title]').tooltip({
 		show:false,
 		hide:false,
 		position:{
 			my:'left center',
 			at:'right+20 center'
 		}
 	});

 	$('#email').autocomplete({
 		delay:0,
 		autoFocus:true,
 		source:function(request,response) {
 			var hosts = ['qq.com','163.com','gmail.com','hotmail.com','sina.com'],
 				term = request.term,       //获取用户输入的数据
 				name = term,			   //邮箱的用户名
 				host = '',				   //邮箱的域名
 				ix = term.indexOf('@'),	   //@的位置
 				result = [];               //最终呈现的邮箱列表

 			result.push(term);
 			//判断当有@时从新分配邮箱的name和host
 			if (ix > -1) {
 				name = term.slice(0,ix);
 				host = term.slice(ix + 1);
 			}
 			if (name) {
 				//1.如果用户已输入@和域名就
 				//找到相关的域名提示。e.g:bbns@1 提示bbns@163.com
 				//2.如果用户没有输入@和域名就
 				//把所有的域名都提示
 				var findedHosts = (host?$.grep(hosts,function(value,index) {
 						return value.indexOf(host) > -1}):hosts),
 				    findedResult = $.map(findedHosts,function(value,index) {
 						return name + '@'+ value;
 					});
 				result = result.concat(findedResult);
 			}
 			response(result);
 		},
 	});



 	$('#login_a').click(function() {
 		$('#login').dialog('open');
 	});

 	$('#login').dialog({
 		autoOpen:false,
 		modal:true,
 		resizable:false,
 		width:320,
 		height:240,
 		buttons:{
 			'登陆':function() {

 				$(this).submit();
 			}
 		}
 	}).validate({
 		submitHandler : function (form) {
 			$(form).ajaxSubmit({
 				url:'login.php',
 				type:'POST',
 				beforeSubmit:function(formData,jqForm,options) {
 					$('#loading').dialog('open');
 					$('#login').dialog('widget').find('button').eq(1).button('disable');
 				},
 				success:function(responseText, statusText) {
 					if(responseText) {
 						$('#login').dialog('widget').find('button').eq(1).button('enable');
 						$('#loading').css('background','url(image/###) no-repeat 20px center').html('登陆成功!');
 						if ($('#expires').is(':checked')) {
 							$.cookie('user',$('#login_user').val(),{
 								expires : 7,
 							});
 						}else{
 							$.cookie('user',$('#login_user').val());
 						}
 						setTimeout(function() {
 							$('#loading').dialog('close');
 							$('#login').dialog('close');
 							$('#login').resetForm();
 							$('#login span.star').html('*').removeClass('succ');
 							$('#loading').css('background','url(image/###) no-repeat 20px center').html('数据交互中......');
 							toggleLog();
 						},1000)
 					}
 				},
 			});
 		},

 		showErrors : function (errorMap,errorList) {
 			var errors = this.numberOfInvalids();
 			if (errors > 0) {
 				$('#login').dialog('option','height',errors * 20 + 240);
 			} else {
 				$('#login').dialog('option','height',240);
 			}

 			this.defaultShowErrors();
 		},

 		highlight : function (element,errorClass) {
 			$(element).css('border','1px solid #630');
 			$(element).parent().find('span').html('*').removeClass('succ');
 		},
 		unhighlight : function (element,errorClass) {
 			$(element).css('border','1px solid #ccc');
 			$(element).parent().find('span').html('&nbsp;').addClass('succ');
 		},

  		errorLabelContainer : 'ol.login_error',
 		wrapper : 'li',

 		rules: {
 			login_user: {
 				required : true,
 				minlength : 2,
 			},
 			login_pass: {
 				required : true,
 				minlength : 6,
 				remote : {
 					url : 'login.php',
 					type : 'POST',
 					data : {
 						login_user : function () {
 							return $('#login_user').val();
 						}
 					}
 				}
 			}
 		},
 		messages:{
 			login_user:{
 				required : '账号不得为空',
 				minlength : jQuery.validator.format('账号不得小于{0}位'),
 			},
 			login_pass:{
 				required : '密码不得为空',
 				minlength : jQuery.validator.format('账号不得小于{0}位'),
 				remote : '账号或密码不正确!'
 			}
 		}
 	});


 	$('#tabs').tabs({
 		collapsible : true,
 		//event : 'mouseover',
 		// active : 1,
 		active : false,
 		// load : function (event,ui) {
 		// 	alert($(ui.tab.get()).html());
 		// },
 		// beforeLoad : function (event,ui) {
 		// 	ui.jqXHR.success(function (responseText) {
 		// 		alert(responseText);
 		// 	});
 		// },
 	});
 	// $('#button').click(function () {
 	// 	$('#tabs').tabs('load',0)
 	// });
 	// $('#tabs').on('tabsload',function() {
 	// 	alert('ajax远程加载文档后触发')
 	// });
 	
 	$('#accordion').accordion({
 		collapsible : true,
 		active : false,
 		//disable : true,
 		header : 'h3',
 		icons : {
 			"header" : "ui-icon-plus",
 			"activeHeader" : "ui-icon-minus",
 		},
 		// activate : function(event,ui) {
 		// 	alert($(ui.newHeader.get()).html());
 		// 	alert($(ui.newPanel.get()).html());
 		// 	alert($(ui.oldHeader.get()).html());
 		// 	alert($(ui.oldPanel.get()).html());
 		// },
 	});
});

function replacePos(strObj,pos,replaceText) {
	return strObj.substr(0,pos-1) + replaceText + strObj.substr(pos,strObj.length)
}