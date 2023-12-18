<?php
// Apply membership discount
// Alter prices in the cart based on membership and custom data
add_action('woocommerce_before_calculate_totals', 'codibu_alter_price_cart', 9999);
function codibu_alter_price_cart($cart) {
    // Loop through each cart item
    $user_id = get_current_user_id();

    // Get option data
    $checkout_car_vin_number = get_option('checkout_car_vin_number');
    // Get usermeta data data
    $carVinNumbers = get_user_meta($user_id, 'car_vin_numbers', true);
    $carVinNumbersArray = unserialize($carVinNumbers) ? unserialize($carVinNumbers) : [];
    foreach ($carVinNumbersArray as $key => $value){
        if ($value['vin_number'] == $checkout_car_vin_number && $value['is_check']){
            return;
        }
    }

    if ($checkout_car_vin_number) {
        // Set option data
        update_option('checkout_car_vin_number', null);
    }
    foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
        $regular_price = $cart_item['data']->get_regular_price();
        $price = $cart_item['data']->get_price();
        $new_price = null; // Initialize $new_price

        // Check if the user is a member
        if (wc_memberships_is_user_member($user_id)) {
            $memberships_infos = wc_memberships_get_user_active_memberships($user_id);
            $membership_info = reset($memberships_infos);
            $membership_plan_id = $membership_info->get_plan_id();
            $membership_plan = wc_memberships_get_membership_plan($membership_plan_id);

            // Get the formatted discount
            $discount = $membership_plan->get_formatted_product_discount($cart_item['data']->get_id());

            // Calculate new price based on the discount
            if (strpos($discount, "%") !== false) {
                $other_percentage = 1 - floatval($discount) / 100;
                $new_price = $regular_price / $other_percentage;
            } else {
                $discount = $regular_price - $price;
                $new_price = $regular_price + $discount;
            }
        }
        // Set the new price
        if ($new_price !== null) {
            $cart_item['data']->set_price($new_price);
        }
    }
}

add_action( 'wp_footer', 'codibu_trigger_js_function' );

function codibu_trigger_js_function() {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('#select_vin_number').change(function() {
                var vin_number = $(this).val();
                updateCartProductPrice(vin_number);
            });
            var vin_number = $('#select_vin_number').val();
            updateCartProductPrice(vin_number);
        });

        function updateCartProductPrice(vin_number) {
            jQuery.ajax({
                type: 'POST',
                url: '<?php echo admin_url('admin-ajax.php');?>',
                data: {
                    action: 'update_cart_product_price',
                    vin_number: vin_number,
                },
                success: function(response) {
                    // Handle the response from the server (if needed)
                    jQuery('body').trigger('update_checkout');
                }
            });
        }
    </script>
    <?php
}

add_action('wp_ajax_update_cart_product_price', 'update_cart_product_price_callback');

function update_cart_product_price_callback() {
    $vin_number = $_POST['vin_number'];

    // Set option data
    update_option('checkout_car_vin_number', $vin_number);

    wp_die(); // This is required to terminate immediately and return a proper response
}
