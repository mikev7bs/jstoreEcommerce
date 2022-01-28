<?php
header('content-type: text/html; charset=utf-8');
try
{
  $pdo_options[PDO::ATTR_ERRMODE]=PDO::ERRMODE_EXCEPTION;
  $pdo = new PDO('mysql:host=localhost;dbname=jstore_ecommerce', 'root', '');
  //$pdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");
}
catch(PDOException $e)
{
        die('Erreur : '.$e->getMessage());
}
$pdo->query("SET NAMES 'utf8'");
return $pdo;
?>
