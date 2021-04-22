/**
 * Created by Nurbek Nurjanov on 3/11/19.
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 */

$('#carousel-index').bind('slide.bs.carousel', function (e) {
    var index = $(e.target).find(".active").index();
    var $item = $("li[data-slide-to='"+index+"']");

    //if(!$('.wrap-indicators').is(":hover"))
    if(!$('.wrap-indicators:hover').length)
    {
        if(index==$('.carousel-indicators li').length-1)
            $('.wrap-indicators ol').scrollLeft(0);
        else
            centerItFixedWidth($item, $('.wrap-indicators ol'));
    }
});

$(function() {
    $('.carousel-indicators').perfectScrollbar({
        suppressScrollY: true
    });
});
