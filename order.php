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

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
   if (isset($_POST["ID"]) && isset($_POST["access"]) && isset($_POST["date"]) && strtotime(date('d-m-Y', time())) < strtotime($_POST["date"]))
   {
      $sql = $conn->prepare("SELECT * FROM Tours WHERE ID=:ID LIMIT 1");
      $sql->execute([":ID" => $_POST["ID"]]);
      $result = $sql->fetch();
      if (empty($result))
      {
         header("Location: http://fida.ru/services.html");
      }
      else
      {
         $sql = $conn->prepare("INSERT INTO TouristBookings (UserID, TourID, Price, IsIndividual, DateTour) VALUES (:userID, :tourID, :price, :isIndividual, :dateTour)");
         $check = $sql->execute([":userID" => $_SESSION["ID"], ":tourID" => $_POST["ID"], ":price" => $result["Price"], ":isIndividual" => 0, ":dateTour" => $_POST["date"]]);
         if ($check)
         {
            header("Location: tours.php");
         }
         else
            echo "Произошла ошибка";
      }
   }
   else
   {
      header("Location: http://fida.ru/services.html");
   }

   exit();
}
elseif (!isset($_GET["ID"]))
{
   header("Location: http://fida.ru/services.html");
   exit();
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <!-- mobile metas -->
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="viewport" content="initial-scale=1, maximum-scale=1">
   <!-- site metas -->
   <meta name="keywords" content="">
   <meta name="description" content="">
   <meta name="author" content="">
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
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
   <title>Заказ тура</title>
   <link rel="stylesheet" href="order.css">
   <script src="js/order.js"></script>
</head>

<body>
   <div class="header_section">
      <div class="header_main">
         <div class="mobile_menu">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
               <div class="logo_mobile"><a href="index.html"><img src="images/лог.jpg"></a></div>
               <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
               </button>
               <div class="collapse navbar-collapse" id="navbarNav">
                  <ul class="navbar-nav">
                     <li class="nav-item">
                        <a style="color: black;" class="nav-link" href="index.html">Главная</a>
                     </li>
                     <li class="nav-item">
                        <a style="color: black;" class="nav-link" href="services.html">Туры</a>
                     </li>
                     <li class="nav-item">
                        <a style="color: black;" class="nav-link " href="blog.html">Блог</a>
                     </li>
                     <li class="nav-item">
                        <a style="color: black;" class="nav-link" href="about.html">О нас</a>
                     </li>
                     <li class="nav-item">
                        <a style="color: black;" class="nav-link " href="avtoriz.html">Вход</a>
                     </li>
                  </ul>
               </div>
            </nav>
         </div>
         <header>
            <nav id="main-nav">
               <div class="logo-holder">
                  <a href="#"><img style="height: 50px; width: 180px;" src="images/лог.jpg" alt="MOUNTAIN" class="logo-img"></a>
               </div>
               <ul id="main-menu">
                  <li class="main-menu-item"><a href="index.html"> Главная</a></li>
                  <li class="main-menu-item"><a href="services.html"> Туры</a></li>
                  <li class="main-menu-item"><a href="blog.html"> Блог</a></li>
                  <li class="main-menu-item"><a href="about.html"> О нас</a></li>
                  <!--<li class="main-menu-item"><a href="#acsi"> Контакты</a></li>-->
                  <li class="main-menu-itemm"><a href="indexxx.php"><img src="images/иконка.png" width="35" height="35" style="vertical-align: middle;"></a></li>

               </ul>
            </nav>
         </header>
      </div>
   </div>
   <h1 class="title">Заказ тура</h1>
   <div class="ordercontainer">
      <form id="order-form" action="order.php" method="POST">
         <?php
         $sql = $conn->prepare("SELECT * FROM Tours WHERE ID=:ID LIMIt 1");
         $sql->execute([":ID" => $_GET["ID"]]);
         $result = $sql->fetch();
         if (empty($result))
            header("Location: http://fida.ru/services.html");
         ?>
         <label>
            Выберите дату тура:
            <input id="dateInput" type="date" name="date" required>
         </label>
         <div class="titlediv">
            Название тура: 
            <span class="title"><?php echo $result["Title"]; ?></span> 
         </div>
         <div class="pricediv">
            Цена: 
            <span class="price">
               <?php echo $result["Price"]; ?>
            </span> 
            рублей
         </div>
         <label>
            Подтвердить:
            <input type="checkbox" name="access" required>
         </label>
         <input type="hidden" name="ID" value="<?php echo $result["ID"] ?>">
         <button type="submit">ЗАКАЗАТЬ</button>
      </form>
   </div>

</body>

</html>