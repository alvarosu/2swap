<?php
/**
 * Index
 */

include('header.php');
$users = new users();
$wallets = new wallets();

$current_user = $users->get_currentUser();
$local_currency = $current_user['local_currency'];

$user_wallets = $wallets->getWalletsByUser($current_user['email']);
?>

<div class="page-template-homepage">

	<div class="container">
		<div class="site-content-inner">


			<div class="row flex-md-row-reverse">
				<div class="col-md-4">
					<div class="site-content-box">
						<div class="site-content-box--header"><h5>Saldo de la cartera</h5></div>
						<div class="inner-padding pt-0">
							<div class="market-status mb-0">
								<p class="market-status--bottom mb-0"><big class="wallet-total" id="wallet-total"><span class="string-loading"></span></big></p>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-8">
					<div class="site-content-box">
						<div class="site-content-box--header"><h5>TOP 7 <i class="fas fa-rocket"></i></span> En Tendencia</h5></div>
						<table class="table table-hover" id="table-trending">
							<thead>
								<tr>
									<th scope="col" width="70">#</th>
									<th scope="col col-name">Nombre</th>
									<th scope="col"><span class="d-none d-lg-inline">Posición</span> Market Cap.</th>
								</tr>
							</thead>
							<tbody>
								<tr class="loading">
									<th scope="row"><span class="string-loading"></span></th>
									<td class="name"><span class="string-loading"></span></td>
									<td class="current_price"><span class="string-loading"></span></td>
								</tr>
								<tr class="loading">
									<th scope="row"><span class="string-loading"></span></th>
									<td class="name"><span class="string-loading"></span></td>
									<td class="current_price"><span class="string-loading"></span></td>
								</tr>
								<tr class="loading">
									<th scope="row"><span class="string-loading"></span></th>
									<td class="name"><span class="string-loading"></span></td>
									<td class="current_price"><span class="string-loading"></span></td>
								</tr>
								<tr class="loading">
									<th scope="row"><span class="string-loading"></span></th>
									<td class="name"><span class="string-loading"></span></td>
									<td class="current_price"><span class="string-loading"></span></td>
								</tr>
								<tr class="loading">
									<th scope="row"><span class="string-loading"></span></th>
									<td class="name"><span class="string-loading"></span></td>
									<td class="current_price"><span class="string-loading"></span></td>
								</tr>
								<tr class="loading">
									<th scope="row"><span class="string-loading"></span></th>
									<td class="name"><span class="string-loading"></span></td>
									<td class="current_price"><span class="string-loading"></span></td>
								</tr>
								<tr class="loading">
									<th scope="row"><span class="string-loading"></span></th>
									<td class="name"><span class="string-loading"></span></td>
									<td class="current_price"><span class="string-loading"></span></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="site-content-box">

				<div class="site-content-box--header"><h5>Sus activos</h5></div>

				<?php
				// var_dump($wallets);
				if (!empty($user_wallets)) : ?>
				<table class="table table-hover" id="table-user-wallets">

					<tbody>
						<?php
						$counter = 0;
						foreach ($user_wallets as $el_wallet) {
							# code...
							$counter++;
							$wallet_amount = $el_wallet['amount'];
							if ( $wallet_amount > 0 ) {
								// $wallet_amount = $wallet_amount;
								?><tr data-asset-id="<?php echo $el_wallet['currency']; ?>" data-asset-amount="<?php echo $el_wallet['amount']; ?>">
									<td class="col-name text-capitalize"><span class="name"><?php echo ( $el_wallet['currency'] == 'eur' ) ? '<i class="fas fa-euro-sign"></i>Euro' : '<span class="string-loading"></span>'; ?></span></td>
									<?php if ( $el_wallet['currency'] == 'eur' ) : ?>
									<td class="current_price"><strong><?php echo $wallet_amount . ' €'; ?></strong></td>
									<?php else: ?>
									<td class="current_price"><span class="string-loading"></span><strong class="conversion_to_eur"></strong> <span class="asset_amount d-none"><?php echo $wallet_amount; ?></span></td>
									<?php endif; ?>
									<td class="trade_options text-end"><?php if ( $el_wallet['currency'] == 'eur' ) echo '<a href="./deposit.php" class="btn btn-primary btn-asset ms-2">Depositar</a>'; ?></td>
								</tr><?php
							}
						} ?>
					</tbody>
				</table>
				<?php endif; ?>

			</div>

			<div class="loader d-none"></div>

		</div>
	</div>

</div>

<?php
include('footer.php');
?>