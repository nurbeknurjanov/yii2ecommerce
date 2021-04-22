var direction;
function doIncrease(directParam) {
    direction = directParam;
    if (isDown) {
        var increement = getIncrement(iteration);

        if(direction=='forward')
            $('.product-images').scrollLeft(function(i, v) {
                return Number(v) + increement;
            });
        if(direction=='back')
            $('.product-images').scrollLeft(function(i, v) {
                return Number(v) - increement;
            });

        iteration++;

        mousedownTimeout = setTimeout(function () {
            doIncrease(direction);
        }, 50);
    } else {
        clearTimeout(mousedownTimeout);
    }
}
mousePress($('.scrollRight'), function(){
    doIncrease('forward');
});
mousePress($('.scrollLeft'), function(){
    doIncrease('back');
});
$('.scrollLeft, .scrollRight').bind('hideMe',function() {
    $(this).addClass('scrollHide');
});
$('.scrollLeft, .scrollRight').bind('showMe',function() {
    $(this).removeClass('scrollHide');
});
$('.product-images').on('scroll', function() {
    var width =  $(this)[0].scrollWidth - $(this).innerWidth();

    if($(this).scrollLeft() > 0) {
        $('.scrollLeft').trigger('showMe');
    }
    if($(this).scrollLeft() < width) {
        $('.scrollRight').trigger('showMe');
    }

    if($(this).scrollLeft()===0){
        $('.scrollLeft').trigger('hideMe');
        $('.scrollRight').trigger('showMe');
    }
    if($(this).scrollLeft() >= width) {
        $('.scrollLeft').trigger('showMe');
        $('.scrollRight').trigger('hideMe');
    }
});




$(".zoom-container").imagezoomsl({
    zoomrange: [1, 10],
    magnifiersize: ['50%', '40%'],
    //magnifiersize: [557, 377],
    magnifierborder: '1px solid #888',
});

$('body').on('mouseover', '.zoom-image', function () {
    $(".product-thumbnail").removeClass('active');
    $(this).parent().addClass('active');
    var that = this;
    $(".zoom-container").fadeOut(50, function(){
        $(this).attr("src", $(that).attr("data-medium"))              // путь до small картинки
            .attr("data-large",       $(that).attr("data-large"))       // путь до big картинки
            //дополнительные атрибуты, если есть
            //.attr("data-title",       $(that).attr("data-title"))       // заголовок подсказки
            //.attr("data-help",        $(that).attr("data-help"))        // текст подсказки
            //.attr("data-text-bottom", $(that).attr("data-text-bottom")) // текст снизу картинки
            .fadeIn(300);
    });
});


$('body').on('click', '.tracker, .zoom-container', function () {
    $('a[href="'+$('.zoom-container').attr('data-large')+'"]').click();
});


var u  = new Url;
/*if(u.hash)
    $('.'+u.hash).click();*/

if(u.query.tab)
    $('a[href="#'+u.query.tab+'"]').tab('show');
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    var target = $(e.target).attr("href");
    u.query.tab = str_replace('#', '', target);
    window.history.pushState('', '', u);
});