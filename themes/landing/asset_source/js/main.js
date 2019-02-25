/* ==========================================================================
   Page Loader
   ========================================================================== */



/* ==========================================================================
   CounterUp
   ========================================================================== */
  jQuery(document).ready(function( $ ) {
    $('.counter').counterUp({
      delay: 1,
      time: 500
    });
  });

  /* slicknav mobile menu active  */
  $('.mobile-menu').slicknav({
      prependTo: '.navbar-header',
      parentTag: 'liner',
      allowParentLinks: true,
      duplicate: true,
      label: '',
      closedSymbol: '<i class="icon-arrow-right"></i>',
      openedSymbol: '<i class="icon-arrow-down"></i>',
    });

/* ==========================================================================
   MixitUp
   ========================================================================== */
  $(function(){
    $('#portfolio').mixItUp();
  });


/* ==========================================================================
 Carousel Main Slider
 ========================================================================== */
/*
$(".carousel-slider").owlCarousel({
    navigation: true,
    pagination: false,
    slideSpeed: 1000,
    stopOnHover: true,
    autoPlay: false,
    items: 1,
    itemsDesktopSmall: [1024, 1],
    itemsTablet: [600, 1],
    itemsMobile: [479, 1]
});
*/


/* ==========================================================================
   Touch Owl Carousel
   ========================================================================== */
$(".touch-slider").owlCarousel({
    navigation: true,
    pagination: false,
    slideSpeed: 1000,
    stopOnHover: true,
    autoPlay: true,
    items: 1,
    itemsDesktopSmall: [1024, 1],
    itemsTablet: [600, 1],
    itemsMobile: [479, 1]
});

$('.touch-slider').find('.owl-prev').html('<i class="icon-arrow-left"></i>');
$('.touch-slider').find('.owl-next').html('<i class="icon-arrow-right"></i>');

/*$('.carousel-slider').find('.owl-prev').html('<i class="icon-arrow-left"></i>');
$('.carousel-slider').find('.owl-next').html('<i class="icon-arrow-right"></i>');*/

$(window).on('scroll', function() {
    if ($(window).scrollTop() > 20) {
        $('.header-top-area').addClass('menu-bg');
    } else {
        $('.header-top-area').removeClass('menu-bg');
    }
});

/* ==========================================================================
   Back Top Link
   ========================================================================== */
  var offset = 200;
  var duration = 500;
  $(window).scroll(function() {
    if ($(this).scrollTop() > offset) {
      $('.back-to-top').fadeIn(400);
    } else {
      $('.back-to-top').fadeOut(400);
    }
  });
  $('.back-to-top').click(function(event) {
    event.preventDefault();
    $('html, body').animate({
      scrollTop: 0
    }, 600);
    return false;
  })

  jQuery(function($) {

      //Initiat WOW JS
      new WOW().init();

      // one page navigation 
      $('.main-navigation').onePageNav({
              currentClass: 'active'
      });

      
  });

  jQuery(document).ready(function() {
     
      $('body').scrollspy({
          target: '.navbar-collapse',
          offset: 195
      });

      $(window).on('scroll', function() {
          if ($(window).scrollTop() > 200) {
              $('.fixed-top').addClass('menu-bg');
          } else {
              $('.fixed-top').removeClass('menu-bg');
          }
      });

      $(document).on('click', '.portfolio-item', function () {
          //window.location.href = $(this).attr('href');
          window.open($(this).attr('href'),'_blank');
      });
  });
