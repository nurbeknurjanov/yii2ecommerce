var done = [];
function child($element)
{
    var checked = $element.prop('checked');
    if(clicked==false && checked==false)
        return false;
    var id = $element.data('id');


    if(done[id]!==undefined)
        return false;

    done[id]=id;

    var $childs = $('.roleH').filter(function(){
        if( $(this).attr('data-parent_id').match(id))
            return $(this);
    });

    $childs.each(function(){
        if(checked==true){
            $(this).prop('checked', true);
            $(this).prop('disabled', true);
        }
        else{
            $(this).prop('checked', false);
            $(this).prop('disabled', false);
        }
        child($(this));
    });

}
var clicked = false;
$('body').on( 'click','.roleH', function(){
    clicked = true;
    done = [];
    child($(this));
});
