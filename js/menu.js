$(document).ready(function() {
	var rotation = 0;
	$(".arrow").click(function() {
		rotation += 60;
		$(".menu-listings").css({
			"transform" : 'rotate(' + rotation + 'deg)'
		});
	});

	$('#products, #ressources, #art-school, #art-science, #forum, #old-students').hover(function() {
		//alert("dd");
	});
});
