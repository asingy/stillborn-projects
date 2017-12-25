
(function ($) {
"use strict";
/*--
	Menu Icon Toggle
-----------------------------------*/
$('.menu-toggle').on('click', function(){
	$(this).toggleClass('is-active');
	if($('.main-menu').hasClass('open')){
		$('.main-menu').removeClass('open');
		$('.menu-overlay').removeClass('open');
	}else{
		$('.main-menu').addClass('open');
		$('.menu-overlay').addClass('open');
	}
});
/*--
	Mobile Menu & Overlay Open
-----------------------------------*/
$('.main-menu nav ul li a, .menu-overlay').on('click', function(){
	if($('.main-menu').hasClass('open')){
		$('.main-menu').removeClass('open');
		$('.menu-overlay').removeClass('open');
	};
	if($('.menu-toggle').hasClass('is-active')){
		$('.menu-toggle').removeClass('is-active');
	};
});
/*--
	One Page Menu
-----------------------------------*/
var TopOffsetId = '#header';
$('.main-menu nav').onePageNav({
	currentClass: 'active',
	scrollThreshold: 0.2,
	scrollSpeed: 1000,
	scrollOffset: Math.abs( $( TopOffsetId ).outerHeight() - 1 )
});
/*--
	Smooth Scroll
-----------------------------------*/
$('.header-button a, .header-button-2 a, .hero-content a, .hero-content-2 a').on('click', function(e) {
	e.preventDefault();
	var link = this;
	$.smoothScroll({
	  offset: -80,
	  scrollTarget: link.hash
	});
});


function createSlick(){
$('.slider').not('.slick-initialized').slick({
	initialSlide: 1,
  centerMode: true,
  draggable : false,
  centerPadding: '60px',
  slidesToShow: 3,
  nextArrow: '<button type="button" class="slick-next"><i class="zmdi zmdi-chevron-right"></i></button>',
  prevArrow: '<button type="button" class="slick-prev"><i class="zmdi zmdi-chevron-left"></i></button>',
  responsive: [
    {
      breakpoint: 768,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 3
      }
    },
    {
      breakpoint: 480,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 1
      }
    }
  ]
});
}

$(window).on('resize', createSlick());

$(document).ajaxComplete(function(){
	createSlick();
});


$(".constructor-select").on('change', function () {
	if($(this).val() === '' ){
		$(this).addClass("place-holder");
	}else{
		$(this).removeClass("place-holder");
	}
});

$('.dismiss-btn').on('click', function (e) {
	$('#popup').addClass('hidden');
});

$('#contact-form').on('submit', function (e) {
	$.ajax({
 				url: 'message',
 				type: 'POST',
 				data: $('#contact-form').serialize(),
 				success: function(data) {
					$('#contact-form')[0].reset();
					if ($('#popup-main').hasClass('therms-popup')) {
						$('#popup-main').removeClass('therms-popup');
						$('#popup-main').addClass('order-popup');
					}
					$('#popup .popup-header').text('Ваше сообщение отправленно');
					$('#popup .popup-text').text('Мы обязательно учтём Ваши замечания и предложения');
					$('#popup').removeClass('hidden');
 				},
 		 });
	e.preventDefault();
});

$('#check-form').on('submit', function (e) {
	if ($('#check-text').val() == '') {
		return false;
	}
	$.ajax({
 				url: 'order',
 				type: 'GET',
 				data: $('#check-form').serialize(),
 				success: function(data) {

					if ($('#popup-main').hasClass('therms-popup')) {
						$('#popup-main').removeClass('therms-popup');
						$('#popup-main').addClass('order-popup');
					}
					$('#popup .popup-header').text('Заказ № ' + $('#check-text').val());
					$('#popup .popup-text').text(data);
					$('#popup').removeClass('hidden');
 				},
 		 });
 		 e.preventDefault();
});
})(jQuery);
