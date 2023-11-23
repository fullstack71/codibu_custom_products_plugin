<?php
defined('ABSPATH') || die ("You can't access this file directyly !");

function add_this_vin_script_footer(){
    $user = wp_get_current_user();
    $user_data = get_userdata($user->ID);
    foreach($user->roles as $role){
        $role = $role;
        break;
    }
    if($role == 'customer'){
        $parentDiv = 'display: inline-flex;';
        $inputTxt = 'max-width: 202px;';
        $inputbtn = 'margin-left: 5px;padding: 8px;';
        ?>
        <script>
            var vin_numbers = <?php echo json_encode(get_user_meta($user->ID, 'xoo_aff_text_05a5i', false)); ?>;

            vin_numbers = vin_numbers.map((element, index) => {
                return '<div class="input-block" style="margin-bottom: 5px;<?php echo $parentDiv; ?>"> <input style="<?php echo $inputTxt; ?>" type="text" name="vin_number_update[]" value="'+element+'" class="form-control"><input style="<?php echo $inputbtn; ?>" type="button" class="remove-field" value="-"></div>';
            });
            jQuery(document).ready(function() {
                jQuery("#some_div").append(vin_numbers.toString().replaceAll(',', ''))

                jQuery("#add-field").click(function () {
                    jQuery("#some_div").append('<div class="input-block" style="margin-bottom: 5px;<?php echo $parentDiv; ?>"><input style="<?php echo $inputTxt; ?>" type="text" name="vin_number_add[]" class="form-control"><input style="<?php echo $inputbtn; ?>" type="button" class="remove-field" value="-"></div>');
                });
                jQuery(document).on("click", ".remove-field", function () {
                    jQuery(this).closest(".input-block").remove();
                });
                jQuery('.xoo_aff_text_05a5i_cont').parent().parent().hide()
            })
        </script>
        <?php
    }
}

add_action('wp_footer', 'add_this_vin_script_footer');

function userCarVinNumberOwnForm(){
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
}

function userCarVinNumberForm($user) {
    $user_data = get_userdata($user->ID);
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
        <script>
            var vin_numbers = <?php echo json_encode(get_user_meta($user->ID, 'xoo_aff_text_05a5i', false)); ?>;

            vin_numbers = vin_numbers.map((element, index) => {
                return '<div class="input-block" style="margin-bottom: 5px;"> <input  type="text" name="vin_number_update[]" value="'+element+'" class="form-control"><input type="button" class="remove-field" value="-"></div>';
            });
            jQuery(document).ready(function() {
                jQuery("#some_div").append(vin_numbers.toString().replaceAll(',', ''))

                jQuery("#add-field").click(function () {
                    jQuery("#some_div").append('<div class="input-block" style="margin-bottom: 5px;"><input type="text" name="vin_number_add[]" class="form-control"><input type="button" class="remove-field" value="-"></div>');
                });
                jQuery(document).on("click", ".remove-field", function () {
                    jQuery(this).closest(".input-block").remove();
                });
                jQuery('.xoo_aff_text_05a5i_cont').parent().parent().hide()
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

    $carVinNumbers = get_user_meta($userId, 'xoo_aff_text_05a5i', false);
    if ($_POST['vin_number_update'] != NULL){
        $differences = array_diff($carVinNumbers, $_POST['vin_number_update']);
        foreach ($differences as $difference){
            delete_user_meta($userId,'xoo_aff_text_05a5i',$difference, false);
        }

        $differences = array_diff($_POST['vin_number_update'], $carVinNumbers);
        foreach ($differences as $difference){
            add_user_meta($userId,'xoo_aff_text_05a5i',$difference, false);
        }
    } else {
		foreach ($carVinNumbers as $carVinNumber){
            delete_user_meta($userId,'xoo_aff_text_05a5i',$carVinNumber, false);
        }
	}
	
	if ($_POST['vin_number_add'] != NULL){
		$differences = array_diff($_POST['vin_number_add'], $carVinNumbers);
		foreach ($differences as $vin_number){
			add_user_meta($userId,'xoo_aff_text_05a5i',$vin_number, false);
		}
	}
}
add_action('personal_options_update', 'userCarVinNumberSave');
add_action('edit_user_profile_update', 'userCarVinNumberSave');
add_action('user_register', 'userCarVinNumberSave');
add_action('woocommerce_update_customer', 'userCarVinNumberSave');

