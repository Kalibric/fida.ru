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

if (getUser($conn, $_SESSION["ID"])["Status"] == 10)
{
  $sql = $conn->prepare("DELETE FROM Baza WHERE ID=:id LIMIT 1");
  $sql->execute([":id" => $_GET["ID"]]);
  if ($sql->rowCount() > 0)
  {
    echo '
        <script>
          alert("Пользователь успешно удален!")
        </script>
        ';
    header("Location: admin.php");
  }
  else
    echo "0 строк задето";
}
else
  header("Location: admin.php");
?>
