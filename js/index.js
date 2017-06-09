$(function() {
    $('#navbar-lock').click(function() {
        if ($(this).attr('data') == 1) {
        	$('#navbar').removeClass('navbar-fixed-top');
        	$('body').css('margin-top','0');
            $(this).attr('data', 0);
            $(this).css('color', '#777');
        } else {
        	$('#navbar').addClass('navbar-fixed-top');
        	$('body').css('margin-top','50px');
            $(this).attr('data', 1);
            $(this).css('color', '#3c763d');
        }
    });
});
