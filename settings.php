<?php
/**
 * Index
 */

include('header.php');

$users = new users();
$user_updated = false;

$current_user = $users->get_currentUser();
$current_user_name = '';

$user_name = $current_user['name'];
$user_lastname = $current_user['lastname'];
$user_local_currency = $current_user['local_currency'];

if ( isset($_REQUEST['user-email']) && isset($_REQUEST['user-name']) || isset($_REQUEST['user-lastname']) || isset($_REQUEST['user-local_currency']) ) {
	// $conexion = mysqli_connect(SERVER, USER, PASS, DB);

	$email = stripslashes($_REQUEST['user-email']);
	// $email = mysqli_real_escape_string($conexion, $email);

	$user_name = stripslashes($_REQUEST['user-name']);

	$user_lastname = stripslashes($_REQUEST['user-lastname']);

	$user_local_currency = stripslashes($_REQUEST['user-local_currency']);

	$user_updated = $users->update($user_name, $user_lastname, $user_local_currency, $email);
}

?>

<div class="page-template-homepage">

	<div class="container">
		<div class="site-content-inner">

			<div class="site-content-box">
				<div class="inner-padding">
					<div class="row align-items-end">
						<div class="col-md-6">
							<h4 class="mb-5">Configuración</h4>
							<form id="form-local_currency" action="" method="post" class="m-0">
								<h5 class="mb-4">Perfil</h5>
								<div class="mb-3">
									<label for="user-name" class="form-label">Nombre</label>
									<input type="text" class="form-control" id="user-name" name="user-name" value="<?php echo $user_name; ?>">
								</div>
								<div class="mb-3">
									<label for="user-lastname" class="form-label">Apellidos</label>
									<input type="text" class="form-control" id="user-lastname" name="user-lastname" value="<?php echo $user_lastname; ?>">
								</div>
								<div class="mb-3">
									<label for="user-email" class="form-label">Email</label>
									<input type="text" class="form-control" id="user-email" name="user-email" value="<?php echo $current_user['email']; ?>" readonly>
								</div>
								<h5 class="mt-5 mb-4">Preferencias</h5>
								<div class="mb-3">
									<label for="user-local_currency" class="form-label">Moneda local</label>
									<select name="user-local_currency" id="user-local_currency" class="form-select" aria-label="Selecciona una moneda local">
										<option value="usd" <?php if ($user_local_currency=='usd') echo 'selected'; ?>>USD Dólar estadounidense</option>
										<option value="eur" <?php if ($user_local_currency=='eur') echo 'selected'; ?>>EUR Euro</option>
									</select>
								</div>
								<div class="row justify-content-between align-items-center mt-5">
									<div class="col-auto">
										<button class="btn btn-primary" type="submit">Guardar</button>
									</div>
									<div class="col-auto">
										<?php 
										if ( $user_updated ) {
											echo '<span class="text-success">Usuario actualizado.</span>';
										} ?>
									</div>
								</div>
							</form>
							<?php if ($user_updated) : ?>
								<script>
									document.querySelector('.user-logged .dropdown a strong').innerHTML = '<?php echo $user_name; ?>';
								</script>
							<?php endif; ?>
						</div>
						<div class="col-md-6 text-md-end">
							<div class="user-remove mt-5">
								<form action="./logout.php" method="post" class="m-0" id="form-userremove" onsubmit="return confirm('¿Quieres eliminar tu cuenta?');">
									<input type="hidden" class="form-control`d-none" id="userremove-email" name="userremove-email" value="<?php echo $current_user['email']; ?>" readonly>
									<button class="btn btn-link" type="submit">Eliminar cuenta</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="loader d-none"></div>

		</div>
	</div>

</div>

<?php
include('footer.php');
?>