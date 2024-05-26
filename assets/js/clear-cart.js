jQuery(document).ready(function($) {
    $(window).on('beforeunload', function() {
        $.ajax({
            url: custom_ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'custom_clear_cart'
            },
            async: false
        });
    });
});