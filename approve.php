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
if ($user["Status"] != 10 && $user["Status"] != 5)
{
  header("Location: login.php");
  exit();
}
if (isset($_GET["ID"]))
{
    $sql = $conn->prepare("UPDATE TouristBookings SET Status=1 WHERE ID=:ID AND Status=0");
    $sql->execute([":ID" => $_GET["ID"]]);
    if ($sql->rowCount() > 0)
    {
        echo '
        <script>
          alert("Тур успешно одобрен!")
        </script>
        ';
        header("Location: toursCheck.php");
    }
    else
        echo "0 строк задето";
}
else
{
    header("Location: toursCheck.php");
}
?>