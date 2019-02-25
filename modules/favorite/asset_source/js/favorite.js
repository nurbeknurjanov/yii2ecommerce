$('body').on('click', '.addToFavorite',function(e){
    /*
     setCookie('scroll', $(window).scrollTop());
     window.location.href = $(this).attr('href');
     */
    e.preventDefault();
    $.ajax({
        url: $(this).attr('href'),
        method: 'POST',
        data: $(this).data()['params'],
        headers: {
            'returnOnlyAlert':true,
        },
        success:function(data)
        {
            //$('#favoriteCountSpan').html(data.count);
            $('#favoriteCountSpan').html(data.favoriteMessage);
            if(data.type)
                $.notify({
                    // options
                    message: data.message
                },{
                    // settings
                    type: data.type,
                    //element: 'body',
                    placement: {
                        from: 'top',
                        align: 'right'
                    }
                });
            //$.pjax.reload({container:"#favoritePjax"});  //Reload GridView
        }
    });


    $(this).attr('href', $(this).attr('href').replace(new RegExp("create",'g'),"delete"));
    $(this).removeClass('addToFavorite');
    $(this).addClass('removeFromFavorite');
    $(this).blur();
    return false;
});


$('body').on('click', '.removeFromFavorite',function(e){
    e.preventDefault();

    $.ajax({
        url: $(this).attr('href'),
        headers: {
            'returnOnlyAlert':true,
        },
        success:function(data)
        {
            $('#favoriteCountSpan').html(data.favoriteMessage);
            if(data.type)
                $.notify({
                    // options
                    message: data.message
                },{
                    // settings
                    type: data.type,
                    //element: 'body',
                    placement: {
                        from: 'top',
                        align: 'right'
                    }
                });
            //$.pjax.reload({container:"#favoritePjax"});  //Reload GridView
        }
    });


    $(this).attr('href', $(this).attr('href').replace(new RegExp("delete",'g'),"create") );
    $(this).removeClass('removeFromFavorite');
    $(this).addClass('addToFavorite');
    $(this).blur();
    return false;
});


