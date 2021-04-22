
$('.someButton').click(function(e){
    e.preventDefault();
    setCookie('scroll', $(window).scrollTop());
    window.location.href = $(this).attr('href');
    return false;
});

if(getCookie('scroll')){
    $(window).scrollTop(getCookie('scroll'));
    deleteCookie('scroll');
}



$('body').on('click', 'a[data-ajax="1"]', function (e) {
    e.preventDefault();

    var $this = $(this);
    $.ajax({
                url: $(this).attr('href'),
                type:'post',
                success:function(data)
                {
                    if($this.parents("[data-pjax-container]").length)
                        $.pjax.reload({container:'#'+$this.parents("[data-pjax-container]").attr('id')});
                }
        });
    return false;
});