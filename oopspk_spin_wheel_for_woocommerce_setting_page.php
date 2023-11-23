<?php
// create custom plugin settings menu
add_action('admin_menu', 'my_cool_plugin_create_menu');

function my_cool_plugin_create_menu() {

  //create new top-level menu
  add_menu_page('My Cool Plugin Settings', 'CAR VIN', 'administrator', __FILE__, 'my_cool_plugin_settings_page' , "" );

  //call register settings function
  add_action( 'admin_init', 'register_my_cool_plugin_settings' );
}

function register_my_cool_plugin_settings() {
  //register our settings
  register_setting( 'my-cool-plugin-settings-group', 'new_option_name' );
  register_setting( 'my-cool-plugin-settings-group', 'some_other_option' );
  register_setting( 'my-cool-plugin-settings-group', 'option_etc' );
}

function my_cool_plugin_settings_page() {
$current_user_id = get_current_user_id();
$meta_data = get_user_meta($current_user_id);
$vin_car_number = $meta_data['xoo_aff_number_nx1lj'][0];
// var_dump($meta_data['xoo_aff_number_nx1lj'][0]);
if(empty($meta_data)){

}	
else{

}
?>

<div class="wrap">
<h1>CAR VIN</h1>
<hr>

<?php } ?>