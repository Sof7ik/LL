<?
require 'connection.php';
session_start();

if (isset($_SESSION['userLogin'])) {
	if ($_SESSION['roleId'] == 1) {
		echo "<meta http-equiv='refresh' content='0;marketolog.php'>";
	}
	else 
		if ($_SESSION['roleId'] == 2) {
		echo "<meta http-equiv='refresh' content='0;count.php'>";
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Авторизация - LEVLoyality</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="styles/style_auth.css">
	<link href="https://fonts.googleapis.com/css?family=Fira+Sans&display=swap" rel="stylesheet"> 
</head>
<body>

<div class="wrapper">

	<div class="main">
		<h1>Авторизация</h1>

		<form method="POST" action="">
			<input class="text" name="login" type="text" placeholder="Логин" style="margin-top: unset;">
			<input class="text" name="password" type="text" placeholder="Пароль">
			<input type="submit" name="submit" value="ВОЙТИ" class="submit">
			<a href="index.php" class="submit">НАЗАД</a>
		</form>
	</div>

</div>

<?
$login = $_POST['login'];
$password = $_POST['password'];
$loginSubmit = $_POST['submit'];

if (isset($loginSubmit)) {
	$logIn = mysqli_query($link, "SELECT * FROM `users` WHERE `userLogin` = '$login' AND `userPass` = '$password';");
	$logInRes = mysqli_fetch_assoc($logIn);
	$rows = mysqli_num_rows($logIn);
	echo $rows;
	$basket = [];
	if ($rows == 1) {
		$_SESSION['userLogin'] = $logInRes['userLogin'];
		$_SESSION['userRole'] = $logInRes['roleId'];
		$_SESSION['basket'] = $basket;
		echo '<meta http-equiv="refresh" content="0;count.php">';
	}
	
}

?>

</body>
</html>