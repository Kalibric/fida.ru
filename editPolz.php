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
	$connection =  mysqli_connect($servername, $username, $password, $dbname) or die('Невозможно подключиться к серверу');

// Проверка подключения к базе данных
if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}


// Получение информации о пользователе из базы данных
$login = $_SESSION['login'];

$stmt = $conn->prepare("SELECT Familia, Name, Otch, Password, Status FROM Baza WHERE Login = ?");
$stmt->bind_param("s", $login);
$stmt->execute();
$stmt->bind_result($name1, $name2, $name3, $password, $status);
$stmt->fetch();

// Сохранение статуса пользователя в сессии
$_SESSION['status'] = $status;
 $password=$_SESSION['password'];


if(isset($_POST['editPolz'])){

	$upname1 = mysqli_real_escape_string($connection, $_POST['oldname1']);
	$upname2 = mysqli_real_escape_string($connection, $_POST['oldname2']);
	$upname3 = mysqli_real_escape_string($connection, $_POST['oldname3']);

	mysqli_query($connection, "UPDATE Baza SET Familia = '$upname1',
	Name = '$upname2', Otch = '$upname3'  WHERE Login = '$login'")
	or die ('query failed');

	$old_pas = $password;
	$update_pas = mysqli_real_escape_string($connection,$_POST['update_pas']);
	$new_pas = mysqli_real_escape_string($connection,$_POST['new_pas']);
	$confirm_pas = mysqli_real_escape_string($connection, $_POST['confirm_pas']);

	mysqli_query($connection, "UPDATE Baza SET Password = '$confirm_pas' WHERE Login = '$login'")
		or die ('query failed');
	}
	header('Location: '.$_SERVER['REQUEST_URI']);

$stmt->close();
$conn->close();

 ?>
 <!DOCTYPE html>
<html>
<head>
    <title>Редактирование</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<img style = "width:300px; height: 60px" src="images/лог.jpg" > <br>
<div class="container">
    <div class="row">
        <div class="col-sm-3">
        </div>
        <div class="col-sm-6">

     <form action="" method="POST" enctype='multipart/form-data'>
  <div class="login_form">

 <br>

     <form method="post" enctype='multipart/form-data' action="">
          <div class="row">
            <div class="col"></div>
           <div class="col-6">
            <center>
           <?php if($image==NULL)
                {
                 echo '<img style="height:80px;width:auto;border-radius:50%;" src="images/avto.jpg">';
                } else { echo '<img src="images/'.$image.'" style="height:80px;width:auto;border-radius:50%;">';}?>
<div class="form-group">

            </div>

  </center>
           </div>
            <div class="col"><p><a href="cabinet.php"><span style="color:reds;">Назад</span> </a></p>
         </div>
          </div>

          <div class="form-group">
          <div class="row">
            <div class="col-3">
                <label>Фамилия</label>
            </div>
             <div class="col">
                <input type="text" name="oldname1" value="<?php echo $name1;?>" class="form-control">
            </div>
          </div>
      </div>
      <div class="form-group">
 <div class="row">
            <div class="col-3">
                <label>Имя</label>
            </div>
             <div class="col">
                <input type="text" name="oldname2" value="<?php echo $name2;?>" class="form-control">
            </div>
          </div>
      </div>
      <div class="form-group">
 <div class="row">
            <div class="col-3">
                <label>Отчество</label>
            </div>
             <div class="col">
                <input type="text" name="oldname3" value="<?php echo $name3;?>" class="form-control">
            </div>
          </div>
      </div>
	     <div class="form-group">
 <div class="row">
            <div class="col-3">
			<input type="hidden" name="old_pas" value="<?php echo $password; ?>" class="form-control">
                <label>Старый пароль</label>
            </div>
             <div class="col">
                <input type="password" id="update_pas" name="update_pas" placeholder = "Введите старый пароль" class="form-control">
            </div>
          </div>
      </div>
	   <div class="form-group">
 <div class="row">
            <div class="col-3">
                <label>Новый пароль</label>
            </div>
             <div class="col">
                <input type="password" id="new_pas" name="new_pas" placeholder = "Введите новый пароль" class="form-control">
            </div>
          </div>
      </div>
	   <div class="form-group">
 <div class="row">
            <div class="col-3">
                <label>Повтор пароля</label>
            </div>
             <div class="col">
                <input type="password" id="confirm_pas" name="confirm_pas" placeholder = "Повторите пароль" class="form-control">
            </div>
          </div>
      </div>

           <div class="row">
			<div class="col-sm-6"></div>
            <div class="col-sm-6">
<button  name="editPolz" type="submit" class="btn btn-success" >Сохранить</button>
            </div>
           </div>
       </form>
        </div>
        <div class="col-sm-3">
        </div>
    </div>
	<?php echo $error;

	?>
</div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
</html>
