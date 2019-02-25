$('[name="DeliveryForm[role][]"], [name="DeliveryForm[subscribe][]"]').change(function() {
    var roles = [];
    $('[name="DeliveryForm[role][]"]:checked').each(function () {
        roles.push($(this).val())
    });

    var subscribe = [];
    $('[name="DeliveryForm[subscribe][]"]:checked').each(function () {
        subscribe.push($(this).val())
    });
    $.ajax({
        url: baseUrlWithLanguage+'/user/manage/index/select',
        type:'get',
        data:{
            'UserSearch[rolesAttribute]':roles,
            'UserSearch[subscribe]':subscribe,
        },
        success:function(data)
        {
            $('[name="DeliveryForm[recipients][]"]').html('');
            $.each(data, function(i, user) {
                $('[name="DeliveryForm[recipients][]"]').append($('<option>').text(user.name).attr('value', user.email+'|'+user.name));
            });
            $('[name="DeliveryForm[recipients][]"] option').prop("selected", "selected");
        }
    });
});


