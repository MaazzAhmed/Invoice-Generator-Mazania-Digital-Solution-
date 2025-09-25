<?php require_once("./main_components/header.php") ?>

<?php


// Check if the user is logged in
if (isset($_POST['delete_invoice'])) {

    $access_token_own = "123";
    $access_token = $_POST['access_token'];
    $invoice_id = $_POST['invoice_id'];

    if ($access_token === $access_token_own) {
        // Prepare and execute the SQL query to delete the employee
        $sql = "DELETE FROM generated_invoices WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $invoice_id);

        if ($stmt->execute()) {
            // Employee deleted successfully
            echo "<script>window.location.href = 'view_invoice' </script>"; // Redirect to the list of employees
            exit;
        } else {
            $error = "Error: " . $conn->error;
        }

        $stmt->close();
    }
}

?>
