$(document).ready(function() {
	var rotation = 0;
	var nbSlice = $(".slice").length;

	function curveText(element) {
		if (element.find(".text-slice").find("span").length == 0) {
			var characters = element.find(".text-model").text().split("");
			characters.forEach(function(item, index) {
				element.find(".text-slice").append("<span>" + item + "</span").find("span:last").css({
					"transform" : 'rotate(' + (2.25 * (index - characters.length / 2)) + 'deg)',
					"display" : 'inline-block',
					"position" : 'absolute',
					"transform-origin" : 'bottom center',
					"padding-bottom" : '50%'
				});
			});
		}
	}

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
			$(this).find(".icn").fadeOut(0);
			$(this).find(".text-slice").fadeIn();
			curveText($(this));
		}, function() {
			$(this).css({
				"transform" : 'rotate(' + (rotation * 360 / nbSlice + index * 360 / nbSlice) + 'deg) skewX(30deg) scale(1)',
				"transition" : 'transform 1s'
			});
			$(this).find(".icn").fadeIn();
			$(this).find(".text-slice").fadeOut(0);
		});
	});
});
