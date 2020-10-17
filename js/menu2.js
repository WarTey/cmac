$(document).ready(function() {
	var rotation = 0;
	var nbSlice = $(".slice").length;

	function hideCollapseNavbar() {
		if ($(".collapse").hasClass("show"))
			$(".collapse").collapse("hide");
	}

	/*function menuResize() {
		var offsetDown = $('#down').offset().top - $('#menu').offset().top;
		var offsetLeft = $('#menu').offset().left - $('header').offset().left;
		var headerHeight = 100 * parseFloat($('header').css('height')) / parseFloat($('header').parent().css('height'));

		$("header").css({
			"height" : $(window).height() - headerHeight < 235 ? '100%' : '100vh',
		});

		$(".navbar").css({
			"margin-bottom" : offsetDown < 426 && offsetDown > -125 ? '-2rem' : '0',
		});

		$("#menu").css({
			"width" : $(window).height() - headerHeight < 235 ? '125vh' : '60vh',
			"max-width" : function() {
				if (parseFloat($('#menu').css('max-width')) == 520)
					return $("header")[0].style.height == "100%" && $(window).width() < 500 ? '20em' : (offsetLeft <= 40 ? '30em' : '40em');
				else if (parseFloat($('#menu').css('max-width')) == 390)
					return offsetLeft <= 40 ? '25em' : (offsetLeft >= 90 ? '40em' : '30em');
				else if (parseFloat($('#menu').css('max-width')) == 325)
					return offsetLeft <= 40 || ($(window).height() - headerHeight < 235 && offsetLeft <= 40) ? '20em' : (offsetLeft >= 80 ? '30em' : '25em');
				else if (parseFloat($('#menu').css('max-width')) == 260)
					return offsetLeft <= 40 ? '15em' : ((offsetLeft >= 80 && $(window).height() - headerHeight >= 235) || (offsetLeft >= 100 && $(window).height() - headerHeight < 235) ? '25em' : '20em');
				else if (parseFloat($('#menu').css('max-width')) == 195)
					return offsetLeft >= 80 ? '20em' : '15em';
			}
		});

		$("#arrow").css({
			"margin-top" : ($('#menu').offset().left - $('header').offset().left < 100) || ($(window).height() - headerHeight < 235) ? '0' : 'auto',
			"margin-left" : ($('#menu').offset().left - $('header').offset().left < 100) || ($(window).height() - headerHeight < 235) ? '0' : '10%',
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
	}*/

	function resizeHeader() {
		$("header").css({
			"height" : $('#menu').offset().top <= 107 && $(window).height() <= $('#next').offset().top ? '100%' : '100vh',
		});
	}

	function resizeMiddle() {
		const sizeMenu = 455;
		const sizeMiddle = 1 - (1 - $("#menu").height() / sizeMenu) / 5;
		$("#middle").css({
			"transform" : "scale(" + sizeMiddle + ")",
		});
		//console.log(sizeMiddle);
		$(".slice a").css({
			"font-size" : sizeMiddle <= 0.92 ? sizeMiddle <= 0.9 ? '0.8rem' : '0.85rem' : '0.95rem',
		});
	}

	function getAngle(element) {
		var values = element.split("(")[1],
			values = values.split(")")[0],
			values = values.split(","),
			radians = Math.atan2(values[1], values[0]);
		if (radians < 0)
			radians += (2 * Math.PI);
		return Math.round(radians * (180 / Math.PI));
	}

	function showPopover(origin, object, event) {
		if (!object.hasClass("show")) {
			const angle = getAngle(origin.css("transform"));
			var left = event.pageX - object.width() * 1.25;
			if (angle == 60 || angle == 120 || angle == 180)
				left = event.pageX + 75;
			object.addClass("show");
			object.css('left', left + 'px');
			object.css('top', (event.pageY-object.height()/2) + 'px');
		} else
			object.removeClass("show");
	}

	function hidePopover(id) {
		$(".popover").each(function() {
			if ($(this).hasClass("show") && $(this).attr("id") != id)
				$(this).removeClass("show");
		});
	}

	//menuResize();
	resizeHeader();
	resizeMiddle();

	$(window).scroll(function() {
		hideCollapseNavbar();
	});

	$(window).on('resize', function() {
		hideCollapseNavbar();
		//menuResize();
		resizeHeader();
		resizeMiddle();
	});

	$(".close").click(function() {
		hidePopover();
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
		$(this).hover(function() {
			$(this).css({
				"transform" : 'rotate(' + (rotation * 360 / nbSlice + index * 360 / nbSlice) + 'deg) skewX(30deg) scale(1.15)',
				"transition" : 'transform 1s',
			});
			$(this).find(".icn").fadeOut(0);
			$(this).find(".no-icn").fadeIn(0).arctext({radius: 200});
		}, function() {
			$(this).css({
				"transform" : 'rotate(' + (rotation * 360 / nbSlice + index * 360 / nbSlice) + 'deg) skewX(30deg) scale(1)',
				"transition" : 'transform 1s',
			});
			$(this).find(".no-icn").fadeOut(0);
			$(this).find(".icn").fadeIn(0);
		});

		$(this).click(function(event) {
			hidePopover("popover-" + $(this).attr("id"));
			showPopover($(this), $("#popover-" + $(this).attr("id")), event);
		});
	});
});
