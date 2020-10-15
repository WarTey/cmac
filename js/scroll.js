$(document).ready(function() {
	$("#down").click(function(event) {
		event.preventDefault();
		$('html,body').animate({
			scrollTop: $("#next").offset().top
		},'slow');
	});
});
