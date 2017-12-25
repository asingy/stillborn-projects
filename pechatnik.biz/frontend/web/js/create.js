$(document).on('clicheReload', function(e, data) {
    $.ajax({
        url: '/get-template/'+data.id+'/'+data.size,
        method: 'GET',
        success: function(response) {
            $('#cliche_image').html(response);
        }
    });
});

$('#create').on('click','.step2',function (e) {
		 $.ajax({
				url: 'create?step=2',
				type: 'POST',
				data: {'data': $('.slick-current').data('id')},
				success: function(data) {
          $(document).scrollTop($('#create').offset().top - 70);
						$('#create').html(data);
				},
		 });
		 e.preventDefault();
});

$('#create').on('click','.step3',function (e) {
		 $.ajax({
				url: 'create?step=3',
				type: 'POST',
				data: {'data': $('.slick-current').data('id')},
				success: function(data) {
                    $(document).scrollTop($('#create').offset().top - 70);
                    $('#create').html(data);
				},
		 });
		 e.preventDefault();
});

$('#create').on('click', '.step4',function (e) {
    var isValid = [];
    $('.bevalidate').each(function(){
      if($(this).val() === ''){
        $(this).addClass('form-error');
        isValid.push('false');
      }else{
        $(this).removeClass('error');
        isValid.push('true');
      }
    });
    if ($.inArray('false', isValid) > -1) {
      return false;
    }

    $('#svg_h').val($('#cliche_image').html());

		var form = $('#form-step3');
		 $.ajax({
				url: 'create?step=4',
				type: 'POST',
				data: form.serialize(),
				success: function(data) {
          $(document).scrollTop($('#create').offset().top - 70);
						$('#create').html(data);
				},
		 });
		 e.preventDefault();
});

$('#create').on('click','.step5',function (e) {
	 var price = $('.slick-current .price').text();
		$.ajax({
			 url: 'create?step=5',
			 type: 'POST',
			 data: {'data': $('.slick-current').data('id'), 'price': price},
			 success: function(data) {
				 $(document).scrollTop($('#create').offset().top - 70);

					 $('#create').html(data);
			 },
		});
		e.preventDefault();
});

$('#create').on('click', '.step6',function (e) {

  var isValid = [];
  $('.bevalidate').each(function(){
    if($(this).val() === '') {
        if ($(this).attr('name') === 'scans') {
            $('.file-drop-zone.clickable').addClass('form-error');
        }
        else {
            $(this).addClass('form-error');
        }
      isValid.push('false');
    }else{
      $(this).removeClass('error');
      isValid.push('true');
    }
  });
  if ($.inArray('false', isValid) > -1) {
    return false;
  }
    var form = $('#form-step5');
     $.ajax({
        url: 'create?step=6',
        type: 'POST',
        data: form.serialize(),
        success: function(data) {
          $(document).scrollTop($('#create').offset().top - 70);
            $('#create').html(data);
        },
     });
     e.preventDefault();
});

$('#create').on('click', '.order-btn',function (e) {
	if($('#agree').is(':checked') === false){
		$('#id-agree').addClass('form-error')
		return false;
	}
	$.ajax({
		 url: 'new_order',
		 type: 'POST',
		 data: {},
		 success: function(data) {

		 },
	});
	e.preventDefault();
});

$('#create').on('click', '.back-btn',function (e) {
			var step = $(this).data('step');
     $.ajax({
        url: 'create',
        type: 'GET',
        data: {'step': step},
        success: function(data) {
            $('#create').html(data);
        },
     });
     e.preventDefault();
});

$('#create').on('change', '.cliche-size', function(e) {
    e.preventDefault();

    $(document).trigger('clicheReload', [{id: $('input[name="id_cliche_tpl"]').val(), size: $(this).val()}]);
});


// ====================
// validate
// ====================

$('#create').on('keypress', '#inn_ip',function(e){
  var len = $(this).val().length;
  if(len >= 10){
    $(this).val($(this).val().substring(0, len-1));
  }
  if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        return false;
  }
});

$('#create').on('keypress', '#inn_ooo',function(e){
  var len = $(this).val().length;
  if(len >= 12){
    $(this).val($(this).val().substring(0, len-1));
  }
  if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        return false;
  }
});

$('#create').on('keypress', '#ogrn_ooo',function(e){
  var len = $(this).val().length;
  if(len >= 13 ){
    $(this).val($(this).val().substring(0, len-1));
  }
  if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        return false;
  }
});

$('#create').on('keypress', '#ogrn_ip',function(e){
  var len = $(this).val().length;
  if(len >= 15){
    $(this).val($(this).val().substring(0, len-1));
  }
  if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        return false;
  }
});

// ================
// constructor
// ================
var create = $('#create');

create.on('input','#inn_ooo, #inn_ip', function() {
	var text = $(this).val();
  if(text === ''){
    text = '1234567890';
  }
  $('#cliche_inn').text(text);
});

create.on('input','#ogrn_ooo, #ogrn_ip', function() {
	var text = 'ОГРНИП ' + $(this).val();
  if(text === ''){
    text = '123456789012';
  }
  $('#cliche_ogrn').text(text);
});

create.on('input','#city', function() {
    var text = $(this).val();
  if(text === ''){
    text = 'Воронеж';
  }
  $('#cliche_city').text(text);
});

create.on('input','#name', function() {
    var text = $(this).val();
    if(text === ''){
        text = 'Название';
    }
    $('#cliche_name, #cliche_name2').text(text);
});

create.on('input','#text', function() {
    var text = $(this).val();
    if(text === ''){
        text = 'Название';
    }
    $('#cliche_text').text(text);
});

create.on('input','#fio', function() {
    var text = $(this).val();

    var fio = [];

    if(text === '') {
        fio = ['Фамилия', 'Имя', 'Отчество'];
    }
    else {
        fio = text.split(' ');
    }

    $('#cliche_surname').text(fio[0]);
    $('#cliche_name').text(fio[1]);
    $('#cliche_middlename').text(fio[2]);
});