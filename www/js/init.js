$(function() {

	$('input[placeholder]').each(function(i, el) {
		$('label[for="' + $(el).attr('id') + '"]').hide();
		$(el).jvFloat();
		$(el).focusin(function() {
			$(el).siblings('label').addClass('placeholder-focus');
		});
		$(el).focusout(function() {
			$(el).siblings('label').removeClass('placeholder-focus');
		});
	});

});
