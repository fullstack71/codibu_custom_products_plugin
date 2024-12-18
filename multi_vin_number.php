<?php
defined('ABSPATH') || die ("You can't access this file directyly !");


$vin_numbers = get_user_meta($user_id, 'car_vin_numbers', true);
$vin_numbers = unserialize($vin_numbers);
$vin_numbers_count = is_array($vin_numbers) ? count($vin_numbers) : 0;
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
        var count = <?php echo $vin_numbers_count; ?>;
        jQuery(document).ready(function() {
            if (count == 1){
                carInfo(jQuery('#vinNumber').val());
            }
            jQuery('#vinNumber').on('change', function() {
                carInfo(this.value);
            });
            function carInfo(car_vin_number) {
                var width = <?php echo (isset($_GET['post']) && $_GET['post'] != null && isset($_GET['action']) && $_GET['action'] == "edit") ? '213' : '100'; ?>;
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
                                        <td class="td_tilte">MODEL YEAR</td>
                                        <td>`+obj.Results[10].Value+`</td>
                                    </tr>
                                    <tr>
                                        <td class="td_tilte">MAKE</td>
                                        <td>`+obj.Results[7].Value+`</td>
                                    </tr>
                                    <tr>
                                        <td class="td_tilte">MODEL</td>
                                        <td>`+obj.Results[9].Value+`</td>
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
