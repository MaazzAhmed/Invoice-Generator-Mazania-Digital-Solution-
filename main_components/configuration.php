<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'invoice_system';

// Create a database connection
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>