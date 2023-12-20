<?php
require_once "db.php";
require_once "Status.php";
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
if ($user["Status"] != 10)
{
  header("Location: login.php");
  exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title> Личный кабинет</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-1">

        </div>
        <div class="col-sm-12">
  <div class="login_form">

          <div class="row">
            <div class="col"></div>
           <div class="col-6">
             <?php
             if(isset($_GET['profile_updated']))
             {
             ?>
              <div class="successmsg">Profile saved ..</div>
             <?php
             }

             if(isset($_GET['password_updated']))
             {
             ?>
              <div class="successmsg">Password has been changed...</div>
             <?php
             }
             ?>
              <center>
             <?php
             if($image==NULL)
               echo '<img style="height:80px;width:auto;border-radius:50%;" src="images/avto.jpg">';
             else
               echo '<img src="images/'.$image.'" style="height:80px;width:auto;border-radius:50%;">'
             ?>

              <p> Добро пожаловать,<br> <span style="color:blue"><?php echo $user["Familia"] . ' ' . $user["Name"] . '!' ?></span> </p>
              </center>
                       </div>
                        <div class="col"><p><a href="logout.php"><span style="color:red;">Выйти</span> </a></p>
                     </div>
                      </div>
                      <div class="cabinetHeader">
                        <a href="admin.php">Пользователи</a>
                        <a href="toursCheck.php" class="active">Одобрение туров</a>
                      </div>

                      <table class="table">
            		  <tr><tr>
                        <th style='text-align: center;' >Название тура</th>
                        <th style='text-align: center;' >Тип тура</th>
                        <th style='text-align: center;' >Пользователь</th>
            			<th style='text-align: center;'>Цена</th>
            			<th style='text-align: center;'>Запланированная дата</th>
                        <th style='text-align: center;'>Связь</th>
                        <th style='text-align: center;'>Одобрить</th>
                        <th style='text-align: center;'>Отказать</th>
                    </tr>
            		 <?php
                 $sql = $conn->prepare("SELECT *, TouristBookings.Status AS 'TourStatus', TouristBookings.Price AS 'TourPrice', TouristBookings.ID AS 'TourIDMes' FROM TouristBookings INNER JOIN Tours ON Tours.ID=TouristBookings.TourID INNER JOIN Baza ON Baza.ID=TouristBookings.UserID WHERE TouristBookings.Status=0");
                 $sql->execute();
                 $users = $sql->fetchAll();
                 foreach ($users as $key => $value)
                 {
                   echo "<tr style='text-align: center; padding: 2 '>";
                   echo "<td style='text-align: center; font-size:10pt; padding: 0.5rem'>" . $value['Title'] . "</td>";
                   echo "<td style='text-align: center; font-size:10pt; padding: 0.5rem'>" . $status[$value["TourStatus"]]["name"] . "</td>";
                   echo "<td style='text-align: center; font-size:10pt; padding: 0.5rem'><a href='user.php?ID=" . $value['ID'] . "'>{$value['Name']}</a></td>";
                   echo "<td style='text-align: center; font-size:10pt; padding:0.5rem'>" . $value['TourPrice'] . "</td>";
                   echo "<td style='text-align: center; font-size:10pt; padding:0.5rem'>" . $value['DateTour'] . "</td>";
                   echo "<td style='text-align: center; font-size:10pt; padding: 0.5rem'><a href='message.php?ID=" . $value['TourIDMes'] . "'>Сообщения</a></td>";
                   echo "<td style='text-align: center; font-size:10pt; padding: 0.5rem'><a href='approve.php?ID=" . $value['TourIDMes'] . "'>Одобрить</a></td>";
                   echo "<td style='text-align: center; font-size:10pt; padding: 0.5rem'><a href='deny.php?ID=" . $value['TourIDMes'] . "'>Отказать</a></td>";
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
