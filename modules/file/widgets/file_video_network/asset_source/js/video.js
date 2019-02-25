/**
 * Created by nurbek on 11/2/16.
 */

$('.videoAttribute').keyup(function(){
    var $this = $(this);
    $.ajax({url: baseUrlWithLanguage + '/file/file-video-network/img',
        data: {'FileVideoNetwork[link]': $(this).val()},
        //beforeSend: function (){  $('#checkVideo').html('<img src="/images/loading.gif">'); },
        success:function(data){
            if($this.parent().find('.file-preview').length){
                $this.parent().find('.file-preview').replaceWith(data);
            }else{
                $this.before(data);
            }
        }});
});

$('body').on('click', '.video-image', function () {
    $.ajax({
        url: baseUrlWithLanguage+'/file/file-video-network/video',
        data:{id:$(this).data('id'), file_name:$(this).data('file_name')},
        success:function(data)
        {
            $('#videoModal .modal-body').html(data);
        }
    });
    $('#videoModal').modal('show');
});

$('body').on('click', '.localDelete', function () {
    $(this).parents('.file-preview').remove();
    $('#article-videosattribute').val('');
});



$('#videoModal').on('hidden.bs.modal', function () {
    $('#videoModal .modal-body').html('');
});

