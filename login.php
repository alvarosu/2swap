<?php
/**
 * Log in
 */
require_once 'inc/functions.php';
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<title>Precios - 2SWAP</title>

	<link rel="stylesheet" href="./vendor/bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="./vendor/fontawesome-free-5.15.3-web/css/all.min.css">
	<link rel="stylesheet" href="./assets/css/style.css">

	<!-- Favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="./assets/images/favicon/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="./assets/images/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="./assets/images/favicon/favicon-16x16.png">
	<link rel="manifest" href="./assets/images/favicon/site.webmanifest">
	<link rel="mask-icon" href="./assets/images/favicon/safari-pinned-tab.svg" color="#2d4f6c">
	<meta name="msapplication-TileColor" content="#2d4f6c">
	<meta name="theme-color" content="#ffffff">
</head>

<body class="page-template-login">

	<div class="page-wrap">

		<div class="site-branding text-center mb-4">
			<img src="./assets/images/2swap.svg" alt="2swap" height="200">
		</div>

		<main class="form-signin text-center">
			<h5 class="mb-4 color-primary"><strong>Iniciar sesión</strong></h5>
			<?php
				// When form submitted, check and create user session.
				if (isset($_POST['login-email'])&&isset($_POST['login-password'])) {
					$con = mysqli_connect(SERVER, USER, PASS, DB);
					$email = stripslashes($_REQUEST['login-email']);    // removes backslashes
					$email = mysqli_real_escape_string($con, $email);
					$password = stripslashes($_REQUEST['login-password']);
					$password = mysqli_real_escape_string($con, $password);
					// Check user is exist in the database
					$query = "SELECT * FROM `users` WHERE email='$email'
								AND password='" . md5($password) . "'";
					$result = mysqli_query($con, $query) or die(mysql_error());
					$rows = mysqli_num_rows($result);
					if ($rows == 1) {
						$_SESSION['email'] = $email;
						// Redirect to user dashboard page
						header("Location: index.php");
					} else {
						// echo '<p class="text-danger">Datos de acceso incorrectos.</p>';
					}
				}
			?>
			<form id="login-signup" action="" method="post">
				<div class="row mb-2 g-2">
					<div class="col-sm">
						<div class="form-floating">
							<input type="email" class="form-control" id="login-email" name="login-email" placeholder="Email" required>
							<label for="login-email">Email</label>
						</div>
					</div>
				</div>
				<div class="row mb-2 g-2">
					<div class="col-sm">
						<div class="form-floating">
							<input type="password" class="form-control" id="login-password" name="login-password" placeholder="Contraseña" required>
							<label for="login-password">Contraseña</label>
						</div>
					</div>
				</div>
				<div class="checkbox mt-3 mb-4">
					<label>
						<input type="checkbox" id="remember_me" name="remember_me" checked/> Recordarme
					</label>
				</div>
				<button class="w-100 btn btn-primary" type="submit">Acceder</button>
			</form>
			<?php
			if (isset($_POST['login-email'])&&isset($_POST['login-password'])) { 
				if ($rows == 1) {
					// $_SESSION['email'] = $email;
					// Redirect to user dashboard page
					// header("Location: index.php");
				} else {
					echo '<p class="mt-4 mb-0 text-danger">Email o contraseña incorrectos.</p>';
				}
			}
			?>
		</main>
		<a href="./signup.php" class="w-100 mt-4 btn btn-link">Crear una cuenta</a>
		<div class="site-footer text-center">
			<div class="container">
				<p>© <?php echo date("Y"); ?> - 2SWAP Buy and Sell Crypto</p>
			</div>
		</div>
		
	</div>
</body>

</html>