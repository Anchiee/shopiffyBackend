<?php


$dbName = "shopiffy";
$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";

$dsn = "mysql:host=$dbHost;dbname=$dbName";

try {

  $pdo = new PDO($dsn, $dbUser, $dbPass);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
} catch(PDOException $e) {
  echo "something wrong happened";
  die();
}