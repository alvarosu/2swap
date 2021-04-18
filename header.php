<?php
/**
 * Header
*/
// require('./inc/config.php');
include("./inc/auth_session.php");
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

<body>

	<?php 
	$users = new users();
	$current_user = $users->get_currentUser();
	echo '<input type="hidden" name="currency_fiat_selected" id="currency_fiat_selected" value="'.$current_user['local_currency'].'">';
	?>

	<div class="page-wrap">

		<?php include('sidebar.php'); ?>

		<header class="site-header">
			<div class="container-fluid">
				<div class="row align-items-center justify-content-between">
					<div class="col-auto">
						<a href="./" class="text-decoration-none d-md-none">
							<img src="./assets/images/2swap-hh.svg" alt="2swap" height="40" class="">
						</a>
					</div>
					<div class="col-auto text-end">
						<div class="user-logged d-flex">
							<a href="./trade.php" class="btn btn-primary d-none d-lg-inline-block">Comprar</a>
							<a href="./wallet.php" class="btn btn-primary ms-2 d-none d-lg-inline-block">Vender</a>
							<a href="./deposit.php" class="btn btn-primary d-none d-sm-inline-block ms-2">Depositar</a>
							<div class="dropdown dropdown-user ms-3 d-inline-flex align-items-center">
								<?php
								$users = new users();
								$current_urser = $users->get_currentUser();
								if (!empty($current_urser)) :
								?>
								<a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
									<i class="fas fa-user-circle  me-2"></i>
									<strong><?php echo $current_urser['name']; ?></strong>
								</a>
								<ul class="dropdown-menu" aria-labelledby="dropdownUser">
									<li class=" d-sm-none"><a href="./deposit.php" class="dropdown-item">Depositar</a></li>
									<li><a class="dropdown-item" href="./settings.php">Configuración</a></li>
									<li><a class="dropdown-item" href="./logout.php">Cerrar sesión</a></li>
								</ul>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</header>

		<div class="site-content">