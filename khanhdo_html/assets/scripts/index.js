$(document).ready(function() {

	$("#navSearch").hide();

    $( "#btnOpen" ).click(function() {
        $( "#navSearch" ).toggle( 1000, "swing", function() {
        
        });
    });
	
    FastClick.attach(document.body);
	
    $(window).resize(function() {

    });
	
	var slideShow = new Swiper('#slideShow', {
		loop: true,
		slidesPerView: 1,
		autoHeight: true,
		grabCursor: true,
		centeredSlides: true,
		speed: 1000,
		effect: 'fade',
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
	
	var swiperProduct = new Swiper('#productHome', {
		slidesPerView: 'auto',
		spaceBetween: 20,
		speed: 2000,
		pagination: {
			el: '.swiper-pagination',
			clickable: true,
		},
	});

	let allTabs = $('.control');
    let nowTab = 0; // currently shown div
    allTabs.hide().first().show(); // hide all divs except first
    $('#btnNext').click(function() {
        allTabs.eq(nowTab).slideUp(1000,"swing")
        .css('opacity', 1)
        .animate({opacity: 0}, {queue: false, duration: 900});

        nowTab = (nowTab + 1 < allTabs.length) ? nowTab + 1 : 0;
		if(nowTab + 1 == allTabs.length){
			$("#btnNext").prop("disabled", true);
		}

        allTabs.eq(nowTab).slideDown(1000,"swing")
        .css('opacity', 0)  
        .animate({opacity: 1}, {queue: false, duration: 900}); // show next

		$("#btnPrev").prop("disabled", false);
    });

	$("#btnPrev").prop("disabled", true);
    $('#btnPrev').click(function() {
        allTabs.eq(nowTab).slideUp(1000,"swing")
        .css('opacity', 1)  
        .animate({opacity: 0}, {queue: false, duration: 900});

        nowTab = (nowTab > 0) ? nowTab - 1 : allTabs.length - 1;
		if(nowTab + 1 == 1){
			$("#btnPrev").prop("disabled", true);
		}

		//console.log(nowTab);
        allTabs.eq(nowTab).slideDown(1000,"swing")
        .css('opacity', 0)  
        .animate({opacity: 1}, {queue: false, duration: 900}); // show previous

		$("#btnNext").prop("disabled", false);
    });

	$('.dropdown-menu').each(function(){
		$(this).click(function(event){
			event.stopPropagation();
		});
	});
	
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
	
	$('.nav-link').each(function(){
		let href = $(this).attr('href');
		let pathname = location.pathname;
		if (href == 'javascript:void(0);' || !href){
			return;
		}

		let lastPos = href.length;
		let lastStr = href.substring((lastPos-1), lastPos);

		if(lastStr != '/'){
			href = href+'/';
		};

		if(pathname === '/'){
			if(href == location.href){
				$(this).parent().toggleClass('active');
			}
		}

		let current = pathname.split('/')[1];
		if (current === '') return;
		if (href.indexOf(current) !== -1) {
			$(this).parent().toggleClass('active');
		}
	
	});
	
	$('.fnum').each(function(){
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

});

function capitalizeFirstLetter(_string) {
    return _string.charAt(0).toUpperCase() + _string.slice(1);
}