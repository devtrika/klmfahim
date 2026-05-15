$(window).on("load", function () {
  $("body").removeClass("overflow");
  /************************************ Marquee ************************************/
  $(".marquee").marquee({
    duration: 10000,
    gap: 50,
    delayBeforeStart: 0,
    direction: document.dir == "rtl" ? "right" : "left",
    duplicated: true,
    pauseOnHover: true,
  });
});

$(document).ready(function () {
  if ($(window).width() >= 991) {
    sal({
      once: true,
    });
  } else {
    sal({
      disabled: true,
    });
  }
  lazyLoad();

  /************************************ Navbar ************************************/
  if ($(window).width() <= 993) {
    $(".menu-btn").on("click", (e) => {
      if (e.isDefaultPrevented()) return;
      e.preventDefault();
      e.stopPropagation();
      $(".overlay").fadeIn(500);
      $(".header-nav").addClass("active");
      $("body").addClass("overflow");
    });

    $(".close-btn,.overlay").on("click", (e) => {
      if (e.isDefaultPrevented()) return;
      e.preventDefault();
      e.stopPropagation();
      $(".overlay").fadeOut(500);
      $(".header-nav").removeClass("active");
      $("body").removeClass("overflow");
    });

    $(".has_children>a").click(function (e) {
      if (e.isDefaultPrevented()) return;
      e.preventDefault();
      e.stopPropagation();
      $(".has_children>a").not(this).removeClass("acc-active");
      $(this).toggleClass("acc-active");
      if ($(this).siblings().css("display") == "none") {
        $(this).siblings().slideDown(500);
      } else {
        $(this).siblings().slideUp(500);
      }
      $(".has_children>a").not(this).siblings().slideUp(500);
    });
  }
  /************************************ Hero Slider ************************************/
  var mainSwiper = new Swiper(".main-slider .swiper", {
    a11y: {
      enabled: false,
    },
    spaceBetween: 10,
    loop: true,
    autoplay: {
      delay: 5000,
    },
    navigation: {
      nextEl: ".main-slider .swiper-btn-next",
      prevEl: ".main-slider .swiper-btn-prev",
    },
    pagination: {
      el: ".main-slider .swiper-pagination",
      clickable: true,
    },
    on: {
      init: function (swiper) {
        lazyLoad();
      },
    },
  });

  /************************************ Services Slider ************************************/
  var servicesSwiper = new Swiper(".services-slider .swiper", {
    loop: true,
    autoplay: {
      delay: 5000,
    },
    breakpoints: {
      0: {
        slidesPerView: 1,
        spaceBetween: 15,
      },
      767: {
        slidesPerView: 2,
        spaceBetween: 30,
      },
      992: {
        slidesPerView: 3,
        spaceBetween: 15,
      },
      1199: {
        slidesPerView: 3,
        spaceBetween: 30,
      },
    },
    pagination: {
      el: ".services-slider .swiper-pagination",
      clickable: true,
    },
    on: {
      init: function (swiper) {
        lazyLoad();
      },
    },
  });

  /************************************ Testimonials Slider ************************************/
  var testimonialsSwiper = new Swiper(".testimonials-slider .swiper", {
    loop: true,
    autoplay: {
      delay: 5000,
    },
    breakpoints: {
      0: {
        slidesPerView: 1,
        spaceBetween: 15,
      },
      992: {
        slidesPerView: 2,
        spaceBetween: 15,
      },
      1199: {
        slidesPerView: 2,
        spaceBetween: 30,
      },
    },
    pagination: {
      el: ".testimonials-slider .swiper-pagination",
      clickable: true,
    },
  });

  /************************************ News Slider ************************************/
  var newsSwiper = new Swiper(".news-slider .swiper", {
    loop: true,
    autoplay: {
      delay: 5000,
    },
    breakpoints: {
      0: {
        slidesPerView: 1,
        spaceBetween: 15,
      },
      767: {
        slidesPerView: 2,
        spaceBetween: 30,
      },
      992: {
        slidesPerView: 3,
        spaceBetween: 15,
      },
      1199: {
        slidesPerView: 3,
        spaceBetween: 30,
      },
    },
    pagination: {
      el: ".news-slider .swiper-pagination",
      clickable: true,
    },
    on: {
      init: function (swiper) {
        lazyLoad();
      },
    },
  });

  /************************************ Partners Slider ************************************/
  var partnerSwiper = new Swiper(".partners-slider .swiper", {
    loop: true,
    autoplay: {
      delay: 5000,
    },
    breakpoints: {
      0: {
        slidesPerView: 3,
        spaceBetween: 20,
      },
      480: {
        slidesPerView: 4,
        spaceBetween: 15,
      },
      767: {
        slidesPerView: 5,
        spaceBetween: 15,
      },
      992: {
        slidesPerView: 6,
        spaceBetween: 20,
      },
      1199: {
        slidesPerView: 7,
        spaceBetween: 20,
      },
    },
    pagination: {
      el: ".partners-slider .swiper-pagination",
      clickable: true,
    },
    on: {
      init: function (swiper) {
        lazyLoad();
      },
    },
  });

  /************************************ Related Slider ************************************/
  var relatedSwiper = new Swiper(".related-slider .swiper", {
    loop: true,
    autoplay: {
      delay: 5000,
    },
    breakpoints: {
      0: {
        slidesPerView: 1,
        spaceBetween: 15,
      },
      767: {
        slidesPerView: 2,
        spaceBetween: 30,
      },
      992: {
        slidesPerView: 3,
        spaceBetween: 15,
      },
      1199: {
        slidesPerView: 3,
        spaceBetween: 30,
      },
    },
    pagination: {
      el: ".related-slider .swiper-pagination",
      clickable: true,
    },
    on: {
      init: function (swiper) {
        lazyLoad();
      },
    },
  });

  /************************************ Arrow Top ************************************/

  $(window).scroll(function () {
    $(this).scrollTop() >= 500
      ? $(".arrow-top").fadeIn(500)
      : $(".arrow-top").fadeOut(500);
  });
  $(".arrow-top").click(function () {
    $("html,body").animate(
      {
        scrollTop: 0,
      },
      1000
    );
  });
});
