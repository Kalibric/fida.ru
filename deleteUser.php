<?php
require_once "db.php";

if (!isset($_SESSION["login"]))
{
  header("Location: login.php");
  exit();
}

$login = $_SESSION['login'];
if (getStatus($conn, $login) == 10)
{
  $sql = $conn->prepare("DELETE FROM Baza WHERE ID=:id LIMIT 1");
  $sql->execute([":id" => $_GET["id"]]);
  if ($sql->rowCount() > 0)
  {
    echo '
        <script>
          alert("Пользователь успешно удален!")
        </script>
        ';
    //exit("<meta http-equiv='refresh' content='1; url=./admin.php'>");
  }
  else
    echo "0 строк задето";
}
else
  header("Location: index.html");
?>
