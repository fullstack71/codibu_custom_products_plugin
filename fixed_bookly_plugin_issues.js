(function($) {
    $(document).ready(function() {
        if (document.referrer.includes("thank-you") && window.location.href.includes("schedule")) {
            // Your code here
            window.location.reload();
        }
    });
})(jQuery);