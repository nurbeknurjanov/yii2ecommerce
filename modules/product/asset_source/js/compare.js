$('body').on('click', '.addToCompare',function(e){
    e.preventDefault();
    $.ajax({
        url: $(this).attr('href'),
        headers: {
            'returnOnlyAlert':true,
        },
        success:function(data)
        {
            $('#compareCountSpan').html(data.compareMessage);
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
        }
    });


    $(this).attr('title',removeCompareTitle);
    $(this).attr('href', $(this).attr('href').replace(new RegExp("add",'g'),"remove"));
    $(this).removeClass('addToCompare');
    $(this).addClass('removeFromCompare');
    $(this).blur();
    return false;
});


$('body').on('click', '.removeFromCompare',function(e){
    e.preventDefault();
    $.ajax({
        url: $(this).attr('href'),
        headers: {
            'returnOnlyAlert':true,
        },
        success:function(data)
        {
            $('#compareCountSpan').html(data.compareMessage);
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
        }
    });

    $(this).attr('title',addCompareTitle);
    $(this).attr('href', $(this).attr('href').replace(new RegExp("remove",'g'),"add") );
    $(this).removeClass('removeFromCompare');
    $(this).addClass('addToCompare');
    $(this).blur();
    return false;
});



