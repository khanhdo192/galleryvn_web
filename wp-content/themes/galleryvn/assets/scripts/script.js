$(document).ready(function(){

    FastClick.attach(document.body);
	
	toggleAsideMenu();
	toggleAsideFilter();
	loadProductPage();
	formBuyGallery();
	formContactGallery();
	showCloudTag();
	
	$(window).load(function(){
		autoMainStyle();
		disabledFilter();
		loadImageSize();
	});

    $(window).resize(function() {
		autoMainStyle();
		disabledFilter();
		loadImageSize();
    });

	if(window.location.pathname == '/' || window.location.pathname == '/en/'){
		loadHomePage();
	}

	/*$('.dropdown-menu').each(function(){
		$(this).click(function(event){
			event.stopPropagation();
		});
	});*/

	$('.menu-item:has(.trp-ls-language-name)').addClass('menu-translate').css('display', 'inline-flex');
	
	$('.status-hover').each(function(){
		let _this = $(this);
		_this.bind('mouseenter', function() {
			_this.addClass('hover');
		});
		_this.bind('mouseleave', function() {
			_this.removeClass('hover');
		});
	});

	$('.capitalize').each(function() {
		let getText = $(this).text();
		$(this).text(capitalizeFirstLetter(getText));
	});
	
	$('.formatPrice').each(function(){
		let o=$(this).text();
		o=o.toString().replace(/\B(?=(\d{3})+(?!\d))/g,"."),
		$(this).text(o)
	});

	$('.formatPhone').each(function(){
		$(this).text(function (_index, _text) {
			if(_text.length < 10){
				return _text;
			}
			if(_text.length == 10){
				return _text.replace(/(\d{3})(\d{3})(\d{4})/,"$1.$2.$3");
			}
			if(_text.length == 11){
				return _text.replace(/(\d{3})(\d{4})(\d{4})/,"$1.$2.$3");
			}
		});
	});

	// $('.btnEventHover').bind('mouseenter', function() {
	// 	$(this).find('i.symbol').eq(0).removeClass('charcoal');
	// 	$(this).find('i.symbol').eq(0).addClass('white');
	// });
	// $('.btnEventHover').bind('mouseleave', function() {
	// 	$(this).find('i.symbol').eq(0).removeClass('white');
	// 	$(this).find('i.symbol').eq(0).addClass('charcoal');
	// });

	$('#licenseTip').bind('mouseenter', function() {
		$('#licenseContent').css('display', 'block');
	});
	$('#licenseTip').bind('mouseleave', function() {
		$('#licenseContent').css('display', 'none');
	});

	$('#bankcardTip').bind('mouseenter', function() {
		$('#bankcardContent').css('display', 'block');
	});
	$('#bankcardTip').bind('mouseleave', function() {
		$('#bankcardContent').css('display', 'none');
	});

	$('#deliveryTip').bind('mouseenter', function() {
		$('#deliveryContent').css('display', 'block');
	});
	$('#deliveryTip').bind('mouseleave', function() {
		$('#deliveryContent').css('display', 'none');
	});
});

function capitalizeFirstLetter(_string) {
    return _string.charAt(0).toUpperCase() + _string.slice(1);
}

function loadHomePage() {
	let slideShow = new Swiper('#slideShow', {
		loop: true,
		slidesPerView: 1,
		autoHeight: true,
		grabCursor: true,
		centeredSlides: true,
		speed: 1000,
		effect: 'fade',
		observer: true,
		observeParents: true,
		fadeEffect: {
			crossFade: true
		},
		autoplay: {
			delay: 8000,
			disableOnInteraction: true,
		},
		pagination: {
			el: '#slideShowPaging',
			clickable: true,
		},
	});
	
	let allTabs = $('.control');
    let nowTab = 0; // currently shown div
    allTabs.hide()
	allTabs.first().show().css('opacity', 1); // hide all divs except first
	if($('#btnPrev').prop('disabled', true)){
		$('#btnPrev').css('background-color', '#8f8f8f');
		$('#btnPrev').css('border-color', '#8f8f8f');
	}

	$('#btnNext').click(function()
	{
		if(nowTab == (allTabs.length-1)){
			return;
		}
		
        allTabs.eq(nowTab).hide();
        nowTab = (nowTab + 1 < allTabs.length) ? nowTab + 1 : 0;
		
		if(nowTab == (allTabs.length-1)){
			$(this).prop('disabled', true);
			$(this).css('background-color', '#8f8f8f');
			$(this).css('border-color', '#8f8f8f');
		}
		
		allTabs.eq(nowTab).css('transform', 'translateY(-150%)');
		allTabs.eq(nowTab).css('opacity', 0).animate({opacity: 1}, {queue: false, duration: 800});
		setTimeout( function(){ 
			allTabs.eq(nowTab).css('transform', ''); 
		}, 200);
		
        allTabs.eq(nowTab).show(); // show next
		$('#btnPrev').prop('disabled', false);
		$('#btnPrev').css('background-color', '');
		$('#btnPrev').css('border-color', '');
		loadImageSize();
    });
    
	$('#btnPrev').click(function()
	{
		if(nowTab == 0){
			return;
		}
		
        allTabs.eq(nowTab).hide();
        nowTab = (nowTab > 0) ? nowTab - 1 : allTabs.length - 1;
		if(nowTab == 0){
			$(this).prop('disabled', true);
			$(this).css('background-color', '#8f8f8f');
			$(this).css('border-color', '#8f8f8f');
		}
		
		allTabs.eq(nowTab).css('transform', 'translateY(150%)');
		allTabs.eq(nowTab).css('opacity', 0).animate({opacity: 1}, {queue: false, duration: 800});
		setTimeout( function(){ 
			allTabs.eq(nowTab).css('transform', ''); 
		}, 200);
		
        allTabs.eq(nowTab).show(); // show previous
		$('#btnNext').prop('disabled', false);
		$('#btnNext').css('background-color', '');
		$('#btnNext').css('border-color', '');
		loadImageSize();
    });
	
}

function toggleAsideMenu(){

	let asideMenu = $('#asideMenu');
	let overlay = $('#overlay');

	$('.btnMenu').click(function(){
		asideMenu.addClass('show');
		asideMenu.css('opacity',1);
		let headerHeight = $('#navHeader').outerHeight();
		$('#navMenuClose').css('height', headerHeight-25);
		overlay.fadeIn();
		$(this).css('display', 'none');
	});

	$('.btnMenuClose').click(function(){
		asideMenu.removeClass('show');
		overlay.fadeOut();
		$('.btnMenu').fadeIn();
	});

	overlay.mouseup(function(e){
		$(this).fadeOut();
		if (!asideMenu.is(e.target) && asideMenu.has(e.target).length === 0){
			asideMenu.removeClass('show');
			$('.btnMenu').fadeIn();
	   	}
	});
}

function toggleAsideFilter(){

	let asideFilter = $('#asideFilter');
	let overlay = $('#overlay');

	$('.btnOpen').click(function() {

		if($(window).width() > 993){
			$('.navbar-nav-search').fadeToggle();
			$('.btn-search').toggleClass('show');
		}else{
			asideFilter.addClass('show');
			asideFilter.css('opacity', 1);
			let headerHeight = $('#navHeader').outerHeight();
			$('#navFilterClose').css('height', headerHeight-25);
			overlay.fadeIn();
		}
    });

	$('#btnFilterClose').click(function(){
		asideFilter.removeClass('show');
		overlay.fadeOut();
	});

	overlay.mouseup(function(e){
		$(this).fadeOut();
		if (!asideFilter.is(e.target) && asideFilter.has(e.target).length === 0){
			asideFilter.removeClass('show');
	   	}
	});
}

function disabledFilter(){

	let asideFilter = $('#asideFilter');
	let overlay = $('#overlay');

	if($(window).width() < 993){
		$('.navbar-nav-search').css('display', 'none');
		$('.btn-search').removeClass('show');
	}else{
		asideFilter.removeClass('show');
		asideFilter.css('opacity',0);
		overlay.fadeOut();
	}
}

function autoMainStyle(){
	
	let main = $('main > article, main > section');
	let header = $('header');
	let footer = $('footer');
	let windowHeight = $(window).height();

	let webHeight = Math.ceil(main.outerHeight() + header.outerHeight() + footer.outerHeight());
	// console.log(webHeight,windowHeight);
	// console.log(webHeight);
	
	if(windowHeight > 1000){
		if( ! $('main').hasClass('main-flex-fixed') ){
			$('main').addClass('main-flex-fixed');
		}
	}else{
		if($('main').hasClass('main-flex-fixed') ){
			$('main').removeClass('main-flex-fixed');
		}
	}
	
}

function loadProductPage(){
	
	let swiperProduct = new Swiper('#productSlide', {
		slidesPerView: 'auto',
		speed: 1200,
		observer: true,
		observeParents: true,
		spaceBetween: 30,
		centeredSlides: true,
		pagination: {
			el: '#productSlidePaging',
			clickable: true,
		},
		breakpoints: {
			// when window width is >= 769px
			769: {
				slidesPerView: 'auto',
				centeredSlides: false,
			},
			// when window width is >= 577px
			577: {
				centeredSlides: false,
			}
		},
	});
	
	let thumbnailList = new Swiper('#thumbnailList', {
		slidesPerView: 'auto',
		watchOverflow: true,
		watchSlidesVisibility: true,
		watchSlidesProgress: true,
		direction: 'horizontal',
		height: 600,
		breakpoints: {
			1025: {
			  	direction: 'vertical',
			}
		  }
	});
  
	let thumbnailShow = new Swiper('#thumbnailShow', {
		watchOverflow: true,
		watchSlidesVisibility: true,
		watchSlidesProgress: true,
		preventInteractionOnTransition: true,
		slidesPerView: 1,
		pagination: {
			el: '#detailImagePagination',
			clickable: true,
		},
		thumbs: {
			swiper: thumbnailList
		}
	});
}
function loadImageSize(){
	$('.product-box, .box-gallery').each(function(){
		let image = $(this).find('.image');
		if(image.attr('src') != ''){
			let  widthInfo = $($(this)[0]).width() - 30;
			// console.log(widthInfo);
			$(this).find('.box-info').css('max-width', widthInfo + 'px');
		}
	});
}

function formBuyGallery(){
	$('#btnBuyOrder').click(function(){
		let _this = this;
		let type  = $('#formBuyOrder input[name="type"]').val();
		let postId  = $('#formBuyOrder input[name="postId"]').val();
		let defaultPrice = $('#formBuyOrder input[name="defaultPrice"]').val();
		let name = $('#formBuyOrder input[name="name"]').val();
		let email = $('#formBuyOrder input[name="email"]').val();
		let phone = $('#formBuyOrder input[name="phone"]').val();
		let messenger = $('#formBuyOrder textarea[name="messenger"]').val();
		
		if(empty(name)){
			resultTag('.notice-result', 'error', 'Vui lòng nhập họ và tên.')
			return;
		}
		if(empty(email)){
			resultTag('.notice-result', 'error', 'Vui lòng nhập email.')
			return;
		}
		if(empty(phone)){
			resultTag('.notice-result', 'error', 'Vui lòng nhập số điện thoại.')
			return;
		}
		if($(_this).hasClass('btn-disabled')){
			resultTag('.notice-result', 'error', 'Hệ thống đã ghi nhận vui lòng chờ.')
			return;
		}
		
		if(type == 'buy'){
			$.ajax({
				type: 'post',
				dataType: 'json',
				url: product_param.url,
				data : {
					action: product_param.action,
					security: product_param.nonce,
					type: type,
					postId: postId,
					defaultPrice: defaultPrice,
					name: name,
					email: email,
					phone: phone,
					messenger: messenger,
				},
				beforeSend: function(){
					$(_this).attr('disabled', true);
				},
				success: function(response) {
					if(response.success == true){
						
						resultTag('.notice-result', 'success', response.data);
						$(_this).attr('disabled', false);
						
						$(_this).addClass('btn-disabled');
						setTimeout(function() {
							$(_this).removeClass('btn-disabled');
						}, 300000);
						
					}else{
						resultTag('.notice-result', 'error', response.data);
						$(_this).attr('disabled', false);
					}
				},
				error: function(jqXHR, textStatus){
				  console.log( 'The following error occured ' + textStatus);
				}
			  })
			  return false;
		}
		if(type == 'order'){
			$.ajax({
				type: 'post',
				dataType: 'json',
				url: product_param.url,
				data : {
					action: product_param.action,
					security: product_param.nonce,
					type: type,
					name: name,
					email: email,
					phone: phone,
					messenger: messenger,
				},
				beforeSend: function(){
					$(_this).attr('disabled', true);
				},
				success: function(response) {
					if(response.success == true){
						
						resultTag('.notice-result', 'success', response.data);
						$(_this).attr('disabled', false);
						
						$(_this).addClass('btn-disabled');
						setTimeout(function() {
							$(_this).removeClass('btn-disabled');
						}, 300000);
						
					}else{
						resultTag('.notice-result', 'error', response.data);
						$(_this).attr('disabled', false);
					}
				},
				error: function(jqXHR, textStatus){
				  console.log( 'The following error occured ' + textStatus);
				}
			  })
			  return false;
		}
		
		});
}
function formContactGallery(){
	$('#btnContact').click(function(){
		let _this = this;
		let name = $('input[name="name"]').val();
		let email = $('input[name="email"]').val();
		let phone = $('input[name="phone"]').val();
		let messenger = $('textarea[name="messenger"]').val();
		console.log(messenger);

		if(empty(name)){
			resultTag('.notice-result', 'error', 'Vui lòng nhập họ và tên.')
			return;
		}
		if(empty(email)){
			resultTag('.notice-result', 'error', 'Vui lòng nhập email.')
			return;
		}
		if(empty(phone)){
			resultTag('.notice-result', 'error', 'Vui lòng nhập số điện thoại.')
			return;
		}
		if($(_this).hasClass('btn-disabled')){
			resultTag('.notice-result', 'error', 'Hệ thống đã ghi nhận vui lòng chờ.')
			return;
		}

		$.ajax({
			type: 'post',
			dataType: 'json',
			url: contact_param.url,
			data : {
				action: contact_param.action,
				security: contact_param.nonce,
				name: name,
				email: email,
				phone: phone,
				messenger: messenger,
			},
			beforeSend: function(){
				$(_this).attr('disabled', true);
			},
			success: function(response) {
				if(response.success == true){
					resultTag('.notice-result', 'success', response.data);
					$(_this).attr('disabled', false);
					$(_this).addClass('btn-disabled');
					setTimeout(function() {
						$(_this).removeClass('btn-disabled');
					}, 300000);
				}else{
					resultTag('.notice-result', 'error', response.data);
					$(_this).attr('disabled', false);
				}
			},
			error: function(jqXHR, textStatus){
				console.log( 'The following error occured ' + textStatus);
			}
		})
		return false;
	});
}
function empty (str) {
	if (typeof str == 'undefined' || !str || str.length === 0 || str === "" || !/[^\s]/.test(str) || /^\s*$/.test(str) || str.replace(/\s/g,"") === ""){
		return true;
	}else{
		return false;
	}
}
function resultTag(_tag, _class, _text) {

	$(_tag).show();
	$(_tag).addClass(_class);
	$(_tag).text(_text);

    setTimeout(hideMsg,5000);

    function hideMsg(){
        $(_tag).fadeOut();
		$(_tag).removeClass(_class);
    }
}
function showCloudTag() {
	$('#searchValue').on('click', '.dropdown-item', function() {
		let dropdownParent = $(this).closest('.item-value').find('.dropdown-toggle');
		let inputName = dropdownParent.attr('data-input');
		let inputValue = $(this).attr('data-id');
		for (i = 0; i < 3; i++) {
			let getParam = getParamUrl('f'+i);
			$('input[name="f'+ i + '"]').val(getParam);
		}
		$('input[name="'+ inputName + '"]').val(inputValue);
		$('#filter').submit();
	});

	$('#searchMobile').on('change', 'select.filter-item', function() {
		let inputName = $(this).attr('data-input');
		let inputValue = $(this).find('option:selected').attr('data-id');
		for (i = 0; i < 3; i++) {
			let getParam = getParamUrl('f'+i);
			$('input[name="f'+ i + '"]').val(getParam);
		}
		$('input[name="'+ inputName + '"]').val(inputValue);
		$('#filterMobile').submit();
	});

	$('#btnSearch').click(function(){
		$('#formSearch').submit();
	});
	$('.closeTagSearch').click(function() {
		let tagParent = $(this).parents('.tagItem');
		tagParent.fadeOut();
		
		$('input[name="s"]').val('');
		$('#formSearch').submit();
	});

	$('.cloud-tag').on('click', '.closeTag', function() {
		let tagParent = $(this).parents('.tagItem');
		tagParent.fadeOut();
		let inputName = tagParent.attr('data-input');
		for (i = 0; i < 3; i++) {
			let getParam = getParamUrl('f'+i);
			$('input[name="f'+ i + '"]').val(getParam);
		}
		$('input[name="'+ inputName + '"]').val('');
		$('#filter').submit();
		$('#filterMobile').submit();
	});
}
function getParamUrl(_k) {// get parameter by key

    let sPageURL = decodeURIComponent(window.location.search.substr(1)),
        sURLVariables = sPageURL.split('&').map(_v => _v.split('='));
    let result = null;
	result = sURLVariables.find(_v => _v[0] === _k);
	if(result){
		return result[1]
	}else{
		return null;
	};
};