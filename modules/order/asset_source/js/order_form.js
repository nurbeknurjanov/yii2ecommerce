
$('.countTD input').focus(function () {
    $(this).select();
});


$('.countTD input').keyup(function(){
    var $count = $(this);
    var $row = $count.parents('tr');
    var $price = $row.find('.priceTD');
    var $amount = $row.find('.amountTD');
    $amount.data( 'amount',  $count.val() * $price.data('price') );
    $amount.html(  $amount.data( 'amount')  +' '+$price.data('currency') );
    $amount.trigger("contentChange");
});



$('.amountTD').bind("contentChange", function() {
    var totalAmountValue=0;
    $('.amountTD').each(function () {
        totalAmountValue+=$(this).data('amount');
    });
    $('.totalAmountTD').html(totalAmountValue+' '+$('.priceTD').data('currency'));
});


