jQuery(document).ready(function($) {
    $(".table").hover(
        function() {
            $(this).addClass("addclass");
        },
        function() {
            $(this).removeClass("democlass");
        }
    );
});
