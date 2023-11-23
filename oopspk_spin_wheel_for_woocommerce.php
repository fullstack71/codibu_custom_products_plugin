<?php
/*
Plugin Name: Codibu Custom Products Plugin
Plugin URI: https://codibu.com/
Description: Codibu Custom Products Plugin.
Author URI: https://codibu.com/
Version: 1.0.0
License: GPL v2 or later
Stable tag: 1.0.0
*/
defined('ABSPATH') || die ("You can't access this file directyly !");
define("spin_wheel_dir", __DIR__);

require(spin_wheel_dir."/load_pages.php");


register_activation_hook(__FILE__,'oopspk_woocommerce_modify_pro_management_activation_hook');
register_deactivation_hook(__FILE__,'oopspk_woocommerce_modify_pro_management_deactivation_hook');
register_uninstall_hook(__FILE__,'oopspk_woocommerce_modify_pro_management_uninstall_hook');

function oopspk_woocommerce_modify_pro_management_activation_hook(){}
function oopspk_woocommerce_modify_pro_management_deactivation_hook(){}
function oopspk_woocommerce_modify_pro_management_uninstall_hook(){}
?>