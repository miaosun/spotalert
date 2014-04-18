$(document).ready.(function() {
	$('.navbar-inner').on('click', function() {
		$(this).closest('.navbar-inner').find('.popup').slideToggle();
	});
});
