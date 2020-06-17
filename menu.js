$(document).ready(function() {
    new CircleType(document.getElementById("produits-services")).radius(540);
    new CircleType(document.getElementById("actualites")).radius(540);
    new CircleType(document.getElementById("copywriting")).radius(490);
    new CircleType(document.getElementById("ressources")).radius(540);
    new CircleType(document.getElementById("annuaire")).radius(540);
    new CircleType(document.getElementById("livre-forum")).radius(540);

    var rotation = 0;
    $(".arrow-slide").click(function() {
        rotation += 50;
        $(".menu-listings").css({
            "transform" : 'rotate(' + rotation + 'deg)'
        });
    });

    var mousePos = { x: 0, y: 0 };
    $(document).mousemove(function(e) {
        mousePos.x = e.pageX;
        mousePos.y = e.pageY;
    });

    $('#produits-services, #ressources, #actualites, #annuaire, #copywriting, #livre-forum').on("shown.bs.popover", function() {
        $(".popover").css("transform", 'translate3d(' + (mousePos.x + 10) + 'px, ' + (mousePos.y + 10) + 'px, 0px)');
        $(".popover").css("display", "block");
    });

    $("#produits-services, #ressources, #actualites, #annuaire, #copywriting, #livre-forum").click(function() {
        $(".popover").css("display", "none");
        $(this).popover("show");
    });
});
