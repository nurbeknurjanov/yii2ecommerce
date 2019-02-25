/**
 * Created by nurbek on 3/4/18.
 */

$(document).on('beforeSubmit', '#textSearchForm', function ()
{
    $('#q').val($('#q').val().trim());

    $('.categoryTitle').hide();
    $('.categoryBlock').hide();
    $('.breadcrumb').hide();
    $form = $('#leftSearchForm');
    $form.find("input, select, textarea").not(':button, :submit, :reset, :checkbox, :radio').val("");
    $form.find(":checkbox, :radio").prop("checked", false);

    var action = $(this).attr('action')+'?'+$(this).serialize();
    if($('#productsPjax').length){
        $.pjax.reload('#productsPjax', { url:action});

        $.ajax({
                    url: action,
                    headers: {forEav:true},
                    success:function(data)
                    {

                        $('.eavBlock').replaceWith(
                            //$('.eavBlock', data)
                            data
                        );
                    }
            });
    }
    else
        return true;
    return false;
});
