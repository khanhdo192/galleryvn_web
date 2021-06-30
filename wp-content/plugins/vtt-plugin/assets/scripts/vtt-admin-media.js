;(function ( $, window ) {
	$(document).ready(function() {
		
		let image = jQuery('#image');
		let tagInput = image.find('input[name="image"]');
		let tagImg = image.find('img[id="img"]');
		
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
				$(tagInput).val(attachment.url);
				$(tagImg).attr('src',attachment.url);				
			});

			// Finally, open the modal on click
			frame.open();
		});
		
		$('#btnRemoveImage').click(function(){
			
			if(empty($(tagInput).val())){
				showNotification('Chưa chọn ảnh.',-1);
				return;
			};
			$(tagInput).val('');
			$(tagImg).attr('src', admin_media.param.defaultImage);	
		});
		
		$('#btnCreate').click(function(){
			let _this = this;
			let name = $('input[name="name"]').val();
			let type = $('option:selected', '[name=type]').val();
			let link = $('input[name="link"]').val();
			let image = $('input[name="image"]').val();

			if(empty(name) || empty(type) || empty(image)){
				showNotification('Hãy nhập dữ liệu đầy đủ theo dấu *.',-1);
				return;
			}
			
			$.ajax({
				type: 'post',
				dataType: 'json',
				url: vtt_admin_param.url,
				data : {
					action: admin_media.create.action,
					security: admin_media.create.nonce,
					type: type,
					name: name,
					link: link,
					image: image,
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
						}, 3000);
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
			let id = $('input[name="id"]').val();
			let name = $('input[name="name"]').val();
			let type = $('option:selected', '[name=type]').val();
			let link = $('input[name="link"]').val();
			let image = $('input[name="image"]').val();

			if(empty(id) && id == '0'){
				showNotification('Truyền dữ liệu gặp lỗi',-1);
				return;
			}
			
			if(empty(name) || empty(type) || empty(image)){
				showNotification('Hãy nhập dữ liệu đầy đủ theo dấu *.',-1);
				return;
			}
			
			$.ajax({
				type: 'post',
				dataType: 'json',
				url: vtt_admin_param.url,
				data : {
					action: admin_media.edit.action,
					security: admin_media.edit.nonce,
					id: id,
					type: type,
					name: name,
					link: link,
					image: image,
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
						}, 3000);
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
	});
})( jQuery, window );