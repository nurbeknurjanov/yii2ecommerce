google.maps.event.addDomListener(window, 'load', initialize);

function initialize() {
    var input = $('.geo-complete')[0];
    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.addListener('place_changed', function () {
        var place = autocomplete.getPlace();

        let countryName='';
        let stateName='';
        let cityName='';
        let streetName='';
        let streetNumber='';
        let postalCode='';
        place.address_components.forEach(element => {
            if(element.types.includes("street_number"))
                streetNumber = element.long_name;
            if(element.types.includes("route"))
                streetName = element.long_name;
            if(element.types.includes("locality"))
                cityName = element.long_name;
            if(element.types.includes("administrative_area_level_1"))
                stateName = element.long_name;
            if(element.types.includes("country"))
                countryName = element.long_name;
            if(element.types.includes("postal_code"))
                postalCode = element.long_name;
        });

        /*$('#lat').val(place.geometry['location'].lat());
        $('#long').val(place.geometry['location'].lng());*/
        $('.geo-complete').val(streetNumber+ ' '+streetName);
        //$('.postalCode').val(postalCode);

        //find a country
        new Promise(function(resolve, reject) {
            $.ajax({
                url: '/country/country/find-one',
                data: {
                    q: countryName,
                },
                success: function (country_id) {
                    if(country_id)
                        resolve(country_id)
                },
            });
        })
        //define country in selectpicker
        .then(function(country_id){
            $.ajax({
                url: '/country/country/select-picker',
                data: {
                    value: [country_id],
                },
                success:  (options)=> {
                    //data = data.replace(new RegExp('>'+countryName,'i'), ' selected >'+countryName);
                    $('select.country_id').html(options);
                    $('select.country_id').selectpicker('refresh');
                    $('select.country_id').selectpicker('val', country_id);
                    //$('select.country_id').trigger('change')
                },
            });
            return country_id;
        })
            //find a region
            .then(country_id => {
                return new Promise(function(resolve, reject) {
                    $.ajax({
                        url: '/country/region/find-one',
                        data: {
                            q: stateName,
                            country_id: country_id,
                        },
                        success: function (region_id) {
                            if(region_id)
                                resolve([country_id, region_id])
                        },
                    });
                })
            })
            //define region in selectpicker
            .then(params => {
                let country_id = params[0]
                let region_id = params[1]
                $.ajax({
                    url: '/country/region/select-picker',
                    data: {
                        value: [region_id],
                        country_id: country_id,
                    },
                    success: function (options) {
                        $('select.region_id').html(options);
                        $('select.region_id').selectpicker('refresh');
                        $('select.region_id').selectpicker('val', region_id);
                    },
                });

                return region_id;
            })
                //find a city
                .then(region_id => {
                        return new Promise(function(resolve, reject) {
                            $.ajax({
                                url: '/country/city/find-one',
                                data: {
                                    q: cityName,
                                    region_id: region_id,
                                },
                                success: function (city_id) {
                                    if(city_id)
                                        resolve([region_id, city_id])
                                },
                            });
                        })
                    })
                //define city in selectpicker
                .then(params => {
                    let region_id = params[0]
                    let city_id = params[1]
                    $.ajax({
                        url: '/country/city/select-picker',
                        data: {
                            value: [city_id],
                            region_id: region_id,
                        },
                        success: function (options) {
                            $('select.city_id').html(options);
                            $('select.city_id').selectpicker('refresh');
                            $('select.city_id').selectpicker('val', city_id);
                        },
                    });
                    //finished
                });
    });
}

