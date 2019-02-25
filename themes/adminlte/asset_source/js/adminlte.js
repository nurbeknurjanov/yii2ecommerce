/**
 * Created by nurbek on 4/29/18.
 */

$('.sidebar-form').submit(function(){
    $(this).find('input').keyup()
    return false;
});

$('.sidebar-form input').keyup(function(){
    var searchText = $(this).val();
    $('.sidebar-menu li').each(function () {
        var $li = $(this);
        var liHtml = $(this).html();
        liHtml = strip_tags(liHtml);
        liHtml = liHtml.toLowerCase();
        if(liHtml.indexOf(searchText) >= 0)
            $li.show();
        else
            $li.hide();
    });
});