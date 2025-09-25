<?php
ob_start(); // Start output buffering
session_start();
require_once("configuration.php");

// Create a database connection

$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);



// Check the connection

if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);

}


// User Adding Code

if (isset($_POST["add_user"])) {
    // Get form data
    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    // $role = $_POST["roles"];
    date_default_timezone_set('Asia/Karachi');
    $account_created_date = date('d-M-Y h:i: A');
    // Check if the user with the entered email already exists
    $stmt_check = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $stmt_check->bind_result($userCount);
        $stmt_check->fetch();
        $stmt_check->close();

    if ($userCount > 0) {

        // User already exists, show an alert

        echo '<script>alert("User with this email already exists.");</script>';

        echo '<script>window.location.href = "../view-user"</script>';

    } else {
        // User doesn't exist, insert the new record with password hashing
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password
        $stmt_insert = $conn->prepare("INSERT INTO users (`full_name`, `email`, `password`, `user_created_date`) VALUES (?, ?, ?, ?)");
        $stmt_insert->bind_param("ssss", $full_name, $email, $hashedPassword, $account_created_date);
        if ($stmt_insert->execute()) {

            echo '<script>window.location.href = "../view-user"</script>';
        } else {

            echo "Error: " . $stmt_insert->error;
        }
        $stmt_insert->close();
    }
}

?>







<!-- User Editing Code -->



<?php

// Handle form submission to update employee data

if (isset($_POST['update_user'])) {

    $id = $_POST['user_id'];

    $username = $_POST['full_name'];

    $email = $_POST['email'];

    $password = $_POST['password'];

    $roles = $_POST['roles'];





    // Prepare and execute a query to check if the updated email already exists

    $checkQuery = "SELECT COUNT(*) AS count FROM users WHERE email = ? AND id <> ?";

    $stmtCheck = $conn->prepare($checkQuery);

    $stmtCheck->bind_param("si", $email, $id);

    $stmtCheck->execute();

    $resultCheck = $stmtCheck->get_result();

    $rowCheck = $resultCheck->fetch_assoc();



    if ($rowCheck['count'] > 0) {

        // Email already exists in the database for a different employee

        echo $error = "<script>alert('User With Email $email is Already Exists in Our System Record.')</script>";

        echo "<script>window.location.href = '../view-user';</script>";

    } else {

        // Prepare and execute the SQL query to update the employee

        $sqlUpdate = "UPDATE users SET full_name = ?, email = ?  WHERE id = ?";

        $stmtUpdate = $conn->prepare($sqlUpdate);

        $stmtUpdate->bind_param("ssi", $username, $email, $id);



        if ($stmtUpdate->execute()) {

            // Employee updated successfully

            header('Location: ../view-user'); // Redirect to the list of employees

            exit;

        } else {

            echo $error = "Error updating Website: " . $conn->error;

        }



        $stmtUpdate->close();

    }



    $stmtCheck->close();

}





if(isset($_POST['update_client'])){

    $clientEmail = $_POST['clientemail'];

    $clientName = $_POST['clientname'];

    $email = $_POST['email'];



    $query = "Update invoices set client_name = ?, client_email = ? where client_email = ?";



    $stmt = $conn->prepare($query);

    if($stmt){

        $stmt->bind_param("sss", $clientName, $email, $clientEmail);

    

        if ($stmt->execute()) {

            $_SESSION['success'] = "Client updated successfully!"; // Store success message

            header('Location: ../view-clients');

            exit();

        } else {

            $_SESSION['error'] = "Error updating client: " . $stmt->error; // Store error message

            header('Location: ../view-clients');

            exit();

        }



        $stmt->close();

    } else {

        $_SESSION['error'] = "Error preparing query: " . $conn->error; // Store error message

        header('Location: ../view-clients');

        exit();

    }





}



if (isset($_POST['delete_client'])) {



    $access_token_own = "123";

    $access_token = $_POST['access_token'];

    $clientemail = $_POST['clientemail'];



    if ($access_token === $access_token_own) {

        // Prepare and execute the SQL query to delete the client

        $sql = "DELETE FROM invoices WHERE client_email = ?";

        $stmt = $conn->prepare($sql);



        if ($stmt) {

            $stmt->bind_param("s", $clientemail); // Use "s" for string type



            if ($stmt->execute()) {

                $success = "Client deleted successfully!"; // Store success message

            } else {

                $error = "Error deleting client: " . $stmt->error; // Store error message

            }



            $stmt->close();

        } else {

            $error = "Error preparing query: " . $conn->error; // Store error message

        }

    } else {

        $error = "Invalid access token!"; // Store error message

    }



}

if (isset($_POST['update_email_settings'])) {
    $host = $_POST['host'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $port = $_POST['port'];
    $subject = $_POST['subject'];
    $body = $_POST['body'];

    $sql = "SELECT id FROM email_setting LIMIT 1";
    $result = $conn->query($sql);


    if($result->num_rows > 0){
        $updateSQL = "UPDATE email_setting SET host = ?, username = ?, password = ?, port = ?, subject = ?, body = ? WHERE id = 1";
        $stmt = $conn->prepare($updateSQL);
        $stmt->bind_param("ssssss", $host, $username, $password, $port, $subject, $body);
    }
    else{
        $insertSQL = "INSERT INTO email_setting (host, username, password, port, subject, body) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertSQL);
        $stmt->bind_param("ssssss", $host, $username, $password, $port, $subject, $body);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Email settings updated successfully!'); window.location.href='email_settings';</script>";
    } else {
        echo "<script>alert('Error updating email settings.'); window.location.href='email_settings';</script>";
    }
    



} 





if (isset($_POST['login'])) {

    // Get user input
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare the SQL query to retrieve user data
    $sql = "SELECT `id`, `full_name`, `email`, `roles`, `password` FROM `users` WHERE `email` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    // Bind the result variables
    $stmt->bind_result($id, $full_name, $email, $roles, $storedPassword); // Include $storedPassword here

    if ($stmt->fetch()) { // Fetch values
        if (password_verify($password, $storedPassword)) {
            // Authentication successful
            $_SESSION['id'] = $id;
            $_SESSION['user'] = $full_name;
            $_SESSION['email'] = $email;
            $_SESSION['roles'] = $roles;
            header("Location: index");
            exit;
        } else {
            $error = 'Incorrect password';
        }
    } else {
        $error = 'User not found';
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}

if (isset($_POST['logout_user'])) {
    session_destroy();
    header("Location: login");
    exit;
}