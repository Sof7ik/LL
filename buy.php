<!DOCTYPE html>
<html>
<head>
	<title>Покупка</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="styles/style_buy.css">
	<link href="https://fonts.googleapis.com/css?family=Fira+Sans&display=swap" rel="stylesheet">
	<style>
		input {
			font-size: 20px;
		}
	</style>
</head>
<body>

<div class="wrapper">

	<div>
		<h1>Введите номер карты хумана</h1>
		<input type="number" name="" id="card">
		<button id="show">Показать</button>
		<p>Размер скидки</p>
		<p class="salePerCent"></p>
	</div>

	<div>
		<h1>Введите сумму заказа</h1>
		<input type="number" name="" id="price">
	</div>
	<br>
	<button id="countSale">Посчитать скидку</button>
	<br>
	<br>
	<p>Скидка</p>
	<p class="sale"></p>
	<p>ИТОГО</p>
	<p class="finishPrice"></p>

</div>
<?
	require "connection.php";
	$selectCards = mysqli_query($link, "SELECT * FROM `cards`;");
?>

<script type="text/javascript">

	var cardNumber = document.getElementById('card') // инпут номер карты
	var button = document.getElementById('show') // кнопка показать скидку
	var p = document.querySelector('p.salePerCent') //поле для вывода скидки

	var arr=[];

<?
	while ($selectCardsResult = mysqli_fetch_assoc($selectCards)) {
		?>
			var cardId = "<?echo $selectCardsResult['cardId']?>"
			var cardPurchaseAmount = "<?echo $selectCardsResult['purchaseAmount']?>"
			var cardSale = "<?echo $selectCardsResult['sale%']?>"
			arr.push([cardId, cardPurchaseAmount, cardSale]);
		<? 
	}
	mysqli_free_result($selectCards);
?>

	button.addEventListener('click', function (event) {

	for (var i = 0; i < arr.length; i++) {
		if (cardNumber.value == arr[i][0]) {
			p.textContent = arr[i][2] + '%';
			var counter = 1;
		}	
	}

	if (counter != 1) {
			console.log('Нет такой карты')
		}
	})
	var orderAmount = document.getElementById('price') //сумма заказа
	document.getElementById('countSale').addEventListener('click', function () {
		// Высчитываем сумму с учетом скидки
		var price = Math.floor(parseInt(orderAmount.value) / parseInt(p.textContent))
		document.querySelector('p.sale').textContent = price + ' рублей';
		document.querySelector('p.finishPrice').textContent = orderAmount.value - price + ' рублей'; //итоговая цена
	})
	
	
</script>
</body>
</html>