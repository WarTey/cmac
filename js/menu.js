$(document).ready(function() {
	var rotation = 0;
	var nbSlice = $(".slice").length;

	$(".arrow").click(function() {
		rotation++;
		$(".slice").each(function(index) {
			$(this).css({
				"transform" : 'rotate(' + (rotation * 360 / nbSlice + index * 360 / nbSlice) + 'deg) skewX(30deg) scale(1)',
				"transition" : 'transform 1s'
			});
		});
	});

	$(".slice").each(function(index) {
		$(this).hover(function() {
			$(this).css({
				"transform" : 'rotate(' + (rotation * 360 / nbSlice + index * 360 / nbSlice) + 'deg) skewX(30deg) scale(1.15)',
				"transition" : 'transform 1s'
			});
		}, function() {
			$(this).css({
				"transform" : 'rotate(' + (rotation * 360 / nbSlice + index * 360 / nbSlice) + 'deg) skewX(30deg) scale(1)',
				"transition" : 'transform 1s'
			});
		});
	});
});
