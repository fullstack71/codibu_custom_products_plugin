<?php
require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php'; // Load Composer autoload

use Dompdf\Dompdf;
use Dompdf\Options;

// Function to generate PDF and send email
function generate_pdf_and_send_email() {

// Specify the path to your HTML file
    $htmlFilePath = plugin_dir_path(__FILE__) . '/report.html';

// Read the contents of the HTML file into a string
    $htmlContent = file_get_contents($htmlFilePath);

// Define the block to replace
    $startMarker = '<body>';
    $endMarker = '</body>';

// Define the new code
    $newCode = '<body><div id="car_status"><header id="header" style="width: 98%; margin: 0 auto;">' .stripslashes($_POST["headerContent"]). '</header><div id="printableArea">' . stripslashes($_POST["mainContent"]) . '</div></body>';

// Create a regular expression pattern to match the block
    $pattern = '/'.preg_quote($startMarker, '/').'(.*?)'.preg_quote($endMarker, '/').'/s';

// Replace the block with the new code in the HTML content
    $htmlContent = preg_replace($pattern, $newCode, $htmlContent);

// Write the modified content back to the HTML file
    file_put_contents($htmlFilePath, $htmlContent);


    // Get the HTML data from the AJAX request
    //$htmlData = isset($_POST['htmlData']) ? $_POST['htmlData'] : '';
    $htmlData = file_get_contents(plugin_dir_path(__FILE__) . '/report.html');
    // Create a Dompdf instance
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isPhpEnabled', true);
    $dompdf = new Dompdf($options);
    // Load HTML into Dompdf
    $dompdf->loadHtml($htmlData);


    // Set paper size (optional)
    $dompdf->setPaper('Letter', 'portrait');

    // Render PDF
    $dompdf->render();

    // Output buffer
    $canvas = $dompdf->getCanvas();
    // Clear existing output buffer
    ob_clean();

    // Render PDF again and save it to a file
    $dompdf->render();
    // Save the PDF to a file
    $pdfFilePath = plugin_dir_path(__FILE__) . '/report.pdf';
    file_put_contents($pdfFilePath, $dompdf->output());

    $attachments = array(plugin_dir_path(__FILE__) . '/report.pdf');
    // Get the post author ID
    $author_id = get_post_field('post_author', $_POST["workId"]);

    // Get the user ID from an Order ID
    $user_id = get_post_meta( $_POST["workId"], '_customer_user', true );

    // Get an instance of the WC_Customer Object from the user ID
    $customer = new WC_Customer( $user_id );

    // Get account email
    $user_email   = $customer->get_email();

    //send email
    wp_mail($user_email, 'Free Oil Change' , 'Please find the attached file related to your car status. If you have any questions, please feel free to contact us. Thank you for choosing Freeoilchange.com','Free Oil Change',$attachments);

    wp_send_json($user_email);
    // Always exit to avoid extra output

    exit();
}

// Hook this function to an action or call it when needed
// For example, you can use the 'admin_init' action hook to trigger the PDF generation and email sending when an admin user logs in.
add_action('wp_ajax_generate_pdf_and_send_email', 'generate_pdf_and_send_email');