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

function deleteFromCart($productId, $userId)
{
  try {

    require "dbh.php";

    $query = "DELETE FROM cart WHERE productId = :productId AND userId = :userId;";

    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":productId", $productId);
    $stmt->bindParam(":userId", $userId);

    $stmt->execute();

    $stmt = null;
    $pdo = null;

  } catch(PDOException $e) {
    echo "Query failed:" . $e->getMessage();
    die();
  }

}