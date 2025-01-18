<?php




function returnUser($username) {

  try {

    require "dbh.php";

    $query = "SELECT * FROM users WHERE username = :username;";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":username", $username);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $pdo = null;
    $stmt = null;

    return $result;

  } catch(PDOException $e) {
    echo $e->getMessage();
    die();
  }

}