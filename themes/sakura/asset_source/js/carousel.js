var Carousel = $.fn.carousel.Constructor;

$.fn.carousel = function (option) {

    return this.each(function () {
        var $this   = $(this);
        var data    = $this.data('bs.carousel');

        var options = $.extend({}, Carousel.DEFAULTS, $this.data(), typeof option == 'object' && option);
        var action  = typeof option == 'string' ? option : options.slide;

        if (!data) {
            data = new Carousel (this, options);
            data.$indicators = $('.carousel-indicators');
            $this.data('bs.carousel', data);
        }

        if (typeof option == 'number') data.to(option)
        else if (action) data[action]()
        else if (options.interval) data.pause().cycle()
    })
}



