/**
 * Created by nurbek on 3/26/18.
 */
$(document).on('change', '.grid-view :checkbox', function(event)
{
    var keys=$(".grid-view").yiiGridView("getSelectedRows");

    if(keys.length>0)
        $('#multipleForm').slideDown();
    else
        $('#multipleForm').slideUp();

    $('[name="ids"]').val(keys);
});

$('#multipleForm input, #multipleForm select, #multipleForm textarea').not('[name="_backendCSRF"], [name="ids"]').prop('disabled', true);


$(document).on('dblclick', '#multipleForm .form-group', function(event)
{
    var $container = $(this);
    var $element = $container.find('input, textarea, select');

    if($element.prop('disabled')===true){
        $element.prop('disabled', false);
        if($element.prop('id')==='product-description'){
            var editor = CKEDITOR.instances['product-description'];
            editor.document.$.body.setAttribute("contenteditable", true);
            editor.readOnly = false;
        }
    }
    else{
        $element.prop('disabled', true);
        if($element.prop('id')==='product-description'){
            var editor = CKEDITOR.instances['product-description'];
            editor.document.$.body.setAttribute("contenteditable", false);
            editor.readOnly = true;
        }
    }

    if($element.hasClass('selectpicker'))
        $element.selectpicker('refresh');

    if($container.find('input:file').length)
        $element.fileinput('refresh', {slugCallback:function(){}});
});