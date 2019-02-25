/**
 * Created by nurbek on 11/5/16.
 */
$(document).on('click', '.helpLink', function () {

    if($(this).hasClass('active')){
     $(this).removeClass('active');
     $('.helpBlock').animate({right:'-300px'},350);
     }else{
     $(this).addClass('active');
     $('.helpBlock').animate({right:'0'},350);
     }
    return false;
});


$(document).on('click', '.helpLinkModal', function () {

    //$('#helpModal').modal({"show":true});
    $('#helpModal').modal('show');

    return false;
});
