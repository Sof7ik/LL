<?
require 'connection.php';
session_start();
if (!isset($_SESSION['userLogin'])) {
    echo "<meta http-equiv='refresh' content='0;auth.php'>";
}
$selectProducts = mysqli_query($link, "SELECT * FROM `products`;");
$productsIdd = [];
while ($selectProductsResult = mysqli_fetch_row($selectProducts)) {
    array_push($productsIdd,$selectProductsResult[0]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Добавить покупателя - LEVLoyaliti&reg</title>
    <link rel="stylesheet" type="text/css" href="styles/style_add.css">
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

    <div class="addFields">
        <h1>Введите данные продукта</h1>
        <form method="POST" action="" id="form">
            <input type="text" class="textField" placeholder="Введите название продукта" required="" name="productName" autocomplete="off">
            <input type="text" class="textField" placeholder="Введите стоимость продукта" required="" name="productPrice" autocomplete="off">
            <input type="text" class="textField" placeholder="Введите категорию продукта" required="" name="productCategory" autocomplete="off">
            <input type="submit" class="submit" value="Добавить продукт" name="submit" style="margin-top: 2%;">
        </form>

        <?
        if (isset($_POST['submit'])) {
            $productName = $_POST['productName'];
            $productPrice = $_POST['productPrice'];
            $productCategory = $_POST['productCategory'];
            $productId = end($productsIdd) + 1;
            $query = mysqli_query($link, "INSERT INTO `products` 
                (`productId`, 
                `productName`,
                `productImage`,
                `productPrice`)
                VALUES 
                (NULL,
                '$productName',
                'noname', 
                '$productPrice'
                );");

                if($query){
                    $query2 = mysqli_query($link, "INSERT INTO `productcategory`(`catId`,`productId`) VALUES ('$productCategory','$productId');");
                    ?>
                    <script>
                        alert('Продукт добавлен успешно!');
                    </script>
                    <?
                    echo "<meta http-equiv='refresh' content='1;count.php'>";
                }
                else{
                    ?>
                    <script>
                        alert('Ошибка!');
                    </script>
                    <?
                    echo "<meta http-equiv='refresh' content='0;count.php'>";
                }
            }
        ?>
    </div>

</div>

</body>
</html>