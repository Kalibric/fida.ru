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
if (isset($_POST["LastName"]) && isset($_POST["Name"]) && isset($_POST["Patronymic"]))
{
    $sql = $conn->prepare("UPDATE Baza SET Name=:name, Familia=:lastName, Otch=:patromymic WHERE ID=:ID LIMIT 1");
    $sql->execute([":name" => $_POST["Name"], ":lastName" => $_POST["LastName"], ":patromymic" => $_POST["Patronymic"], ":ID" => $_SESSION["ID"]]);
}
header("Location: cabinet.php");
?>