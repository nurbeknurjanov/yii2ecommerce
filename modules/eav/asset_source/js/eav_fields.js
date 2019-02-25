//for backend standard form and for backend multiple form
$('.eavSelect').change(function(){
    $.ajax({
        url: baseUrlWithLanguage + '/eav/dynamic-field/select',
        data:{category_id:$(this).val(), object_id: $(this).data('object_id')},
        beforeSend:function(){
            $('#loading').show();
        },
        success:function(data)
        {
            $('#loading').hide();
            $('.eavFields').html(data);
        }
    });
});
//backend seach form
$('.eavSelectForSearchInBackend').change(function(){
    $.ajax({
        url: baseUrlWithLanguage + '/eav/dynamic-field/select-for-search-in-backend',
        data:{category_id:$(this).val()},

        beforeSend:function(){
            $('#loading').show();
        },
        success:function(data)
        {
            $('#loading').hide();
            $('.eavFields').html(data);
        }
    });
});



//for the left form search in frontend in bootstrap theme
//and for sakura and sakura light theme, here is trigger in search text
$('.eavSelectForSearch').change(function(){
    $.ajax({
        url: baseUrlWithLanguage + '/eav/dynamic-field/select-for-search',
        //context:{ajaxFor:'.eavSelectForSearch'},
        data:{category_id:$(this).val()},
        beforeSend:function(){
            $('#loading').show();
        },
        success:function(data)
        {
            $('#loading').hide();
            $('.eavFields').html(data);
        }
    });
});


$(document).on('click', '.eavBlock .eavFields .form-group > label', function () {
    var $div = $(this).parent();
    $(this).parent().find('.checkBoxBlock').toggle({
        duration:300,
        start:function () {
            if($div.hasClass("opened")){
                $div.removeClass('opened');
            }else{
                $div.addClass('opened');
            }
        }
    });
});