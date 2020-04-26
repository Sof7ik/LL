<?
session_start();
require 'connection.php';
if (empty($_SESSION['basket'])) {
	$basket = [];
	$_SESSION['basket'] = $basket;
}
$catId = $_GET['id'];
$query = mysqli_query($link, "SELECT products.`productId`, `productName`, `productImage`, `productPrice`, productcategory.`catId` FROM `products`, `productcategory` WHERE productcategory.`catId` = $catId AND products.`productId` = productcategory.`productId`;");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Покупка - Бургерная у Ашота</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="styles/style_buy.css">
	<link href="https://fonts.googleapis.com/css?family=Fira+Sans&display=swap" rel="stylesheet"> 
	
	<style>
		div.category {
			margin-right: 2%;
			display: flex;
			flex-flow: column;
			align-items: center;
			justify-content: flex-start;
			border: 2px solid black;
			border-radius: 5px;
			padding: 10px;
		}
	</style>

</head>
<body>

<div class="wrapper">

	<a href="count.php">LEVLoyality</a>
	<a class="back" href="index.php">НАЗАД<img src="/icons/back.png"></a>

	<div class="content">	
			<?
			while ($queryResult = mysqli_fetch_assoc($query)) {
				?>
				<form action="" method="POST">
					<div class="category" style="margin-right: unset">
						<input type="text" class="hiddenInput" name="id" value="<? echo $queryResult['productId']; ?>">
						<p class="title"><? echo $queryResult['productName']; ?></p>
						<img src="img/food/<?echo $queryResult['productImage']?>.png">
						<p class="title" style="margin-top: 7%;"><? echo $queryResult['productPrice'] . ' рублей'; ?></p>
						<input type="submit" style="padding: 5px 20px; margin-top: 10%;" name="buy" value="добавить">
					</div>
				</form>
				<?
			}
			if(isset($_POST['buy'])){
				$kypit=$_POST['id'];
				array_push($_SESSION['basket'], $kypit);
				echo "<meta http-equiv='refresh' content='0;finishbuy.php'>";
			} 
			?>
	</div>

</div>

</body>
</html>