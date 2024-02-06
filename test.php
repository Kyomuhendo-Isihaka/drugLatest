<?php
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();
$report = "  <div class='container p-4'>
<h3 class='text-center text-success'>Drug Management System</h3>
<h5  class='text-center'>Comparative Analysis of Available Drugs: Good, Warning, and Expired</h5>
<h6><b>1. Good Drugs:</b></h6>
<p><b>• Percentage: 70%</b><br>-High efficacy, safety, and reliability.<br>
    -Adherence to GMP standards, accurate labeling, and proper storage
</p>
<h6><b>2. Drugs with Warning Signs:</b></h6>
<p><b>• Percentage: 20%</b><br>
    - Early identification of potential issues.<br>
    - Unusual odor, appearance, packaging inconsistencies, or batch recalls.
</p>
<h6><b>3. Good Drugs:</b></h6>
<p><b>• Percentage: 20%</b><br>
    - Early identification of potential issues.<br>
    - Unusual odor, appearance, packaging inconsistencies, or batch recalls.
</p>

</div>";

$dompdf->loadHtml($report);

$dompdf->setPaper('A4', 'landscape');

$dompdf->render();

// Specify the folder path
$folderPath = __DIR__ . '/reports/';

// Specify the filename using the $report_name variable and append a timestamp
$report_name = "my_rep";
$timestamp = time();
$pdfFilename = $report_name . '_' . $timestamp . '.pdf';
$pdfFilePath = $folderPath . $pdfFilename;

// Save the PDF file
file_put_contents($pdfFilePath, $dompdf->output());

echo "PDF saved at: $pdfFilePath";
echo "PDF filename: $pdfFilename";

?>