$(document).on('click', '.showBasket',function(){
    var $this = $(this);
    var price = 0;
    var count = 1;
    if($(this).data('group_id')){
        $.ajax({
            url: baseUrlWithLanguage+'/order/order-product/group-products',
            data:{
                group_id:$(this).data('group_id'),
                self_product_id:$(this).data('product_id'),
            },
            success:function(data)
            {
                $('#orderproduct-product_id').replaceWith(data);
                $('#orderproduct-product_id').next().hide();
                price = $('#orderproduct-product_id option:selected').data('price');
                count = $('#orderproduct-product_id option:selected').data('count');

                //delay because
                $('#orderproduct-price').val(price);
                $('#orderproduct-price').next().html(price);
                $('#orderproduct-count').val(count);
            }
        });
    }
    else
    {
        $('#orderproduct-product_id').replaceWith('<input type="hidden" id="orderproduct-product_id" name="OrderProduct[product_id]">');
        $('#orderproduct-product_id').val($(this).data('product_id'));
        $('#orderproduct-product_id').next().html($(this).data('title')).show();
        price = $(this).data('price');
        $('#orderproduct-price').val(price);
        $('#orderproduct-price').next().html(price);
        $('#orderproduct-count').val($(this).data('count'));
    }
    $('#basketModal').modal('show');
    return false;
});

$('#basketModal').on('shown.bs.modal', function() {
    $('#orderproduct-count').select();
});

$(document).on('change', 'select#orderproduct-product_id',function(){
    var price = $(this).find("option:selected").data('price');
    var count = $(this).find("option:selected").data('count');
    $('#orderproduct-price').val(price);
    $('#orderproduct-price').next().html(price);//title of price
    $('#orderproduct-count').val(count);
    $('#orderproduct-count').keyup();
});

$(document).on('keyup', '#orderproduct-count',function(){
    var amount = $('#orderproduct-price').val()*$(this).val();
    $('#orderproduct-price').next().html(amount);//title of price
});



$('body').on('beforeSubmit', '#basketForm', function ()
{
    var $form = $(this);
    // return false if $form still have some validation errors
    if ($form.find('.has-error').length || $('.error-summary ul li').length) {
        return false;
    }

    var data = $form.data('yiiActiveForm');
    var $button = data.submitObject || $form.find(':submit:last');
    if ($button.length && $button.attr('type') == 'submit' && $button.attr('name')) {
        // simulate button input value
        var $hiddenButton = $('input[type="hidden"][name="' + $button.attr('name') + '"]', $form);
        if (!$hiddenButton.length) {
            $('<input>').attr({
                type: 'hidden',
                name: $button.attr('name'),
                value: $button.attr('value')
            }).appendTo($form);
        } else {
            $hiddenButton.attr('value', $button.attr('value'));
        }
    }


    // submit $form
    $.ajax({
        url: $form.attr('action'),
        headers: {
            'returnOnlyAlert':true,
        },
        type: 'post',
        data: $form.serialize(),
        success: function (data) {
            if(data.type)
                $.notify({
                    // options
                    message: data.message
                },{
                    // settings
                    //timer: 10000000,
                    type: data.type,
                    //element: 'body',
                    placement: {
                        from: 'top',
                        align: 'right'
                    }
                });
            var product_id = $form.find('[name="OrderProduct[product_id]"]').val();
            //var count = $form.find('[name="OrderProduct[count]"]').val();
            $('#showBasket-'+product_id).data('count', data.countProduct);
            $('#showBasket-'+product_id).addClass('alreadyInBasket');
            $('#basketCountSpan').html(data.messageBasket);
            if(data.countProduct>0)
                $('#basketCountSpan').parent().addClass('basketActive');
        }
    });
    $('#basketModal').modal('hide');
    return false;
});