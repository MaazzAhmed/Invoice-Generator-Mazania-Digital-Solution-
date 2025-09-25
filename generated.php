<?php
ob_start(); // Start output buffering
require_once('vendor/tecnickcom/tcpdf/tcpdf.php');

// Database Connection

$host = 'localhost';

$dbname = 'invoice_system';

$username = 'root';

$password = '';

$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";

session_start();


// Add Validation Here

if (empty(trim($_POST['clientName'])) || empty(trim($_POST['clientEmail']))) {

    $_SESSION['invoice_creation_status'] = 'error';

    $_SESSION['invoice_creation_message'] = 'Client Name and Email cannot be empty.';

    header("Location: create_invoice"); // Replace with your form page name

    exit; // Stop further execution

}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Check if a file is uploaded

    if (isset($_FILES['logoUpload']) && $_FILES['logoUpload']['error'] == 0) {

        $uploadDir = __DIR__ . '/logo/';

        $uploadedFile = $_FILES['logoUpload'];

        $targetFile = $uploadDir . basename($uploadedFile['name']);



        // Check if the file is an image

        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        if (in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {

            // Move uploaded file to the target directory

            if (move_uploaded_file($uploadedFile['tmp_name'], $targetFile)) {

                // Image uploaded successfully, save it in the database

                $logoPath = 'logo/' . basename($uploadedFile['name']); // Save the path for later use

            } else {

                $_SESSION['logo_upload_status'] = 'error';

                $_SESSION['logo_upload_message'] = 'Failed to upload logo.';
            }
        } else {

            $_SESSION['logo_upload_status'] = 'error';

            $_SESSION['logo_upload_message'] = 'Invalid file type. Only JPG, PNG, JPEG, GIF files are allowed.';
        }
    } else {

        $_SESSION['logo_upload_status'] = 'error';

        $_SESSION['logo_upload_message'] = 'No logo file uploaded.';
    }
}

// Check if watermark image is uploaded

if (isset($_FILES['watermarkUpload']) && $_FILES['watermarkUpload']['error'] == 0) {

    $watermarkUploadDir = __DIR__ . '/logo/';

    $watermarkFile = $_FILES['watermarkUpload'];

    $watermarkTargetFile = $watermarkUploadDir . basename($watermarkFile['name']);



    // Check if the file is an image

    $watermarkImageFileType = strtolower(pathinfo($watermarkTargetFile, PATHINFO_EXTENSION));

    if (in_array($watermarkImageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {

        // Move uploaded file to the target directory

        if (move_uploaded_file($watermarkFile['tmp_name'], $watermarkTargetFile)) {

            $watermarkPath = 'logo/' . basename($watermarkFile['name']); // Save the path for later use

        } else {

            $_SESSION['watermark_upload_status'] = 'error';

            $_SESSION['watermark_upload_message'] = 'Failed to upload watermark image.';
        }
    } else {

        $_SESSION['watermark_upload_status'] = 'error';

        $_SESSION['watermark_upload_message'] = 'Invalid watermark file type. Only JPG, PNG, JPEG, GIF files are allowed.';
    }
} else {

    $watermarkPath = ''; // No watermark image uploaded

}







// Create new PDF instance

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);



// Disable the default header and footer

$pdf->setPrintHeader(false);

$pdf->setPrintFooter(false);



// PDF Document settings

$pdf->SetCreator(PDF_CREATOR);

$pdf->SetAuthor('Your Name');

$pdf->SetTitle('Invoice');

$pdf->SetSubject('Invoice Details');

$pdf->SetMargins(10, 10, 10);

$pdf->SetHeaderMargin(5);

$pdf->SetFooterMargin(5);

function wrapText($pdf, $text, $cellWidth)
{

    $lines = [];

    $currentLine = "";

    $words = explode(" ", $text);



    foreach ($words as $word) {

        $lineWidth = $pdf->GetStringWidth($currentLine . " " . $word);



        if ($lineWidth > $cellWidth) {

            // Start a new line

            $lines[] = $currentLine;

            $currentLine = $word;
        } else {

            // Add to the current line

            $currentLine .= ($currentLine === "" ? "" : " ") . $word;
        }
    }



    if (!empty($currentLine)) {

        $lines[] = $currentLine;
    }



    return $lines;
}

// Add a page

$pdf->AddPage();

// Add invoice label in place of the logo

$pageWidth = $pdf->GetPageWidth();

$labelWidth = 50; // Width for the invoice label

$labelX = 10; // New position for invoice label at the top-left

$labelY = 10; // Position for the label

$pdf->SetFont('helvetica', 'B', 14);

$pdf->SetXY($labelX, $labelY);

$pdf->Cell($labelWidth, 10, $_POST['inovoice-label'], 0, 0, 'L'); // Left-align

// Adjust Y-position for the logo after the label

$pdf->SetY(30);



// // Add watermark if the image exists

// if (!empty($watermarkPath) && file_exists($watermarkPath)) {

//     // Set transparency for watermark

//     $pdf->SetAlpha(0.3);

//     // Add the watermark image at the center of the page

//     $pdf->Image($watermarkPath, 50, 100, 100, '', 'PNG', '', 'C', false, 300, '', false, false, 1, false, false, false);

//     $pdf->SetAlpha(1); // Reset transparency

// }


// 
// Default watermark path
$defaultWatermark = __DIR__ . '/logo/watermark.png'; 

// Check if user-provided watermark exists; otherwise, use default
$watermarkFile = (!empty($watermarkPath) && file_exists($watermarkPath)) ? $watermarkPath : $defaultWatermark;

if (!file_exists($watermarkFile)) {
    die('Watermark file not found: ' . $watermarkFile);
}

// Set transparency for watermark
$pdf->SetAlpha(0.3);

// Add the watermark image at the center of the page
$pdf->Image($watermarkFile, 50, 100, 100, '', 'PNG', '', 'C', false, 300, '', false, false, 1, false, false, false);

$pdf->SetAlpha(1); // Reset transparency

// 




// Adjust Y-position after the image

$pdf->SetY(30); // Adjust Y-position to reduce space after the logo



// HTML Content

$lineItemsHtml = '';

$subtotal = 0;



$items = $_POST['item-des'] ?? [];

$quantities = $_POST['quantity'] ?? [];

$rates = $_POST['rate'] ?? [];

$currency = $_POST['currency'] ?? '';

$tax = $_POST['tax'] ?? 0;

$discount = $_POST['discount'] ?? 0;

$balance = $_POST['balance_due'] ?? 0;

$amountpaid = $_POST['amountpaid'] ?? 0;



if (is_array($items)) {

    foreach ($items as $index => $description) {

        $quantity = $quantities[$index] ?? 0;

        $rate = $rates[$index] ?? 0;

        $total = $quantity * $rate;

        $rowColor = ($index % 2 === 0) ? 'background-color: #f2f2f2;' : 'background-color: #ffffff;';

        $lineItemsHtml .= "

            <tr style='$rowColor'>

                <td style='border: 1px solid #ccc; padding: 8px;'>$description</td>

                <td style='border: 1px solid #ccc; padding: 8px;'>$quantity</td>

                <td style='border: 1px solid #ccc; padding: 8px;'>$currency $rate</td>

                <td style='border: 1px solid #ccc; padding: 8px;'>$currency $total</td>

            </tr>";

        $subtotal += $total;
    }
}



$total = $subtotal + $tax - $amountpaid;

// Add invoice label in place of the logo

// Logo placement

$imageFile = !empty($logoPath) && file_exists($logoPath)

    ? $logoPath

    : __DIR__ . '/logo/weblogo.png'; // Default fallback



if (!file_exists($imageFile)) {

    die('Logo file not found: ' . $imageFile);
}



    // Add the logo image

    $pdf->Image($imageFile, $pageWidth - 50 - 10, 10, 40, '', 'PNG', '', 'T', false, 300, '', false, false, 1, false, false, false);



    // Adjust Y-position after the logo

    $pdf->SetY(30); // Ensure content starts below the logo





    // Add invoice details in table-like format

    $pdf->SetFont('helvetica', 'b', 12);

    // Invoice Info

    $pdf->Cell(40, 10, 'Invoice No:', 0, 0);
    $pdf->Cell(40, 10, $_POST['invoice-number'], 0, 1);
    // From and Bill To
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(40, 10, 'From:', 0, 0);
    $pdf->SetFont('helvetica', '', 12);
    // $pdf->Cell(40, 10, $_POST['Invoice_From'], 0, 0);
    $pdf->MultiCell(60, 10, $_POST['Invoice_From'], 0, 'L', false, 0);

    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(30, 10, 'Bill To:', 0, 0);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(40, 10, $_POST['Bill_To'], 0, 1);
    $pdf->SetFont('helvetica', '', 12);
    $paymentTermsLabel = trim($_POST['paymentterms-label']) . ': '; // Ensure no extra spaces
    $pdf->Cell(40, 10, $paymentTermsLabel, 0, 0);
    $pdf->Cell(40, 10, $_POST['payment-terms'], 0, 1);
    $pdf->Cell(40, 10, $_POST['ponumber-label'] . ':', 0, 0);
    $pdf->Cell(40, 10, $_POST['po-number'], 0, 0);

    // Add vertical space whether URL exists or not
$spaceAfterPO = 10; // default gap after PO block

    if (!empty($_POST['url'])) {
        $url = filter_var($_POST['url'], FILTER_VALIDATE_URL);
        if ($url) {
            $pdf->SetTextColor(0, 0, 255); // Set text color to blue for the URL
            $x = $pdf->GetPageWidth() - 60; // X position

            $y = $pdf->GetY(); // Current Y position

            $width = 50; // Width of the rectangle

            $height = 10; // Height of the rectangle

            $radius = 2; // Radius for rounded corners



            // Set fill color for the background

            $pdf->SetFillColor(0, 1, 21); // Light blue

            $pdf->SetDrawColor(255, 255, 255); // Border color



            // Draw the rounded rectangle

            $pdf->RoundedRect($x, $y, $width, $height, $radius, '1111', 'DF');



            // Add the "Pay Now" text

            $pdf->SetXY($x, $y); // Reset position for text

            $pdf->SetTextColor(252, 253, 255); // Set text color for the button text

            $pdf->Cell($width, $height, 'Pay Now', 0, 1, 'C', false, $url);



            $pdf->SetTextColor(0, 0, 0); // Reset text color to black for subsequent content



            // Add image below the button with URL

            $imagePath = 'logo/pngwing.png'; // Replace with your image path

            if (file_exists($imagePath)) {

                $imageX = $pdf->GetPageWidth() - 60; // Align with button

                $imageY = $y + $height + 5; // Position below button (5 units gap)

                $imageWidth = 50; // Adjust width

                $imageHeight = 20; // Adjust height



                // Create a clickable area with the URL and embed the image

                $pdf->SetXY($imageX, $imageY); // Set position for image

                $pdf->Cell($imageWidth, $imageHeight, '', 0, 0, 'C', false, $url); // Hyperlink area

                $pdf->Image($imagePath, $imageX, $imageY, $imageWidth, $imageHeight, '', $url); // Add the image with URL
            // $spaceAfterPO = ($imageY + $imageHeight) - $y; // adjust based on image

            }
        }
    }

    $pdf->SetY($pdf->GetY() + $spaceAfterPO);
    // $pdf->Ln(5);






    $dateFormatted = date('d-M-Y', strtotime($_POST['date']));

    $dueDateFormatted = date('d-M-Y', strtotime($_POST['duedate']));





    // Display the formatted dates

    $pdf->Cell(40, 10, $_POST['date-label'] . ':', 0, 0);

    $pdf->Cell(40, 10, $dateFormatted, 0, 1);



    $pdf->Cell(40, 10, $_POST['due-date-label'] . ':', 0, 0);

    $pdf->Cell(40, 10, $dueDateFormatted, 0, 1);





    $pdf->Ln(5); // Add a line break



// $pdf->Ln(10); // Add a line break



// Set the line width for thinner borders

$pdf->SetLineWidth(0.1); // Adjust the thickness of the table borders



// Set a lighter border color (light gray)

$pdf->SetDrawColor(100, 100, 100); // RGB values for light gray color



// Line Items Table Header (Bottom border only)

$pdf->SetFont('helvetica', 'B', 12);

$pdf->Cell(100, 10, $_POST['itemlabel'], 'B', 0, 'L'); // Bottom border only

$pdf->Cell(25, 10, $_POST['quantitylabel'], 'B', 0, 'C'); // Bottom border only

$pdf->Cell(25, 10, $_POST['ratelabel'], 'B', 0, 'C'); // Bottom border only

$pdf->Cell(40, 10, $_POST['amountlabel'], 'B', 1, 'C'); // Bottom border only



$pdf->SetFont('helvetica', '', 12);

$pdf->Ln(5); // Add vertical space here



$subtotal = 0;

if (is_array($items)) {

    foreach ($items as $index => $description) {

        $quantity = $quantities[$index] ?? 0;

        $rate = $rates[$index] ?? 0;

        $total = $quantity * $rate;

        $subtotal += $total;



        // Wrap text manually for the description column

        $descriptionLines = wrapText($pdf, $description, 100); // Wrap description within 100 width

        $lineHeight = 10; // Row height

        $numberOfLines = count($descriptionLines);



        // Calculate row height based on the tallest column

        $rowHeight = max($lineHeight * $numberOfLines, $lineHeight);



        // Save current position

        $x = $pdf->GetX();

        $y = $pdf->GetY();



        // Draw description column

        $pdf->MultiCell(100, $lineHeight, implode("\n", $descriptionLines), 0, 'L', false);



        // Move to the next columns

        $pdf->SetXY($x + 100, $y);



        // Align other columns with the height of the tallest column

        $pdf->Cell(25, $rowHeight, $quantity, 0, 0, 'C'); // Quantity column

        $pdf->Cell(25, $rowHeight, "$currency $rate", 0, 0, 'C'); // Rate column

        $pdf->Cell(40, $rowHeight, "$currency $total", 0, 1, 'C'); // Amount column



        // Move Y position for the next row

        $pdf->SetY($y + $rowHeight);
    }
}









// Subtotal and Other Details

$pdf->Ln(5); // Add a line break

$pdf->SetFont('helvetica', 'B', 12);

$pdf->Cell(140, 10, 'Sub Total:', 0, 0, 'R');

$pdf->Cell(50, 10, "$currency $subtotal.00", 0, 1, 'R');



if ($tax > 0) {

    $pdf->Cell(140, 10, $_POST['taxlabel'] . ':', 0, 0, 'R');

    $pdf->Cell(50, 10, "$currency $tax.00", 0, 1, 'R');
}





if ($discount > 0) {

    $pdf->Cell(140, 10, 'Discount:', 0, 0, 'R');

    $pdf->Cell(50, 10, "$currency $discount.00", 0, 1, 'R');
}



$total = $subtotal + $tax - $discount;

$pdf->Cell(140, 10, 'Total:', 0, 0, 'R');

$pdf->Cell(50, 10, "$currency $total.00", 0, 1, 'R');


if ($amountpaid > 0) {

    $pdf->Cell(140, 10, $_POST['amountpaidlabel'] . ':', 0, 0, 'R');

    $pdf->Cell(50, 10, "$currency $amountpaid.00", 0, 1, 'R');
}


// $balance = $total - $amountpaid;
if($balance > 0 ){

    
    $pdf->Cell(140, 10, $_POST['balanceduelabel'], 0, 0, 'R');
    
    $pdf->Cell(50, 10, "$currency $balance", 0, 1, 'R');
}







// Notes and Terms Section

$pdf->Ln(10); // Add a line break

$pdf->SetFont('helvetica', 'B', 12);

$pdf->Cell(95, 10, $_POST['notes-label'] . ':', 0, 0);

$pdf->Cell(95, 10, $_POST['terms-label'] . ':', 0, 1);



$pdf->SetFont('helvetica', '', 12);

$pdf->MultiCell(95, 10, $_POST['notes'], 0, 'L', false, 0);

$pdf->MultiCell(95, 10, $_POST['terms'], 0, 'L', false, 1);



$pdf->Ln(10); // Add a line break



// Add a line break before footer

$pdf->Ln(5);



// Footer Section

$pdf->SetY($pdf->getPageHeight() - 40);  // 20mm from the bottom of the page

$pdf->SetFont('helvetica', 'I', 8);

$pdf->Cell(0, 10, $_POST['footer'], 0, 0, 'C');





// Save PDF and store in database

$uploadDir = __DIR__ . '/uploads/';

if (!is_dir($uploadDir)) {

    mkdir($uploadDir, 0777, true);
}

$currentDate = date('Y-m-d');



$pdfFileName = $_POST['clientName'] . '_' . $currentDate . '.pdf';

$pdfFilePath = $uploadDir . $pdfFileName;



try {

    $pdf->Output($pdfFilePath, 'F');



    $sql = "INSERT INTO invoices (client_name, client_email, pdf_path, created_at) 

            VALUES (:client_name, :client_email, :pdf_path, NOW())";

    $stmt = $conn->prepare($sql);

    $stmt->execute([

        ':client_name' => htmlspecialchars($_POST['clientName']),

        ':client_email' => htmlspecialchars($_POST['clientEmail']),

        ':pdf_path' => 'uploads/' . $pdfFileName,

    ]);



    $_SESSION['invoice_creation_status'] = 'success';

    $_SESSION['invoice_creation_message'] = 'Invoice Created Successfully';

    header("Location: view_invoice"); // Redirect to the view_invoice page
    exit; // Make sure no code is executed after the redirection

} catch (Exception $e) {

    $_SESSION['invoice_creation_status'] = 'error';

    $_SESSION['invoice_creation_message'] = $e->getMessage();
}

// header("Location: view_invoice");

exit;

ob_end_flush(); // Flush the output buffer
?>
