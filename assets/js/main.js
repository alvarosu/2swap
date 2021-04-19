var currency_fiat = new Array(
	'usd',
	'eur',
);

var currency_fiat_selected = document.querySelector('#currency_fiat_selected').value;

var currency_crypto = new Array(
	'bitcoin',
	'ethereum',
	'cardano',
	'litecoin',
	'uniswap',
	'chainlink',
	'filecoin',
);

var oReq = new XMLHttpRequest();
var oReq_table_trending = new XMLHttpRequest();

var table_trending = document.querySelector('#table-trending');

function reqListenerTrending() {
	var data = JSON.parse(this.responseText);

	var data_coins = data['coins'];

	var output = "";
	var counter = 0;

	for (var i = 0; i < data_coins.length; i++) {
		counter++;
		output += '<tr data-id="' + data_coins[i]['item'].id + '"><th scope="row" class="index">' + counter + '</th><td class="name"><img class="image" src="' + data_coins[i]['item'].thumb + '">' + data_coins[i]['item'].name + ' <span class="symbol">' + data_coins[i]['item'].symbol + '</span></td><td>' + data_coins[i]['item'].market_cap_rank + '</td></tr>';
	}

	if (typeof (table_trending) != 'undefined' && table_trending != null)
		table_trending.querySelector('tbody').innerHTML = output;
}

if (typeof (table_trending) != 'undefined' && table_trending != null) {
	oReq_table_trending.addEventListener("load", reqListenerTrending);
	oReq_table_trending.open("GET", "https://api.coingecko.com/api/v3/search/trending");
	oReq_table_trending.send();
}

var table_prices = document.querySelector('#table-prices');

function reqListener() {
	var data = JSON.parse(this.responseText);

	// console.log(this.responseText);

	var output = "";
	var counter = 0;
	var market_status_array = 0;

	for (var i = 0; i < data.length; i++) {
		// if (currency_crypto.includes(data[i].id)) {
		counter++;
		var current_price = '';
		// if (i == 0) console.log(data[i]);
		// output += data[i].name + ': $' + data[i].market_data.current_price.usd + '<br>';
		if (currency_fiat_selected == 'usd') {
			current_price = data[i].market_data.current_price.usd.toFixed(2) + ' $US';
		} else if (currency_fiat_selected == 'eur') {
			current_price = data[i].market_data.current_price.eur.toFixed(2) + ' €';
		}
		price_24h = 'n-up';
		price_7d = 'n-up';
		price_30d = 'n-up';
		icon_price_24h = '<span class="d-md-none n-up"><i class="fas fa-sort-up"></i></span>';
		market_status_array += data[i].market_data.price_change_percentage_24h;
		if (Math.sign(data[i].market_data.price_change_percentage_24h) == -1) {
			price_24h = 'n-down';
			icon_price_24h = '<span class="d-md-none n-down"><i class="fas fa-sort-down"></i></span>';
		}
		if (Math.sign(data[i].market_data.price_change_percentage_7d) == -1) price_7d = 'n-down';
		if (Math.sign(data[i].market_data.price_change_percentage_30d) == -1) price_30d = 'n-down';

		output += '<tr data-id="' + data[i].id + '"><th scope="row" class="index">' + counter + '</th><td class="name"><img class="image" src="' + data[i].image.small + '"><span class="asset-name">' + data[i].name + '</span> <span class="symbol">' + data[i].symbol + '</span></td><td class="current_price">' + current_price + '</td><td class="change price_24h">' + icon_price_24h + '<span class="d-none d-md-inline-block ' + price_24h + '">' + data[i].market_data.price_change_percentage_24h.toFixed(2) + ' %</span></td><td class="change price_7d"><span class="' + price_7d + '">' + data[i].market_data.price_change_percentage_7d.toFixed(2) + ' %</span></td><td class="change price_30d"><span class="' + price_30d + '">' + data[i].market_data.price_change_percentage_30d.toFixed(2) + ' %</span></td><td class="trade_options text-end"><a href="./trade.php?asset=' + data[i].id + '" class="btn btn-primary btn-asset">Comprar</a></td></tr>';
		// }
	}

	if (typeof (table_prices) != 'undefined' && table_prices != null) {
		table_prices.querySelector('tbody').innerHTML = output;

		var market_status_string = 'El mercado está al alza';
		market_status_price24h = 'n-up';
		if (Math.sign(market_status_array) == -1) {
			market_status_price24h = 'n-down';
			market_status_string = 'El mercado está retrocediendo';
		}

		document.querySelector('.market-status--bottom').innerHTML = market_status_string + ' <span class="d-inline-block ' + market_status_price24h + '">' + market_status_array.toFixed(2) + ' %</span>';
		
	}

	// document.querySelector('.loader').classList.add('collapse')
}

if (typeof (table_prices) != 'undefined' && table_prices != null) {
	oReq.addEventListener("load", reqListener);
	oReq.open("GET", "https://api.coingecko.com/api/v3/coins/?include_platform=false");
	oReq.send();
}

function reqListenerWallets() {
	var data = JSON.parse(this.responseText);

	var output = "";
	var counter = 0;

	var wallet_total = 0;

	var eur_amount = document.querySelector('#table-user-wallets tr[data-asset-id="eur"]').getAttribute('data-asset-amount');
	// console.log(eur_amount);
	wallet_total = parseFloat(eur_amount);

	var table_userWallets_rows = table_userWallets.querySelectorAll('tr');

	table_userWallets_rows.forEach(element => {
		if (element.hasAttribute('data-asset-id')) {
			var asset_id = element.getAttribute('data-asset-id');
			var asset_amount = element.getAttribute('data-asset-amount');


			for (var i = 0; i < data.length; i++) {
				if (data[i].id == asset_id) {
					var current_market_price = data[i].market_data.current_price.eur;

					var amount_result = 0;

					var amount_result = asset_amount * current_market_price;
					wallet_total += parseFloat(amount_result);
					amount_result = amount_result.toFixed(2);
					// console.log(data[i].id + ' ' + amount_result + ' ' + current_market_price);

					element.querySelector('.name').innerHTML = '<img class="image" src="' + data[i].image.small + '"><span class="asset-name">' + data[i].name + '</span> <span class="symbol"> ' + data[i].symbol + '</span>';

					element.querySelector('.current_price').innerHTML = '<strong>' + amount_result + ' €</strong> <span class="asset_amount symbol text-uppercase">' + asset_amount + ' ' + data[i].symbol + '</span>';
					element.querySelector('.trade_options').innerHTML = '<a href="./trade.php?asset=' + data[i].id + '&type=sell" class="btn btn-primary btn-asset">Vender</a> <a href="./trade.php?asset=' + data[i].id + '" class="btn btn-primary btn-asset d-none d-md-inline-block">Comprar</a>';


				}
			}
		}
	});

	document.querySelector('#wallet-total').innerHTML = wallet_total.toFixed(2) + ' €';
}

var table_userWallets = document.querySelector('#table-user-wallets');
if (typeof (table_userWallets) != 'undefined' && table_userWallets != null) {
	oReq.addEventListener("load", reqListenerWallets);
	oReq.open("GET", "https://api.coingecko.com/api/v3/coins/?include_platform=false");
	oReq.send();
}



//
var conversion_to_usd = document.querySelectorAll('.conversion_to_usd');
conversion_to_usd.forEach(function (e) {
	if (currency_fiat_selected == "usd") {
		var amount_usd = e.innerHTML * 1.13;
		e.innerHTML = 'US$ ' + amount_usd.toFixed(2);
		e.classList.remove('collapse')
	}
});


// var table_hover_array = document.querySelectorAll('.table.table-hover');
// table_hover_array.forEach(element => function () {
// 	console.log(element);
// 	var table_hover_tr_array = element.querySelectorAll('tbody tr');
// 	table_hover_tr_array.forEach(element => function () {
// 		console.log('table_hover_array_tr');
// 		table_hover_tr_array.addEventListener('click', function () {
// 			if (window.outerWidth <= 767) {
// 			}
// 		});
// 	});
// });