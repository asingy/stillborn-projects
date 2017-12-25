$('#create').on('click', '.next-slide', function (e) {
  $('.slider').slick('slickNext');
});

$('#create').on('click', '.prev-slide', function (e) {
  $('.slider').slick('slickPrev');
});

$('#create').on('init reInit afterChange setPosition', '.slider',function(event){
  $('.slick-current').prev().addClass('prev-slide');
  $('.slick-current').next().addClass('next-slide');
});

$('#create').on('beforeChange', '.slider',function(event){
  $('.slick-current').prev().removeClass('prev-slide');
  $('.slick-current').next().removeClass('next-slide');
});

$('#create').on('afterChange', '.slider',function(event){
  var id = $('.slick-current').data('slick-index');
  $('.item').addClass('hidden');
  $('#info #'+id).removeClass('hidden');
});
