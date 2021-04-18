<?php
/**
 * tradeConfirm
 * 
 * Pantalla para confirmar la compra del activo
 * 
 */

include('header.php');

if (isset($_REQUEST['asset-id']) && isset($_REQUEST['asset-vs_currencies']) && isset($_REQUEST['trade-amount']) && isset($_REQUEST['trade-asset-amount'])) :
	$asset_id = $_REQUEST['asset-id'];
	$asset_symbol = $_REQUEST['asset-symbol'];
	$asset_vs_currencies = $_REQUEST['asset-vs_currencies'];
	$trade_amount = $_REQUEST['trade-amount'];
	$trade_asset_amount = $_REQUEST['trade-asset-amount'];
	$trade_type = $_REQUEST['trade-type'];

?>

<div class="page-template-homepage">

	<div class="container">
		<div class="site-content-inner">

			<div class="prices-header">
				<div class="row justify-content-between">
					<div class="col-auto">
						<div class="market-status">
							<p class="market-status--top"><?php echo (isset($_REQUEST['trade-confirmation'])) ? 'Operación realizada': 'Confirmar operación'; ?></p>
							<p class="market-status--bottom text-uppercase"><?php echo $asset_id ; ?></span>
						</div>
					</div>
				</div>
			</div>

			<div class="row justify-content-around align-items-end">
				<div class="col-auto">
					<div class="site-content-box border-radius swap-box">
						<?php
						if (isset($_REQUEST['trade-confirmation'])) :


							$users = new users();
							$wallets = new wallets();
							$deposit_result = false;

							$current_user = $users->get_currentUser();
							$current_user_email = $current_user['email'];

							$hay_fondos = false;
							

							if ( $trade_type == 'sell' ) {
								// $asset_vs_currencies = $asset_id;

								$wallet_fund_id = md5( $asset_id . $current_user_email );
								$wallet_fund_data = $wallets->getWallet($wallet_fund_id);

								if ( $trade_asset_amount <= $wallet_fund_data['amount'] ) $hay_fondos = true;

								$deposit_amount = $trade_amount;
								$deposit_local_currency = $asset_vs_currencies;

								if ( $hay_fondos ) {

									// Quito trade_asset_amount dela cuenta de fondos
									$new_amount = $wallet_fund_data['amount'] - $trade_asset_amount;
									$deposit_result = $wallets->update($wallet_fund_id, $new_amount);
								
									
									$wallet_id = md5( $deposit_local_currency . $current_user_email );
		
									$wallet_data = $wallets->getWallet($wallet_id);
									// var_dump($wallet_data);
		
									if ( $wallet_data && $wallet_data['id'] == $wallet_id ) {
										// Actualizar
										$deposit_amount = $wallet_data['amount'] + $deposit_amount;
										$deposit_result = $wallets->update($wallet_id, $deposit_amount);
									} else {
										// Crear
										$create_datetime = date("Y-m-d H:i:s");
										$deposit_result = $wallets->create($wallet_id, $current_user_email, $deposit_local_currency, $deposit_amount, $create_datetime);
									}
									?>
									<div class="inner-padding">
										<h4 class="mb-5">Detalles de la operación</h4>
										<p>Has recibido <strong class="text-uppercase"><?php echo $trade_amount . ' ' . $deposit_local_currency; ?></strong></p>
										
										<div class="row justify-content-center mt-5">
											<div class="col">
												<a href="./wallet.php" class="btn btn-primary border-radius w-100">Volver al listado</a>
											</div>
											<div class="col">
												<a href="./wallet.php" class="btn btn-primary border-radius w-100">Ver mi cartera</a>
											</div>
										</div>
									</div>
								<?php } else { ?>
									<div class="inner-padding">
										<h4 class="mb-5">Detalles de la operación</h4>
										<p>No hay <strong class="text-uppercase"><?php echo $asset_symbol; ?></strong> suficiente en tu cartera.</p>
										<p>Revisa las cantidades y vuelve a intentarlo.</p>
										
										<div class="row justify-content-center mt-5">
											<div class="col">
												<a href="./wallet.php" class="btn btn-secondary border-radius w-100">Volver a cartera</a>
											</div>
											<div class="col">
												<a href="./trade.php" class="btn btn-primary border-radius w-100">Comprar</a>
											</div>
										</div>
									</div>
								<?php } ?>
								<?php
							} else {

								$wallet_fund_id = md5( $asset_vs_currencies . $current_user_email );
								$wallet_fund_data = $wallets->getWallet($wallet_fund_id);

								if ( $wallet_fund_data['amount'] >= $trade_amount ) $hay_fondos = true;

								if ( $hay_fondos ) {
									$deposit_amount = $trade_asset_amount;
									$deposit_local_currency = $asset_id;		

									$wallet_id = md5( $deposit_local_currency . $current_user_email );
		
									$wallet_data = $wallets->getWallet($wallet_id);
									// var_dump($wallet_data);
		
									if ( $wallet_data && $wallet_data['id'] == $wallet_id ) {
										// Actualizar
										$deposit_amount = $wallet_data['amount'] + $deposit_amount;
										$deposit_result = $wallets->update($wallet_id, $deposit_amount);
									} else {
										// Crear
										$create_datetime = date("Y-m-d H:i:s");
										$deposit_result = $wallets->create($wallet_id, $current_user_email, $deposit_local_currency, $deposit_amount, $create_datetime);
									}
									if ($deposit_result) {
										
										// Quito EUR dela cuenta de fondos
										$new_amount = $wallet_fund_data['amount'] - $trade_amount;
										$deposit_result = $wallets->update($wallet_fund_id, $new_amount);
									}
									?>
									<div class="inner-padding">
										<h4 class="mb-5">Detalles de la operación</h4>
										<p>Has recibido <strong class="text-uppercase"><?php echo $trade_asset_amount . ' ' . $asset_symbol; ?></strong> por valor de <strong class="text-uppercase"><?php echo $trade_amount . ' ' . $asset_vs_currencies; ?></strong></p>
										
										<div class="row justify-content-center mt-5">
											<div class="col">
												<a href="./trade.php" class="btn btn-primary border-radius w-100">Volver al listado</a>
											</div>
											<div class="col">
												<a href="./wallet.php" class="btn btn-primary border-radius w-100">Ver mi cartera</a>
											</div>
										</div>
									</div>
								<?php } else { ?>
									<div class="inner-padding">
										<h4 class="mb-5">Detalles de la operación</h4>
										<p>No hay fondos suficientes en tu cartera.</p>
										<p>Debes realizar un depósito y volver a intentarlo.</p>
										
										<div class="row justify-content-center mt-5">
											<div class="col">
												<a href="./trade.php" class="btn btn-secondary border-radius w-100">Volver al listado</a>
											</div>
											<div class="col">
												<a href="./deposit.php" class="btn btn-primary border-radius w-100">Depositar</a>
											</div>
										</div>
									</div>
								<?php } ?>
							<?php } ?>
						<?php else: ?>
						<div class="inner-padding">
							<h4 class="mb-5">Confirmar operación</h4>
							<form id="form-buy_asset" action="./tradeConfirm.php" method="post" class="m-0 text-center">
								<input type="hidden" name="asset-vs_currencies" id="asset-vs_currencies" value="<?php echo $asset_vs_currencies; ?>">
								<input type="hidden" name="asset-id" id="asset-id" value="<?php echo $asset_id; ?>">
								<input type="hidden" name="asset-symbol" id="asset-symbol" value="<?php echo $asset_symbol; ?>">
								<input type="hidden" name="trade-amount" id="trade-amount" value="<?php echo $trade_amount; ?>">
								<input type="hidden" name="trade-asset-amount" id="trade-asset-amount" value="<?php echo $trade_asset_amount; ?>">
								<input type="hidden" name="trade-type" id="trade-type" value="<?php echo $trade_type; ?>">
								<input type="hidden" name="trade-confirmation" id="trade-confirmation" value="true">

								<p><?php echo ( $trade_type == 'sell' ) ? 'Venderás' : 'Recibirás'; ?> <strong class="text-uppercase"><?php echo $trade_asset_amount . ' ' . $asset_symbol; ?></strong> por valor de <strong class="text-uppercase"><?php echo $trade_amount . ' ' . $asset_vs_currencies; ?></strong></p>
								<p>¿Estás seguro?</p>
								
								<div class="row justify-content-center mt-5">
									<div class="col">
										<a href="javascript: window.history.back();" class="btn btn-secondary btn-lg border-radius w-100">Cancelar</a>
									</div>
									<div class="col">
										<button class="btn btn-primary btn-lg border-radius w-100" type="submit">Confirmar</button>
									</div>
								</div>
								<?php 
								if ( isset($deposit_result) ) {
									echo '<div class="alert alert-success mt-4 mb-0 text-center"><strong>Depósito realizado en tu cartera</strong><br> <small>('.$wallet_id.')</small></div>';
								} ?>
							</form>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>

		</div>
	</div>

</div>

<?php endif; ?>

<?php
include('footer.php');
?>