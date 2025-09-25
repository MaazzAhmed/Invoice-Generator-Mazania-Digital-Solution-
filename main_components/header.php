<?php require_once("global.php"); 
if (!isset($_SESSION['user'])) {
    header('Location: login');  
    exit;   
}
// ob_end_flush(); // Flush the output buffer
?>

<!DOCTYPE html>

<html lang="zxx" class="js">



<meta http-equiv="content-type" content="text/html;charset=UTF-8" />



<head>

    <meta charset="utf-8">

    <meta name="author" content="Softnio">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description"

        content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">

    <link rel="shortcut icon" href="images/favicon.png">

    <title>Invoice Generator | Powered By Mazania</title>

    <link rel="stylesheet" href="assets/css/dashlite324d.css?ver=3.1.0">

    <link id="skin-default" rel="stylesheet" href="assets/css/theme324d.css?ver=3.1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.5.0/css/fontawesome.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



    <link href="./assets/select2/css/select2.min.css" rel="stylesheet" />

    <link href="./assets/notify/css/alertify.min.css" rel="stylesheet" />

    <script src="./assets/notify/alertify.min.js"></script>



    <script src="./assets/select2/js/select2.min.js"></script>

    <script src="./assets/js/script.js"> </script>

    <script>

        // Email Textfield Restriction

        document.addEventListener('DOMContentLoaded', function () {

            const emailInput = document.getElementById('email');



            emailInput.addEventListener('input', function () {

                const inputValue = this.value.trim(); // Trim leading and trailing spaces



                // Regular expression to match valid email format (without spaces and commas)

                const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;



                // Check if the input value matches the email format and does not contain spaces or commas

                if (!emailRegex.test(inputValue)) {

                    // Remove any invalid characters (spaces and commas)

                    const sanitizedValue = inputValue.replace(/[ ,]/g, '');

                    this.value = sanitizedValue;

                }

            });

        });



        // Email Textfield Restriction

        document.addEventListener('DOMContentLoaded', function () {

            const emailInput = document.getElementById('email');

            const errorMsg = document.getElementById('error-msg');



            emailInput.addEventListener('input', function () {

                const inputValue = this.value.trim(); // Trim leading and trailing spaces



                // Regular expression to match valid email format (without spaces and commas)

                const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;



                // Check if the input value matches the email format

                if (!emailRegex.test(inputValue)) {

                    errorMsg.textContent = 'Invalid email format. Email must contain @gmail.com or @outlook.com.';

                } else {

                    // Check if the email contains the specified domains

                    if (

                        inputValue.includes('@gmail.com') ||

                        inputValue.includes('@outlook.com')

                    ) {

                        errorMsg.textContent = ''; // Reset error message

                    } else {

                        errorMsg.textContent = 'Invalid email format. Email must contain @gmail.com or @outlook.com';

                    }

                }

            });

        });

    </script>







</head>


