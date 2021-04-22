/**
 * Created by Nurbek Nurjanov on 12/16/18.
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 */

function resizeReCaptcha() {

    var width = $( ".g-recaptcha" ).parent().width();

    if (width < 302) {
        var scale = width / 302;
    } else {
        var scale = 1;
    }

    $( ".g-recaptcha" ).css('transform', 'scale(' + scale + ')');
    $( ".g-recaptcha" ).css('-webkit-transform', 'scale(' + scale + ')');
    $( ".g-recaptcha" ).css('transform-origin', '0 0');
    $( ".g-recaptcha" ).css('-webkit-transform-origin', '0 0');
};

$( document ).ready(function() {

    $( window ).on('resize', function() {
        resizeReCaptcha();
    });

    $('a[href="#comments"]').click(function(){
        setTimeout(resizeReCaptcha, 1000);
    });

});