<?php
function car_status_single_order_meta_box() {
    ?>
    <style>
        .crimson{
            background-color: crimson;
        }
        .darkgoldenrod{
            background-color: darkgoldenrod;
        }
        .greenyellow{
            background-color: greenyellow;
        }
        .vertical-label {
            writing-mode: tb;
            padding: 6px;
            font-weight: 600;
            height: 50px;
            margin: 5px;
        }
        .horiz-label{
            padding: 6px;
            font-weight: 600;
            height: 50px;
            margin: 5px;
        }
        .text-box-size{
            min-width: 400px;
            height: 24px;
            margin: 6px;
        }
        .horiz-flex-container {
            display: flex;
        }

        .vertical-flex-container {
            display: flex;
            flex-direction: column;
        }

        td {
            text-align: center;
        }

        {    width: 30px;
            margin: 5px;
        }
        td .check-box-size{
            width: 20px;
            height: 20px;
        }
        td .check-box-crimson{
            outline-style: solid;
            outline-width: 5px;
            outline-color: crimson;
        }
        td .check-box-darkgoldenrod{
            outline-style: solid;
            outline-width: 5px;
            outline-color: darkgoldenrod;
        }
        td .check-box-greenyellow{
            outline-style: solid;
            outline-width: 5px;
            outline-color: greenyellow;
        }
    </style>
    <table>
        <tbody>
        <?php

        $car_status = get_post_meta(get_the_ID(), 'car_status', true);
        $car_status = unserialize($car_status);
        //print_r($car_status);
        $labels = ['Brake Pads/Shoes', 'Brake Rotors/Drums', 'Brake Hoses/Lines', 'Brake Calipers/Wheel Cylinders', 'Air Filter', 'Battery', 'Belt(s)', 'Hoses', 'Engine Oil', 'Transmission Fluid', 'Brake Fluid', 'Clutch Fluid', 'Power Steering Fluid', 'Windshield Washer Fluid', 'Front Left', 'Front Right', 'Rear Left', 'Rear Right', 'Lights', 'Wiper Blades', 'Struts/Shocks', 'Fuel Lines', 'Exhaust System', 'Steering System', 'Body Panels', 'Windows and Mirrors', 'Warning Lights', 'Interior Lights', 'Air Conditioning', 'Heating System', 'Cabin Air Filter', 'Seatbelt', 'Airbags'];
        $headings =[1=>'Visual Brake Check',5=>'Visual Underhood Check',15=>'Tire Tread Depth and Pressure Check',19=>'Visual Exterior Check',27=>'Visual Interior Check'];
        for ($r=1; $r<=33;$r++) {
            if (in_array($r, array_keys($headings))) {
                echo '<tr>
                    <th style="width: 250px;">'.$headings[$r].'</th>
                    <th style="width: 50px;"><label class="vertical-label crimson">Red</label></th>
                    <th style="width: 50px;"><label class="vertical-label darkgoldenrod">Amber</label></th>
                    <th style="width: 50px;"><label class="vertical-label greenyellow">Green</label></th>
                    <th style="width: 50px;"><label class="vertical-label">N/C</label></th>
                    <th><label class="horiz-label">Report & Recommendations</label></th>
                </tr>';
            }
            echo '<tr>
                <td>
                    <label>'.$labels[$r-1].'</label>
                </td>
                <td>
					<input class="check-box-size check-box-crimson" type="checkbox" name="r' . $r . 'c1" ' . ($car_status["r" . $r . "c1"] == "on" ? "checked" : "") . '>
                </td>
                <td>
                    <input class="check-box-size check-box-darkgoldenrod" type="checkbox" name="r'.$r.'c2" ' . ($car_status["r" . $r . "c2"] == "on" ? "checked" : "") . '>
                </td>
                <td>
                    <input class="check-box-size check-box-greenyellow" type="checkbox" name="r'.$r.'c3" ' . ($car_status["r" . $r . "c3"] == "on" ? "checked" : "") . '>
                </td>
                <td>
                    <input class="check-box-size" type="checkbox" name="r'.$r.'c4" ' . ($car_status["r" . $r . "c4"] == "on" ? "checked" : "") . '>
                </td>
                <td>
                    <textarea rows="2" cols="200" type="text" name="r'.$r.'c5">'.$car_status["r" . $r . "c5"].'</textarea>
                </td>
            </tr>';
        }
        ?>
        </tbody>

    </table>
    <?php
}

function car_status_order_meta_box() {
    add_meta_box( 'car_status_box', 'Car Status', 'car_status_single_order_meta_box', 'shop_order', 'advanced', 'high' );
}

add_action( 'add_meta_boxes', 'car_status_order_meta_box' );

function car_status_update_in_woocommerce_order_meta(){

    for ($r=1; $r<=33;$r++) {
        for ($c = 1; $c <= 5; $c++) {
            $key ='r'.$r.'c'.$c;
            $arr[$key] = $_POST[$key];
        }
    }
    $car_status = serialize( $arr );
    update_post_meta(get_the_ID(), 'car_status',$car_status);
}
add_action( 'woocommerce_process_shop_order_meta', 'car_status_update_in_woocommerce_order_meta', 50, 2 );