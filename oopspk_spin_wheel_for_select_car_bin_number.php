<?php
defined('ABSPATH') || die ("You can't access this file directyly !");

function codibu_custom_text_on_orders_page( $order ) {
    if($order == ""){
        $user_id = get_current_user_id();
    } else {
        $user_id = $order->get_user_id();
    }
    require(spin_wheel_dir . "/multi_vin_number.php");
}
add_action( 'woocommerce_admin_order_data_after_order_details', 'codibu_custom_text_on_orders_page', 9);
add_action('woocommerce_edit_account_form', 'codibu_custom_text_on_orders_page',11);

// Add custom fields to user profile edit page
function codibu_add_custom_user_fields($user) {
    $user_id = $user->ID;
    require(spin_wheel_dir . "/multi_vin_number.php");
}
add_action('show_user_profile', 'codibu_add_custom_user_fields',9);
add_action('edit_user_profile', 'codibu_add_custom_user_fields',9);