;(function ( $, window ) {
	$(document).ready(function() {

		$('#btnAddImage').click(function(event){
			
			event.preventDefault();
			
			let frame;
			if ( frame ) {
				frame.open();
				return;
			}

			// Create a new media frame
			frame = wp.media({
				title: 'Chọn ảnh tại thư viện',
				button: {
					text: 'Chọn'
				},
				multiple: false  // Set to true to allow multiple files to be selected
			});
			
			// When an image is selected in the media frame...
			frame.on( 'select', function() {
				// Get media attachment details from the frame state
				let attachment = frame.state().get('selection').first().toJSON();
				
				let html = '';
				html += '<figure class="image">'
				html += '<input type="text" name="image" value="'+ attachment.url +'" hidden />'
				html += '<img class="img" src="'+ attachment.url +'"/>'
				html += '<a href="javascript:void(0);" class="vtt-btn btn-outline-danger btn-text btnRemoveImage">Xóa</a>'
				html += '</figure>';
				
				$('#groupImage').append(html);
			});

			// Finally, open the modal on click
			frame.open();
		});
		
		$('#groupImage').on('click', '.btnRemoveImage', function() {
			$(this).parents('.image').remove();
		});
		
		$('#btnCreate').click(function(){
			let _this = this;
			let postId = $('option:selected', '[name=postId]').val();
			let defaultPrice = $('input[name="defaultPrice"]').val();
			let size = $('input[name="size"]').val();
			let authorName = $('input[name="authorName"]').val();
			let authorStory = $('textarea[name="authorStory"]').val();
			let image = multipleValues('input[name="image"]');
			let style = $('option:selected', '[name=style]').val();
			let theme = $('option:selected', '[name=theme]').val();
			let material = $('option:selected', '[name=material]').val();

			if(empty(postId) || empty(defaultPrice) || empty(size) || empty(authorName)){
				showNotification('Hãy nhập dữ liệu đầy đủ theo dấu *.',-1);
				return;
			}
			
			if(postId == 0){
				showNotification('Vui lòng chọn sản phẩm.',-1);
				return;
			}
			
			$.ajax({
				type: 'post',
				dataType: 'json',
				url: vtt_admin_param.url,
				data : {
					action: admin_product.create.action,
					security: admin_product.create.nonce,
					postId: postId,
					defaultPrice: defaultPrice,
					size: size,
					authorName: authorName,
					authorStory: authorStory,
					image: image,
					style: style,
					theme: theme,
					material: material,
				},
				beforeSend: function(){
					$(_this).attr('disabled', true);
				},
				success: function(response) {
					if(response.success == true){
						$(_this).attr('disabled', true);
						showNotification(response.data,0);
						setTimeout(function(){ 
							$('#btnEsc')[0].click();
						}, 2000);
					}else{
						$(_this).attr('disabled', false);
						showNotification(response.data,1);
					}
				},
				error: function(jqXHR, textStatus){
					console.log( 'The following error occured ' + textStatus);
				}
			})
			return false;
		});

		$('#btnEdit').click(function(){
			let _this = this;
			let postId = $('input[name=postId]').val();
			let defaultPrice = $('input[name="defaultPrice"]').val();
			let size = $('input[name="size"]').val();
			let authorName = $('input[name="authorName"]').val();
			let authorStory = $('textarea[name="authorStory"]').val();
			let image = multipleValues('input[name="image"]');
			let style = $('option:selected', '[name=style]').val();
			let theme = $('option:selected', '[name=theme]').val();
			let material = $('option:selected', '[name=material]').val();

			if(empty(postId) || empty(defaultPrice) || empty(size) || empty(authorName)){
				showNotification('Hãy nhập dữ liệu đầy đủ theo dấu *.',-1);
				return;
			}
			
			if(postId == 0){
				showNotification('Vui lòng chọn sản phẩm.',-1);
				return;
			}
			
			$.ajax({
				type: 'post',
				dataType: 'json',
				url: vtt_admin_param.url,
				data : {
					action: admin_product.edit.action,
					security: admin_product.edit.nonce,
					postId: postId,
					defaultPrice: defaultPrice,
					size: size,
					authorName: authorName,
					authorStory: authorStory,
					image: image,
					style: style,
					theme: theme,
					material: material,
				},
				beforeSend: function(){
					$(_this).attr('disabled', true);
				},
				success: function(response) {
					if(response.success == true){
						$(_this).attr('disabled', true);
						showNotification(response.data,0);
						setTimeout(function(){ 
							$('#btnEsc')[0].click();
						}, 2000);
					}else{
						$(_this).attr('disabled', false);
						showNotification(response.data,1);
					}
				},
				error: function(jqXHR, textStatus){
					console.log( 'The following error occured ' + textStatus);
				}
			})
			return false;
		});

		$('.delProduct').click(function(){
			let popup = false;
			let _this = this;

			if ('undefined' != showNotice){
				popup = showNotice.warn();
			};
		
			if (popup) {
				let _id  = parseInt($(_this).attr('data-id'));
				if(_id <= 0){
					showNotification('Truyền dữ liệu gặp vấn đề.',-1);
					return;
				}

				$.ajax({
					type: 'post',
					dataType: 'json',
					url: hainm_admin_param.url,
					data : {
						action: admin_product_delete.action,
						security: admin_product_delete.nonce,
						id: _id,
					},
					beforeSend: function(){
						$(_this).attr('disabled', true);
					},
					success: function(response) {
						if(response.success == true){
							$(_this).attr('disabled', true);
							showNotification(response.data,0);
							setTimeout(function(){ 
								location.reload();
							}, 1500);
						}else{
							$(_this).attr('disabled', false);
							showNotification(response.data,1);
						}
					},
					error: function(jqXHR, textStatus){
						console.log( 'The following error occured ' + textStatus);
					}
				})
			};
			return false;
		});
	});
})( jQuery, window );