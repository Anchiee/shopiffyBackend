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



function returnProducts()
{
  try
  {
    require_once "dbh.php";


    $query = "SELECT * FROM products;";
    $stmt = $pdo->prepare($query);

    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = null;
    $pdo = null;

    return $result;

  } catch(PDOException $e) {
    echo "Query failed:" . $e->getMessage();
    die();
  }
}


function returnSpecifiedProduct($parameter)
{
  try
  {
    require_once "dbh.php";

    $query = "SELECT * FROM products WHERE model = :argument OR brand = :argument OR category = :argument OR 
    system = :argument;";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":argument", $parameter);

    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = null;
    $pdo = null;

    return $result;

  } catch(PDOException $e) {
    echo "Query failed:" . $e->getMessage();
    die();
  }
}