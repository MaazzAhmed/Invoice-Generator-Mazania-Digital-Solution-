<?php
// email_sender.php
require_once 'configuration.php';

use PHPMailer\PHPMailer\PHPMailer;
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

if (isset($_GET['id'])) {
    $invoiceId = $_GET['id'];
    $additionalEmail = isset($_GET['additionalEmail']) ? $_GET['additionalEmail'] : '';

    // Fetch invoice details from the database
    $sql = "SELECT client_email, pdf_path FROM invoices WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $invoiceId);
    $stmt->execute();

    // Bind result variables
    $stmt->bind_result($clientEmail, $pdfPath);

    if ($stmt->fetch()) {
        $pdfPath = "../" . $pdfPath;
    } else {
        die("No invoice found with this ID.");
    }

    $stmt->close();

    // Fetch email settings from the database
    $sql = "SELECT host, username, password, port, subject, body FROM email_setting LIMIT 1";
    $emailStmt = $conn->prepare($sql);
    $emailStmt->execute();

    // Bind result variables
    $emailStmt->bind_result($host, $username, $password, $port, $subject, $body);

    if ($emailStmt->fetch()) {
        $emailSettings = [
            'host' => $host,
            'username' => $username,
            'password' => $password,
            'port' => $port,
            'subject' => $subject,
            'body' => $body
        ];
    } else {
        die("Email settings not found.");
    }

    $emailStmt->close();

    // Initialize PHPMailer
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = $emailSettings['host'];
        $mail->SMTPAuth = true;
        $mail->Username = $emailSettings['username'];
        $mail->Password = $emailSettings['password'];
        $mail->Port = $emailSettings['port'];
        $mail->setFrom($emailSettings['username'], "Invoice");

        // Add primary recipient and optional additional recipient
        $mail->addAddress($clientEmail);
        if (!empty($additionalEmail)) {
            $mail->addAddress($additionalEmail);
        }

        // Attach the PDF
        $mail->addAttachment($pdfPath);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = $emailSettings['subject'];
        $mail->Body = nl2br($emailSettings['body']);

        // Send email
        $mail->send();
        echo "Email sent successfully!";
    } catch (Exception $e) {
        die("Error: {$mail->ErrorInfo}");
    }
} else {
    echo "Invalid request. No ID provided.";
}
?>
