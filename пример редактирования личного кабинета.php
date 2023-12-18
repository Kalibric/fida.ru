<?php
session_start(); // Инициализация сессии

// Проверка, авторизован ли пользователь
if (!isset($_SESSION['login'])) {
    header("Location: login.php"); // Если не авторизован, перенаправляем на страницу входа
    exit();
}

// Подключение к базе данных
$servername = "llocalhost";
$username = "root";
$password = "";
$dbname = "mountain";
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка подключения к базе данных
if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}

// Получение информации о пользователе из базы данных
$login = $_SESSION['login'];

$stmt = $conn->prepare("SELECT Familia, Name, Otch, Status FROM Baza WHERE Login = ?");
$stmt->bind_param("s", $login);
$stmt->execute();
$stmt->bind_result($name1, $name2,$name3, $status);
$stmt->fetch();

// Сохранение статуса пользователя в сессии
$_SESSION['status'] = $status;

$stmt->close();
$conn->close();




?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<title>MOUNTAINS</title>
    <link rel="stylesheet" type="text/css" href="avtoriz.css">
  </head>
  <body>
  <form action="" method="POST">
	<input name="name" value="<?=
		$name2 ?>">
	<input name="surname" value="<?=
		$name1 ?>">
	<input type="submit" name="submit">
</form>>
<?php

	$connection =  mysqli_connect($servername, $username, $password) or die('Невозможно подключиться к серверу');
    mysqli_select_db($connection, $dbname) or die('А нет такой таблицы');
	if (!empty($_POST['submit'])) {
		$name2 = $_POST['name2'];
		$name1 = $_POST['name1'];


		mysqli_query($connection, "UPDATE Baza SET Name='$name2',
			Familia='$name1' WHERE Login='" . $_SESSION['Login'] . "'");
	}
?>
</body>
</html>
