<?php
require_once "db.php";
session_start();

if (!isset($_SESSION["ID"]))
{
  header("Location: login.php");
  exit();
}

$user = getUser($conn, $_SESSION["ID"]);
if ($user)
{
  $_SESSION["status"] = $user["status"];
}
else
{
  session_destroy();
  header("Location: login.php");
  exit();
}
?>
<!DOCTYPE html>

<html lang="en">

<head>
   <!-- basic -->
   <title> Личный кабинет</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <!-- mobile metas -->
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="viewport" content="initial-scale=1, maximum-scale=1">
   <!-- site metas -->
   <title>MOUNTAINS</title>
   <!-- bootstrap css -->
   <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
   <!-- style css -->
   <link rel="stylesheet" type="text/css" href="css/style.css">
   <!-- Responsive-->
   <link rel="stylesheet" href="css/responsive.css">
   <!-- fevicon -->
   <link rel="icon" href="images/fevicon.png" type="image/gif" />
   <!-- Scrollbar Custom CSS -->
   <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
   <!-- Tweaks for older IEs-->
   <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
   <!-- fonts -->
   <link href="https://fonts.googleapis.com/css?family=Poppins:400,700|Righteous&display=swap" rel="stylesheet">
   <!-- owl stylesheets -->
   <link rel="stylesheet" href="css/owl.carousel.min.css">
   <link rel="stylesheet" href="css/owl.theme.default.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css"
      media="screen">
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

  <p> Добро пожаловать,<br> <span style="color:blue"><?php echo $user["Familia"] . ' ' . $user["Name"] . '!' ?></span> </p>
  </center>
           </div>
            <div class="col"><p><a href="logout.php"><span style="color:red;">Выйти</span> </a></p>
         </div>
          </div>
          <div class="cabinetHeader">
            <a href="cabinet.php" class="active">Личный кабинет</a>
            <a href="tours.php">Туры</a>
          </div>

          <table class="table">
          <tr>
              <th>Фамилия </th>
              <td><?php echo $user["Familia"]; ?></td>
          </tr>
          <tr>
              <th>Имя</th>
              <td><?php echo $user["Name"]; ?></td>
          </tr>
          <tr>
              <th>Отчество</th>
              <td><?php echo $user["Otch"]; ?></td>
          </tr>
           <tr>
              <th>Логин</th>
              <td><?php echo $user["Login"]; ?></td>
          </tr>
		  <tr>
              <th>Статус</th>
              <td><?php if ($user["Status"] == 1) {
    echo "<p>Обычный пользователь</p>";
}
elseif ($user["Status"] == 5) {
  echo "<p>Сотрудник</p>";
  echo '<p style=" padding: 6px"><a href="toursCheck.php" >Страница сотрудника</a></p>';
} elseif ($user["Status"] == 10) {
    echo "<p>Администратор</p>";

    // Вывод кликабельного текста "Страница администратора"
    echo '<p style=" padding: 6px"><a href="admin.php" >Страница администратора</a></p>';
} ?></td>
          </tr>
          </table>
           <div class="row">
            <div class="col-sm-2">
            </div>
             <div class="col-sm-4">
                <a href="editPolz.php"><button type="button" class="btn btn-primary">Редактировать</button></a>
            </div>
            <div class="col-sm-6">
         <a href="changePass.php"><button type="button" class="btn btn-warning">Поменять пароль</button></a>
            </div>
           </div>
        </div>
        <div class="col-sm-3">
        </div>
    </div>
</div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
</html>
