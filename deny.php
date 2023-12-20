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
    if (isset($_GET["reason"]))
    {
        $sql = $conn->prepare("UPDATE TouristBookings SET Status=2, Reason=:reason WHERE ID=:ID AND Status=0");
        $sql->execute([":reason" => $_GET["reason"], ":ID" => $_GET["ID"]]);
        if ($sql->rowCount() > 0)
        {
            echo '
            <script>
            alert("Тур успешно Отказан!")
            </script>
            ';
            header("Location: toursCheck.php");
        }
        else
            echo "0 строк задето";
    }
}
else
    header("Location: toursCheck.php");
?>
<html>
    <head>
        <script src="js/deny.js"></script>
    </head>
</html>