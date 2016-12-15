$(function() {

	//登陆界面
	$('#login').dialog({
		title : '登陆后台',
		width : 300,
		height : 180,
		modal : true,
		iconCls : 'icon-login',
		buttons : '#btn',
	});

	//管理员账号验证
	$('#manager').validatebox({
		required : true,
		missingMessage : '请输入管理员账号',
		invalidMessage : '管理员账号不得为空',
	});

	//管理员密码验证
	$('#password').validatebox({
		required : true,
		validType : 'length[6,30]',
		missingMessage : '请输入管理员密码',
		invalidMessage : '管理员密码不得为空',
	});

	//加载时判断验证
	if (!$('#manager').validatebox('isValid')) {
		$('#manager').focus();
	}else if (!$('#password').validatebox('isValid')) {
		$('#password').focus();
	}

	//点击登陆
	$('#btn a').click(function() {
		if (!$('#manager').validatebox('isValid')) {
			$('#manager').focus();
		}else if (!$('#password').validatebox('isValid')) {
			$('#password').focus();
		}else {
			$.ajax({
				url : 'checklogin.php',
				type : 'post',
				data : {
					manager : $('#manager').val(),
					password : $('#password').val(),
				},
				beforeSend : function() {
					$.messager.progress({
						text : '正在登陆中......',
					});
				},
				success : function(data,response,status) {
					$.messager.progress('close');

					if (data > 0) {
						location.href = 'admin.php';
					}else {
						$.messager.alert('登录失败!','用户名或密码错误!','warning',function() {
							$('#password').select();
						});
					}
				},
			});
		}
	});
	
});