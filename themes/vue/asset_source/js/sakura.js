/**
 * Created by nurbek on 10/11/16.
 */


$('.nav > .dropdown > a').removeClass('dropdown-toggle');
$('.nav > .dropdown > a').removeAttr('data-toggle');
$('.nav > .dropdown').hover(function(){

    var $this = $(this);
    $this.addClass('open');
    if($this.parents('.navbar-menu ').length){
        var height = $('.nav > .open > ul').height();
        $('#shadow').height(height+15).show();
    }
},function(){
    $(this).removeClass('open');
    $('#shadow').hide();
});






function centerItFixedWidth(target, outer)
{
    var out = $(outer);
    var tar = $(target);
    var x = out.width();
    var y = tar.outerWidth(true);
    var z = tar.index();
    var scrollLeftValue = Math.max(0, (y * z) - (x - y)/2);
    //if(scrollLeftValue) scrollLeftValue+=90;
    out.scrollLeft(scrollLeftValue);
}

$('#carousel-index').bind('slide.bs.carousel', function (e) {
    var index = $(e.target).find(".active").index();
    var $item = $("[data-slide-to='"+index+"']");

    if(!$('.wrap-indicators').is(":hover")){

        if(index==$('.carousel-indicators li').length-1)
            $('.wrap-indicators').scrollLeft(0);
        else
            centerItFixedWidth($item, $('.wrap-indicators'));
    }
});

$(function() {
    $('.carousel-indicators').perfectScrollbar({
        suppressScrollY: true
    });
});


