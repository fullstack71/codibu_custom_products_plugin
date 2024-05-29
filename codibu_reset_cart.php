<?php

function custom_clear_cart() {
    echo $current_url="//".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(!str_contains($current_url, 'last-step')){
        WC()->cart->empty_cart();
    }
}
add_action('init', 'custom_clear_cart');