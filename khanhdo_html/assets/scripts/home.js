$(document).ready(function(){

  var swiper1 = new Swiper(".gallery-slide", {
      loop:true,
      effect: "coverflow",
      slidesPerView: "1",
      autoHeight: true,
      grabCursor: true,
      centeredSlides: true,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      coverflowEffect: {
        rotate: 80,
        stretch: 0,
        depth: 50,
        modifier: 1,
        slideShadows: true,
      },
      autoplay: true,
      speed: 400,
  });

  $(".gallery-slide").mouseenter(function() {
    swiper1.autoplay.stop();
  });

  $(".gallery-slide").mouseleave(function() {
    swiper1.autoplay.start();
  });

  $("#btn-img").mouseenter(function() {
    $(this).removeClass("btn-scroll-down").addClass("btn-scroll-hover");
  });

  $("#btn-img").mouseleave(function() {
    $(this).removeClass("btn-scroll-hover").addClass("btn-scroll-down");
  });

});