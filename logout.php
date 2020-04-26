<?
session_start();
session_destroy();
unset($_SESSION['userLogin']);
unset($_SESSION['userRole']);
echo "<meta http-equiv='refresh' content='0;index.php'>";
?>