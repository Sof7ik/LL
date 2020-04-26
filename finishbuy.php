<?
session_start();
require 'connection.php';
$purchase = [];
if (empty($_SESSION['basket'])) {
	$basket = [];
	$_SESSION['basket'] = $basket;
}
$baskets = $_SESSION['basket'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Покупка - Бургерная у Ашота</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="styles/style_finishBuy.css">
	<link href="https://fonts.googleapis.com/css?family=Fira+Sans&display=swap" rel="stylesheet">
</head>
<body>

	<div class="wrapper">
		<a href="count.php">LEVLoyality</a>
		<div class="content">
		<?
		if(!empty($baskets)){
		for ($i=0;$i<count($baskets);$i++) {
		$query = mysqli_query($link, "SELECT * FROM `products` WHERE productId='$baskets[$i]';");
		$queryResult = mysqli_fetch_assoc($query);
		$price= $price + $queryResult['productPrice'];
		?>
				<div class="category">
					<h1 class="title"><? echo $queryResult['productName']; ?></h1>
					<img src="img/food/<?echo $queryResult['productImage']; ?>.png">
					<p class="title"><? echo $queryResult['productPrice']; ?> рублей</p>
				</div>
		<? }} ?>
				<a href="index.php" class="addProduct">
					<div class="category" style="margin-right: unset;">
						<h1 class="addProduct">+</h1>
						<h1>Добавить товар</h1>
					</div>
				</a>
		</div>
			
				<form action="" method="POST">
				
					<div class="middleInfo">
						<div class="middleContent">
							<h2>Cумма заказа без скидки</h2>
							<p id="price"><? echo $price; ?> рублей</p>
						</div>
							
						<div class="middleContent">
							<h2>Введите номер карты хумана</h2>
							<input type="number" name="idCard" id="card">
							<p>Размер скидки (с учетом стоимости заказа)</p>
							<p class="salePerCent"></p>
							<input type="button" value="Посчитать скидку" id="countSale">
							<p>Скидка</p>
							<p class="sale"></p>
						</div>
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
			var orderAmount = document.getElementById('price') //сумма заказа
			document.getElementById('countSale').addEventListener('click', function () {
				for (var i = 0; i < arr.length; i++) {
					if (cardNumber.value == arr[i][0]) {
						p.textContent = arr[i][2] + '%';
						var counter = 1;
						// Высчитываем сумму с учетом скидки
						if (parseInt(p.textContent) != 0){
							var price = Math.round(parseInt(orderAmount.textContent) / parseInt(p.textContent))
						}
						else{
							var price = parseInt(p.textContent);
						}
						document.querySelector('p.sale').textContent = price + ' рублей';
						document.querySelector('input.finishPrice').value = parseInt(orderAmount.textContent) - parseInt(price); //итоговая цена
					}	
				}

				if (counter != 1) {
					p.textContent = 0 + '%. Такой карты не существует!';
					document.querySelector('input.finishPrice').value = <? echo $price;?>;
					document.querySelector('p.sale').textContent = 0 + ' рублей';
					//console.log('Нет такой карты')
				}
				
				// если сумма заказа больше 2000 рублей, то накидываем еще 2% сверху (к карте, если она указана)
				if (parseInt(orderAmount.textContent) > 2000) {
					var sale = parseInt(p.textContent) + 2
					price = Math.round(parseInt(orderAmount.textContent) /100 * parseInt(sale))
					p.textContent = sale + '%';
					document.querySelector('p.sale').textContent = price + ' рублей';
					// Высчитываем сумму с учетом скидки
					document.querySelector('input.finishPrice').value = parseInt(orderAmount.textContent) - parseInt(price); //итоговая цена
				}
			})
			
			
		</script>

		<div class="buy">
					<h1>Итоговая сумма заказа</h1>
					
					<input type="tel" class="finishPrice" name="finishPrice" value="<?echo $price;?>">
					<?
					$price = $_POST['finishPrice'];
					?>
				</div>

				<input type="submit" name="submit" value="Заказать" class="submit">

				<input type="submit" name="resetOrderArray" value="Отменить заказ" class="submit" style="background-color: red">
			</form>

			<?
			if (isset($_POST['resetOrderArray'])) {
				$basket = [];
				$_SESSION['basket'] = $basket;
				echo "<meta http-equiv='refresh' content='0;finishbuy.php'>";
			}
		/* Скрипт скидки */		if (isset($_POST['submit'])) {
					$idCard = $_POST['idCard'];
					for ($i=0;$i<count($baskets);$i++){
						$query2 = mysqli_query($link,"SELECT purchaseAmount FROM cards WHERE cardId='$idCard';");
						$queryResult2 = mysqli_fetch_assoc($query2);
						$query = mysqli_query($link, "SELECT * FROM `products` WHERE productId='$baskets[$i]';");
						$queryResult = mysqli_fetch_assoc($query);
						$price2 = $queryResult['productPrice'];
						$createOrder = mysqli_query($link, "INSERT INTO `orders` (`orderId`, `orderDate`, `productId`, `orderAmount`) VALUES (NULL, NOW(), '$baskets[$i]', '$price2');");
						$sum = $queryResult2['purchaseAmount'] + $price2;
						$updateBase = mysqli_query($link, "UPDATE `cards` SET purchaseAmount='$sum' WHERE cardId='$idCard';");
						}
						$s1 = 5;
						$s2 = 10;
						$s3 = 15;
						if ($sum >= 5000){
							$updateBaseSale = mysqli_query($link, "UPDATE `cards` SET `sale%`='$s1' WHERE cardId='$idCard';");
							if ($sum >= 10000){
								$updateBaseSale2 = mysqli_query($link, "UPDATE `cards` SET `sale%`='$s2' WHERE cardId='$idCard';");
								if ($sum >= 15000){
									$updateBaseSale3 = mysqli_query($link, "UPDATE `cards` SET `sale%`='$s3' WHERE cardId='$idCard';");
								}
							}
						}
						$basket = [];
						$_SESSION['basket'] = $basket;
						echo "<meta http-equiv='refresh' content='0;index.php'>";
				}
			?>
		</div>

		

	</div>

</body>
</html>