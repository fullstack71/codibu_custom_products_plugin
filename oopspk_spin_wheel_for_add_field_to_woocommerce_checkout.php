<?php
defined('ABSPATH') || die ("You can't access this file directyly !");

function add_this_script_footer(){
    //WC()->cart->empty_cart();
    $vin_numbers = get_user_meta(get_current_user_id(), 'car_vin_numbers', true);
    $vin_numbers = $vin_numbers ? unserialize($vin_numbers) : [];
    ?>
    <script>
        jQuery(document).ready(function($) {
            var vin_numbers = <?php echo json_encode($vin_numbers); ?>;
            if (vin_numbers.length != 0) {
                $('#selectVin').attr('disabled','disabled');
                $('#add_vin_number_field').hide();
                $('#binNumber').val('select_vin');
                $('#selectVin').on('click', function () {
                    $('#selectVin').attr('disabled','disabled');
                    $('#addVin').removeAttr('disabled');
                    $('#add_vin_number_field').hide();
                    $('#select_vin_number_field').show();
                    $('#binNumber').val('select_vin');
                });
            } else {
                $('#binNumber').val('add_vin');
            }
            $('#addVin').on('click', function () {
                $('#addVin').attr('disabled','disabled');
                $('#selectVin').removeAttr('disabled');
                $('#select_vin_number_field').hide();
                $('#add_vin_number_field').show();
                $('#binNumber').val('add_vin');
            });
        });
    </script>

<?php }

add_action('wp_footer', 'add_this_script_footer');

add_action('woocommerce_checkout_before_customer_details', 'add_checkout_car_vin_number');
function add_checkout_car_vin_number($checkout){
    ?>

    <style>
        #select_vin_number {
            -moz-appearance: inherit !important;
            -webkit-appearance: menulist !important;
            border: 0px solid #ccc;
            background-color: #F9FAFA;
        }
        #add_vin_number {
            border: 0px solid #ccc;
            background-color: #F9FAFA;
        }
        .box {
            background: var(--sections-background-color,#fff);
            border-radius: var(--sections-border-radius,3px);
            padding: var(--sections-padding,16px 30px);
            margin: var(--sections-margin,0 0 24px 0);
            border: 1px var(--sections-border-type,solid) var(--sections-border-color,#d5d8dc);
            display: block;
        }
    </style>
    <?php
    $car_vin_number = isset($_POST['add_vin_number']) ? sanitize_text_field($_POST['add_vin_number']) : '';
    $vin_numbers = get_user_meta(get_current_user_id(), 'car_vin_numbers', true);
    $vin_numbers = $vin_numbers ? unserialize($vin_numbers) : [];
    echo '<div class="box"><p class="form-row">';
    if($vin_numbers != []) {
        echo '<input type="button" id="selectVin" class="woocommerce-Button button" name="select_vin" value="Select Bin Number">
        <span style="margin:0px 10px">OR</span>';
    }
    echo '<input type="button" id="addVin" class="woocommerce-Button button" name="add_vin" value="Add Bin Number">
    <input type="hidden" id="binNumber" name="bin_number">
    </p>';
    woocommerce_form_field('add_vin_number', array(
        'type'          => 'text',
        'placeholder'   => __('Enter Car Vin Number', 'woocommerce'),
        'required'      => true,
        'default'       => $car_vin_number,
    ));
    if($vin_numbers != []) {
        foreach($vin_numbers as $vin_number){
            $vin_numbers_k_v[$vin_number['vin_number']] = $vin_number['vin_number'];
        }
        woocommerce_form_field( 'select_vin_number', array(
            'type'          => 'select',
            'required'    => true,
            'custom_attributes' => array('style'=>"padding: 10px;"),
            'options'     => $vin_numbers_k_v,
        ),
        );
    }
    echo '</div>';
}

/**
 * Checkout Process
 */
add_action('woocommerce_checkout_process', 'validate_checkout_car_vin_number');
function validate_checkout_car_vin_number()
{
// Show an error message if the field is not set.
    if ($_POST['bin_number'] == "add_vin" && empty($_POST['add_vin_number'])) {
        wc_add_notice(__('<strong>Vin Number</strong> is a required field.'), 'error');
    } elseif($_POST['bin_number'] == "add_vin" && !empty($_POST['add_vin_number'])) {
        $vin = $_POST['add_vin_number'];
    } else {
        $vin = $_POST['select_vin_number'];
    }

    global $wpdb;
    $customerId = get_current_user_id();

    $postmetas = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."postmeta WHERE meta_key = 'Car Vin Number' AND meta_value = '".$vin."'");
    foreach ($postmetas as $postmeta){
        if ($postmetas){
            $latest_postmeta = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."postmeta WHERE post_id = ".$postmeta->post_id." AND meta_key = '_customer_user' AND meta_value = '".$customerId."' ORDER BY post_id DESC LIMIT 1");
            if($latest_postmeta){
                $items = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."woocommerce_order_items WHERE order_id = ".$postmeta->post_id );

                foreach ( $items as $key => $item ) {
                    $data_store = WC_Data_Store::load( 'order-item' );
                    $metadata = $data_store->get_metadata( $item->order_item_id, 'bookly', true );
                    $customer_appointment = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."bookly_customer_appointments WHERE id = ".$metadata["ca_ids"][0]);
                    $appointment = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."bookly_appointments WHERE id = ".$customer_appointment[0]->appointment_id);

                    $currentusermaxdate = $appointment[0]->start_date;
                    $nextalloweddateShow = date('Y-m-d', strtotime("+3 months", strtotime($currentusermaxdate)));

                    $nextalloweddate = strtotime($nextalloweddateShow);
                    $cart_items = WC()->cart->get_cart();
                    foreach ($cart_items as $bookly => $values) {
                        $serviceId = $values['bookly']['items'][0]['service_id'];
                        $requestingDate = $values['bookly']['slots'][0][2];
                        $requestingDate = strtotime($requestingDate);
                        if($nextalloweddate > $requestingDate)
                        {
                            $sql34 = "SELECT title FROM ".$wpdb->prefix."bookly_services WHERE id='".$serviceId."'";
                            $serviceTitle = $wpdb->get_results( $sql34, ARRAY_A);
                            wc_add_notice( sprintf( __( 'You are not allowed to buy more than 1 pieces of VIN with Name <strong>'.$serviceTitle[0]['title'].'</strong> in 3 months. ', 'woocommerce' ), $limit, $specific_product_id_name ), 'error' );
                            break 3;
                        }

                    }
                }
            }

        }
    }
}

/**
 * Update the value given in custom field
 */
add_action('woocommerce_checkout_update_order_meta', 'store_checkout_car_vin_number');
function store_checkout_car_vin_number($order_id){
    if ($_POST['bin_number'] == "add_vin"){
        if (!empty($_POST['add_vin_number'])) {
            $vin_numbers = get_user_meta(get_current_user_id(), 'car_vin_numbers', true) ?? null;
            $vin_numbers_array = $vin_numbers ? unserialize($vin_numbers) : [];

            $numbers = array_map(function($itam) {
                return $itam['vin_number'];
            }, $vin_numbers_array);

            if (!in_array($_POST['add_vin_number'], $numbers)) {
                $newItem = [
                    'is_check' => null,
                    'vin_number' =>$_POST['add_vin_number']
                ];
                $array = array_merge($vin_numbers_array,[$newItem]);
                update_user_meta(get_current_user_id(),'car_vin_numbers',serialize($array),$vin_numbers);
            }
            $vin = sanitize_text_field($_POST['add_vin_number']);
        }
    } else {
        $vin = sanitize_text_field($_POST['select_vin_number']);
    }
    update_post_meta($order_id, 'Car Vin Number',$vin);
    car_info_in_woocommerce_order_meta($order_id, $vin);
}

function car_info_in_woocommerce_order_meta($order_id, $vin){
    $responseArray = get_car_info_from_api($vin);
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
                        <td>'.$responseArray['Results'][10]['Value'].'</td>
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
    update_post_meta($order_id, 'car_info',$data);
}

function get_car_info_from_api($vin){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://vpic.nhtsa.dot.gov/api/vehicles/decodevinextended/'.$vin.'*BA?format=json');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);
    return  json_decode($response, true);
}

function car_info_in_woocommerce_admin_order( $order ) {
    echo get_post_meta(get_the_ID(), 'car_info', true);
}
add_action( 'woocommerce_admin_order_data_after_billing_address', 'car_info_in_woocommerce_admin_order', 50, 2 );

function car_info_update_in_woocommerce_order_meta(){

    update_post_meta(get_the_ID(), 'Car Vin Number',$_POST["vinNumber"]);
    car_info_in_woocommerce_order_meta(get_the_ID(), $_POST["vinNumber"]);
}
add_action( 'woocommerce_process_shop_order_meta', 'car_info_update_in_woocommerce_order_meta', 50, 2 );