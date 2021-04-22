var Nav;
(function($) {
    var $main_nav = $('#category-menu-widget2');
    var $toggle = $('.navbar-menu-hidden .navbar-toggle ignore');// it is not standard, we do ignore, because we do it manually nije

    var defaultData = {
        maxWidth: false,
        customToggle: $toggle,
        navTitle: 'All Categories',
        levelTitles: true,
        //pushContent: '#container',
        pushContent: true,
        insertClose: false,
        /*insertBack: true,*/
        insertBack: 1,
        labelClose: 'Close',
        labelBack: 'Back',
        levelOpen:        'overlap',//expand
        levelSpacing:     0,
        //navTitle:         null,
        navClass:        $('#category-menu-widget2').hasClass('nav-gray-category') ? 'nav-gray':null //sakura-light theme
    };

    // call our plugin
    Nav = $main_nav.hcOffcanvasNav(defaultData);

})(jQuery);
/*sessionStorage.removeItem('level');
sessionStorage.removeItem('index');*/
//console.log(sessionStorage);
$('body').on('click', '.navbar-menu-hidden .navbar-toggle', function () {

    Nav.open();
    //console.log(sessionStorage);
    var level  = sessionStorage.getItem('level')||0;
    var layer=1;
    if(level>0)
    {
        while (layer <= level) {
            Nav.openLevel(layer,sessionStorage.getItem('index-level-'+layer));

            //console.log(layer+':'+sessionStorage.getItem('index-level-'+layer));

            layer++;
        }
    }
});





(function($) {
    var $main_navTop = $('#top-menu-widget2');
    var $toggleTop = $('.navbar-menu-top-hidden .navbar-toggle');//it is standard

    var defaultDataTop = {
        maxWidth: false,
        customToggle: $toggleTop,
        navTitle: 'Home',
        levelTitles: true,
        //pushContent: '#container',
        pushContent: true,
        insertClose: false,
        /*insertBack: true,*/
        insertBack: 1,
        labelClose: 'Close',
        labelBack: 'Back',
        levelOpen:        'overlap',//expand
        levelSpacing:     0,
        //navTitle:         null,
        position:         'right',
        navClass:         'nav-gray'
    };

    // call our plugin
    var NavTop = $main_navTop.hcOffcanvasNav(defaultDataTop);

})(jQuery);




