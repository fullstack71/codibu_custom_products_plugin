<?php
defined('ABSPATH') || die ("You can't access this file directyly !");
/*--------------------------------------------------------------*/
# Wp Enqueue Style Frontend
/*--------------------------------------------------------------*/

function oopspk_woocommerce_modify_pro_management_style()
{
    wp_enqueue_style('oopspk_woocommerce_modify_pro_managemen_style',plugins_url('assets/css/frontend_style_css.css',__FILE__));
    wp_enqueue_script('custom-js', plugin_dir_url(__FILE__) . 'fixed_bookly_plugin_issues.js', array(), '1.0', true);

}
add_action('wp_enqueue_scripts', 'oopspk_woocommerce_modify_pro_management_style', PHP_INT_MAX);

/*--------------------------------------------------------------*/
# Wp Enqueue Style Admin
/*--------------------------------------------------------------*/

function oopspk_woocommerce_modify_pro_management_scripts() {

    wp_register_script( 'oopspk_woocommerce_modify_pro_managemen_style_custom-js', plugins_url('assets/js/admin_javascript.js',__FILE__), array( 'jquery' ), '', true );
    wp_enqueue_script('oopspk_woocommerce_modify_pro_managemen_style_custom-js');

    wp_enqueue_style( 'oopspk_woocommerce_modify_pro_management_style_css_admin',plugins_url('assets/css/admin_style_css.css',__FILE__));

}
add_action( 'admin_enqueue_scripts', 'oopspk_woocommerce_modify_pro_management_scripts');

/*--------------------------------------------*/
# Wp enqueue Javascript Frontend
/*--------------------------------------------*/


add_action('woocommerce_checkout_update_user_meta', 'save_custom_field_to_user_meta');

function save_custom_field_to_user_meta($user_id) {
    require(spin_wheel_dir."/wpcustomio_header_userdata_con.php");
    $current_user_id = get_current_user_id();
//** WooCommmerce order page **/
    $data =  '<table style="width: 213%;" border="1" class="tabel_data_json">
<tbody>
<tr>
<td class="td_tilte">VEHICLE DESCRIPTOR</td>
<td>'.$responseArray['Results'][5]['Value'].'</td>
<td class="td_tilte">MANUFACTURER NAME</td>
<td>'.$responseArray['Results'][8]['Value'].'</td>
</tr>
<tr>
<td class="td_tilte">MODEL YEAR</td>
<td>'.$responseArray['Results'][9]['Value'].'</td>
<td class="td_tilte">SERIES</td>
<td>'.$responseArray['Results'][12]['Value'].'</td>
</tr>
<tr>
<td class="td_tilte">PLANT COUNTRY</td>
<td>'.$responseArray['Results'][15]['Value'].'</td>
<td class="td_tilte">DOORS</td>
<td>'.$responseArray['Results'][24]['Value'].'</td>
</tr>
<tr>
<td class="td_tilte">WHEEL BASE (INCHES) FROM</td>
<td>'.$responseArray['Results'][31]['Value'].'</td>
<td class="td_tilte">FUEL TYPE-PRIMARY</td>
<td>'.$responseArray['Results'][77]['Value'].'</td>
</tr>
<tr>
<td class="td_tilte">SEAT BELT TYPE</td>
<td>'.$responseArray['Results'][91]['Value'].'</td>
<td class="td_tilte">MAKE</td>
<td>'.$responseArray['Results'][7]['Value'].'</td>
</tr>
<tr>
<td class="td_tilte">MODEL</td>
<td>'.$responseArray['Results'][9]['Value'].'</td>
<td class="td_tilte">PLANT CITY</td>
<td>'.$responseArray['Results'][28]['Value'].'</td>
</tr>
<tr>
<td class="td_tilte">VEHICLE TYPE</td>
<td>'.$responseArray['Results'][14]['Value'].'</td>
<td class="td_tilte">BODY CLASS</td>
<td>'.$responseArray['Results'][23]['Value'].'</td>
</tr>
<tr>
<td class="td_tilte">GROSS VEHICLE WEIGHT RATING FROM</td>
<td>'.$responseArray['Results'][28]['Value'].'</td>
<td class="td_tilte">ENGINE NUMBER OF CYLINDERS</td>
<td>'.$responseArray['Results'][70]['Value'].'</td>
</tr>
<tr>
<td class="td_tilte">DISPLACEMENT (CI)</td>
<td>'.$responseArray['Results'][72]['Value'].'</td>
<td class="td_tilte">ENGINE POWER (KW)</td>
<td>'.$responseArray['Results'][76]['Value'].'</td>
</tr>
</tbody>
</table>
<!-- DivTable.com -->';
    $data = '<table style="width: 100%;" border="1" class="tabel_data_json">
            <tbody>
                <tr>
                    <td class="td_tilte">MODEL YEAR</td>
                    <td>'.$responseArray['Results'][10]['Value'].'</td>
                </tr>
                <tr>
                    <td class="td_tilte">MODEL</td>
                    <td>'.$responseArray['Results'][9]['Value'].'</td>
                </tr>
                <tr>
                    <td class="td_tilte">MAKE</td>
                    <td>'.$responseArray['Results'][7]['Value'].'</td>
                </tr>
            </tbody>
        </table>';
    update_user_meta($current_user_id, 'custom_field', $data);

}

// Add custom text to the Edit Account form
function add_custom_text_to_edit_account() {

    require(spin_wheel_dir."/wpcustomio_header_userdata_con.php");
// Check if JSON decoding was successful
    if ($responseArray === null) {
        echo "Error decoding JSON response";
    } else {
        // Now you can work with the $responseArray as a PHP array
        //var_dump($responseArray['Results']);

        ?>
        <!---------------* Edit Account  *------------------->
        <table style="width: 100%;" border="1" class="tabel_data_json">
            <tbody>
                <tr>
                    <td class="td_tilte">MODEL YEAR</td>
                    <td><?php echo  $responseArray['Results'][10]['Value']?></td>
                </tr>
                <tr>
                    <td class="td_tilte">MODEL</td>
                    <td><?php echo $responseArray['Results'][9]['Value']?></td>
                </tr>
                <tr>
                    <td class="td_tilte">MAKE</td>
                    <td><?php echo $responseArray['Results'][7]['Value']?></td>
                </tr>
            </tbody>
        </table>
        <!--<table style="width: 100%;" border="1" class="tabel_data_json">
            <tbody>
            <tr>
                <td class="td_tilte">VEHICLE DESCRIPTOR</td>
                <td><?php /*echo $responseArray['Results'][5]['Value']*/?></td>
                <td class="td_tilte">MANUFACTURER NAME</td>
                <td><?php /*echo $responseArray['Results'][8]['Value']*/?></td>
            </tr>
            <tr>
                <td class="td_tilte">MODEL YEAR</td>
                <td><?php /*echo  $responseArray['Results'][10]['Value']*/?></td>
                <td class="td_tilte">SERIES</td>
                <td><?php /*echo $responseArray['Results'][12]['Value']*/?></td>
            </tr>
            <tr>
                <td class="td_tilte">PLANT COUNTRY</td>
                <td><?php /*echo $responseArray['Results'][15]['Value']*/?></td>
                <td class="td_tilte">DOORS</td>
                <td><?php /*echo $responseArray['Results'][24]['Value']*/?></td>
            </tr>
            <tr>
                <td class="td_tilte">WHEEL BASE (INCHES) FROM</td>
                <td><?php /*echo  $responseArray['Results'][31]['Value']*/?></td>
                <td class="td_tilte">FUEL TYPE-PRIMARY</td>
                <td><?php /*echo $responseArray['Results'][77]['Value']*/?></td>
            </tr>
            <tr>
                <td class="td_tilte">SEAT BELT TYPE</td>
                <td><?php /*echo $responseArray['Results'][91]['Value']*/?></td>
                <td class="td_tilte">MAKE</td>
                <td><?php /*echo $responseArray['Results'][7]['Value']*/?></td>
            </tr>
            <tr>
                <td class="td_tilte">MODEL</td>
                <td><?php /*echo $responseArray['Results'][9]['Value']*/?></td>
                <td class="td_tilte">PLANT CITY</td>
                <td><?php /*echo $responseArray['Results'][11]['Value']*/?></td>
            </tr>
            <tr>
                <td class="td_tilte">VEHICLE TYPE</td>
                <td><?php /*echo $responseArray['Results'][14]['Value']*/?></td>
                <td class="td_tilte">BODY CLASS</td>
                <td><?php /*echo $responseArray['Results'][23]['Value']*/?></td>
            </tr>
            <tr>
                <td class="td_tilte">GROSS VEHICLE WEIGHT RATING FROM</td>
                <td><?php /*echo $responseArray['Results'][28]['Value']*/?></td>
                <td class="td_tilte">ENGINE NUMBER OF CYLINDERS</td>
                <td><?php /*echo $responseArray['Results'][70]['Value']*/?></td>
            </tr>
            <tr>
                <td class="td_tilte">DISPLACEMENT (CI)</td>
                <td><?php /*echo $responseArray['Results'][72]['Value']*/?></td>
                <td class="td_tilte">ENGINE POWER (KW)</td>
                <td><?php /*echo $responseArray['Results'][76]['Value']*/?></td>
            </tr>
            </tbody>
        </table>-->
        <!-- DivTable.com -->
        <?php
        //var_dump($responseArray['Results'][7]);
    }
}
add_action('woocommerce_edit_account_form', 'add_custom_text_to_edit_account',50);

//require(spin_wheel_dir."/wpcustomio_header_userdata_con.php");
function custom_text_on_orders_page( $order ) {

    require(spin_wheel_dir."/wpcustomio_header_userdata_con.php");
// Check if JSON decoding was successful
    if ($responseArray === null) {
        echo "Error decoding JSON response";
    } else {
        // Now you can work with the $responseArray as a PHP array
        //var_dump($responseArray['Results']);
//$user_id = get_current_user_id(); // Get the current user's ID
        $order_id = get_the_ID(); // This gets the current order's ID on the edit page
// Get the customer user ID associated with the order
        $customer_user_id = get_post_meta($order_id, '_customer_user', true);

        if ($customer_user_id) {

            if ($customer_user_id) {
                $custom_field_value = get_user_meta($customer_user_id, 'custom_field', true);

                if (!empty($custom_field_value)) {
                    echo  $custom_field_value;
                } else {
                    echo "Custom Field Value is empty.";
                }
            }
        } else {
            echo "No customer user ID found for this order.";
        }




    }}
//add_action( 'woocommerce_admin_order_data_after_billing_address', 'custom_text_on_orders_page', 50, 2 );


// Add custom fields to user profile edit page
function add_custom_user_fields($user) {
    $meta_data = get_user_meta($user->ID, 'car_vin_numbers', true);
    $role = reset($user->roles);
    if($role == 'administrator'){
        $vin_car_number_json =  "";
    }else{
        $vin_car_number_json =  $meta_data ? unserialize($meta_data)[0] : '';
    }
    $ch = curl_init();

// Set cURL options for GET request
    curl_setopt($ch, CURLOPT_URL, 'https://vpic.nhtsa.dot.gov/api/vehicles/decodevinextended/'.$vin_car_number_json.'*BA?format=json'); // Replace with your API endpoint
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Execute cURL request
    $response = curl_exec($ch);

// Close cURL session
    curl_close($ch);

// Convert JSON response to PHP array
    $responseArray = json_decode($response, true);


    if ($responseArray === null) {
        echo "Error decoding JSON response";
    } else {
        // Now you can work with the $responseArray as a PHP array
        //var_dump($responseArray['Results']);

        ?>
        <!---------- * User profile detail page in the admin panel * --------------->
        <table style="width: 100%;" border="1" class="tabel_data_json">
            <tbody>
            <tr>
                <td class="td_tilte">MODEL YEAR</td>
                <td><?php echo  $responseArray['Results'][10]['Value']?></td>
            </tr>
            <tr>
                <td class="td_tilte">MODEL</td>
                <td><?php echo $responseArray['Results'][9]['Value']?></td>
            </tr>
            <tr>
                <td class="td_tilte">MAKE</td>
                <td><?php echo $responseArray['Results'][7]['Value']?></td>
            </tr>
            </tbody>
        </table>
        <!--<table style="width: 100%;" border="1" class="tabel_data_json">
            <tbody>
            <tr>
                <td class="td_tilte">VEHICLE DESCRIPTOR</td>
                <td><?php /*echo $responseArray['Results'][5]['Value']*/?></td>
                <td class="td_tilte">MANUFACTURER NAME</td>
                <td><?php /*echo $responseArray['Results'][8]['Value']*/?></td>
            </tr>
            <tr>
                <td class="td_tilte">MODEL YEAR</td>
                <td><?php /*echo  $responseArray['Results'][10]['Value']*/?></td>
                <td class="td_tilte">SERIES</td>
                <td><?php /*echo $responseArray['Results'][12]['Value']*/?></td>
            </tr>
            <tr>
                <td class="td_tilte">PLANT COUNTRY</td>
                <td><?php /*echo $responseArray['Results'][15]['Value']*/?></td>
                <td class="td_tilte">DOORS</td>
                <td><?php /*echo $responseArray['Results'][24]['Value']*/?></td>
            </tr>
            <tr>
                <td class="td_tilte">WHEEL BASE (INCHES) FROM</td>
                <td><?php /*echo  $responseArray['Results'][31]['Value']*/?></td>
                <td class="td_tilte">FUEL TYPE-PRIMARY</td>
                <td><?php /*echo $responseArray['Results'][77]['Value']*/?></td>
            </tr>
            <tr>
                <td class="td_tilte">SEAT BELT TYPE</td>
                <td><?php /*echo $responseArray['Results'][91]['Value']*/?></td>
                <td class="td_tilte">MAKE</td>
                <td><?php /*echo $responseArray['Results'][7]['Value']*/?></td>
            </tr>
            <tr>
                <td class="td_tilte">MODEL</td>
                <td><?php /*echo $responseArray['Results'][9]['Value']*/?></td>
                <td class="td_tilte">PLANT CITY</td>
                <td><?php /*echo $responseArray['Results'][11]['Value']*/?></td>
            </tr>
            <tr>
                <td class="td_tilte">VEHICLE TYPE</td>
                <td><?php /*echo $responseArray['Results'][14]['Value']*/?></td>
                <td class="td_tilte">BODY CLASS</td>
                <td><?php /*echo $responseArray['Results'][23]['Value']*/?></td>
            </tr>
            <tr>
                <td class="td_tilte">GROSS VEHICLE WEIGHT RATING FROM</td>
                <td><?php /*echo $responseArray['Results'][28]['Value']*/?></td>
                <td class="td_tilte">ENGINE NUMBER OF CYLINDERS</td>
                <td><?php /*echo $responseArray['Results'][70]['Value']*/?></td>
            </tr>
            <tr>
                <td class="td_tilte">DISPLACEMENT (CI)</td>
                <td><?php /*echo $responseArray['Results'][72]['Value']*/?></td>
                <td class="td_tilte">ENGINE POWER (KW)</td>
                <td><?php /*echo $responseArray['Results'][76]['Value']*/?></td>
            </tr>
            </tbody>
        </table>-->
        <?php
    }
}
add_action('show_user_profile', 'add_custom_user_fields');
add_action('edit_user_profile', 'add_custom_user_fields');

// Save custom fields data
function save_custom_user_fields($user_id) {
    if (current_user_can('edit_user', $user_id)) {
         $custom_field = $_POST['custom_field']  ?? null;
        update_user_meta($user_id, 'custom_field', sanitize_text_field($custom_field));
    }
}
add_action('personal_options_update', 'save_custom_user_fields');
add_action('edit_user_profile_update', 'save_custom_user_fields');

?>
