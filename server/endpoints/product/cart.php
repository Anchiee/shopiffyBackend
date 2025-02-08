<?php


header("Access-control-Allow-Origin: http://192.168.0.13:5173");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, GET, DELETE");
header("Access-Control-Allow-Credentials: true");


switch($_SERVER["REQUEST_METHOD"]) {
  
  case "POST":
    require_once "../../config/session.php";
    require_once "../../database/ReadData.php";
    require_once "../../database/AddData.php";


    $data = json_decode(file_get_contents("php://input"));
    echo json_last_error_msg();

    if(empty($data->model)) {
      echo json_encode([
        "status" => "error",
        "message" => "something went wrong"
      ]);
      die();
    }

    $username = $_SESSION["username"];

    $userData = returnUser($username);
    $userId = $userData["id"];

    $userCart = returnUserCart($userId);
    $cartProducts = [];



    foreach($userCart as $product) {
      $cartProducts[] = returnProductInfo($product["productId"]);
    }


    $productExists = false;
    $model = $data->model;

    foreach($cartProducts as $product) {
      if($model === $product["model"]) {
        $productExists = true;
        break;
      }
    }

    if(!$productExists) {
      $productData = returnProductInfo($model);
      $productId = $productData["id"];

      AddToCart($userId, $productId);

      echo json_encode([
        "status" => "success",
        "message" => "successfully added to the cart",
        "productAdded" => $productData
      ]);

    }
    
    break;
  
  case "GET":
    require_once "../../config/session.php";
    require_once "../../database/ReadData.php";

    $username = $_SESSION["username"];
    $userData = returnUser($username);

    $userId = $userData["id"];

    $userCart = returnUserCart($userId);

    $productsId = [];

    foreach($userCart as $column) {
      foreach($column as $row => $value) {
          array_push($productsId, $value);
      }
    }

    $userCartProducts = [];

    foreach($productsId as $id) {
      $productData = returnProductInfo($id);
      array_push($userCartProducts, $productData);
    }

    echo json_encode([
      "status" => "success",
      "message" => "successfully retrieved the user's cart",
      "products" => $userCartProducts
    ]);
    break;
  
  case "DELETE":
    require_once "../../database/DeleteData.php";
    require_once "../../database/ReadData.php";
    require_once "../../config/session.php";


    $username = $_SESSION["username"];

    $userData = returnUser($username);

    $userId = $userData["id"];

    $data = json_decode(file_get_contents("php://input"));
    $model = $data->model;


    $productData = returnProductsByName($model);
    $productId = $productData[0]["id"];



    deleteFromCart($productId, $userId);

    echo json_encode([
      "status" => "success",
      "message" => "successfully deleted the product from the cart",
      "model" => $model
    ]);

    break;
}
