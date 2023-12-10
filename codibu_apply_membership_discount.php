<?php
// Apply membership discount
add_action('woocommerce_cart_calculate_fees', 'codibu_apply_membership_discount');

function codibu_apply_membership_discount() {
    $user_id = get_current_user_id();
    $car_vin_numbers = unserialize(get_user_meta($user_id, 'car_vin_numbers', true))?? null;
    if ($car_vin_numbers) {
        $args = array( 'status' => array( 'active' ));
        if (wc_memberships_is_user_active_member($user_id)) {

            // Get the membership plan ID for the user
            $memberships_info = wc_memberships_get_user_active_memberships($user_id);
            $membership_info = reset($memberships_info);
            $membership_plan_id =$membership_info->get_id();
            $membership_plan = wc_memberships_get_membership_plan($membership_plan_id);

            if ($membership_plan) {
                $discount_amount = $membership_plan->get_product_discount(); // Replace with actual method to get discount from the plan

                // Apply the discount to the cart
                if ($discount_amount) {
                    WC()->cart->add_fee('Membership Discount', -$discount_amount);
                }
            }
        }
    }
}