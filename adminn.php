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
<html>
<head>
    <title> Личный кабинет</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-3">
            
        </div>
        <div class="col-sm-6">
  <div class="login_form">
     
          <div class="row">
            <div class="col"></div>
           <div class="col-6"> 
             <?php if(isset($_GET['profile_updated'])) 
      { ?>
    <div class="successmsg">Profile saved ..</div>
      <?php } ?>
        <?php if(isset($_GET['password_updated'])) 
      { ?>
    <div class="successmsg">Password has been changed...</div>
      <?php } ?>
            <center>
            <?php if($image==NULL)
                {
                 echo '<img style="height:80px;width:auto;border-radius:50%;" src="images/avto.jpg">';
                } else { echo '<img src="images/'.$image.'" style="height:80px;width:auto;border-radius:50%;">';}?> 

  <p> Добро пожаловать,<br> <span style="color:blue"><?php echo $name1 . ' ' . $name2 . '!' ?></span> </p>
  </center>
           </div>
            <div class="col"><p><a href="logout.php"><span style="color:red;">Выйти</span> </a></p>
         </div>
          </div>

          <table class="table">
		  <tr><tr>
            <th style='text-align: center;' >Логин</th>
            <th style='text-align: center;' >Статус</th>
			<th style='text-align: center;'>Права</th>
			<th style='text-align: center;'>Удаление</th>
        </tr>
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
        
         
        </div>
        <div class="col-sm-3">
        </div>
    </div>
</div> 
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
</html>