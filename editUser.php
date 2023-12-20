<?php
require_once "db.php";
session_start();

if (!isset($_SESSION["ID"]))
{
  exit();
}
elseif (!isset($_POST["id"]) || !$_POST["status"])
{
  exit();
}

$user = getUser($conn, $_SESSION["ID"]);
if ($user)
{
  $_SESSION["status"] = $user["status"];
}
else
{
  exit();
}

if (getUser($conn, $_SESSION["ID"])["Status"] == 10)
{
  switch ($_POST["status"]) {
    case 'user':
      $setstatus = 1;
      break;
    
    case 'staff':
      $setstatus = 5;
      break;

    case 'admin':
      $setstatus = 10;
      break;
    
    default:
      exit();
  }
  $user = getUser($conn, $_POST["id"]);
  $sql = $conn->prepare("UPDATE Baza SET Status=:status WHERE ID=:id LIMIT 1");
  $sql->execute([":id" => $_POST["id"], ":status" => $setstatus]);
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
?>
