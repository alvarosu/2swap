<?php
/**
 * trade
 */

include('header.php');
?>

<div class="page-template-homepage">

	<div class="container">
		<div class="site-content-inner">

			<div class="prices-header">
				<div class="row justify-content-between">
					<div class="col-auto">
						<?php if (isset($_REQUEST['asset'])) : ?>
						<div class="market-status">
							<p class="market-status--top">Operar activo</p>
							<p class="market-status--bottom text-uppercase"><?php echo $_REQUEST['asset']; ?></span>
						</div>
						<?php else: ?>
						<div class="market-status">
							<p class="market-status--top">En las últimas 24 horas</p>
							<p class="market-status--bottom"><span class="string-loading"></span></p>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>

				<?php if (isset($_REQUEST['asset'])) :
					$asset_id = $_REQUEST['asset'];
					$type = 'buy';
					if ( isset( $_REQUEST['type'] ) ) $type = $_REQUEST['type'];

					if ( $type == 'sell' ) :
						
						$users = new users();
						$wallets = new wallets();
						$deposit_result = false;

						$current_user = $users->get_currentUser();
						$current_user_email = $current_user['email'];
												
						$wallet_id = md5( $asset_id . $current_user_email );
					
						$wallet_data = $wallets->getWallet($wallet_id);

					?>

					<div class="row justify-content-around align-items-end">
						<div class="col-auto">
							<div class="site-content-box border-radius swap-box">
								<div class="inner-padding">
									<h4 class="mb-4">Vender</h4>
									<form id="form-sell_asset" action="./tradeConfirm.php" method="post" class="m-0">
										<input type="hidden" name="asset-vs_currencies" id="asset-vs_currencies" value="eur">
										<input type="hidden" name="asset-id" id="asset-id" value="">
										<input type="hidden" name="asset-symbol" id="asset-symbol" value="">
										<input type="hidden" name="asset-market_price" id="asset-market_price" value="">
										<input type="hidden" name="trade-type" id="trade-type" value="<?php echo $type; ?>">

										<?php if (!empty($wallet_data['amount'])) : ?><p class="alert alert-secondary">Tienes <strong class="asset_amount"><?php echo $wallet_data['amount']; ?></strong> en tu cartera.</p><?php endif; ?>

										<div class="row justify-content-between align-items-center mt-4">
											<div class="col-8">
												<label for="trade-asset-amount" class="form-label">Cantidad</label>
												<input type="text_money" class="form-control " id="trade-asset-amount" name="trade-asset-amount" placeholder="0.00" max="<?php echo $wallet_data['amount']; ?>" disabled required>
											</div>
											<div class="col-4">
												<label for="trade-asset-id" class="form-label">Moneda</label>
												<input type="text_money" class="form-control text-uppercase" id="trade-asset-id" name="trade-asset-id" value="" readonly required>
											</div>
										</div>
										<div class="row justify-content-between align-items-center mt-3">
											<div class="col-8">
												<input type="text_money" class="form-control " id="trade-amount" name="trade-amount" placeholder="0.00" disabled required>
											</div>
											<div class="col-4">
												<select name="deposit-local_currency" id="deposit-local_currency" class="form-select" readonly aria-label="Selecciona una moneda local" required>
													<?php /*<option value="usd" <?php if ($current_user['local_currency'] == 'usd') echo ' selected'; ?>>USD</option>*/ ?>
													<option value="eur" <?php //if ($current_user['local_currency'] == 'eur') echo ' selected'; ?>>EUR</option>
												</select>
											</div>
										</div>
										<div class="row mt-4">
											<div class="col">Precio actual</div>
											<div class="col text-end text-uppercase"><strong id="span-asset-market_price"><span class="string-loading"></span></strong></div>
										</div>
										<div class="row justify-content-center mt-5">
											<div class="col">
												<button class="btn btn-primary btn-lg border-radius w-100" type="submit" disabled>Vender</button>
											</div>
										</div>
									</form>
									<script>

										function reqListener() {
											// var tb_result = document.querySelector('#table-prices');
											var data = JSON.parse(this.responseText);
											var current_market_price = data.market_data.current_price.eur;

											document.querySelector('#asset-id').value = data.id;
											document.querySelector('#asset-symbol').value = data.symbol;

											document.querySelector('#asset-market_price').value = current_market_price;

											document.querySelector('#span-asset-market_price').innerHTML = '1 ' + data.symbol + ' = ' + current_market_price + ' €';
											// document.querySelector('#span-asset-market_price').innerHTML = output;

											document.querySelector('#trade-asset-id').value = data.symbol;

											var inputs_disabled = document.querySelectorAll('#form-sell_asset input:disabled');
											inputs_disabled.forEach(element => {
												element.removeAttribute('disabled');
											});
											var btn_submit = document.querySelector('#form-sell_asset [type="submit"]')
											if ( btn_submit ) btn_submit.removeAttribute('disabled');

											var trade_amount = document.querySelector('#trade-amount');
											var trade_assetAmount = document.querySelector('#trade-asset-amount');

											trade_amount.addEventListener('keyup', function(e) {
												e.preventDefault();
												// console.log(this.value);
												
												// 1 = current_market_price
												// trade_amount.value = x

												var assetAmount_result = trade_amount.value / current_market_price;
												if ( isNaN(assetAmount_result) ) {
													assetAmount_result = 0;
													trade_amount.value = 0;
												}
												trade_assetAmount.value = assetAmount_result;
											});

											trade_assetAmount.addEventListener('keyup', function(e) {
												e.preventDefault();
												// console.log(this.value);
												
												// current_market_price = 1 
												// trade_assetAmount.value = x 

												var amount_result = trade_assetAmount.value * current_market_price;
												if ( isNaN(amount_result) ) {
													amount_result = 0;
													trade_assetAmount.value = 0;
												}
												trade_amount.value = amount_result.toFixed(2);
											});
										}
										
										var oReq = new XMLHttpRequest();
										
										function update_price() {
											oReq.addEventListener("load", reqListener);
											oReq.open("GET", "https://api.coingecko.com/api/v3/coins/<?php echo $asset_id; ?>?localization=es&tickers=false&market_data=true&community_data=false&developer_data=false&sparkline=false");
											oReq.send();
										}

										// var updateForm = setInterval( function() {
										// 	update_price();
										// }, 600600);

										update_price();

									</script>
								</div>
							</div>
						</div>
					</div>
					
					<?php else: ?>

					<div class="row justify-content-around align-items-end">
						<div class="col-auto">
							<div class="site-content-box border-radius swap-box">
								<div class="inner-padding">
									<h4 class="mb-5">Comprar</h4>
									<form id="form-buy_asset" action="./tradeConfirm.php" method="post" class="m-0">
										<input type="hidden" name="asset-vs_currencies" id="asset-vs_currencies" value="eur">
										<input type="hidden" name="asset-id" id="asset-id" value="">
										<input type="hidden" name="asset-symbol" id="asset-symbol" value="">
										<input type="hidden" name="asset-market_price" id="asset-market_price" value="">
										<input type="hidden" name="trade-type" id="trade-type" value="<?php echo $type; ?>">

										<div class="row justify-content-between align-items-center mt-5">
											<div class="col-8">
												<label for="deposit-amount" class="form-label">Cantidad</label>
												<input type="currency" class="form-control " id="trade-amount" name="trade-amount" placeholder="0.00" disabled required>
											</div>
											<div class="col-4">
												<label for="deposit-local_currency" class="form-label">Moneda</label>
												<select name="deposit-local_currency" id="deposit-local_currency" class="form-select" aria-label="Selecciona una moneda local" required>
													<?php /*<option value="usd" <?php if ($current_user['local_currency'] == 'usd') echo ' selected'; ?>>USD</option>*/ ?>
													<option value="eur" <?php //if ($current_user['local_currency'] == 'eur') echo ' selected'; ?>>EUR</option>
												</select>
											</div>
										</div>
										<div class="row justify-content-between align-items-center mt-3">
											<div class="col-8">
												<input type="currency" class="form-control " id="trade-asset-amount" name="trade-asset-amount" placeholder="0.00" disabled required>
											</div>
											<div class="col-4">
												<input type="currency" class="form-control text-uppercase" id="trade-asset-id" name="trade-asset-id" value="" readonly disabled required>
											</div>
										</div>
										<div class="row mt-4">
											<div class="col">Precio actual</div>
											<div class="col text-end text-uppercase"><strong id="span-asset-market_price"><span class="string-loading"></span></strong></div>
										</div>
										<div class="row justify-content-center mt-5">
											<div class="col">
												<button class="btn btn-primary btn-lg border-radius w-100" type="submit" disabled>Comprar</button>
											</div>
										</div>
									</form>
									<script>

										function reqListener() {
											// var tb_result = document.querySelector('#table-prices');
											var data = JSON.parse(this.responseText);
											var current_market_price = data.market_data.current_price.eur;

											document.querySelector('#asset-id').value = data.id;
											document.querySelector('#asset-symbol').value = data.symbol;

											document.querySelector('#asset-market_price').value = current_market_price;

											document.querySelector('#span-asset-market_price').innerHTML = '1 ' + data.symbol + ' = ' + current_market_price + ' €';
											// document.querySelector('#span-asset-market_price').innerHTML = output;

											document.querySelector('#trade-asset-id').value = data.symbol;

											var inputs_disabled = document.querySelectorAll('#form-buy_asset input:disabled');
											inputs_disabled.forEach(element => {
												element.removeAttribute('disabled');
											});
											var btn_submit = document.querySelector('#form-buy_asset [type="submit"]')
											if ( btn_submit ) btn_submit.removeAttribute('disabled');

											var trade_amount = document.querySelector('#trade-amount');
											var trade_assetAmount = document.querySelector('#trade-asset-amount');

											trade_amount.addEventListener('keyup', function(e) {
												e.preventDefault();
												// console.log(this.value);
												
												// 1 = current_market_price
												// trade_amount.value = x

												var assetAmount_result = trade_amount.value / current_market_price;
												if ( isNaN(assetAmount_result) ) {
													assetAmount_result = 0;
													trade_amount.value = 0;
												}
												trade_assetAmount.value = assetAmount_result;
											});

											trade_assetAmount.addEventListener('keyup', function(e) {
												e.preventDefault();
												// console.log(this.value);
												
												// current_market_price = 1 
												// trade_assetAmount.value = x 

												var amount_result = trade_assetAmount.value * current_market_price;
												if ( isNaN(amount_result) ) {
													amount_result = 0;
													trade_assetAmount.value = 0;
												}
												trade_amount.value = amount_result.toFixed(2);
											});
										}
										
										var oReq = new XMLHttpRequest();
										
										function update_price() {
											oReq.addEventListener("load", reqListener);
											oReq.open("GET", "https://api.coingecko.com/api/v3/coins/<?php echo $asset_id; ?>?localization=es&tickers=false&market_data=true&community_data=false&developer_data=false&sparkline=false");
											oReq.send();
										}

										// var updateForm = setInterval( function() {
										// 	update_price();
										// }, 600600);

										update_price();

									</script>
								</div>
							</div>
						</div>
					</div>

					<?php endif; ?>

				<?php else: ?>
				<div class="site-content-box">
					<table class="table table-hover" id="table-prices">
						<thead>
							<tr>
								<th class="index">#</th>
								<th class=" col-name">Nombre</th>
								<th class="">Precio</th>
								<th class=" change price_24h"><span class="d-none d-sm-inline">24 h</span></th>
								<th class=" change price_7d">7 d</th>
								<th class=" change price_30d">30 d</th>
								<th class=" trade_options"></th>
							</tr>
						</thead>
						<tbody>
							<tr class="loading">
								<th class="index"><span class="string-loading"></span></th>
								<td class="name"><span class="string-loading"></span></td>
								<td class="current_price"><span class="string-loading"></span></td>
								<td class="change price_24h"><span class="string-loading"></span></td>
								<td class="change price_7d"><span class="string-loading"></span></td>
								<td class="change price_30d"><span class="string-loading"></span></td>
								<td class="trade_options"><span class="string-loading"></span></td>
							</tr>
							<tr class="loading">
								<th class="index"><span class="string-loading"></span></th>
								<td class="name"><span class="string-loading"></span></td>
								<td class="current_price"><span class="string-loading"></span></td>
								<td class="change price_24h"><span class="string-loading"></span></td>
								<td class="change price_7d"><span class="string-loading"></span></td>
								<td class="change price_30d"><span class="string-loading"></span></td>
								<td class="trade_options"><span class="string-loading"></span></td>
							</tr>
							<tr class="loading">
								<th class="index"><span class="string-loading"></span></th>
								<td class="name"><span class="string-loading"></span></td>
								<td class="current_price"><span class="string-loading"></span></td>
								<td class="change price_24h"><span class="string-loading"></span></td>
								<td class="change price_7d"><span class="string-loading"></span></td>
								<td class="change price_30d"><span class="string-loading"></span></td>
								<td class="trade_options"><span class="string-loading"></span></td>
							</tr>
							<tr class="loading">
								<th class="index"><span class="string-loading"></span></th>
								<td class="name"><span class="string-loading"></span></td>
								<td class="current_price"><span class="string-loading"></span></td>
								<td class="change price_24h"><span class="string-loading"></span></td>
								<td class="change price_7d"><span class="string-loading"></span></td>
								<td class="change price_30d"><span class="string-loading"></span></td>
								<td class="trade_options"><span class="string-loading"></span></td>
							</tr>
							<tr class="loading">
								<th class="index"><span class="string-loading"></span></th>
								<td class="name"><span class="string-loading"></span></td>
								<td class="current_price"><span class="string-loading"></span></td>
								<td class="change price_24h"><span class="string-loading"></span></td>
								<td class="change price_7d"><span class="string-loading"></span></td>
								<td class="change price_30d"><span class="string-loading"></span></td>
								<td class="trade_options"><span class="string-loading"></span></td>
							</tr>
						</tbody>
					</table>
				</div>
				<?php endif; ?>

			<div class="loader d-none"></div>

		</div>
	</div>

</div>

<?php
include('footer.php');
?>