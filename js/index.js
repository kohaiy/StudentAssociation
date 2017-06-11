$(function() {
    $('[data-toggle="tooltip"]').tooltip();
    $('#navbar-lock').click(function() {
        if ($(this).attr('data') == 1) {
            $('#navbar').removeClass('navbar-fixed-top');
            $('body').css('margin-top', '0');
            $(this).attr('data', 0);
            $(this).css('color', '#777');
        } else {
            $('#navbar').addClass('navbar-fixed-top');
            $('body').css('margin-top', '50px');
            $(this).attr('data', 1);
            $(this).css('color', '#5cb85c');
        }
    });
    $('#to-top').click(function() {
        $('html,body').animate({
            scrollTop: 0
        }, 1000);
    });
    $('#to-bottom').click(function() {
        $('html,body').animate({
            scrollTop: $(document).height()
        }, 1000);
    });
    $(document).scroll(function() {
        if ($(this).scrollTop() < 100) {
            $('#to-top').fadeOut(800);
        } else {
            $('#to-top').fadeIn(800);
        }
        if ($(this).height() - $(this).scrollTop() - $(window).height() < 100) {
            $('#to-bottom').fadeOut(800);
        } else {
            $('#to-bottom').fadeIn(800);
        }
    });
});
