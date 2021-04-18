<?php
/**
 * Sign up
 */
require_once 'inc/functions.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
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

<body class="page-template-signup">

	<div class="page-wrap">

		<div class="site-branding text-center mb-4">
			<img src="./assets/images/2swap.svg" alt="2swap" height="200">
		</div>

	<main class="form-signin text-center">
		<h5 class="mb-4 color-primary"><strong>Crear cuenta</strong></h5>
		<?php
		// require('./inc/config.php');
		// When form submitted, insert values into the database.
		if ( isset($_REQUEST['signup-name']) && isset($_REQUEST['signup-email']) && isset($_REQUEST['signup-password']) ) {
			// removes backslashes
			// $con = mysqli_connect(SERVER, USER, PASS, DB);
			$name = stripslashes($_REQUEST['signup-name']);
			// $name = mysqli_real_escape_string($con, $name);
			$lastname = stripslashes($_REQUEST['signup-lastname']);
			// $lastname = mysqli_real_escape_string($con, $lastname);
			$email = stripslashes($_REQUEST['signup-email']);
			// $email = mysqli_real_escape_string($con, $email);
			$password = stripslashes($_REQUEST['signup-password']);
			// $password = mysqli_real_escape_string($con, $password);
			$create_datetime = date("Y-m-d H:i:s");
			$local_currency = 'usd';
			$users = new users();
			$user_created = $users->create($name, $lastname, $email, $password, $create_datetime, $local_currency);
			if ($user_created) {
				echo "<div class='form'>
					<p class='text-success'>Te has registrado correctamente.</p>
					<p class='link'>Puedes acceder <a href='login.php'>aquí</a>.</p>
					</div>";
			} else {
				echo "<div class='form'>
					<p class='text-danger'>Ha ocurrido un problema.</p>
					<p class='link'>Inténtalo de nuevo <a href='signup.php'>aquí</a>.</p>
					</div>";
			}
		} else {
		?>
		<form id="form-signup" action="" method="post">
			<div class="row mb-2 g-2">
				<div class="col-sm">
					<div class="form-floating">
						<input type="text" class="form-control" id="signup-name" name="signup-name" placeholder="Nombre" required>
						<label for="signup-name">Nombre</label>
					</div>
				</div>
				<div class="col-sm">
					<div class="form-floating">
						<input type="text" class="form-control" id="signup-lastname" name="signup-lastname" placeholder="Apellidos">
						<label for="signup-lastname">Apellidos</label>
					</div>
				</div>
			</div>
			<div class="row mb-2 g-2">
				<div class="col-sm">
					<div class="form-floating">
						<input type="email" class="form-control" id="signup-email" name="signup-email" placeholder="Email" required>
						<label for="signup-email">Email</label>
					</div>
				</div>
			</div>
			<div class="row mb-2 g-2">
				<div class="col-sm">
					<div class="form-floating">
						<input type="password" class="form-control" id="signup-password" name="signup-password" placeholder="Password" required>
						<label for="signup-password">Password</label>
					</div>
				</div>
			</div>
			<button class="w-100 btn btn-primary mt-4" type="submit">Registrarme</button>
			<a href="./login.php" class="w-100 mt-4 btn btn-link">Ya tengo una cuenta</a>
		</form>
		<?php }	?>
	</main>

	<div class="site-footer text-center">
		<div class="container">
			<p>© <?php echo date("Y"); ?> - 2SWAP Buy and sell crypto</p>
		</div>
	</div>

</div>

<script src="./vendor/jquery-3.6.0.min.js"></script>
<script src="./vendor/popper.min.js"></script>
<script src="./vendor/bootstrap-5.0.0-beta3-dist/js/bootstrap.min.js"></script>
<script src="./assets/js/main.js"></script>
</body>

</html>