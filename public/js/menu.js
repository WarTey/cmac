$(document).ready(function() {
    let rotation = 0;
    const slice = $(".slice");
    const nbSlice = slice.length;

    $("#arrow").click(function() {
        rotation++;
        $(".slice").each(function(index) {
            $(this).css({
                "transform" : 'rotate(' + (rotation * 360 / nbSlice + index * 360 / nbSlice + 54) + 'deg) skewX(18deg) scale(1)',
                "transition" : 'transform 1s',
            });
            $(this).find(".icn").fadeIn();
            $(this).find(".text-slice").fadeOut(0);
        });
    });

    slice.each(function(index) {
        $(this).hover(function() {
            $(this).css({
                "transform" : 'rotate(' + (rotation * 360 / nbSlice + index * 360 / nbSlice + 54) + 'deg) skewX(18deg) scale(1.15)',
                "transition" : 'transform 1s',
            });
            $(this).find(".icn").fadeOut(0);
            $(this).find(".no-icn").fadeIn(0).arctext({radius: 200});
        }, function() {
            $(this).css({
                "transform" : 'rotate(' + (rotation * 360 / nbSlice + index * 360 / nbSlice + 54) + 'deg) skewX(18deg) scale(1)',
                "transition" : 'transform 1s',
            });
            $(this).find(".no-icn").fadeOut(0);
            $(this).find(".icn").fadeIn(0);
        });
    });
});
