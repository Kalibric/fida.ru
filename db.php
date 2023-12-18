<?php
try
{
  $conn = new PDO("mysql:host=127.0.0.1;dbname=mountain;port=3306;charset=utf8", "root", "");
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
  $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
}
catch (PDOException $e)
{
  exit("Connection failed: " . $e->getMessage());
}

function getUser(PDO $conn, int $ID)
{
  $sql = $conn->prepare("SELECT * FROM Baza WHERE ID=:ID LIMIT 1");
  $sql->execute([":ID" => $ID]);
  $user = $sql->fetch();
  return isset($user["Status"]) ? $user : false;
}
?>
