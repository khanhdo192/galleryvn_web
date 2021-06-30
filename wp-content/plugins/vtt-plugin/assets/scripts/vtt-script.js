;(function ( $, window ) {
	$(document).ready(function() {

		function multipleValues (_element) {
			let val = new Array();
			jQuery(_element).each(function() {
				val.push(jQuery(this).val())
			});
			return val;
		}

		function empty (str) {
			if (typeof str == 'undefined' || !str || str.length === 0 || str === "" || !/[^\s]/.test(str) || /^\s*$/.test(str) || str.replace(/\s/g,"") === ""){
				return true;
			}else{
				return false;
			}
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
		
	});
})( jQuery, window );