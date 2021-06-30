$(document).ready(function(){

  var swiper = new Swiper(".highlight-slide", {
    loop:true,
    slidesPerView: "auto",
    centeredSlides: true,
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    breakpoints: {
      1024: {
        centeredSlides: false,
      },
    },
  });
  
});
