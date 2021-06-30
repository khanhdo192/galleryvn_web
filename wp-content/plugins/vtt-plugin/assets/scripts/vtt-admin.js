function multipleValues(_element) {
	let val = new Array();
	jQuery(_element).each(function() {
		val.push(jQuery(this).val())
	});
	return val;
}

function empty(str) {
	if (typeof str == 'undefined' || !str || str.length === 0 || str === "" || !/[^\s]/.test(str) || /^\s*$/.test(str) || str.replace(/\s/g,"") === ""){
		return true;
	}else{
		return false;
	}
}

function callUploadImage() {
	// ADD IMAGE LINK
	jQuery('.uploadImage').on( 'click', function( event ){

		event.preventDefault();

		let callback = jQuery(this).attr('data-callback');
		if (!callback) {
			return;
		}

		// If the media frame already exists, reopen it.
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
			jQuery('input[name="'+ callback +'"]').val(attachment.url);
			jQuery('#'+ callback + 'Preview').attr('src',attachment.url);
		});
		// Finally, open the modal on click
		frame.open();
	});
}

function showNotification (msg, status) {
	let txtType = '';
	let txtTitle = '';
	if (status == 0){
		txtType = 'success';
		txtTitle = 'Thành công';
	}else if(status==1){
		txtType = 'error';
		txtTitle = 'Thông báo';
	}else if(status==-1){
		txtType = 'warning';
		txtTitle = 'Thông báo';
	}else{
		return;
	}
	if(txtType==''){
		return;
	}
	toastr.options = {
		"closeButton": true,
		"newestOnTop": true,
		"preventDuplicates": false,
		"positionClass": "toast-bottom-right",
	}
	toastr[txtType](msg, txtTitle);
}

function resultTag (_tag, _class, _text) {

	jQuery(_tag).show();
	jQuery(_tag).addClass(_class);
	jQuery(_tag).text(_text);

	setTimeout(hideMsg,3000);

	function hideMsg(){
		jQuery(_tag).fadeOut();
		jQuery(_tag).removeClass(_class);
	}
}
