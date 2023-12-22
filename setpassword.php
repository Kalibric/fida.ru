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
    if (isset($_POST["newPass"]) && isset($_POST["refreshPass"]))
    {
        if ($_POST["newPass"] == $_POST["refreshPass"] && strlen($_POST["newPass"]) > 5)
        {
            $sql = $conn->prepare("UPDATE Baza SET Password=:pass WHERE ID=:ID LIMIT 1");
            $sql->execute([":ID" => $_SESSION["ID"], ":pass" => $_POST["newPass"]]);
            header("Location: cabinet.php");
        }
        else
        {
            header("Location: setpassword.php");
            exit();
        }
    }
    else
    {
        header("Location: setpassword.php");
        exit();
    }
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
      <script src="js/setpassword.js"></script>
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

  <p> Смена пароля </p>
  </center>
           </div>
            <div class="col"><p><a href="cabinet.php"><span style="color:red;">Назад</span> </a></p>
         </div>
          </div>
          <form action="setpassword.php" method="POST" id="formPassword">
            <div class="mb-3">
                <label class="form-label">Новый пароль</label>
                <input type="password" class="form-control" name="newPass">
                <span style="color: #fa5252" id="newPassword"></span>
            </div>
            <div class="mb-3">
                <label class="form-label">Повтор нового пароля</label>
                <input type="password" class="form-control" name="refreshPass">
                <span style="color: #fa5252" id="refreshPassword"></span>
            </div>
            <div class="col-sm-6">
                <input type="submit" class="btn btn-warning" value="Поменять пароль">
            </div>
          </form>
        </div>
        <div class="col-sm-3">
        </div>
    </div>
</div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
</html>
