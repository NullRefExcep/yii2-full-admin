/**
 * @author    Yaroslav Velychko
 */
jQuery(function () {
    /**
     * Submenu fix
     */
    var activeLink = jQuery('a[href!="/"].active');
    var items = activeLink.parents('li');
    jQuery.each(items, function (index) {
        var item = jQuery(this);
        if (!item.hasClass('active')) {
            item.toggleClass('active');
        }
    });

    /**
     * Save state of main menu
     */
    if (localStorage) {
        var status = localStorage.getItem('admin.menu.status');

        if (status == 'active') {
            jQuery('.sidebar').removeClass('closed');
            jQuery('#page-wrapper').removeClass('maximized');
        }

        jQuery('.menu-button').on('click', function () {
            setTimeout(function () {
                var active = !jQuery('.sidebar').hasClass('closed') ? 'active' : '';
                localStorage.setItem('admin.menu.status', active)
            });
        });
    }
});
