<?php

function codibu_wc_pip_before_body($type, $action, $document, $order){
    echo '<h3>Car Info</h3>';
    if(!$order->id){
        echo '<table style="width: 213%" border="1" class="tabel_data_json">
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
    </table>';
    } else {
        $customer_user_id = get_post_meta($order->id, 'car_info', true);
        echo $customer_user_id;
    }
}
add_action('wc_pip_before_body','codibu_wc_pip_before_body',10, 4);