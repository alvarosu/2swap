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
// $user_wallets_total = 0;
// if (!empty($user_wallets)) :
// foreach ($user_wallets as $el_wallet) {
// 	$wallet_amount = $el_wallet['amount'];
// 	$user_wallets_total = $user_wallets_total + $wallet_amount;
// }
// endif;
?>

<div class="page-template-homepage">

	<div class="container">
		<div class="site-content-inner">

			<div class="prices-header">
				<div class="row justify-content-between">
					<div class="col-auto">
						<div class="market-status">
							<p class="market-status--top">Saldo de la cartera</p>
							<p class="market-status--bottom"><big class="wallet-total" id="wallet-total"><span class="string-loading"></span></big></p>
						</div>
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