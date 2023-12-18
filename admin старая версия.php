<?php
session_start(); // Инициализация сессии

// Проверка, авторизован ли пользователь и является ли он администратором
if (!isset($_SESSION['login']) || $_SESSION['status'] != 10) {
    header("Location: indexx.php"); // Если не авторизован или не является администратором, перенаправляем на страницу входа
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

// Получение списка пользователей из базы данных
$sql = "SELECT Login, Status FROM Baza";
$result = $conn->query($sql);
$users = array();

$conn->close();
?>

<!-- Остальной HTML-код страницы -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<title>MOUNTAINS</title>
    <link rel="stylesheet" type="text/css" href="avtoriz.css">
  </head>
  <body>
  <form style="width:400px; padding:20px; border-radius:50px;  " name="reg" >

    <!-- Кнопка "Назад" -->
    <a href="cabinet.php">
        <button style=" width:400px; align:center; padding:9px; " type="button">Назад</button>
    </a>
    <br><br>
   <!-- Таблица пользователей -->
    <table style=" text-align:center; " border="1">
    <thead>
        <tr>
            <th style='text-align: center;' >Логин</th>
            <th style='text-align: center;' >Статус</th>
			<th style='text-align: center;'>Права</th>
			<th style='text-align: center;'>Удаление</th>
        </tr>
    </thead>


<?php
	$connection =  mysqli_connect($servername, $username, $password) or die('Невозможно подключиться к серверу');
    mysqli_select_db($connection, $dbname) or die('А нет такой таблицы');
    $rows = mysqli_query($connection, "SELECT * FROM Baza WHERE Login = '" . $_SESSION['Login'] . "'");
    $data = mysqli_fetch_array($rows);
	$rows = mysqli_query($connection, "SELECT * FROM Baza");
    while ($data = mysqli_fetch_array($rows))
	{
        $editText = $data['Status'] == 10 ? 'Сделать пользователем' : 'Сделать администратором';
        $editQuery = $data['Status'] == 10 ? 'makeUser' : 'makeAdmin';
        echo "<tr style='text-align: center; padding: 2 '>";
        echo "<td style='text-align: center; font-size:10pt; padding: 0.5rem'>" . $data['Login'] . "</td>";
        echo "<td style='text-align: center; font-size:10pt; padding: 0.5rem'>" . $data['Status'] . "</td>";
        echo "<td style='text-align: center; font-size:10pt; padding: 0.5rem'><a href='./editUser.php?id=" . $data['ID'] . "&edit=" . $editQuery . "'>" . $editText . "</a></td>";
        echo "<td style='text-align: center; font-size:10pt; padding:0.5rem'><a href='./deleteUser.php?id=" . $data['ID'] . "'>Удалить</a></td>";
        echo "</tr>";
    }
     echo '</table>';
?>
       </form>
</body>
</html>
