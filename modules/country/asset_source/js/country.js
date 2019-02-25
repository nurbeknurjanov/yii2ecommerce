/**
 * Created by nurbek on 3/14/18.
 */

$(document).on('change', 'select.country_id', function () {
    var $this = $(this);
    $.ajax({
        url: baseUrlWithLanguage+'/country/region/select-region',
        data:{
            country_id:$this.val(),
        },
        success:function(data)
        {
            var url = new Url($("select.region_id").data('url').toString());
            url.query.country_id=$this.val();
            $("select.region_id").data('url', url.toString());
            $("select.region_id" ).html( data ).selectpicker('refresh').trigger('change');
        }
    });
});

$(document).on('change', 'select.region_id', function () {
    var $this = $(this);
    $.ajax({
        url: baseUrlWithLanguage+'/country/city/select-city',
        data:{
            region_id:$this.val(),
        },
        success:function(data)
        {
            var url = new Url($("select.city_id").data('url').toString());
            url.query.region_id=$this.val();
            $("select.city_id").data('url', url.toString());
            $("select.city_id" ).html( data ).selectpicker('refresh').trigger('change');
        }
    });
});

