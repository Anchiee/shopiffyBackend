<?php


function UpdateUser($option, $username, $newData)
{
  try {

    require "dbh.php";

    $query = "";

    switch($option) {
      case "USERNAME":
        $query = "UPDATE users SET username = :newData WHERE username = :userUsername;";
        break;
      case "PASSWORD":
        $query = "UPDATE users SET pwd = :newData WHERE username = :userUsername;";
        break;
      case "EMAIL":
        $query = "UPDATE users SET email = :newData WHERE username = :userUsername;";
        break;
    }

    $stmt  = $pdo->prepare($query);
    $stmt->bindParam(":newData", $newData);
    $stmt->bindParam(":userUsername", $username);

    $stmt->execute();

    $stmt = null;
    $pdo = null;

  } catch(PDOException $e) {
    echo $e->getMessage();
    die();
  }
}