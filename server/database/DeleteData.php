<?php


function DeleteUser($username) {
  try {

    require_once "dbh.php";

    $query = "DELETE FROM users WHERE username = :username;";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":username", $username);

    $stmt->execute();

    $pdo = null;
    $stmt = null;

  } catch(PDOException $e) {
    echo $e->getMessage();
    die();
  }
}