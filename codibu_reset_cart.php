<?php

add_action('template_redirect', 'check_last_step_and_empty_cart');

function check_last_step_and_empty_cart() {
    if (strpos($_SERVER['REQUEST_URI'], 'schedule')) {
        global $woocommerce;
        $woocommerce->cart->empty_cart();
    }
}

