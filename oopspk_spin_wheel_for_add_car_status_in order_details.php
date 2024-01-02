<?php
function car_status_single_order_meta_box() {

    $order = get_post($_GET['post']);
    $order_meta = get_post_meta($_GET['post']);
    $_billing_first_name = isset($order_meta["_billing_first_name"]) ? reset($order_meta["_billing_first_name"]) : '';
    $_billing_last_name = isset($order_meta["_billing_last_name"]) ? reset($order_meta["_billing_last_name"]) : '';
    $_shipping_company = isset($order_meta["_shipping_company"]) ? reset($order_meta["_shipping_company"]) : '';
    $_billing_address_1 = isset($order_meta["_billing_address_1"]) ? reset($order_meta["_billing_address_1"]) : '';
    $_billing_address_2 = isset($order_meta["_billing_address_2"]) ? reset($order_meta["_billing_address_2"]) : '';
    $_billing_city = isset($order_meta["_billing_city"]) ? reset($order_meta["_billing_city"]) : '';
    $_billing_state = isset($order_meta["_billing_state"]) ? reset($order_meta["_billing_state"]) : '';
    $_billing_postcode = isset($order_meta["_billing_postcode"]) ? reset($order_meta["_billing_postcode"]) : '';
    $_billing_c_s_p = $_billing_city.', '.$_billing_state.' '.$_billing_postcode;

    $_shipping_first_name = isset($order_meta["_shipping_first_name"]) ? reset($order_meta["_shipping_first_name"]) : '';
    $_shipping_last_name = isset($order_meta["_shipping_last_name"]) ? reset($order_meta["_shipping_last_name"]) : '';
    $_shipping_address_1 = isset($order_meta["_shipping_address_1"]) ? reset($order_meta["_shipping_address_1"]) : '';
    $_shipping_address_2 = isset($order_meta["_shipping_address_2"]) ? reset($order_meta["_shipping_address_2"]) : '';
    $_shipping_city = isset($order_meta["_shipping_city"]) ? reset($order_meta["_shipping_city"]) : '';
    $_shipping_state = isset($order_meta["_shipping_state"]) ? reset($order_meta["_shipping_state"]) : '';
    $_shipping_postcode = isset($order_meta["_shipping_postcode"]) ? reset($order_meta["_shipping_postcode"]) : '';
    $_shipping_c_s_p = $_shipping_city.', '.$_shipping_state.' '.$_shipping_postcode;
    ?>

    <script>
        jQuery(document).ready(function ($) {
            $('#printCarStatus').on('click', function () {
                var printContent = $('#printableArea').html();
                var printContent1 = $('#header').html();
                var originalContent = $('body').html();
                $('body').html(printContent1 + printContent);
                window.print();
                $('body').html(originalContent);
            });
            // Attach a click event to a button or element that will trigger the AJAX request
            $('#sendMailCarStatus').on('click', function () {
                var printContent = $('#printableArea').html();
                var printContent1 = $('#header').html();
                var originalContent = $('body').html();
                var htmlData = printContent1 + printContent;
                // Make an AJAX request
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo admin_url('admin-ajax.php');?>',
                    data: {
                        action: 'generate_pdf_and_send_email',
                        htmlData: htmlData,
                    },
                    success: function(response) {
                        // Handle the response from the server (if needed)
                        alert('Sent Successfully');
                    }
                });
            });
        });



    </script>
    <button type="button" class="button" style="vertical-align:middle" id="printCarStatus"><span>Print </span></button>

    <button type="button" class="button" style="vertical-align:middle" id="sendMailCarStatus"><span>Send Mail </span></button>
    <div id="car_status">
        <style>
            @media print {
                body {
                    margin:10px; /* Adjust the value as needed */
                }

                .tabel_data_json{
                    margin: 0 auto;
                    width: max-content;
                    max-width: 100%;
                }
            }
            h1, h2, h3, h4, h5, h6 {
                color: #000000;
                line-height: 150%;
            }
            h1 { font-size: 32px; }

            h2 { font-size: 28px; }

            h3 { font-size: 24px; }

            h4 { font-size: 20px; }

            h5 { font-size: 16px; }

            h6 { font-size: 12px; }


            .left {
                float: left;
            }
            .company-information {
                margin-bottom: 3em;
            }
            .customer-addresses {
                margin-left: -15px;
                margin-right: -15px;
            }

            .customer-addresses .column {
                padding: 0 15px;
                width: 33.33333333%;
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
            }

            .order-info {
                margin-bottom: 0;
            }

            .order-date {
                color: #666666;
                margin: 0;
            }


            span.coupon {
                background: #F4F4F4;
                color: #333;
                font-family: monospace;
                padding: 2px 4px;
            }
            .clear {
                clear: both;
            }
            .document-body-content{
                position: relative;
                max-width: 960px;
            }
            .td_tilte {
                border: 0px solid #1D2327;
                background-color: #1D2327;
                color: #fff;
            }
            .tabel_data_json{
                margin: 0 auto;
                width: max-content;
            }
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
            .sub-cell {
                display: -webkit-box;
                margin-bottom: 10px;
            }
            td .sub-cell-mr {
                margin-right: 10px;
            }
            td .sub-cell-ml {
                margin-left: 9px;
            }
            .last-column {
                text-align: left;
            }
            label {
                vertical-align: text-top;
            }
            .button {
                display: inline-block;
                border-radius: 4px;
                background-color: #f4511e;
                border: none;
                color: #FFFFFF;
                text-align: center;
                font-size: 28px;
                padding: 20px;
                width: 200px;
                transition: all 0.5s;
                cursor: pointer;
                margin: 5px;
                width: 100px;
                float: inline-end;
            }

            .button span {
                cursor: pointer;
                display: inline-block;
                position: relative;
                transition: 0.5s;
            }

            .button span:after {
                content: '\00bb';
                position: absolute;
                opacity: 0;
                top: 0;
                right: -20px;
                transition: 0.5s;
            }

            .button:hover span {
                padding-right: 25px;
            }

            .button:hover span:after {
                opacity: 1;
                right: 0;
            }
        </style>
        <div id="header-container" style="">
            <header id="header" style="width: 80%; margin: 0 auto;">
                <div class="company-information">
                    <h1 class="title ">Free Oil Change</h1>
                </div>
                <h3 class="order-info">Invoice for order <span class="order-number visible-print-inline"><?php echo $order->ID; ?></span></h3>
                <h5 class="order-date">Order Date: <?php echo date("Y/m/d", strtotime($order->post_date)); ?></h5>
                <div class="customer-addresses">
                    <div class="column customer-address billing-address left">
                        <h3>Billing Address</h3>
                        <address class="customer-addresss">
                            <?php echo $_billing_first_name.' '.$_billing_last_name; ?><br>
                            <?php echo $_shipping_company; ?><br>
                            <?php echo $_billing_address_1; ?><br>
                            <?php echo $_billing_address_2; ?><br>
                            <?php echo $_billing_c_s_p; ?><br>
                        </address>
                    </div>
                    <div class="column customer-address shipping-address left">
                        <h3>Shipping Address</h3>
                        <address class="customer-address">
                            <?php echo $_shipping_first_name.' '.$_shipping_last_name; ?><br>
                            <?php echo $_shipping_company; ?><br>
                            <?php echo $_shipping_address_1; ?><br>
                            <?php echo $_shipping_address_2; ?><br>
                            <?php echo $_shipping_c_s_p; ?><br>
                        </address>
                    </div>
                    <div class="column shipping-method left">
                        <h3>Shipping Method</h3>
                        <em class="shipping-method">
                            No shipping
                        </em>
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="document-body-content">
                    <?php
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
                        echo '<ol>';
                        foreach($comments as $comment){
                            echo '<li>'.$comment->comment_content.'</li>';
                        }
                        echo '</ol>';
                    }
                    ?>
                    <h3>Car Info</h3>
                    <h5>Vin Number: <?php echo reset($order_meta["Car Vin Number"]); ?></h5>
                    <?php echo reset($order_meta["car_info"]); ?>
                </div>
            </header>
        </div>
        <div id="printableArea">
            <table style="margin-top: 50px;">
                <tbody>
                <?php
                $car_status = get_post_meta(get_the_ID(), 'car_status', true);
                $car_status = unserialize($car_status);
                ?>
                <tr>
                    <th class="th_f">Visual Brake Check</th>
                    <th class="th_m"><label class="vertical-label crimson">Red</label></th>
                    <th class="th_m"><label class="vertical-label darkgoldenrod">Amber</label></th>
                    <th class="th_m"><label class="vertical-label greenyellow">Green</label></th>
                    <th class="th_m"><label class="vertical-label">N/C</label></th>
                    <th class="th_l"><label class="horiz-label">Report &amp; Recommendations</label></th>
                </tr>
                <tr>
                    <td>
                        <label>Brake Pads/Shoes</label>
                    </td>
                    <td>
                        <input class="check-box-size check-box-crimson" type="checkbox" name="r1c1" <?php echo ($car_status["r1c1"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-darkgoldenrod" type="checkbox" name="r1c2" <?php echo ($car_status["r1c2"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-greenyellow" type="checkbox" name="r1c3" <?php echo ($car_status["r1c3"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size" type="checkbox" name="r1c4" <?php echo ($car_status["r1c4"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td class="last-column">
                        <textarea rows="2" cols="120" type="text" name="r1c5"><?php echo $car_status["r1c5"]; ?></textarea>
                    </td>
                </tr>
                <!--    sub cell-->
                <tr>
                    <td colspan="5">
                    </td>
                    <td class="sub-cell">
                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r1c5s1" <?php echo ($car_status["r1c5s1"] == "on" ? "checked" : "") ?>>
                            <label>Front</label>
                        </div>
                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r1c5s2" <?php echo ($car_status["r1c5s2"] == "on" ? "checked" : "") ?>>
                            <label>Rear</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Brake Rotors/Drums</label>
                    </td>
                    <td>
                        <input class="check-box-size check-box-crimson" type="checkbox" name="r2c1" <?php echo ($car_status["r2c1"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-darkgoldenrod" type="checkbox" name="r2c2" <?php echo ($car_status["r2c2"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-greenyellow" type="checkbox" name="r2c3" <?php echo ($car_status["r2c3"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size" type="checkbox" name="r2c4" <?php echo ($car_status["r2c4"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td class="last-column">
                        <textarea rows="2" cols="120" type="text" name="r2c5"><?php echo $car_status["r2c5"]; ?></textarea>
                    </td>
                </tr>
                <!--    sub cell-->
                <tr>
                    <td colspan="5">
                    </td>
                    <td class="sub-cell">
                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r2c5s1" <?php echo ($car_status["r2c5s1"] == "on" ? "checked" : "") ?>>
                            <label>Front</label>
                        </div>
                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r2c5s2" <?php echo ($car_status["r2c5s2"] == "on" ? "checked" : "") ?>>
                            <label>Rear</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Brake Hoses/Lines</label>
                    </td>
                    <td>
                        <input class="check-box-size check-box-crimson" type="checkbox" name="r3c1" <?php echo ($car_status["r3c1"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-darkgoldenrod" type="checkbox" name="r3c2" <?php echo ($car_status["r3c2"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-greenyellow" type="checkbox" name="r3c3" <?php echo ($car_status["r3c3"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size" type="checkbox" name="r3c4" <?php echo ($car_status["r3c4"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td class="last-column">
                        <textarea rows="2" cols="120" type="text" name="r3c5"><?php echo $car_status["r3c5"]; ?></textarea>
                    </td>
                </tr>
                <!--    sub cell-->
                <tr>
                    <td colspan="5">
                    </td>
                    <td class="sub-cell">
                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r3c5s1" <?php echo ($car_status["r3c5s1"] == "on" ? "checked" : "") ?>>
                            <label>Front</label>
                        </div>
                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r3c5s2" <?php echo ($car_status["r3c5s2"] == "on" ? "checked" : "") ?>>
                            <label>Rear</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Brake Calipers/Wheel Cylinders</label>
                    </td>
                    <td>
                        <input class="check-box-size check-box-crimson" type="checkbox" name="r4c1" <?php echo ($car_status["r4c1"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-darkgoldenrod" type="checkbox" name="r4c2" <?php echo ($car_status["r4c2"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-greenyellow" type="checkbox" name="r4c3" <?php echo ($car_status["r4c3"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size" type="checkbox" name="r4c4" <?php echo ($car_status["r4c4"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td class="last-column">
                        <textarea rows="2" cols="120" type="text" name="r4c5"><?php echo $car_status["r4c5"]; ?></textarea>
                    </td>
                </tr>
                <!--    sub cell-->
                <tr>
                    <td colspan="5">
                    </td>
                    <td class="sub-cell">
                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r4c5s1" <?php echo ($car_status["r4c5s1"] == "on" ? "checked" : "") ?>>
                            <label>Front</label>
                        </div>
                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r4c5s2" <?php echo ($car_status["r4c5s2"] == "on" ? "checked" : "") ?>>
                            <label>Rear</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th class="th_f">Visual Underhood Check</th>
                    <th class="th_m"><label class="vertical-label crimson">Red</label></th>
                    <th class="th_m"><label class="vertical-label darkgoldenrod">Amber</label></th>
                    <th class="th_m"><label class="vertical-label greenyellow">Green</label></th>
                    <th class="th_m"><label class="vertical-label">N/C</label></th>
                    <th class="th_l"><label class="horiz-label">Report &amp; Recommendations</label></th>
                </tr>
                <tr>
                    <td>
                        <label>Air Filter</label>
                    </td>
                    <td>
                        <input class="check-box-size check-box-crimson" type="checkbox" name="r5c1" <?php echo ($car_status["r5c1"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-darkgoldenrod" type="checkbox" name="r5c2" <?php echo ($car_status["r5c2"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-greenyellow" type="checkbox" name="r5c3" <?php echo ($car_status["r5c3"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size" type="checkbox" name="r5c4" <?php echo ($car_status["r5c4"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td class="last-column">
                        <textarea rows="2" cols="120" type="text" name="r5c5"><?php echo $car_status["r5c5"]; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Battery</label>
                    </td>
                    <td>
                        <input class="check-box-size check-box-crimson" type="checkbox" name="r6c1" <?php echo ($car_status["r6c1"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-darkgoldenrod" type="checkbox" name="r6c2" <?php echo ($car_status["r6c2"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-greenyellow" type="checkbox" name="r6c3" <?php echo ($car_status["r6c3"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size" type="checkbox" name="r6c4" <?php echo ($car_status["r6c4"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td class="last-column">
                        <textarea rows="2" cols="120" type="text" name="r6c5"><?php echo $car_status["r6c5"]; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Belt(s)</label>
                    </td>
                    <td>
                        <input class="check-box-size check-box-crimson" type="checkbox" name="r7c1" <?php echo ($car_status["r7c1"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-darkgoldenrod" type="checkbox" name="r7c2" <?php echo ($car_status["r7c2"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-greenyellow" type="checkbox" name="r7c3" <?php echo ($car_status["r7c3"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size" type="checkbox" name="r7c4" <?php echo ($car_status["r7c4"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td class="last-column">
                        <textarea rows="2" cols="120" type="text" name="r7c5"><?php echo $car_status["r7c5"]; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Hoses</label>
                    </td>
                    <td>
                        <input class="check-box-size check-box-crimson" type="checkbox" name="r8c1" <?php echo ($car_status["r8c1"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-darkgoldenrod" type="checkbox" name="r8c2" <?php echo ($car_status["r8c2"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-greenyellow" type="checkbox" name="r8c3" <?php echo ($car_status["r8c3"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size" type="checkbox" name="r8c4" <?php echo ($car_status["r8c4"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td class="last-column">
                        <textarea rows="2" cols="120" type="text" name="r8c5"><?php echo $car_status["r8c5"]; ?></textarea>
                    </td>
                </tr>
                <!--    sub cell-->
                <tr>
                    <td colspan="5">
                    </td>
                    <td class="sub-cell">
                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r8c5s1" <?php echo ($car_status["r8c5s1"] == "on" ? "checked" : "") ?>>
                            <label>Heater</label>
                        </div>
                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r8c5s2" <?php echo ($car_status["r8c5s2"] == "on" ? "checked" : "") ?>>
                            <label>Air Conditioning</label>
                        </div>
                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r8c5s3" <?php echo ($car_status["r8c5s3"] == "on" ? "checked" : "") ?>>
                            <label>Radiator</label>
                        </div>
                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r8c5s3" <?php echo ($car_status["r8c5s3"] == "on" ? "checked" : "") ?>>
                            <label>Power Steering</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Engine Oil</label>
                    </td>
                    <td>
                        <input class="check-box-size check-box-crimson" type="checkbox" name="r9c1" <?php echo ($car_status["r9c1"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-darkgoldenrod" type="checkbox" name="r9c2" <?php echo ($car_status["r9c2"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-greenyellow" type="checkbox" name="r9c3" <?php echo ($car_status["r9c3"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size" type="checkbox" name="r9c4" <?php echo ($car_status["r9c4"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td class="last-column">
                        <textarea rows="2" cols="120" type="text" name="r9c5"><?php echo $car_status["r9c5"]; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Transmission Fluid</label>
                    </td>
                    <td>
                        <input class="check-box-size check-box-crimson" type="checkbox" name="r10c1" <?php echo ($car_status["r10c1"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-darkgoldenrod" type="checkbox" name="r10c2" <?php echo ($car_status["r10c2"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-greenyellow" type="checkbox" name="r10c3" <?php echo ($car_status["r10c3"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size" type="checkbox" name="r10c4" <?php echo ($car_status["r10c4"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td class="last-column">
                        <textarea rows="2" cols="120" type="text" name="r10c5"><?php echo $car_status["r10c5"]; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Brake Fluid</label>
                    </td>
                    <td>
                        <input class="check-box-size check-box-crimson" type="checkbox" name="r11c1" <?php echo ($car_status["r11c1"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-darkgoldenrod" type="checkbox" name="r11c2" <?php echo ($car_status["r11c2"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-greenyellow" type="checkbox" name="r11c3" <?php echo ($car_status["r11c3"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size" type="checkbox" name="r11c4" <?php echo ($car_status["r11c4"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td class="last-column">
                        <textarea rows="2" cols="120" type="text" name="r11c5"><?php echo $car_status["r11c5"]; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Clutch Fluid</label>
                    </td>
                    <td>
                        <input class="check-box-size check-box-crimson" type="checkbox" name="r12c1" <?php echo ($car_status["r12c1"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-darkgoldenrod" type="checkbox" name="r12c2" <?php echo ($car_status["r12c2"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-greenyellow" type="checkbox" name="r12c3" <?php echo ($car_status["r12c3"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size" type="checkbox" name="r12c4" <?php echo ($car_status["r12c4"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td class="last-column">
                        <textarea rows="2" cols="120" type="text" name="r12c5"><?php echo $car_status["r12c5"]; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Power Steering Fluid</label>
                    </td>
                    <td>
                        <input class="check-box-size check-box-crimson" type="checkbox" name="r13c1" <?php echo ($car_status["r13c1"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-darkgoldenrod" type="checkbox" name="r13c2" <?php echo ($car_status["r13c2"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-greenyellow" type="checkbox" name="r13c3" <?php echo ($car_status["r13c3"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size" type="checkbox" name="r13c4" <?php echo ($car_status["r13c4"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td class="last-column">
                        <textarea rows="2" cols="120" type="text" name="r13c5"><?php echo $car_status["r13c5"]; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Windshield Washer Fluid</label>
                    </td>
                    <td>
                        <input class="check-box-size check-box-crimson" type="checkbox" name="r14c1" <?php echo ($car_status["r14c1"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-darkgoldenrod" type="checkbox" name="r14c2" <?php echo ($car_status["r14c2"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-greenyellow" type="checkbox" name="r14c3" <?php echo ($car_status["r14c3"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size" type="checkbox" name="r14c4" <?php echo ($car_status["r14c4"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td class="last-column">
                        <textarea rows="2" cols="120" type="text" name="r14c5"><?php echo $car_status["r14c5"]; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th class="th_f">Tire Tread Depth and Pressure Check</th>
                    <th class="th_m"><label class="vertical-label crimson">Red</label></th>
                    <th class="th_m"><label class="vertical-label darkgoldenrod">Amber</label></th>
                    <th class="th_m"><label class="vertical-label greenyellow">Green</label></th>
                    <th class="th_m"><label class="vertical-label">N/C</label></th>
                    <th>
                        <table>
                            <tr>
                                <th colspan="3"><label class="horiz-label">Depth mm</label></th>
                            </tr>
                            <tr>
                                <th style="width: 100px;"><label class="horiz-label">Outer</label></th>
                                <th style="width: 100px;"><label class="horiz-label">Middle</label></th>
                                <th style="width: 100px;"><label class="horiz-label ">Inner</label></th>
                                <th style="width: 50%"><label class="horiz-label">Report &amp; Recommendations</label></th>
                            </tr>
                        </table>
                    </th>
                </tr>
                <tr>
                    <td>
                        <label>Front Left</label>
                    </td>
                    <td>
                        <input class="check-box-size check-box-crimson" type="checkbox" name="r15c1" <?php echo ($car_status["r15c1"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-darkgoldenrod" type="checkbox" name="r15c2" <?php echo ($car_status["r15c2"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-greenyellow" type="checkbox" name="r15c3" <?php echo ($car_status["r15c3"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size" type="checkbox" name="r15c4" <?php echo ($car_status["r15c4"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td class="last-column">
                        <table>
                            <tr>
                                <td style="width: 100px;"><input class="depth_inp" type="text" name="r15c5s1" value=" <?php echo $car_status["r15c5s1"]?>" ></td>
                                <td style="width: 100px;"><input class="depth_inp" type="text" name="r15c5s2" value=" <?php echo $car_status["r15c5s2"]?>" ></td>
                                <td style="width: 100px;"><input class="depth_inp" type="text" name="r15c5s3" value=" <?php echo $car_status["r15c5s3"]?>" ></td>
                                <td class="last-column">
                                    <textarea rows="2" cols="45" type="text"  name="r15c5s4"><?php echo $car_status["r15c5s4"]?></textarea>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <!--    sub cell-->
                <tr>
                    <td colspan="5">
                    </td>
                    <td class="sub-cell">
                        <div class="sub-cell-mr sub-cell-ml">
                            <input type="checkbox" name="r15c5s5" <?php echo ($car_status["r15c5s5"] == "on" ? "checked" : "") ?>>
                            <label>PSI</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Front Right</label>
                    </td>
                    <td>
                        <input class="check-box-size check-box-crimson" type="checkbox" name="r16c1" <?php echo ($car_status["r16c1"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-darkgoldenrod" type="checkbox" name="r16c2" <?php echo ($car_status["r16c2"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-greenyellow" type="checkbox" name="r16c3" <?php echo ($car_status["r16c3"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size" type="checkbox" name="r16c4" <?php echo ($car_status["r16c4"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td class="last-column">
                        <table>
                            <tr>
                                <td style="width: 100px;"><input class="depth_inp" type="text" name="r16c5s1" value=" <?php echo $car_status["r16c5s1"]?>" ></td>
                                <td style="width: 100px;"><input class="depth_inp" type="text" name="r16c5s2" value=" <?php echo $car_status["r16c5s2"]?>" ></td>
                                <td style="width: 100px;"><input class="depth_inp" type="text" name="r16c5s3" value=" <?php echo $car_status["r16c5s3"]?>" ></td>
                                <td class="last-column">
                                    <textarea rows="2" cols="45" type="text"  name="r16c5s4"><?php echo $car_status["r16c5s4"]?></textarea>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <!--    sub cell-->
                <tr>
                    <td colspan="5">
                    </td>
                    <td class="sub-cell">
                        <div class="sub-cell-mr sub-cell-ml">
                            <input type="checkbox" name="r16c5s5" <?php echo ($car_status["r16c5s5"] == "on" ? "checked" : "") ?>>
                            <label>PSI</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Rear Left</label>
                    </td>
                    <td>
                        <input class="check-box-size check-box-crimson" type="checkbox" name="r17c1" <?php echo ($car_status["r17c1"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-darkgoldenrod" type="checkbox" name="r17c2" <?php echo ($car_status["r17c2"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-greenyellow" type="checkbox" name="r17c3" <?php echo ($car_status["r17c3"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size" type="checkbox" name="r17c4" <?php echo ($car_status["r17c4"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td class="last-column">
                        <table>
                            <tr>
                                <td style="width: 100px;"><input class="depth_inp" type="text" name="r17c5s1" value=" <?php echo $car_status["r17c5s1"]?>" ></td>
                                <td style="width: 100px;"><input class="depth_inp" type="text" name="r17c5s2" value=" <?php echo $car_status["r17c5s2"]?>" ></td>
                                <td style="width: 100px;"><input class="depth_inp" type="text" name="r17c5s3" value=" <?php echo $car_status["r17c5s3"]?>" ></td>
                                <td class="last-column">
                                    <textarea rows="2" cols="45" type="text"  name="r17c5s4"><?php echo $car_status["r17c5s4"]?></textarea>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!--    sub cell-->
                <tr>
                    <td colspan="5">
                    </td>
                    <td class="sub-cell">
                        <div class="sub-cell-mr sub-cell-ml">
                            <input type="checkbox" name="r17c5s5" <?php echo ($car_status["r17c5s5"] == "on" ? "checked" : "") ?>>
                            <label>PSI</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Rear Right</label>
                    </td>
                    <td>
                        <input class="check-box-size check-box-crimson" type="checkbox" name="r18c1" <?php echo ($car_status["r18c1"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-darkgoldenrod" type="checkbox" name="r18c2" <?php echo ($car_status["r18c2"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-greenyellow" type="checkbox" name="r18c3" <?php echo ($car_status["r18c3"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size" type="checkbox" name="r18c4" <?php echo ($car_status["r18c4"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td class="last-column">
                        <table>
                            <tr>
                                <td style="width: 100px;"><input class="depth_inp" type="text" name="r18c5s1" value=" <?php echo $car_status["r18c5s1"]?>" ></td>
                                <td style="width: 100px;"><input class="depth_inp" type="text" name="r18c5s2" value=" <?php echo $car_status["r18c5s2"]?>" ></td>
                                <td style="width: 100px;"><input class="depth_inp" type="text" name="r18c5s3" value=" <?php echo $car_status["r18c5s3"]?>" ></td>
                                <td class="last-column">
                                    <textarea rows="2" cols="45" type="text"  name="r18c5s4"><?php echo $car_status["r18c5s4"]?></textarea>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <!--    sub cell-->
                <tr>
                    <td colspan="5">
                    </td>
                    <td class="sub-cell">
                        <div class="sub-cell-mr sub-cell-ml">
                            <input type="checkbox" name="r18c5s5" <?php echo ($car_status["r18c5s5"] == "on" ? "checked" : "") ?>>
                            <label>PSI</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th class="th_f">Visual Exterior Check</th>
                    <th class="th_m"><label class="vertical-label crimson">Red</label></th>
                    <th class="th_m"><label class="vertical-label darkgoldenrod">Amber</label></th>
                    <th class="th_m"><label class="vertical-label greenyellow">Green</label></th>
                    <th class="th_m"><label class="vertical-label">N/C</label></th>
                    <th class="th_l"><label class="horiz-label">Report &amp; Recommendations</label></th>
                </tr>
                <tr>
                    <td>
                        <label>Lights</label>
                    </td>
                    <td>
                        <input class="check-box-size check-box-crimson" type="checkbox" name="r19c1" <?php echo ($car_status["r19c1"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-darkgoldenrod" type="checkbox" name="r19c2" <?php echo ($car_status["r19c2"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-greenyellow" type="checkbox" name="r19c3" <?php echo ($car_status["r19c3"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size" type="checkbox" name="r19c4" <?php echo ($car_status["r19c4"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td class="last-column">
                        <textarea rows="2" cols="120" type="text" name="r19c5"><?php echo $car_status["r19c5"]; ?></textarea>
                    </td>
                </tr>
                <!--    sub cell-->
                <tr>
                    <td colspan="5">
                    </td>
                    <td class="sub-cell">
                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r19c5s1" <?php echo ($car_status["r19c5s1"] == "on" ? "checked" : "") ?>>
                            <label>Headlights</label>
                        </div>

                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r19c5s2" <?php echo ($car_status["r19c5s2"] == "on" ? "checked" : "") ?>>
                            <label>High Beams</label>
                        </div>

                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r19c5s3" <?php echo ($car_status["r19c5s3"] == "on" ? "checked" : "") ?>>
                            <label>Brake Lights/Tail Lights</label>
                        </div>

                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r19c5s4" <?php echo ($car_status["r19c5s4"] == "on" ? "checked" : "") ?>>
                            <label>Turn Signals</label>
                        </div>

                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r19c5s5" <?php echo ($car_status["r19c5s5"] == "on" ? "checked" : "") ?>>
                            <label>Reverse Lights</label>
                        </div>

                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r19c5s6" <?php echo ($car_status["r19c5s6"] == "on" ? "checked" : "") ?>>
                            <label>Parking Lights</label>
                        </div>

                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r19c5s7" <?php echo ($car_status["r19c5s7"] == "on" ? "checked" : "") ?>>
                            <label>Fog Lights</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Wiper Blades</label>
                    </td>
                    <td>
                        <input class="check-box-size check-box-crimson" type="checkbox" name="r20c1" <?php echo ($car_status["r20c1"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-darkgoldenrod" type="checkbox" name="r20c2" <?php echo ($car_status["r20c2"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-greenyellow" type="checkbox" name="r20c3" <?php echo ($car_status["r20c3"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size" type="checkbox" name="r20c4" <?php echo ($car_status["r20c4"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td class="last-column">
                        <textarea rows="2" cols="120" type="text" name="r20c5"><?php echo $car_status["r20c5"]; ?></textarea>
                    </td>
                </tr>
                <!--    sub cell-->
                <tr>
                    <td colspan="5">
                    </td>
                    <td class="sub-cell">
                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r20c5s1" <?php echo ($car_status["r20c5s1"] == "on" ? "checked" : "") ?>>
                            <label>Driver Side</label>
                        </div>

                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r20c5s2" <?php echo ($car_status["r20c5s2"] == "on" ? "checked" : "") ?>>
                            <label>Passanger Side</label>
                        </div>

                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r20c5s3" <?php echo ($car_status["r20c5s3"] == "on" ? "checked" : "") ?>>
                            <label>Rear</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Struts/Shocks</label>
                    </td>
                    <td>
                        <input class="check-box-size check-box-crimson" type="checkbox" name="r21c1" <?php echo ($car_status["r21c1"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-darkgoldenrod" type="checkbox" name="r21c2" <?php echo ($car_status["r21c2"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-greenyellow" type="checkbox" name="r21c3" <?php echo ($car_status["r21c3"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size" type="checkbox" name="r21c4" <?php echo ($car_status["r21c4"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td class="last-column">
                        <textarea rows="2" cols="120" type="text" name="r21c5"><?php echo $car_status["r21c5"]; ?></textarea>
                    </td>
                </tr>
                <!--    sub cell-->
                <tr>
                    <td colspan="5">
                    </td>
                    <td class="sub-cell">
                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r21c5s1" <?php echo ($car_status["r21c5s1"] == "on" ? "checked" : "") ?>>
                            <label>Front Left</label>
                        </div>

                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r21c5s2" <?php echo ($car_status["r21c5s2"] == "on" ? "checked" : "") ?>>
                            <label>Front Right</label>
                        </div>

                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r21c5s3" <?php echo ($car_status["r21c5s3"] == "on" ? "checked" : "") ?>>
                            <label>Rear Left</label>
                        </div>

                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r21c5s4" <?php echo ($car_status["r21c5s4"] == "on" ? "checked" : "") ?>>
                            <label>Rear Right</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Fuel Lines</label>
                    </td>
                    <td>
                        <input class="check-box-size check-box-crimson" type="checkbox" name="r22c1" <?php echo ($car_status["r22c1"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-darkgoldenrod" type="checkbox" name="r22c2" <?php echo ($car_status["r22c2"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-greenyellow" type="checkbox" name="r22c3" <?php echo ($car_status["r22c3"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size" type="checkbox" name="r22c4" <?php echo ($car_status["r22c4"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td class="last-column">
                        <textarea rows="2" cols="120" type="text" name="r22c5"><?php echo $car_status["r22c5"]; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Exhaust System</label>
                    </td>
                    <td>
                        <input class="check-box-size check-box-crimson" type="checkbox" name="r23c1" <?php echo ($car_status["r23c1"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-darkgoldenrod" type="checkbox" name="r23c2" <?php echo ($car_status["r23c2"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-greenyellow" type="checkbox" name="r23c3" <?php echo ($car_status["r23c3"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size" type="checkbox" name="r23c4" <?php echo ($car_status["r23c4"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td class="last-column">
                        <textarea rows="2" cols="120" type="text" name="r23c5"><?php echo $car_status["r23c5"]; ?></textarea>
                    </td>
                </tr>
                <!--    sub cell-->
                <tr>
                    <td colspan="5">
                    </td>
                    <td class="sub-cell">
                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r23c5s1" <?php echo ($car_status["r23c5s1"] == "on" ? "checked" : "") ?>>
                            <label>Muffler</label>
                        </div>

                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r23c5s2" <?php echo ($car_status["r23c5s2"] == "on" ? "checked" : "") ?>>
                            <label>Catalytic Converter</label>
                        </div>

                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r23c5s3" <?php echo ($car_status["r23c5s3"] == "on" ? "checked" : "") ?>>
                            <label>Exhaust Manifold</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Steering System</label>
                    </td>
                    <td>
                        <input class="check-box-size check-box-crimson" type="checkbox" name="r24c1" <?php echo ($car_status["r24c1"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-darkgoldenrod" type="checkbox" name="r24c2" <?php echo ($car_status["r24c2"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-greenyellow" type="checkbox" name="r24c3" <?php echo ($car_status["r24c3"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size" type="checkbox" name="r24c4" <?php echo ($car_status["r24c4"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td class="last-column">
                        <textarea rows="2" cols="120" type="text" name="r24c5"><?php echo $car_status["r24c5"]; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Body Panels</label>
                    </td>
                    <td>
                        <input class="check-box-size check-box-crimson" type="checkbox" name="r25c1" <?php echo ($car_status["r25c1"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-darkgoldenrod" type="checkbox" name="r25c2" <?php echo ($car_status["r25c2"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-greenyellow" type="checkbox" name="r25c3" <?php echo ($car_status["r25c3"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size" type="checkbox" name="r25c4" <?php echo ($car_status["r25c4"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td class="last-column">
                        <textarea rows="2" cols="120" type="text" name="r25c5"><?php echo $car_status["r25c5"]; ?></textarea>
                    </td>
                </tr>
                <!--    sub cell-->
                <tr>
                    <td colspan="5">
                    </td>
                    <td class="sub-cell">
                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r25c5s1" <?php echo ($car_status["r25c5s1"] == "on" ? "checked" : "") ?>>
                            <label>Front</label>
                        </div>

                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r25c5s2" <?php echo ($car_status["r25c5s2"] == "on" ? "checked" : "") ?>>
                            <label>Left Side</label>
                        </div>

                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r25c5s3" <?php echo ($car_status["r25c5s3"] == "on" ? "checked" : "") ?>>
                            <label>Rear</label>
                        </div>

                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r25c5s4" <?php echo ($car_status["r25c5s4"] == "on" ? "checked" : "") ?>>
                            <label>Right Side</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Windows and Mirrors</label>
                    </td>
                    <td>
                        <input class="check-box-size check-box-crimson" type="checkbox" name="r26c1" <?php echo ($car_status["r26c1"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-darkgoldenrod" type="checkbox" name="r26c2" <?php echo ($car_status["r26c2"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-greenyellow" type="checkbox" name="r26c3" <?php echo ($car_status["r26c3"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size" type="checkbox" name="r26c4" <?php echo ($car_status["r26c4"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td class="last-column">
                        <textarea rows="2" cols="120" type="text" name="r26c5"><?php echo $car_status["r26c5"]; ?></textarea>
                    </td>
                </tr>
                <!--    sub cell-->
                <tr>
                    <td colspan="5">
                    </td>
                    <td class="sub-cell">
                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r26c5s1" <?php echo ($car_status["r26c5s1"] == "on" ? "checked" : "") ?>>
                            <label>Windshield</label>
                        </div>

                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r26c5s2" <?php echo ($car_status["r26c5s2"] == "on" ? "checked" : "") ?>>
                            <label>Side & Rear Glass</label>
                        </div>

                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r26c5s3" <?php echo ($car_status["r26c5s3"] == "on" ? "checked" : "") ?>>
                            <label>Mirrors</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th class="th_f">Visual Interior Check</th>
                    <th class="th_m"><label class="vertical-label crimson">Red</label></th>
                    <th class="th_m"><label class="vertical-label darkgoldenrod">Amber</label></th>
                    <th class="th_m"><label class="vertical-label greenyellow">Green</label></th>
                    <th class="th_m"><label class="vertical-label">N/C</label></th>
                    <th class="th_l"><label class="horiz-label">Report &amp; Recommendations</label></th>
                </tr>
                <tr>
                    <td>
                        <label>Warning Lights</label>
                    </td>
                    <td>
                        <input class="check-box-size check-box-crimson" type="checkbox" name="r27c1" <?php echo ($car_status["r27c1"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-darkgoldenrod" type="checkbox" name="r27c2" <?php echo ($car_status["r27c2"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-greenyellow" type="checkbox" name="r27c3" <?php echo ($car_status["r27c3"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size" type="checkbox" name="r27c4" <?php echo ($car_status["r27c4"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td class="last-column">
                        <textarea rows="2" cols="120" type="text" name="r27c5"><?php echo $car_status["r27c5"]; ?></textarea>
                    </td>
                </tr>
                <!--    sub cell-->
                <tr>
                    <td colspan="5">
                    </td>
                    <td class="sub-cell">
                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r27c5s1" <?php echo ($car_status["r27c5s1"] == "on" ? "checked" : "") ?>>
                            <label>Check Engine Light </label>
                        </div>

                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r27c5s2" <?php echo ($car_status["r27c5s2"] == "on" ? "checked" : "") ?>>
                            <label>Airbag Light</label>
                        </div>

                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r27c5s3" <?php echo ($car_status["r27c5s3"] == "on" ? "checked" : "") ?>>
                            <label>ABS Light</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Interior Lights</label>
                    </td>
                    <td>
                        <input class="check-box-size check-box-crimson" type="checkbox" name="r28c1" <?php echo ($car_status["r28c1"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-darkgoldenrod" type="checkbox" name="r28c2" <?php echo ($car_status["r28c2"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-greenyellow" type="checkbox" name="r28c3" <?php echo ($car_status["r28c3"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size" type="checkbox" name="r28c4" <?php echo ($car_status["r28c4"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td class="last-column">
                        <textarea rows="2" cols="120" type="text" name="r28c5"><?php echo $car_status["r28c5"]; ?></textarea>
                    </td>
                </tr>

                <!--    sub cell-->
                <tr>
                    <td colspan="5">
                    </td>
                    <td class="sub-cell">
                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r28c5s1" <?php echo ($car_status["r28c5s1"] == "on" ? "checked" : "") ?>>
                            <label>Dashboard Lights</label>
                        </div>

                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r28c5s2" <?php echo ($car_status["r28c5s2"] == "on" ? "checked" : "") ?>>
                            <label>Overhead/Map Lights</label>
                        </div>

                        <div class="sub-cell-mr">
                            <input type="checkbox" name="r28c5s3" <?php echo ($car_status["r28c5s3"] == "on" ? "checked" : "") ?>>
                            <label>Vanity/Mirror Lights</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Air Conditioning</label>
                    </td>
                    <td>
                        <input class="check-box-size check-box-crimson" type="checkbox" name="r29c1" <?php echo ($car_status["r29c1"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-darkgoldenrod" type="checkbox" name="r29c2" <?php echo ($car_status["r29c2"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-greenyellow" type="checkbox" name="r29c3" <?php echo ($car_status["r29c3"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size" type="checkbox" name="r29c4" <?php echo ($car_status["r29c4"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td class="last-column">
                        <textarea rows="2" cols="120" type="text" name="r29c5"><?php echo $car_status["r29c5"]; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Heating System</label>
                    </td>
                    <td>
                        <input class="check-box-size check-box-crimson" type="checkbox" name="r30c1" <?php echo ($car_status["r30c1"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-darkgoldenrod" type="checkbox" name="r30c2" <?php echo ($car_status["r30c2"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-greenyellow" type="checkbox" name="r30c3" <?php echo ($car_status["r30c3"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size" type="checkbox" name="r30c4" <?php echo ($car_status["r30c4"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td class="last-column">
                        <textarea rows="2" cols="120" type="text" name="r30c5"><?php echo $car_status["r30c5"]; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Cabin Air Filter</label>
                    </td>
                    <td>
                        <input class="check-box-size check-box-crimson" type="checkbox" name="r31c1" <?php echo ($car_status["r31c1"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-darkgoldenrod" type="checkbox" name="r31c2" <?php echo ($car_status["r31c2"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-greenyellow" type="checkbox" name="r31c3" <?php echo ($car_status["r31c3"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size" type="checkbox" name="r31c4" <?php echo ($car_status["r31c4"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td class="last-column">
                        <textarea rows="2" cols="120" type="text" name="r31c5"><?php echo $car_status["r31c5"]; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Seatbelt</label>
                    </td>
                    <td>
                        <input class="check-box-size check-box-crimson" type="checkbox" name="r32c1" <?php echo ($car_status["r32c1"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-darkgoldenrod" type="checkbox" name="r32c2" <?php echo ($car_status["r32c2"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-greenyellow" type="checkbox" name="r32c3" <?php echo ($car_status["r32c3"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size" type="checkbox" name="r32c4" <?php echo ($car_status["r32c4"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td class="last-column">
                        <textarea rows="2" cols="120" type="text" name="r32c5"><?php echo $car_status["r32c5"]; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Airbags</label>
                    </td>
                    <td>
                        <input class="check-box-size check-box-crimson" type="checkbox" name="r33c1" <?php echo ($car_status["r33c1"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-darkgoldenrod" type="checkbox" name="r33c2" <?php echo ($car_status["r33c2"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size check-box-greenyellow" type="checkbox" name="r33c3" <?php echo ($car_status["r33c3"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td>
                        <input class="check-box-size" type="checkbox" name="r33c4" <?php echo ($car_status["r33c4"] == "on" ? "checked" : "") ?>>
                    </td>
                    <td class="last-column">
                        <textarea rows="2" cols="120" type="text" name="r33c5"><?php echo $car_status["r33c5"]; ?></textarea>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
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
            for ($s = 1; $s <= 7; $s++) {
                $key ='r'.$r.'c'.$c.'s'.$s;
                $arr[$key] = $_POST[$key];
            }
        }
    }
    $car_status = serialize( $arr );
    update_post_meta(get_the_ID(), 'car_status',$car_status);
}
add_action( 'woocommerce_process_shop_order_meta', 'car_status_update_in_woocommerce_order_meta', 50, 2 );