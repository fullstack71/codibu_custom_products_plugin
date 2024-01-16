<?php
defined('ABSPATH') || die ("You can't access this file directyly !");


$vin_numbers = get_user_meta($user_id, 'car_vin_numbers', true);
$vin_numbers = unserialize($vin_numbers);
$vin_numbers_count =count($vin_numbers);
if ($vin_numbers){
    if ($_GET['post'] != null && $_GET['action'] == "edit") {
        $vin_number_meta_value= get_post_meta( get_the_ID(), "Car Vin Number" );
        $vin_number_meta_value = reset($vin_number_meta_value);
        ?>
        <table class="form-table" style="margin-bottom: 10px;">
            <tr>
                <th><label for="user_birthday">Select car vin number</label></th>
                <td>
                    <select name="vinNumber" id="vinNumber">
                        <?php
                        foreach ($vin_numbers as $vin_number) { ?>
                            <option value="<?php echo $vin_number['vin_number'] ?>" <?php echo ($vin_number_meta_value == $vin_number['vin_number']) ? 'selected' : ''; ?> ><?php echo $vin_number['vin_number'] ?></option>

                        <?php } ?>
                    </select>
                </td>
            </tr>
        </table>
        <?php
    } else {
        ?>
        <table class="form-table" style="margin-bottom: 10px;">
            <tr>
                <th><label for="user_birthday">Select car vin number</label></th>
                <td>
                    <select name="vinNumber" id="vinNumber">
                        <?php
                        foreach ($vin_numbers as $vin_number) { ?>
                            <option value="<?php echo $vin_number['vin_number'] ?>"><?php echo $vin_number['vin_number'] ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
        </table>
        <?php
    }
}
?>
    <script>
        var count = <?php echo $vin_numbers_count; ?>
        jQuery(document).ready(function() {
            if (count == 1){
                carInfo(jQuery('#vinNumber').val());
            }
            jQuery('#vinNumber').on('change', function() {
                carInfo(this.value);
            });
            function carInfo(car_vin_number) {
                var width = <?php echo ($_GET['post'] != null && $_GET['action'] == "edit") ? '213' : '100'; ?>;
                jQuery.ajax({
                    type: "get",
                    dataType: "json",
                    url: 'https://vpic.nhtsa.dot.gov/api/vehicles/decodevinextended/'+car_vin_number+'*BA?format=json',
                    success: function(obj) {
                        console.log(obj.Results);
                        jQuery(".tabel_data_json")
                            .replaceWith(`
                            <table style="width: `+width+`%" border="1" class="tabel_data_json">
                                <tbody>
                                    <tr>
                                        <td class="td_tilte">VEHICLE DESCRIPTOR</td>
                                        <td>`+obj.Results[5].Value+`</td>
                                        <td class="td_tilte">MANUFACTURER NAME</td>
                                        <td>`+obj.Results[8].Value+`</td>
                                    </tr>
                                    <tr>
                                        <td class="td_tilte">MODEL YEAR</td>
                                        <td>`+obj.Results[10].Value+`</td>
                                        <td class="td_tilte">SERIES</td>
                                        <td>`+obj.Results[12].Value+`</td>
                                    </tr>
                                    <tr>
                                        <td class="td_tilte">PLANT COUNTRY</td>
                                        <td>`+obj.Results[15].Value+`</td>
                                        <td class="td_tilte">DOORS</td>
                                        <td>`+obj.Results[24].Value+`</td>
                                    </tr>
                                    <tr>
                                        <td class="td_tilte">WHEEL BASE (INCHES) FROM</td>
                                        <td>`+obj.Results[31].Value+`</td>
                                        <td class="td_tilte">FUEL TYPE-PRIMARY</td>
                                        <td>`+obj.Results[77].Value+`</td>
                                    </tr>
                                    <tr>
                                        <td class="td_tilte">SEAT BELT TYPE</td>
                                        <td>`+obj.Results[91].Value+`</td>
                                        <td class="td_tilte">MAKE</td>
                                        <td>`+obj.Results[7].Value+`</td>
                                    </tr>
                                    <tr>
                                        <td class="td_tilte">MODEL</td>
                                        <td>`+obj.Results[9].Value+`</td>
                                        <td class="td_tilte">PLANT CITY</td>
                                        <td>`+obj.Results[28].Value+`</td>
                                    </tr>
                                    <tr>
                                        <td class="td_tilte">VEHICLE TYPE</td>
                                        <td>`+obj.Results[14].Value+`</td>
                                        <td class="td_tilte">BODY CLASS</td>
                                        <td>`+obj.Results[23].Value+`</td>
                                    </tr>
                                    <tr>
                                        <td class="td_tilte">GROSS VEHICLE WEIGHT RATING FROM</td>
                                        <td>`+obj.Results[28].Value+`</td>
                                        <td class="td_tilte">ENGINE NUMBER OF CYLINDERS</td>
                                        <td>`+obj.Results[70].Value+`</td>
                                    </tr>
                                    <tr>
                                        <td class="td_tilte">DISPLACEMENT (CI)</td>
                                        <td>`+obj.Results[72].Value+`</td>
                                        <td class="td_tilte">ENGINE POWER (KW)</td>
                                        <td>`+obj.Results[76].Value+`</td>
                                    </tr>
                                </tbody>
                            </table>
                            `)
                    }
                });
            }
        })
    </script>
<?php