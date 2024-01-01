<?php
require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php'; // Load Composer autoload

use Dompdf\Dompdf;
use Dompdf\Options;

// Function to generate PDF and send email
function generate_pdf_and_send_email() {

    // Get the HTML data from the AJAX request
    $htmlData = isset($_POST['htmlData']) ? $_POST['htmlData'] : '';

    // Create a Dompdf instance
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isPhpEnabled', true);
    $dompdf = new Dompdf($options);

    // Load HTML into Dompdf
    $dompdf->loadHtml($htmlData);

    // Set paper size (optional)
    $dompdf->setPaper('A4', 'portrait');

    // Render PDF
    $dompdf->render();

    // Output buffer
    $canvas = $dompdf->getCanvas();
    $numPages = count($canvas->get_page_count());

    // Clear existing output buffer
    ob_clean();

    // Render PDF again and save it to a file
    $dompdf->render();
    // Save the PDF to a file
    $pdfFilePath = plugin_dir_path(__FILE__) . '/report.pdf';
    file_put_contents($pdfFilePath, $dompdf->output());

    // Always exit to avoid extra output
    exit();
}

// Hook this function to an action or call it when needed
// For example, you can use the 'admin_init' action hook to trigger the PDF generation and email sending when an admin user logs in.
add_action('wp_ajax_generate_pdf_and_send_email', 'generate_pdf_and_send_email');