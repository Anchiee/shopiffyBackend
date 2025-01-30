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


function returnProductsByName($parameter)
{
  try
  {
    require "dbh.php";

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


function returnProductsByFilter($category, $brands, $os)
{
  try {

    require_once "dbh.php";

    $conditions = [];
    $params = [];
    $query;
    $stmt;

    if(empty($category) && empty($brands) && empty($os)) {
      $query = "SELECT * FROM products;";
      $stmt = $pdo->prepare($query);
      $stmt->execute();
    }
    
    else {
      $query = "SELECT * FROM products WHERE ";

      if(!empty($category)) {
        $params[":category"] = $category;
        $conditions[] =  "category = :category";
      }
  
      if(!empty($brands)) {
        $brandQuery = "brand IN(";
  
        $brandsArr = [];
  
        for($i = 0; $i < sizeof($brands); $i++) {
          $params[":brand$i"] = $brands[$i];
          $brandsArr[] = ":brand$i";
        }
        $brandQuery .= implode(",", $brandsArr);
        $brandQuery .= ")";
  
        $conditions[] = $brandQuery;
      }
  
      if(!empty($os)) {
        $params[":os"] = $os;
        $conditions[] = "system = :os";
      }
  
      $query .= implode(" AND ", $conditions);

      $stmt = $pdo->prepare($query);

      $stmt->execute($params);
    }


    

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $pdo = null;
    $stmt = null;

    return $result;


  } catch(PDOException $e) {
    echo "Query failed:" . $e->getMessage();
    die();
  }
}


function returnProductInfo($id)
{
  try {

    require "dbh.php";

    $query = "SELECT * FROM products WHERE id = :argument OR model = :argument;";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":argument", $id);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = null;
    $pdo = null;
    
    return $result;

  } catch(PDOException $e) {
    echo "Query failed:" . $e->getMessage();
    die();
  }
}

function returnUserCart($id)
{
  try {

    require "dbh.php";

    $query = "SELECT productId FROM cart WHERE userId = :id;";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":id", $id);
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