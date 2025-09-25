<!DOCTYPE html>
<html lang="en">


<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
	<!-- loader-->
	<link href="assets/css/pace.min.css" rel="stylesheet" />
	<script src="assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
	<link href="assets/css/app.css" rel="stylesheet">
	<link href="assets/css/icons.css" rel="stylesheet">
	<title>Reset Password </title>
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
						<?php
						$error = '';
						require_once("../main_components/global.php");
						if (
							isset($_GET["key"]) && isset($_GET["email"])
							&& isset($_GET["action"]) && ($_GET["action"] == "reset")
							&& !isset($_POST["action"])
						) {
							$key = $_GET["key"];
							$email = $_GET["email"];
							$curDate = date("Y-m-d H:i:s");
							$query = mysqli_query($conn, "
SELECT * FROM `password_reset_temp` WHERE `key`='" . $key . "' and `email`='" . $email . "';");
							$row = mysqli_num_rows($query);
							if ($row == "") {
								$error .= '<h2>Invalid Link</h2>
<p>The link is invalid/expired. Either you did not copy the correct link from the email, 
or you have already used the key in which case it is deactivated.</p>
<p><a href="https://Invoice-Product/fpass/authentication-forgot-password.php">Click here</a> to reset password.</p>';
							} else {
								$row = mysqli_fetch_assoc($query);
								$expDate = $row['expDate'];
								if ($expDate >= $curDate) {
						?>
									<p class="">Please Enter Your Registered Email Address For Continue To Rest Password</p>



									<br />
									<form method="post" action="" name="update">
										<div class="my-2">
											<label class="form-label">Enter New Password</label>
											<input type="hidden" name="action" value="update" />
											<input type="password" name="pass1" id="passone" class="form-control form-control-lg" />
										</div>
										<div class="my-2">
											<label class="form-label">Re-Enter New Password:</label>
											<input type="password" name="pass2" id="passtwo" class="form-control form-control-lg" />
										</div>
										<div class="d-grid gap-2">
											<input type="hidden" name="email" value="<?php echo $email; ?>" />

											<button type="submit" id="reset" class="btn btn-light btn-lg">Send</button>
											<a href="authentication-signin" class="btn btn-light btn-lg"><i class='bx bx-arrow-back me-1'></i>Back to Login</a>
										</div>
									</form>
						<?php
								} else {
									$error .= "<h2>Link Expired</h2>
<p>The link is expired. You are trying to use the expired link which as valid only 24 hours (1 days after request).<br /><br /></p>";
								}
							}
							if ($error != "") {
								echo "<div class='error'>" . $error . "</div><br />";
							}
						} // isset email key validate end


						if (isset($_POST["email"]) && isset($_POST["action"]) && ($_POST["action"] == "update")) {
							$error = "";
							$pass1 = mysqli_real_escape_string($conn, $_POST["pass1"]);
							$pass2 = mysqli_real_escape_string($conn, $_POST["pass2"]);
							$email = $_POST["email"];
							$curDate = date("Y-m-d H:i:s");
							if ($pass1 != $pass2) {
								$error .= "<p>Password do not match, both password should be same.<br /><br /></p><br />";
								echo "<a class='btn btn-warning' href='javascript:history.go(-1)'>Go Back</a>";
							}
							if ($error != "") {
								echo "<div class='error'>" . $error . "</div><br />";
							} else {

								$pas_encrypt = password_hash($pass1, PASSWORD_BCRYPT);
								mysqli_query($conn, "UPDATE `clients` SET `password` = '{$pas_encrypt}' WHERE `email`= '{$email}'") or die("Password Reset Query Faild");

								mysqli_query($conn, "DELETE FROM `password_reset_temp` WHERE `email`='" . $email . "';");

								echo '<div class="error"><p>Congratulations! Your password has been updated successfully.</p></div><br />';
								echo '<a class="btn btn-warning" href="../client_login">Login Now</a>';
							}
						}
						?>
						<!-- PHP CODE -->






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


<script>
	const passone = document.getElementById("passone");

	passone.addEventListener("keydown", function(event) {
		if (event.code === "Space") {
			event.preventDefault();
		}
	});
	const passtwo = document.getElementById("passtwo");

	passtwo.addEventListener("keydown", function(event) {
		if (event.code === "Space") {
			event.preventDefault();
		}
	});
</script>

</html>