
  document.addEventListener('DOMContentLoaded', function () {
    var swiper = new Swiper('.mySwiper', {
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      slidesPerView: 4,
      spaceBetween: 30,
      freeMode: true,
      breakpoints: {
        0: {
          slidesPerView: 2,
          spaceBetween: 20
        },
        768: {
          slidesPerView: 4,
          spaceBetween: 30
        }
      }
    });
  });