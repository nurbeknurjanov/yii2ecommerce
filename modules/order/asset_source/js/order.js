

$(document).ajaxStart(function(){
});
$(document).ajaxComplete(function(){
});



$('form#formId').on('beforeValidate', function (event, messages, deferreds) {

});
$('form#formId').on('afterValidate', function (event, messages) {
    //$('form#formId').loadingOverlay('remove');
});

$('#gridView').on('beforeFilter', function (event) {
});

$('[name="Order[payment_type]"]').change(function(){
    if(isPaymentOnline())
        $('.field-order-online_payment_type').show();
    else
        $('.field-order-online_payment_type').hide();
    $('[name="Order[online_payment_type]"]').trigger('change');
});


$('[name="Order[online_payment_type]"]').change(function(){
    if(isPaymentOnlineAndOnlinePaymentTypeIsCard())
        $('.card').show();
    else
        $('.card').hide();
});

var isPaymentOnline = function () {
    return $('[name="Order[payment_type]"]').val()==PAYMENT_TYPE_ONLINE;
};

var isPaymentOnlineAndOnlinePaymentTypeIsCard = function () {
    return isPaymentOnline() && $('[name="Order[online_payment_type]"]:checked').val()==ONLINE_PAYMENT_TYPE_CARD;
};

var isAllDigitsNotFulfilled = function (attribute, value) {
    return !$('[name="Card[digits1]"]').val() || !$('[name="Card[digits2]"]').val() || !$('[name="Card[digits3]"]').val() || !$('[name="Card[digits4]"]').val();
};
var isBothDateNotFulfilled = function (attribute, value) {
    return !$('[name="Card[expire_date_month]"]').val() || !$('[name="Card[expire_date_year]"]').val();
};