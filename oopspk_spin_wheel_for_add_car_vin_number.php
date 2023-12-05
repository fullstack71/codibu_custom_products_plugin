<?php
defined('ABSPATH') || die ("You can't access this file directyly !");

function add_this_vin_script_footer(){
    $user = wp_get_current_user();
    $role = reset($user->roles);
    if($role == 'customer'){
        $parentDiv = 'display: inline-flex;';
        $inputTxt = 'max-width: 237px;';
        $inputbtn = 'margin-left: 5px;padding: 8px;';

        $vin_numbers = get_user_meta($user->ID, 'car_vin_number', true);
        $vin_numbers = $vin_numbers ? json_encode(unserialize($vin_numbers)) : json_encode([]);
        ?>
        <script>
            var vin_numbers = <?php echo $vin_numbers ?>;

            vin_numbers = vin_numbers.map((element, index) => {
                return '<div class="input-block" style="margin-bottom: 5px;<?php echo $parentDiv; ?>"> <input style="<?php echo $inputTxt; ?>" type="text" name="vin_number_update[]" value="'+element+'" class="form-control" disabled></div>';
            });
            jQuery(document).ready(function() {
                jQuery("#some_div").append(vin_numbers.toString().replaceAll(',', ''))

                jQuery("#add-field").click(function () {
                    jQuery("#some_div").append('<div class="input-block" style="margin-bottom: 5px;<?php echo $parentDiv; ?>"><input style="<?php echo $inputTxt; ?>" type="text" name="vin_number_add[]" class="form-control"><input style="<?php echo $inputbtn; ?>" type="button" class="remove-field" value="-"></div>');
                });
                jQuery(document).on("click", ".remove-field", function () {
                    jQuery(this).closest(".input-block").remove();
                });
                jQuery('.car_vin_number_cont').parent().parent().hide()
            })
        </script>
        <?php
    }
}

add_action('wp_footer', 'add_this_vin_script_footer');

function userCarVinNumberOwnForm(){
    ?>
    <p style="background-color: lightgrey;padding: 10px;">
        <span style="margin-right: 20px;">Note:</span>To delete or update a  vin#, please <a href="https://freeoilchange.com/contacts">contact us</a>
    </p>
    <table class="form-table">
        <tr>
            <th><label for="user_birthday">Car vin numbers</label></th>
            <td>
                <div id="some_div"></div>
                <input type="button" id="add-field" value="+">
            </td>
        </tr>
    </table>
    <?php
}

function userCarVinNumberForm($user) {
    foreach($user->roles as $role){
        $role = $role;
        break;
    }
    if($role != 'administrator'){
        ?>
        <table class="form-table">
            <tr>
                <th><label for="user_birthday">Car vin numbers</label></th>
                <td>
                    <div id="some_div"></div>
                    <input type="button" id="add-field" value="+">
                </td>
            </tr>
        </table>

        <?php
        $vin_numbers = get_user_meta($user->ID, 'car_vin_number', true);
        $vin_numbers = $vin_numbers ? json_encode(unserialize($vin_numbers)) : json_encode([]);

        ?>
        <script>
            var vin_numbers = <?php echo $vin_numbers ?>;
            vin_numbers = vin_numbers.map((element, index) => {
                return '<div class="input-block" style="margin-bottom: 5px;"><input type="checkbox" name="'+index+'"> <input  type="text" name="vin_number_update[]" value="'+element+'" class="form-control"><input type="button" class="remove-field" value="-"></div>';
            });
            jQuery(document).ready(function() {
                jQuery("#some_div").append(vin_numbers.toString().replaceAll(',', ''))

                jQuery("#add-field").click(function () {
                    jQuery("#some_div").append('<div class="input-block" style="margin-bottom: 5px;"><input type="checkbox" name="is_check[]"> <input type="text" name="vin_number_add[]" class="form-control"><input type="button" class="remove-field" value="-"></div>');
                });
                jQuery(document).on("click", ".remove-field", function () {
                    jQuery(this).closest(".input-block").remove();
                });
                jQuery('.car_vin_number_cont').parent().parent().hide()
            })
        </script>
        <?php
    }
}
//add_action('show_user_profile', 'userCarVinNumberForm'); // editing your own profile
add_action('edit_user_profile', 'userCarVinNumberForm'); // editing another user
//add_action('user_new_form', 'userCarVinNumberForm'); // creating a new user
add_action( 'woocommerce_register_form_start', 'userCarVinNumberForm' );
add_action( 'woocommerce_edit_account_form', 'userCarVinNumberOwnForm', 100);

function userCarVinNumberSave($userId) {
    if (!current_user_can('edit_user', $userId)) {
        return;
    }

    /*    foreach(get_users() as $user){
            $carVinNumbers = get_user_meta($user->ID, 'xoo_aff_text_05a5i', false);
            if(count($carVinNumbers)>=1){
                $asdasd = [];
                foreach ($carVinNumbers as $kk => $carVinNumber) {
                    $asdasd[$kk] = $carVinNumber;
                    delete_user_meta($user->ID, 'xoo_aff_text_05a5i', $carVinNumber, false);
                }
                update_user_meta($user->ID,'car_vin_number',serialize($asdasd),'');
            }
        }*/

    $carVinNumbers = get_user_meta($userId, 'car_vin_number', true);
    $carVinNumbers = unserialize($carVinNumbers) ? unserialize($carVinNumbers) : [];

    $current_hook = current_filter();
    if($current_hook != 'woocommerce_update_customer') {
        $vin_number_update =$_POST['vin_number_update'] != NULL ? $_POST['vin_number_update'] : [];
        $vin_number_add = $_POST['vin_number_add'] != NULL ? $_POST['vin_number_add'] : [];
        $array = array_merge($vin_number_update,$vin_number_add);
    } else {
        $vin_number_add = $_POST['vin_number_add'] != NULL ? $_POST['vin_number_add'] : [];
        $array = array_merge($carVinNumbers,$vin_number_add);
    }
    update_user_meta($userId,'car_vin_number',serialize($array),serialize($carVinNumbers));
}
add_action('personal_options_update', 'userCarVinNumberSave');
add_action('edit_user_profile_update', 'userCarVinNumberSave');
add_action('user_register', 'userCarVinNumberSave');
add_action('woocommerce_update_customer', 'userCarVinNumberSave');

