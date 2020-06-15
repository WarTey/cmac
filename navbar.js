$(document).ready(function() {
    function resizeSocialIcon() {
        if ($(".navbar-toggler").is(":visible")) {
            $("#facebook").addClass("mr-3");
            $("#instagram").addClass("mr-3");
            $("#linkedin").removeClass("mr-2");
        } else {
            $("#facebook").removeClass("mr-3");
            $("#instagram").removeClass("mr-3");
            $("#linkedin").addClass("mr-2");
        }
    }

    resizeSocialIcon();

    $(window).on("resize", function() {
        resizeSocialIcon();
    });
});
