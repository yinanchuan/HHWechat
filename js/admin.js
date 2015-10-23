jQuery(function($) {
	
	//Show collect list
	$('.view-codes').on('click', function(e){
		var uid = $(this).attr('data-uid');
		var wename = $(this).attr('data-wename');
		
		//title
		$('#myModalLabel').html(wename + '\'s codes');
		
		//loading
		var _html = '<tr class="info"><td colspan="5">Loading...</td></tr>';
		$('#myModalTbody').html(_html);
		
		var url = 'admin.php/viewcodes?id=' + uid;
		Utils.ajaxGet(url, function(res){
			if(!res.success){
				alert(res.msg);
				return false;
			}
			
			var table_ = [];
			
			var list = res.data;
			if(list && list.length > 0){
				for (var i = 0; i < list.length; i++){
					if(i%2 == 0){
						table_.push('<tr class="info">');
					}else{
						table_.push('<tr>');
					}
					table_.push('<td>' + (i+1) + '</td>');
					table_.push('<td>' + list[i].cdate + '</td>');
					table_.push('<td>' + list[i].times + '</td>');
					table_.push('<td>' + list[i].codes + '</td>');
					table_.push('<td>' + list[i].codeused + '</td>');
					table_.push('</tr>');
				}
			}else{
				table_.push('<tr class="info">');
				table_.push('<td colspan="5">No query to data.</td>');
				table_.push('</tr>');
			}
			$('#myModalTbody').html(table_.join(''));
		});
	});
	
	//Code Verifys
	$('#select-password').change(function(){
		var uid = $(this).children('option:selected').val();
		if(!uid || uid == null){
			return false;
		}
		Utils.location('admin.php/verifys?uid=' + uid);
	});
	
	//Change password
    $('#but-submit-updpwd').on('click',function() {
		var username = $('#input-username').val();
		var oldpwd = $('#input-oldpassword').val();
		var password = $('#input-password').val();
		var truepwd = $('#input-truepassword').val();
		if (Utils.isNull(oldpwd) || Utils.isNull(password) || Utils.isNull(truepwd)) {
            alert('The password is not allowed to be empty.');
			return false;
        }
        if (password !== truepwd) {
            alert('Two password input is not consistent.');
			return false;
        }
		
		Utils.ajaxPost('admin.php/updatepwd', {
			username: username,
			oldpwd: oldpwd,
			password: password
		}, function (data) {
			alert(data.msg);
			//$('#form-admin-updpwd')[0].reset();
			document.getElementById('form-admin-updpwd').reset();
        });
    });
	
	//code setting
    $('#but-create-codes').on('click',function(){
		Utils.ajaxPost('admin.php/codesetting', {
			
		}, function (data) {
			//TODO ajax
			alert(data.msg);
        });
    });
	
});
