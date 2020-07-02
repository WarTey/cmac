$(document).ready(function() {
	var rotation = 0;
	var nbSlice = $(".slice").length;

	function hideCollapseNavbar() {
		if ($(".collapse").hasClass("show"))
			$(".collapse").collapse("hide");
	}

	function resizeMenu() {
		var offsetDown = $('#down').offset().top - $('#menu').offset().top;
		var offsetLeft = $('#menu').offset().left - $('header').offset().left;
		var diffHeight = $(window).height() - headerHeight;
		var headerHeight = 100 * parseFloat($('header').css('height')) / parseFloat($('header').parent().css('height'));

		$("header").css({
			"height" : diffHeight < 235 ? '100%' : '100vh',
		});
		$(".navbar").css({
			"margin-bottom" : offsetDown < 426 && offsetDown > -125 ? '-2rem' : '0',
		});
		$("#menu").css({
			"width" : diffHeight < 235 ? '125vh' : '60vh',
			"max-width" : function() {
				if (parseFloat($('#menu').css('max-width')) == 520)
					return $("header")[0].style.height == "100%" && $(window).width() < 500 ? '20em' : (offsetLeft <= 40 ? '30em' : '40em');
				else if (parseFloat($('#menu').css('max-width')) == 390)
					return offsetLeft <= 40 ? '25em' : (offsetLeft >= 90 ? '40em' : '30em');
				else if (parseFloat($('#menu').css('max-width')) == 325)
					return offsetLeft <= 40 || (diffHeight < 235 && offsetLeft <= 40) ? '20em' : (offsetLeft >= 80 ? '30em' : '25em');
				else if (parseFloat($('#menu').css('max-width')) == 260)
					return offsetLeft <= 40 ? '15em' : ((offsetLeft >= 80 && diffHeight >= 235) || (offsetLeft >= 100 && diffHeight < 235) ? '25em' : '20em');
				else if (parseFloat($('#menu').css('max-width')) == 195)
					return offsetLeft >= 80 ? '20em' : '15em';
			}
		});
		$("#arrow").css({
			"margin-top" : offsetLeft < 100 || diffHeight < 235 ? '0' : 'auto',
			"margin-left" : offsetLeft < 100 || diffHeight < 235 ? '0' : '10%',
			"font-size" : $("#middle").innerHeight() <= 275 ? '1.1rem' : ($("#middle").innerHeight() <= 355 ? '1.2rem' : '1.35rem'),
		});
		$("#down").css({
			"display" : offsetDown < 426 && offsetDown > -125 ? 'none' : 'inline-block'
		});
		$("#middle").css({
			"width" : $("#middle").innerHeight() <= 205 ? '94%' : ($("#middle").innerHeight() <= 275 ? '96%' : ($("#middle").innerHeight() <= 425 ? '98%' : ($("#middle").innerHeight() <= 500 ? '100%' : '102%'))),
			"height": $("#middle").innerHeight() <= 205 ? '94%' : ($("#middle").innerHeight() <= 275 ? '96%' : ($("#middle").innerHeight() <= 425 ? '98%' : ($("#middle").innerHeight() <= 500 ? '100%' : '102%'))),
			"top": $("#middle").innerHeight() <= 205 ? '3%' : ($("#middle").innerHeight() <= 275 ? '2%' : ($("#middle").innerHeight() <= 425 ? '1%' : ($("#middle").innerHeight() <= 500 ? '0' : '-1%'))),
			"left": $("#middle").innerHeight() <= 205 ? '3%' : ($("#middle").innerHeight() <= 275 ? '2%' : ($("#middle").innerHeight() <= 425 ? '1%' : ($("#middle").innerHeight() <= 500 ? '0' : '-1%'))),
		});
		$(".slice a").css({
			"font-size" : $("#middle").innerHeight() <= 275 ? '0.6rem' : ($("#middle").innerHeight() <= 355 ? '0.775rem' : '1rem'),
		});
	}

	function curveText(element) {
		if (element.find(".text-slice").find("span").length == 0) {
			var characters = element.find(".text-model").text().split("");
			characters.forEach(function(item, index) {
				element.find(".text-slice").append("<span>" + item + "</span").find("span:last").css({
					"transform" : 'rotate(' + (2.25 * (index - characters.length / 2)) + 'deg)',
					"display" : 'inline-block',
					"position" : 'absolute',
					"transform-origin" : 'bottom center',
					"padding-bottom" : '50%',
					"max-height" : '50%',
				});
			});
		}
	}

	resizeMenu();

	$(window).scroll(function() {
		hideCollapseNavbar();
	});

	$(window).on('resize', function() {
		hideCollapseNavbar();
		resizeMenu();
	});

	$("#arrow").click(function() {
		rotation++;
		$(".slice").each(function(index) {
			$(this).css({
				"transform" : 'rotate(' + (rotation * 360 / nbSlice + index * 360 / nbSlice) + 'deg) skewX(30deg) scale(1)',
				"transition" : 'transform 1s',
			});
			$(this).find(".icn").fadeIn();
			$(this).find(".text-slice").fadeOut(0);
		});
	});

	$(".slice").each(function(index) {
		$(this).children().hover(function() {
			$(this).parent().css({
				"transform" : 'rotate(' + (rotation * 360 / nbSlice + index * 360 / nbSlice) + 'deg) skewX(30deg) scale(1.15)',
				"transition" : 'transform 1s',
			});
			$(this).parent().find(".icn").fadeOut(0);
			$(this).parent().find(".text-slice").fadeIn();
			curveText($(this));
		}, function() {
			$(this).parent().css({
				"transform" : 'rotate(' + (rotation * 360 / nbSlice + index * 360 / nbSlice) + 'deg) skewX(30deg) scale(1)',
				"transition" : 'transform 1s',
			});
			$(this).parent().find(".icn").fadeIn();
			$(this).parent().find(".text-slice").fadeOut(0);
		});
	});
});
