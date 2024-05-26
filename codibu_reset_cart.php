<?php

function custom_enqueue_scripts() {
    if (is_cart() || is_checkout()) {
        wp_enqueue_script('custom-clear-cart', get_template_directory_uri() . 'assets/js/clear-cart.js', array('jquery'), null, true);
        wp_localize_script('custom-clear-cart', 'custom_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
    }
}
add_action('wp_enqueue_scripts', 'custom_enqueue_scripts');

function custom_clear_cart() {
    WC()->cart->empty_cart();
    wp_die();
}
add_action('wp_ajax_custom_clear_cart', 'custom_clear_cart');
add_action('wp_ajax_nopriv_custom_clear_cart', 'custom_clear_cart');