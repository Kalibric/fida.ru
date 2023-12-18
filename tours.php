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
        <div class="col-sm-1">

        </div>
        <div class="col-sm-9">
  <div class="login_form">

    <div class="row justify-content-center">

     <div class="col-6 justify-content-center">
                           <center>
      <img style="height:80px;width:auto;border-radius:50%;" src="images/avto.jpg">
<p> История туров </p>
</center>
     </div>
      <div class="col justify-content-center" style="
display: flex;
align-items: center;
"><a href="http://fida.ru/services.html"><button type="button" class="btn btn-warning" style="vertical-align: middle;margin: 0 auto;">Выбрать тур</button></a>
   </div>
    </div>
          <div class="cabinetHeader">
            <a href="cabinet.php">Личный кабинет</a>
            <a href="tours.php" class="active">Туры</a>
          </div>
          <center style="padding-top: 30px;">
            <?php
            $sql = $conn->prepare("SELECT * FROM TouristBookings INNER JOIN Tours ON Tours.ID=TouristBookings.TourID WHERE UserID=:ID");
            $sql->execute([":ID" => $_SESSION["ID"]]);
            $result = $sql->fetchAll();
            if (count($result) == 0)
            {
              ?>
              <p>Вы ещё не заказывали туры :(</p>
              <?php
            }
            else
            {
              ?>
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Название тура</th>
                    <th scope="col">Тип тура</th>
                    <th scope="col">Цена(руб.)</th>
                    <th scope="col">Запланированная дата</th>
                    <th scope="col">Статус</th>
                    <th scope="col">Связь</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($result as $key => $value)
                  {
                    ?>
                    <tr>
                      <th scope="row"><?php echo $value["Title"] ?></th>
                      <td><?php echo $value["isIndividual"] ? "Индивидуальный" : "Обычный" ?></td>
                      <td><?php echo $value["Price"] ?></td>
                      <td><?php echo $value["DateTour"] ?></td>
                      <td><?php echo $status[$value["Status"]]["name"] ?></td>
                      <td><?php echo "Ссылка" ?></td>
                    </tr>
                    <?php
                  }
                  ?>

                </tbody>
              </table>

              <?php
            }
            ?>
          </center>
        </div>
        <div class="col-sm-3">
        </div>
    </div>
</div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
</html>
