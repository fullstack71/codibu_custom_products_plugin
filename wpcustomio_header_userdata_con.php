<?php
defined('ABSPATH') || die ("You can't access this file directyly !");

$current_user_id = get_current_user_id();
$meta_data = get_user_meta($current_user_id);

$user = wp_get_current_user();


$role = reset($user->roles);
if($role == "administrator"){
$vin_car_number_json ='';
//xoo_aff_number_nx1lj
//$vin_car_number_json = $meta_data['xoo_aff_number_nx1lj'][0];	
}
else{
$vin_car_number_json = $meta_data['xoo_aff_text_05a5i'][0];	
}

$ch = curl_init();

// Set cURL options for GET request
curl_setopt($ch, CURLOPT_URL, 'https://vpic.nhtsa.dot.gov/api/vehicles/decodevinextended/'.$vin_car_number_json.'*BA?format=json'); // Replace with your API endpoint
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Execute cURL request
$response = curl_exec($ch);

// Close cURL session
curl_close($ch);

// Convert JSON response to PHP array
$responseArray = json_decode($response, true);
if ($responseArray === null) {
    echo "Error decoding JSON response";
} else {
    // Now you can work with the $responseArray as a PHP array
    //var_dump($responseArray['Results']);

?>

<?php
}
?>