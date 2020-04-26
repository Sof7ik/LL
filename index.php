<?
session_start();
if (empty($_SESSION['basket'])) {
	$basket = [];
	$_SESSION['basket'] = $basket;
}
require 'connection.php';
$query = mysqli_query($link, "SELECT `catId`, categories.`catName`, `catImage` FROM `categories`;");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Покупка - Бургерная у Ашота</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="styles/style_buy.css">
	<link href="https://fonts.googleapis.com/css?family=Fira+Sans&display=swap" rel="stylesheet"> 
</head>
<body>

<div class="wrapper">

	<a href="count.php">LEVLoyality</a>

	<div class="content">
	
		<?
		while ($queryResult = mysqli_fetch_assoc($query)) {
			?>
			<a class="category" href="product.php?id=<? echo $queryResult['catId']; ?>">
				<div class="category">
					<p class="title"><? echo $queryResult['catName']; ?></p>
					<img src="img/categories/<?echo $queryResult['catImage'];?>.png">
				</div>
			</a>
			<?
		}
		?>

	</div>

</div>

</body>
</html>