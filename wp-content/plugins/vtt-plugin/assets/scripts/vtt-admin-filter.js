;(function ( $, window ) {
	$(document).ready(function() {
		$('#btnAdd').click(function() {
			let html = '';
			let dataId = parseInt($(this).attr('data-id'));
			dataId = dataId+1;
			let tagName = 'childName';
			let tagId = tagName + dataId;
			
			$(this).attr('data-id', dataId);
						
			html += '<div class="vtt-col-lg-6 vtt-col-12 col-fx appendBlock">'
			html += '<div class="form-group">'
			html += '<label for="' + tagId + '" class="label">Tên thông tin lọc ' + dataId + '</label>'
			html += '<input type="text" class="input" name="childId" value="0" hidden>'
			html += '<div class="inline-group">'
			html += '<input type="text" class="input" id="' + tagId + '" name="'+ tagName +'" placeholder="Nhập tên thông tin lọc ' + dataId + '...">'
			html += '<div class="group-append">'
			html += '<button type="button" class="vtt-btn btn-outline-danger btnRemove">Xóa</button>'
			html += '</div>'
			html += '</div>'
			html += '</div>'
			html += '</div>'
			
			$('#target').append(html);
		});

		$('#target').on('click', '.btnRemove', function() {
			$(this).parents('.appendBlock').remove();
		});
		
		$('#btnCreate').click(function(){
			let _this = this;
			let parentName = $('input[name="parentName"]').val();
			let childName = multipleValues('input[name="childName"]');
			
			if(empty(parentName)){
				showNotification('Nhập tên mục thông tin lọc', -1);
				return;
			}
			
			if(childName.length < 1){
				showNotification('Hãy tạo thông tin lọc', -1);
				return;
			}
			
			for (let i = 0; i < childName.length; i++) {
				if(empty(childName[i])){
					showNotification('Vui lòng nhập thông tin lọc', -1);
					return;
				}
			};
			
			$.ajax({
				type: 'post',
				dataType: 'json',
				url: vtt_admin_param.url,
				data : {
					action: admin_filter.create.action,
					security: admin_filter.create.nonce,
					parent_name: parentName,
					child_name: childName,
				},
				beforeSend: function(){
					$(_this).attr('disabled', true);
				},
				success: function(response) {
					if(response.success == true){
						$(_this).attr('disabled', true);
						showNotification(response.data,0);
						setTimeout(function(){ 
							$('#btnEsc').get(0).click();
						}, 2000);
					}else{
						$(_this).attr('disabled', false);
						showNotification(response.data,1);
					}
				},
				error: function(jqXHR, textStatus){
					console.log( 'The following error occured ' + textStatus);
					showNotification('Đã xảy ra lỗi',-1);
				}
			})
			return false;
		});

		$('#btnEdit').click(function(){
			let _this = this;
			let parentId = $('input[name="parentId"]').val();
			let parentName = $('input[name="parentName"]').val();
			let childId = multipleValues('input[name="childId"]');
			let childName = multipleValues('input[name="childName"]');
			
			if(empty(parentName)){
				showNotification('Nhập tên mục thông tin lọc', -1);
				return;
			}
			
			if(childName.length < 1){
				showNotification('Hãy tạo thông tin lọc', -1);
				return;
			}
			
			for (let i = 0; i < childName.length; i++) {
				if(empty(childName[i])){
					showNotification('Vui lòng nhập thông tin lọc', -1);
					return;
				}
			};
			
			$.ajax({
				type: 'post',
				dataType: 'json',
				url: vtt_admin_param.url,
				data : {
					action: admin_filter.edit.action,
					security: admin_filter.edit.nonce,
					parent_id: parentId,
					parent_name: parentName,
					child_id: childId,
					child_name: childName,
				},
				beforeSend: function(){
					$(_this).attr('disabled', true);
				},
				success: function(response) {
					if(response.success == true){
						$(_this).attr('disabled', true);
						showNotification(response.data,0);
						setTimeout(function(){ 
							$('#btnEsc').get(0).click();
						}, 2000);
					}else{
						$(_this).attr('disabled', false);
						showNotification(response.data,1);
					}
				},
				error: function(jqXHR, textStatus){
					console.log( 'The following error occured ' + textStatus);
					showNotification('Đã xảy ra lỗi',-1);
				}
			})
			return false;
		});
		
	});
})( jQuery, window );