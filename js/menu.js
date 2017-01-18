$(".menu").hide();

function openNav() {
    $(".menu").slideToggle("slow");
    $(".menu").show();
}

/* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
function closeNav() {
    $(".menu").slideToggle("slow");
}
