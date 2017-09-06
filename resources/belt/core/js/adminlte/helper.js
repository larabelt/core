$(document).ready(function () {

    /**
     * functions
     */
    function toggleSidebar() {

        let collapsed = $('body').hasClass('sidebar-collapse');

        if (collapsed) {
            $('body').removeClass('sidebar-collapse');
        } else {
            $('body').addClass('sidebar-collapse');
        }

        History.setCookie('adminlte', 'collapsed', !collapsed);
    }

    /**
     * behaviors
     */
    $('.admin .sidebar-toggle').on('click', function () {
        toggleSidebar();
        return false;
    });

});