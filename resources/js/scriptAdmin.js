$(document).ready(function() {
    console.log(1);
    $(window).scroll(function() {
        if ($(this).scrollTop()) {
            $("#backtop").fadeIn( "slow");
        } else {
            $('#backtop').fadeOut('slow');
        }
    })

    $('#backtop').on('click', function() {
        $('html, body').animate({
            scrollTop: 0
        }, 500)
    })
})