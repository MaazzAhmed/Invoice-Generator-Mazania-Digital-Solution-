<!DOCTYPE html>
<html lang="en">


<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
	<!-- loader-->
	<!-- <link href="assets/css/pace.min.css" rel="stylesheet" />
	<script src="assets/js/pace.min.js"></script> -->
	<!-- Bootstrap CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
	<link href="assets/css/app.css" rel="stylesheet">
	<link href="assets/css/icons.css" rel="stylesheet">
	<title>Reset Password | Admin Panel | Graderz.org</title>
</head>

<body class="bg-theme bg-theme2" id="theme2">
	<!-- wrapper -->
	<div class="wrapper">
		<div class="authentication-forgot d-flex align-items-center justify-content-center">
			<div class="card forgot-box col-md-4">
				<div class="card-body">
					<div class="p-4 rounded  border">
						<div class="text-center">
							<img alt='image' loading="lazy" src="assets/images/icons/forgot-2.png" width="120" alt="" />
						</div>
						<h4 class="mt-5 font-weight-bold">Forgot Password?</h4>


						<!-- PHP CODE -->
						<?php
						require_once("../main_components/global.php");

						require_once('../PHPMailer/Exception.php');
						require_once('../PHPMailer/PHPMailer.php');
						require_once('../PHPMailer/SMTP.php');
						use PHPMailer\PHPMailer\PHPMailer;

						$error = '';
						$addKey ='';

						if (isset($_POST["email"]) && (!empty($_POST["email"]))) {
							$email = $_POST["email"];
							$email = filter_var($email, FILTER_SANITIZE_EMAIL);
							$email = filter_var($email, FILTER_VALIDATE_EMAIL);
							if (!$email) {
								$error .= "<p>Invalid email address please type a valid email address!</p>";
							} else {
								$sel_query = "SELECT * FROM `clients` WHERE email='" . $email . "'";
								$results = mysqli_query($conn, $sel_query);
								$row = mysqli_num_rows($results);
								if ($row == "") {
									$error .= "<p>No user is registered with this email address!</p>";
								}
							}
							if ($error != "") {
								echo "<div class='error'>" . $error . "</div>
<br /><a class='btn btn-warning' href='javascript:history.go(-1)'>Go Back</a>";
							} else {
								$expFormat = mktime(date("H"), date("i"), date("s"), date("m"), date("d") + 1, date("Y"));
								$expDate = date("Y-m-d H:i:s", $expFormat);
								$key = md5(2418 * 2 . $email . $addKey);

								$addKey = substr(md5(uniqid(rand(), 1)), 3, 10);
								$key = $key . (string)$addKey;
								
								// Insert Temp Table
								mysqli_query(
									$conn,
									"INSERT INTO `password_reset_temp` (`email`, `key`, `expDate`)
VALUES ('" . $email . "', '" . $key . "', '" . $expDate . "');"
								);

								$output = '<p>Dear user,</p>';
								$output .= '<p>Please click on the following link to reset your password.</p>';
								$output .= '<p>-------------------------------------------------------------</p>';
								$output .= '<p><a href="Invoice-Product/fpass/authentication_user_pass.php?key=' . $key . '&email=' . $email . '&action=reset" target="_blank">Invoice-Product/fpass/authentication_user_pass.php?key=' . $key . '&email=' . $email . '&action=reset</a></p>';
								$output .= '<p>-------------------------------------------------------------</p>';
								$output .= '<p>Please be sure to copy the entire link into your browser.
The link will expire after 1 day for security reason.</p>';
								$output .= '<p>If you did not request this forgotten password email, no action 
is needed, your password will not be reset. However, you may want to log into 
your account and change your security password as someone may have guessed it.</p>';
								$output .= '<p>Thanks,</p>';
								$output .= '<p>Graderz.Org</p>';
								$body = $output;
								$subject = "Password Recovery Email - Graderz.org";

								$email_to = $email;
								$fromserver = "info@graderz.org";
								$mail = new PHPMailer();
								$mail->isSMTP();
								$mail->Host = "mail.graderz.org";
								$mail->SMTPAuth = true;
								$mail->Username = 'info@graderz.org';
								$mail->Password = 'info@graderz.org123';
								$mail->Port = 587;
								$mail->IsHTML(true);
								$mail->From = "support@graderz.org";
								$mail->FromName = "Graderz.org";
								$mail->Sender = $fromserver; // indicates ReturnPath header
								$mail->Subject = $subject;
								$mail->Body = $body;
								$mail->AddAddress($email_to);
								// $mail->SMTPDebug = 2; // 2 for basic debugging, 3 for more detailed debugging
								
$mail->SMTPSecure = false;
$mail->SMTPAutoTLS = false; 

								if (!$mail->Send()) {
									echo "Mailer Error: " . $mail->ErrorInfo;
								} else {
									echo "<div class='error'>
<p>An email has been sent to you with instructions on how to reset your password.</p>
</div><br /><br /><br />";
									echo "<a href='../client_login' class='btn btn-warning'>Go Back To Login</a>";
								}

							}

						} else {

							?>

							<form method="post" action="" name="reset">
								<div class="my-4">
									<label class="form-label">Email Address</label>
									<input type="text" class="form-control form-control-lg" placeholder="example@user.com"
										name="email" />
								</div>
								<div class="d-grid gap-2">
									<button type="submit" class="btn btn-light btn-lg">Send</button> <a
										href="../client_login" class="btn btn-light btn-lg"><i
											class='bx bx-arrow-back me-1'></i>Back to Login</a>
								</div>
							</form>
						<?php } ?>


					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end wrapper -->
	<!--start switcher-->

	<!--end switcher-->


	<!--plugins-->
	<script src="assets/js/jquery.min.js"></script>

	<!-- Email Sending Code -->



</body>



</html>