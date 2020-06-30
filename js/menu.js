$(document).ready(function() {
	var rotation = 0;
	var nbSlice = $(".slice").length;

	function test() {
		$("#menu").css({
			"display" : 'block',
			"width" : '60vh',
			"min-width" : '40em'
		});
		$("#menu-small").css({
			"display" : 'none'
		});
		$(".slice a").css({
			"font-size" : '1rem',
			"font-weight" : '700'
		});
		$("#middle").css({
			"width" : '102%',
			"height": '102%',
			"top": '-1%',
			"left": '-1%'
		});
		$("#arrow").css({
			"left" : '111%',
		});
		$("header").css({
			"height" : '100vh'
		});
		$("#down-small").css({
			"display" : 'inline-block'
		});

		var pourcent = 100 * ($(window).height() - $(window).width()) / $(window).height();
		if ($(window).height() - $(window).width() > 100 && $(window).height() >= 835) {
			$("#menu").css({
				"width" : '65%',
				"min-width" : '0',
				"display" : pourcent > 71 ? 'none' : 'block'
			});
			$("#menu-small").css({
				"display" : pourcent > 71 ? 'block' : 'none'
			});
			$("header").css({
				"height" : pourcent > 71 ? '100%' : '100vh'
			});
			$("#down-small").css({
				"display" : pourcent > 71 ? 'none' : 'inline-block'
			});
			$(".slice a").css({
				"font-size" : pourcent > 64 ? '0.675rem' : '0.875rem',
				"font-weight" : pourcent > 64 ? '400' : '500'
			});
			$("#arrow").css({
				"left" : pourcent > 67 ? '106%' : '111%',
			});
			var newSize = pourcent > 40 ? (pourcent > 64 ? 102 - pourcent / 6 : 102 - pourcent / 6.5) : 102 - pourcent / 10;
			$("#middle").css({
				"width" : pourcent > 20 ? newSize + '%' : '102%',
				"height": pourcent > 20 ? newSize + '%' : '102%',
				"top": pourcent > 20 ? ((100 - newSize) / 2) + '%' : '-1%',
				"left": pourcent > 20 ? ((100 - newSize) / 2) + '%' : '-1%'
			});
		} else if ($(window).height() - $(window).width() > 50 && $(window).height() < 835 && $(window).height() > 444) {
			$("#menu").css({
				"display" : pourcent > 66 ? 'none' : 'block',
				"width" : '65%',
				"min-width" : '0'
			});
			$("#menu-small").css({
				"display" : pourcent > 66 ? 'block' : 'none'
			});
			$("header").css({
				"height" : pourcent > 66 ? '100%' : '100vh'
			});
			$("#down-small").css({
				"display" : pourcent > 66 ? 'none' : 'inline-block'
			});
			$(".slice a").css({
				"font-size" : pourcent > 52 ? '0.775rem' : '0.875rem',
				"font-weight" : pourcent > 52 ? '400' : '500'
			});
			$("#arrow").css({
				"left" : pourcent > 60 ? '106%' : '111%',
			});
			var newSize = pourcent > 38 ? 102 - pourcent / 4 : 102 - pourcent / 6;
			$("#middle").css({
				"width" : newSize + '%',
				"height": newSize + '%',
				"top": ((100 - newSize) / 2) + '%',
				"left": ((100 - newSize) / 2) + '%',
			});
		}/* else if ($(window).height() - $(window).width() <= 50 && $(window).height() < 835 && $(window).height() > 444) {
			$("#down").css({
				"display" : 'none',
			});
		}*/
		 /*else if ($(window).height() - $(window).width() <= 100) {
			$("#menu").css({
				"display" : 'block'
			});
			if ($("#menu-small").is(':visible')) {
				$("#menu-small").css({
					"display" : 'none'
				});
			}
		}*/
	}

	/*function resizeMenu() {
		if ($(window).height() - $(window).width() > 100 && !$("#menu-small").is(':visible')) {
			$("#menu").css({
				"display" : 'none'
			});
			$("#menu-small").css({
				"display" : 'block'
			});
		} else if ($(window).height() - $(window).width() <= 100) {
			$("#menu").css({
				"display" : 'block'
			});
			if ($("#menu-small").is(':visible')) {
				$("#menu-small").css({
					"display" : 'none'
				});
			}
		}
	}

	resizeMenu();

	$(window).on('resize', function() {
		resizeMenu();
	});*/

	//test();

	function resizeMenu() {
		var sizeType = $(window).height() < 350 || $(window).width() < 350 ? "xSmall" : ($(window).height() < 755 || $(window).width() < 730 ? "small" : "normal");
		// À coller en haut
		sizeType = sizeType == "normal" && $(window).height() - $(window).width() >= 145  ? "small" : sizeType;
		$("header").css({
			"height" : (sizeType == "xSmall" && $(window).height() < 600) || sizeType == "small" ? '100%' : '100vh'
		});
		$("#menu").css({
			"display" : sizeType == "xSmall" ? 'none' : 'block',
			"width" : sizeType == "small" ? '65%' : '60vh',
			"min-width" : sizeType == "small" ? '0' : '40em'
		});
		$("#menu ul").css({
			"margin-bottom" : sizeType == "small" ? '2.5rem' : '5rem',
		});
		$("#arrow").css({
			"display" : sizeType == "small" ? 'inline' : 'block',
			"top" : sizeType == "small" ? '35px' : '45.5%',
			"left" : sizeType == "small" ? '51%' : '111%'
		});
		$("#down").css({
			"display" : sizeType == "small" ? 'none' : 'inline-block',
		});
		$("#down").css({
			"display" : sizeType == "small" || $(window).height() <= 825 ? 'none' : 'inline-block',
		});
		$("#menu-small").css({
			"display" : sizeType == "xSmall" ? 'block' : 'none',
		});
		$("#down-small").css({
			"display" : sizeType == "xSmall" && $(window).height() < 700 ? 'none' : 'inline-block'
		});
		$("#middle").css({
			"width" : sizeType == "small" && $(window).width() < 500 ? '96%' : (sizeType == "small" && $(window).width() < 735 ? '100%' : '102%'),
			"height": sizeType == "small" && $(window).width() < 500 ? '96%' : (sizeType == "small" && $(window).width() < 735 ? '100%' : '102%'),
			"top": sizeType == "small" && $(window).width() < 500 ? '2%' : (sizeType == "small" && $(window).width() < 735 ? '0' : '-1%'),
			"left": sizeType == "small" && $(window).width() < 500 ? '2%' : (sizeType == "small" && $(window).width() < 735 ? '0' : '-1%'),
		});
		$(".slice a").css({
			"font-size" : sizeType == "small" && $(window).width() < 500 ? '0.675rem' : (sizeType == "small" && $(window).width() < 630 ? '0.775rem' : '1rem'),
			"font-weight" : sizeType == "small" && $(window).width() < 735 ? '400' : '700'
		});
	}

	resizeMenu();

	$(window).on('resize', function() {
		resizeMenu();
	});

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

	$("#arrow").click(function() {
		rotation++;
		$(".slice").each(function(index) {
			$(this).css({
				"transform" : 'rotate(' + (rotation * 360 / nbSlice + index * 360 / nbSlice) + 'deg) skewX(30deg) scale(1)',
				"transition" : 'transform 1s'
			});
			$(this).find(".icn").fadeIn();
			$(this).find(".text-slice").fadeOut(0);
		});
	});

	$(".slice").each(function(index) {
		$(this).children().hover(function() {
			$(this).parent().css({
				"transform" : 'rotate(' + (rotation * 360 / nbSlice + index * 360 / nbSlice) + 'deg) skewX(30deg) scale(1.15)',
				"transition" : 'transform 1s'
			});
			$(this).parent().find(".icn").fadeOut(0);
			$(this).parent().find(".text-slice").fadeIn();
			curveText($(this));
		}, function() {
			$(this).parent().css({
				"transform" : 'rotate(' + (rotation * 360 / nbSlice + index * 360 / nbSlice) + 'deg) skewX(30deg) scale(1)',
				"transition" : 'transform 1s'
			});
			$(this).parent().find(".icn").fadeIn();
			$(this).parent().find(".text-slice").fadeOut(0);
		});
	});
});
