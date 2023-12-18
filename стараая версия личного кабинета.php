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
  <form style="width:400px; padding:20px; border-radius:50px; "  name="reg" >
  <?php
  // Вывод информации о пользователе
echo "<h1 >Личный кабинет</h1>";
echo "<p style=' padding: 6px'>Фамилия: $name1</p>";
echo "<p style=' padding: 6px'>Имя: $name2</p>";
echo "<p style=' padding: 6px'>Отчество: $name3</p>";
echo "<p style=' padding: 6px'>Логин: $login</p>";
// Вывод статуса пользователя
if ($status == 1) {
    echo "<p style=' padding: 6px'>Статус: Обычный пользователь</p>";
} elseif ($status == 10) {
    echo "<p style=' padding: 6px'>Статус: Администратор</p>";

    // Вывод кликабельного текста "Страница администратора"
    echo '<p style=" padding: 6px"><a href="admin.php" >Страница администратора</a></p>';
}
?>

    <!-- Кнопка "Выход" -->
    <a href="logout.php">
        <button style="width:400px; padding:9px; border-radius:50px; " type="button">Выйти</button>
    </a>
	</formz>
</body>
</html>
