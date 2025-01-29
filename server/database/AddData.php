<?php


function AddUser($username, $password, $email)
{
  try {

    require "dbh.php";

    $query = "INSERT INTO users(username, pwd, email) VALUES(:user, :pwd, :email);";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":user", $username);
    $stmt->bindParam(":pwd", $password);
    $stmt->bindParam(":email", $email);

    $stmt->execute();

    $stmt = null;
    $pdo = null;

  } catch(PDOException $e) {
    echo $e->getMessage();
  }
}


function AddToCart($userId, $productId)
{

  try {

    require "dbh.php";

    $query = "INSERT INTO cart(productId, userId) VALUES(:productId, :userId);";
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