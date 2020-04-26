<?
require "connection.php";
session_start();

if (!isset($_SESSION['userLogin'])) {
	echo "<meta http-equiv='refresh' content='0;auth.php'>";
}

$customersNameAndCardId = array();

//Сразу забираем покупателей
$selectCustomers = mysqli_query($link, "SELECT * FROM `customers` ORDER BY customers.`customerId`;");
$selectCards = mysqli_query($link, "SELECT cards.`cardId`, `customerName`, `customerSurname`, cards.`purchaseAmount`, cards.`sale%` FROM `customers`, `cards` WHERE customers.`cardId` = cards.`cardId` ORDER BY cards.`cardId`;");
//$selectCards = mysqli_query($link, "SELECT cards.`cardId`, cards.`purchaseAmount`, cards.`sale%` FROM `cards` ORDER BY cards.`cardId`;");
$selectProducts = mysqli_query($link, "SELECT * FROM `products` ORDER BY products.`productId`;");
?>

<!DOCTYPE html>
<html>
<head>
	<title>LevLoyality - система учета скидок</title>
	<meta charset="utf-8">
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="styles/style_count.css">
	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Fira+Sans&display=swap" rel="stylesheet"> 
</head>
<body>

<div class="wrapper">

	<header>

		<a href="count.php" class="LL">LL<span>OYALITY&reg</span></a>
		<!-- <p class="LEVLoyality">LEVLoyality<span>&reg</span></p> -->
		<a href="logout.php"><img src="icons/logOut (2).png"></a>
		
	</header>

	<div class="wrapper2">

		<div class="content">
			
			<div class="select">
				<ul class="select">
					<li><a class="select">Покупатели</a></li>
					<li><a class="select">Карты</a></li>
					<li style="margin-bottom: unset;"><a class="select">Товары</a></li>
				</ul>
			</div>

			<div class="mainContent">
				<form action="" method="POST">

				<div class="buttonsCustomers">
					<a href="addCustomer.php" class="add" style="margin-left: unset;">Добавить</a>
					<input type="submit" class="delete" value="Удалить" name="deleteCustomerButton">
					<a class="change">Изменить</a>
					<a class="buy" href="index.php">Купить</a>
				</div>

				<div class="buttonsProducts">
					<a href="addProducts.php" class="add" style="margin-left: unset;">Добавить</a>
					<input type="submit" class="delete" value="Удалить" name="deleteProductButton">
					<a class="change">Изменить</a>
					<a class="buy" href="index.php">Купить</a>
				</div>

				<!-- Таблица покупателей -->
				<table border="1px solid black" cellpadding="10px" cellspacing="10px" class="customers">
					
					<tr style="margin-top: 10px;">
						<th>Выберите</th>
						<th>Имя</th>
						<th>Фамилия</th>
						<th>Телефон</th>
						<th>Электронная почта</th>
						<th>Возраст</th>
						<th>Номер карты</th>
					</tr>
										
					<tbody align="center" valign="middle">
					<?
					while ($selectCustomersResult = mysqli_fetch_row($selectCustomers)) {
						$customersNameAndCardId[$selectCustomersResult[0]] = $selectCustomersResult[6];
						?>
						<tr>
							<td><input type="checkbox" value="<?echo $selectCustomersResult[0];?>" name="deleteCustomer[]"></td>
							<td><? echo $selectCustomersResult[1]; ?></td>
							<td><? echo $selectCustomersResult[2]; ?></td>
							<td><? echo $selectCustomersResult[3]; ?></td>
							<td><? echo $selectCustomersResult[4]; ?></td>
							<td><? echo $selectCustomersResult[5] . ' лет'; ?></td>
							<td><? echo $selectCustomersResult[6]; ?></td>
						</tr>
						<?
					}
					?>
					</form>				
					</tbody>

				</table>

				<?
				if (isset($_POST['deleteCustomerButton'])) {
					$checkBoxGroupCustomers = $_POST['deleteCustomer'];
					if(empty($checkBoxGroupCustomers)) {
						echo "Ничего не выбрано!";
					}
					else if (!empty($checkBoxGroupCustomers)) {
						for ($i=0; $i < count($checkBoxGroupCustomers); $i++) {
							$queryCustomerDelete = mysqli_query($link, "DELETE FROM `customers` WHERE customers.`customerId` = '$checkBoxGroupCustomers[$i]';");
							$temp = $checkBoxGroupCustomers[$i];
							$queryCardsDelete = mysqli_query($link, "DELETE FROM `cards` WHERE cards.`cardId` = '$customersNameAndCardId[$temp]';");
						}
					}
					echo "<meta http-equiv='refresh' content='1;count.php'>";
				}
				?>
				
				<!-- Таблица карт -->
				<table border="1px solid black" cellpadding="10px" cellspacing="10px" class="cards">
					
					<tr style="margin-top: 10px;">
						<th>Номер карты</th>
						<th>Держатель карты</th>
						<th>Общая сумма покупок</th>
						<th>Процент скидки по карте</th>
					</tr>
										
					<tbody align="center" valign="middle">

					<?
					while ($selectCardsResult = mysqli_fetch_row($selectCards)) {
						?>
						<tr>
							<td><? echo $selectCardsResult[0]; ?></td>
							<td><? echo $selectCardsResult[1] . ' ' . $selectCardsResult[2]; ?></td>
							<td><? echo $selectCardsResult[3] . ' руб.'; ?></td>
							<td><? echo $selectCardsResult[4] . '%'; ?></td>
						</tr>
						<?
					}
					?>				
					</tbody>

				</table>

				<!-- Таблица товаров -->
				<table border="1px solid black" cellpadding="10px" cellspacing="10px" class="products">
					
					<tr style="margin-top: 10px;">
						<th>Выберите</th>
						<th>Название</th>
						<th>Стоимость</th>
					</tr>
										
					<tbody align="center" valign="middle">

					<?
					while ($selectProductsResult = mysqli_fetch_row($selectProducts)) {
						?>
						<tr>
							<td><input id="delProduct <? echo $selectProductsResult[0]; ?>" type="checkbox" value="<?echo $selectProductsResult[0];?>" name="deleteProduct[]"></td>
							<td><label for='delProduct <? echo $selectProductsResult[0]; ?>'><? echo $selectProductsResult[1]; ?></label></td>
							<td><label for='delProduct <? echo $selectProductsResult[0]; ?>'><? echo $selectProductsResult[3]  . ' руб.'; ?></label></td>
						</tr>
						<?
					}
					if (isset($_POST['deleteProductButton'])) {
						$checkBoxGroupProducts = $_POST['deleteProduct'];
						if(empty($checkBoxGroupProducts)) {
							echo "Ничего не выбрано!";
						}
						else if (!empty($checkBoxGroupProducts)) {
							for ($i=0; $i < count($checkBoxGroupProducts); $i++) {
								$queryCustomerDelete = mysqli_query($link, "DELETE FROM `products` WHERE products.`productId` = '$checkBoxGroupProducts[$i]';");
							}
						}
						echo "<meta http-equiv='refresh' content='1;count.php'>";
						}
					?>				
					</tbody>

				</table>

				<!-- Таблица заказов -->
				<table border="1px solid black" cellpadding="10px" cellspacing="10px" class="orders">
					
					<tr style="margin-top: 10px;">
						<th>Название</th>
						<th>Стоимость</th>
					</tr>
										
					<tbody align="center" valign="middle">

					<?
					while ($selectProductsResult = mysqli_fetch_row($selectProducts)) {
						?>
						<tr>
							<td><input id="delProduct <? echo $selectProductsResult[0]; ?>" type="checkbox" value="<?echo $selectProductsResult[0];?>" name="deleteProduct[]"></td>
							<td><label for='delProduct <? echo $selectProductsResult[0]; ?>'><? echo $selectProductsResult[1]; ?></label></td>
							<td><label for='delProduct <? echo $selectProductsResult[0]; ?>'><? echo $selectProductsResult[3]  . ' руб.'; ?></label></td>
						</tr>
						<? } ?>				
					</tbody>

				</table>

			</div>

		</div>

	</div>

</div>
<script type="text/javascript" src="scripts/script_count.js"></script>
</body>
</html>