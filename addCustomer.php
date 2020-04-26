<?
require 'connection.php';
session_start();
if (!isset($_SESSION['userLogin'])) {
    echo "<meta http-equiv='refresh' content='0;auth.php'>";
}
$selectCards = mysqli_query($link, "SELECT * FROM `cards`;");
$cardsIdd = [];
while ($selectCardsResult = mysqli_fetch_row($selectCards)) {
    array_push($cardsIdd,$selectCardsResult[0]);
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
        <?
        if ($query) {
            echo "human created successfully!!!";
        }
        ?>
        <h1>Введите данные покупателя</h1>
        <form method="POST" action="" id="form">
            <input type="text" class="textField" placeholder="Введите имя покупателя" required="" name="customerName" autocomplete="off">
            <input type="text" class="textField" placeholder="Введите фамилию покупателя" required="" name="customerSurname" autocomplete="off">
            <!--<input type="text" class="textField" placeholder="Введите номер Карты лояльности покупателя" required="" name="cardId" autocomplete="off"><!-->
            <input type="tel" class="textField" placeholder="Введите номер телефона покупателя без +, 11 цифр" name="telNumber" autocomplete="off" id="tel">
            <input type="email" class="textField" placeholder="Введите email покупателя" name="email" autocomplete="off">
            <input type="text"  class="textField" placeholder="Введите возраст покупателя" required="" style="margin-bottom: 1%"; name="age">
            <input type="submit" class="submit" value="Добавить покупателя" name="submit">
        </form>

        <script>
            document.querySelector('.submit').addEventListener('click', function () {
                var telLength = document.getElementById('tel').value
                if (telLength.length >= 12) {
                alert('В телефоне больше 11 цифр')
            }
            })
        </script>

        <?
        if (isset($_POST['submit'])) {
            $customerName = $_POST['customerName'];
            $customerSurname = $_POST['customerSurname'];
            /*$cardId = $_POST['cardId'];*/
            $cardId = end($cardsIdd)+1;
            $telNumber = $_POST['telNumber'];
            $email = $_POST['email'];
            $age = $_POST['age'];
            $query2 = mysqli_query($link, "INSERT INTO `cards`(purchaseAmount,`sale%`) VALUES (0,0);");
            $query = mysqli_query($link, "INSERT INTO `customers` 
                (`customerId`, 
                `customerName`,
                `customerSurname`, 
                `customerTel`,
                `customerEmail`, 
                `age`, 
                `cardId`)
                VALUES 
                (NULL,
                '$customerName',
                '$customerSurname',
                '$telNumber',
                '$email',
                '$age',
                '$cardId'
                );");
                if($query){
                    $query2 = mysqli_query($link, "INSERT INTO `cards`(purchaseAmount,`sale%`) VALUES (0,0);");
                    ?>
                    <script>
                        alert('Регистрация прошла успешно!');
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
                }
            }
        ?>
    </div>

</div>

</body>
</html>