<?php


header("Access-control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Credentials: true");

if($_SERVER["REQUEST_METHOD"] == "POST") {
  require_once "../config/session.php";
  require_once "../database/ReadData.php";
  require_once "../database/AddData.php";


  $data = json_decode(file_get_contents("php://input"));

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

  $model = $data->model;

  $productData = returnProductByName($model);
  $productId = $productData["id"];

  AddToCart($userId, $productId);

  echo json_encode([
    "status" => "success",
    "message" => "successfully added to the cart",
    "productAdded" => $productData
  ]);
  die();

}
