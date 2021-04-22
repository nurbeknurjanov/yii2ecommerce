/**
 * Created by Nurbek Nurjanov on 3/20/19.
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 */

$('.nav > .dropdown > a').removeClass('dropdown-toggle');
$('.nav > .dropdown > a').removeAttr('data-toggle');




$('body').on({
    mouseenter: function () {

        var $this = $(this);
        $this.addClass('open');
        /*if($this.find('.dropdown-menu').length){
            $this.find('.dropdown-menu').slideDown();
        }*/
        if($this.parents('.navbar-menu ').length){
            var height = $('.nav > .open > ul').height();
            $('#shadow').height(height+15).show();
        }

    },
    mouseleave: function () {
        $(this).removeClass('open');
        /*var $this = $(this);
        if($this.find('.dropdown-menu').length){
            $this.find('.dropdown-menu').slideUp();
        }*/
        $('#shadow').hide();

    }
}, '.nav > .dropdown');

$('body').on('show.bs.dropdown', '.dropdown', function (e) {

});

$('body').on('click', '.nav > .dropdown a', function(){
    $(this).parents('.dropdown').removeClass('open');
    $('#shadow').hide();
});

