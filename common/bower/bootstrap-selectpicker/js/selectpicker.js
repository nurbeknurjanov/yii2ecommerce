/**
 * Created by nurbek on 3/13/18.
 */

var timer = null;
var previousRequest = null;

$(document).on('keyup', '.bs-searchbox input', function () {

    var $parentSelect = $(this).parents('.bootstrap-select').find('select');

    if($parentSelect.data('delay')){
        clearTimeout(timer);
        timer = setTimeout(_ => {

            if ($parentSelect.data('url'))
                previousRequest = $.ajax({
                    url: $parentSelect.data('url'),
                    data: {
                        q: $(this).val(),
                        value: $parentSelect.val(),
                    },
                    beforeSend: function () {
                        if (previousRequest) {
                            previousRequest.abort();
                        }
                    },
                    success: function (data) {
                        $parentSelect.html(data).selectpicker('refresh');
                    },
                });

        }, parseInt($parentSelect.data('delay')));
    }else{

        if ($parentSelect.data('url'))
            previousRequest = $.ajax({
                url: $parentSelect.data('url'),
                data: {
                    q: $(this).val(),
                    value: $parentSelect.val(),
                },
                beforeSend: function () {
                    if (previousRequest) {
                        previousRequest.abort();
                    }
                },
                success: function (data) {
                    $parentSelect.html(data).selectpicker('refresh');
                },
            });

    }
});