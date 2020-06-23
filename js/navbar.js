$(document).ready(function() {
	function resizeSocialIcon() {
		if ($(".navbar-toggler").is(":visible")) {
			$("#facebook").addClass("mr-3");
			$("#instagram").addClass("mr-3");
			$("#linkedin").removeClass("mr-2");
			$("#btn_login").fadeOut(0);
			$("#icn_login").fadeIn();
		} else {
			$("#facebook").removeClass("mr-3");
			$("#instagram").removeClass("mr-3");
			$("#linkedin").addClass("mr-2");
			$("#btn_login").fadeIn();
			$("#icn_login").fadeOut(0);
		}
	}

	resizeSocialIcon();

	$(window).on("resize", function() {
		resizeSocialIcon();
	});
});