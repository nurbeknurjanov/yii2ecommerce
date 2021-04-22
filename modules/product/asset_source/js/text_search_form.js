/**
 * Created by nurbek on 3/4/18.
 */

$(document).on('beforeSubmit', '#textSearchForm', function ()
{
    $('#q').val($('#q').val().trim());

    $form = $('#leftSearchForm');
    $form.find("input, select, textarea").not(':button, :submit, :reset, :checkbox, :radio').val("");
    $form.find(":checkbox, :radio").prop("checked", false);

    var action = $(this).attr('action')+'?'+$(this).serialize();

    if (typeof window.router !=="undefined"){
        window.router.push(action);
        return false;
    }
    window.location.href=action;
    return false;
});
