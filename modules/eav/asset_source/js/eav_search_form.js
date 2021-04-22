$(document).on('beforeSubmit', '#leftSearchForm', function ()
{
    var $form = $(this);
    // return false if $form still have some validation errors
    if ($form.find('.has-error').length || $('.error-summary ul li').length) {
        return false;
    }
    // submit $form

    var data = filterParameters($form);
    //data.rand=Math.floor(Math.random() * 1000) + 1;

    var action = $(this).attr('action');
    var dataUrl = $.param(data);
    //if(data.length>0)
    if(countProperties(data))
        action+='?'+dataUrl;

    if (typeof window.router !=="undefined"){
        window.router.push(action);
        return false;
    }
    $.pjax.reload('#productsPjax', { url:action});
    return false;
});



//price
$( "[name='priceFrom'], [name='priceTo']" ).keyup(function () {
    var from = $("[name='priceFrom']").val() || 1;
    var to = $("[name='priceTo']").val() || 1000;
    $("#slider-container").slider( "option", "values", [from, to]);
});


//reset
$('.resetButton').click(function(){
    var $form = $(this).parents('form');
    $form.find("input, select, textarea").not(':button, :submit, :reset, :checkbox, :radio').val("");
    $form.find(":checkbox, :radio").prop("checked", false);
    $form.submit();
    //$.pjax.reload('#productsPjax', { url:baseUrlWithLanguage+'/product/product/list'});
});


$(document).on('change', '#leftSearchForm input:not(:hidden), #leftSearchForm select, #leftSearchForm textarea'
    , function () {
        $(this).parents('form').submit();
    });


/*$(document).on('keyup', '#leftSearchForm input', function (e) {
    if(e.keyCode == 13)
        $(this).parents('form').submit();
});*/




/*$('#productsPjax').on('pjax:error', function (event) {
    //alert('Failed to load the page');
    event.preventDefault();
});*/
/*
$('#productsPjax').on('pjax:start', function (event) {
    $('#pjaxLoading').show();
});
$('#productsPjax').on('pjax:end', function (event) {
    $('#pjaxLoading').hide();
});
*/


