/**
 * Created by nurbek on 10/11/16.
 */


$('.nav > .dropdown > a').removeClass('dropdown-toggle');
$('.nav > .dropdown > a').removeAttr('data-toggle');
$('body').on({
    mouseenter: function () {

        var $this = $(this);
        $this.addClass('open');
        if($this.parents('.navbar-menu ').length){
            var height = $('.nav > .open > ul').height();
            $('#shadow').height(height+15).show();
        }

    },
    mouseleave: function () {

        $(this).removeClass('open');
        $('#shadow').hide();

    }
}, '.nav > .dropdown');




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
