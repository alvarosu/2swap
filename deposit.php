<?php
/**
 * Index
 */

include('header.php');

$users = new users();
$wallets = new wallets();
$deposit_result = false;

$current_user = $users->get_currentUser();
$current_user_email = $current_user['email'];

if ( !empty($current_user_email) && isset($_REQUEST['deposit-amount']) && isset($_REQUEST['deposit-local_currency']) ) {
	
	$deposit_amount = stripslashes($_REQUEST['deposit-amount']);
	$deposit_local_currency = stripslashes($_REQUEST['deposit-local_currency']);

	$wallet_id = md5( $deposit_local_currency . $current_user_email );

	$wallet_data = $wallets->getWallet($wallet_id);
	// var_dump($wallet_data);

	if ( $wallet_data  && $wallet_data['id'] == $wallet_id ) {
		// Actualizar
		$deposit_amount = $wallet_data['amount'] + $deposit_amount;
		$deposit_result = $wallets->update($wallet_id, $deposit_amount);
	} else {
		// Crear
		$create_datetime = date("Y-m-d H:i:s");
		$deposit_result = $wallets->create($wallet_id, $current_user_email, $deposit_local_currency, $deposit_amount, $create_datetime);
	}

}

?>

<div class="page-template-homepage">

	<div class="container">
		<div class="site-content-inner">

			<div class="row justify-content-around align-items-end">
				<div class="col-auto">
					<div class="site-content-box border-radius swap-box">
						<div class="inner-padding">
							<h4 class="mb-5">Añadir fondos</h4>
							<form id="form-deposit" action="" method="post" class="m-0">
								<div class="row justify-content-between align-items-center mt-5">
									<div class="col-8">
										<label for="deposit-amount" class="form-label">Importe</label>
										<input type="text_money" class="form-control " id="deposit-amount" name="deposit-amount" placeholder="0.00" required>
									</div>
									<div class="col-4">
										<label for="deposit-local_currency" class="form-label">Moneda</label>
										<select name="deposit-local_currency" id="deposit-local_currency" class="form-select" aria-label="Selecciona una moneda local" required>
											<?php /*<option value="usd" <?php if ($current_user['local_currency'] == 'usd') echo ' selected'; ?>>USD</option>*/ ?>
											<option value="eur" <?php //if ($current_user['local_currency'] == 'eur') echo ' selected'; ?>>EUR</option>
										</select>
									</div>
								</div>
								<div class="row justify-content-center mt-5">
									<div class="col">
										<button class="btn btn-primary btn-lg border-radius w-100" type="submit">Depositar</button>
									</div>
								</div>
								<?php 
								if ( $deposit_result ) {
									echo '<div class="alert alert-success mt-4 mb-0 text-center"><strong>Depósito realizado en tu cartera</strong><br> <small>('.$wallet_id.')</small></div>';
								} ?>
							</form>
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