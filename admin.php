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
    <script src="js/admin.js"></script>
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
                        <div class="col"><p><a href="cabinet.php"><span style="color:red;">Назад</span> </a></p>
                     </div>
                      </div>
                      <div class="cabinetHeader">
                        <a href="admin.php" class="active">Пользователи</a>
                        <a href="toursCheck.php">Одобрение туров</a>
                      </div>

                      <table class="table">
            		  <tr><tr>
                        <th style='text-align: center;' >Логин</th>
                        <th style='text-align: center;' >Статус</th>
            			<th style='text-align: center;'>Права</th>
            			<th style='text-align: center;'>Удаление</th>
                    </tr>
            		 <?php
                 $sql = $conn->prepare("SELECT * FROM Baza");
                 $sql->execute();
                 $users = $sql->fetchAll();
                 foreach ($users as $key => $value)
                 {
                   $editText = $value['Status'] == 10 ? 'Сделать пользователем' : 'Сделать администратором';
                   $editQuery = $value['Status'] == 10 ? 'makeUser' : 'makeAdmin';
                   $userselected = $value['Status'] == 1 ? 'selected' : '';
                   $staffselected = $value['Status'] == 5 ? 'selected' : '';
                   $adminselected = $value['Status'] == 10 ? 'selected' : '';

                   echo "<tr style='text-align: center; padding: 2 '>";
                   echo "<td style='text-align: center; font-size:10pt; padding: 0.5rem'>" . $value['Login'] . "</td>";
                   echo "<td style='text-align: center; font-size:10pt; padding: 0.5rem'>" . $value['Status'] . "</td>";
                  //  echo "<td style='text-align: center; font-size:10pt; padding: 0.5rem'><a href='./editUser.php?ID=" . $value['ID'] . "&edit=" . $editQuery . "'>" . $editText . "</a></td>";
                   echo "<td style='text-align: center; font-size:10pt; padding: 0.5rem'><div class='form-group'>
                   <select class='form-control-sm' id='SelectStatus' userID='{$value['ID']}'>
                     <option value='user' $userselected>Пользователь</option>
                     <option value='staff' $staffselected>Сотрудник</option>
                     <option value='admin' $adminselected>Администратор</option>
                   </select>
                 </div></td>";
                   echo "<td style='text-align: center; font-size:10pt; padding:0.5rem'><a href='./deleteUser.php?ID=" . $value['ID'] . "'>Удалить</a></td>";
                   echo "</tr>";
                 }
                 echo '</table>';
                 ?>


        </div>
        <div class="col-sm-3">
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
</html>
