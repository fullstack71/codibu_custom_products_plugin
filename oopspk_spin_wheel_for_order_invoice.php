<?php

function codibu_wc_pip_before_body($type, $action, $document, $order){

    if(!$order->id){
        echo '<h3>Car Info</h3>';
        echo '<h5>Vin# vin number<h5>';
        /*echo '<table style="width: 213%" border="1" class="tabel_data_json">
        <tbody>
            <tr>
                <td class="td_tilte">VEHICLE DESCRIPTOR</td>
                <td>ASDASDAS**B</td>
                <td class="td_tilte">MANUFACTURER NAME</td>
                <td>null</td>
            </tr>
            <tr>
                <td class="td_tilte">MODEL YEAR</td>
                <td>null</td>
                <td class="td_tilte">SERIES</td>
                <td>null</td>
            </tr>
            <tr>
                <td class="td_tilte">PLANT COUNTRY</td>
                <td>null</td>
                <td class="td_tilte">DOORS</td>
                <td>null</td>
            </tr>
            <tr>
                <td class="td_tilte">WHEEL BASE (INCHES) FROM</td>
                <td>null</td>
                <td class="td_tilte">FUEL TYPE-PRIMARY</td>
                <td>null</td>
            </tr>
            <tr>
                <td class="td_tilte">SEAT BELT TYPE</td>
                <td>null</td>
                <td class="td_tilte">MAKE</td>
                <td>null</td>
            </tr>
            <tr>
                <td class="td_tilte">MODEL</td>
                <td>null</td>
                <td class="td_tilte">PLANT CITY</td>
                <td>null</td>
            </tr>
            <tr>
                <td class="td_tilte">VEHICLE TYPE</td>
                <td>null</td>
                <td class="td_tilte">BODY CLASS</td>
                <td>null</td>
            </tr>
            <tr>
                <td class="td_tilte">GROSS VEHICLE WEIGHT RATING FROM</td>
                <td>null</td>
                <td class="td_tilte">ENGINE NUMBER OF CYLINDERS</td>
                <td>null</td>
            </tr>
            <tr>
                <td class="td_tilte">DISPLACEMENT (CI)</td>
                <td>null</td>
                <td class="td_tilte">ENGINE POWER (KW)</td>
                <td>null</td>
            </tr>
        </tbody>
    </table>';*/
        echo '<table style="width: 213%" border="1" class="tabel_data_json">
        <tbody>
            <tr>
                <td class="td_tilte">MODEL YEAR</td>
                <td>null</td>
            </tr>
            <tr>
                <td class="td_tilte">MODEL</td>
                <td>null</td>
            </tr>
            <tr>
                <td class="td_tilte">MAKE</td>
                <td>null</td>
            </tr>
        </tbody>
    </table>';
    } else {
        global $wpdb;
        $sql = "SELECT *
			FROM `".$wpdb->prefix."comments`
			INNER JOIN `".$wpdb->prefix."commentmeta` ON `".$wpdb->prefix."comments`.`comment_ID` = `".$wpdb->prefix."commentmeta`.`comment_id`
			WHERE `".$wpdb->prefix."comments`.`comment_post_ID` = '".$order->id."'
			AND `".$wpdb->prefix."comments`.`comment_type` = 'order_note'
			AND `".$wpdb->prefix."commentmeta`.`meta_key` = 'is_customer_note'
			AND `".$wpdb->prefix."commentmeta`.`meta_value` = '1'
			ORDER BY `".$wpdb->prefix."comments`.`comment_ID` DESC";
        $comments = $wpdb->get_results($sql);

        if(count($comments)>=1){
            echo '<h3>Note</h3>';
            echo '<ul>';
            foreach($comments as $comment){
                echo '<li>'.$comment->comment_content.'</li>';
            }
            echo '</ul>';
        }
        $car_info = get_post_meta($order->id, 'car_info', true);
        $vin_number_meta_value = get_post_meta( $order->id, "Car Vin Number" );

        echo '<h3>Car Info</h3>';
        echo '<h5>Vin Number: ' .reset($vin_number_meta_value).'<h5>';
        echo $car_info;
    }
}
add_action('wc_pip_before_body','codibu_wc_pip_before_body',10, 4);