<?php


header("Access-Control-Allow-Origin: http://192.168.0.13:5173");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");

if($_SERVER["REQUEST_METHOD"] == "POST") {
  require_once "../../database/ReadData.php";

  $data = json_decode(file_get_contents("php://input"));

  if(empty($data->product)) {
    echo json_encode([
      "status" => "error",
      "message" => "empty input"
    ]);
    die();
  }
  else if($data->product == "none") {
    $products = returnProducts();

    echo json_encode([
      "status" => "success",
      "message" => "successfully retrieved the products",
      "info" => $products
    ]);
    die();
  }

  $products = returnProductsByName($data->product);

  if(empty($products)) {
    echo json_encode([
      "status" => "error",
      "message" => "Product doesn't exist"
    ]);
    die();
  }

  echo json_encode([
    "status" => "success",
    "message" => "successfully retrieved the products",
    "products" => $products
  ]);
  die();
}