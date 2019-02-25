/**
 * Created by Nurbek Nurjanov on 3/9/17.
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 */

//this is not used, depprecated
$(document).on('click', '.like', function (e) {
    e.preventDefault();//this is very important. I specially didn't it. Cause pjax works on a tags.
    $like = $(this);
    if($like.hasClass('disabledLike'))
        return false;
    $.ajax({
                url: baseUrlWithLanguage+'/like/like/create?model_name='+$like.data('model_name')+'&model_id='+$like.data('model_id'),
                headers: {
                    'returnOnlyAlert':true,
                },
                context:{action:'notPjax'},
                type:'post',
                data:{
                    mark:$like.data('mark'),
                },
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
                    $.pjax.reload({container:'#commentsPjax'});
                },
                error: function (request, status, error) {
                    $.notify({
                        // options
                        message: request.responseText
                    },{
                        // settings
                        //timer: 10000000,
                        type: 'error',
                        //element: 'body',
                        placement: {
                            from: 'top',
                            align: 'right'
                        }
                    });
                }
        });
});