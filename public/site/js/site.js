$(document).ready(function(){
	$('#languageChange').on('click', function() {
		var lang = $(this).attr('data-lang'),
				token = $('meta[name="csrf-token"]').attr('content');

		$('#lang-display').html(lang);

		$.ajax({
			url:"/language",
			type:"POST",
			data:{locate:lang, _token:token},
			datatype:'json',
			complete: function(data){
				window.location.reload(true);
			}
		});
	});

	/*var header_h = $('#mainHeader').height(),
			navbar_h = $('nav.navbar').outerHeight();

	$('main.wrapper').css('padding-top', header_h);

	$(window).scroll(function(){
		var scroll = $(window).scrollTop(),
				sticky = $('nav.navbar');

		if (scroll > 96) {
	    sticky.addClass('fixed-top');
	  }

	  if (scroll > 550) {
			sticky.addClass('show');
		}

		if (scroll < 96) {
			sticky.removeClass('fixed-top');
		}
	});*/
});