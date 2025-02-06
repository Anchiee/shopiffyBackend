<?php


header("Access-Control-Allow-Origin: http://192.168.0.13:5173");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");


if($_SERVER["REQUEST_METHOD"] == "POST") {


  require_once "../database/ReadData.php";

  $data = json_decode(file_get_contents("php://input"));

  $category = null;
  $brands = [];
  $os = null;

  if(!empty($data->category) && $data->category !== "none") {
    $category = $data->category;
  }
  
  if(!empty($data->brands) && $data->brands !== "none") {
    
    foreach($data->brands as $brand) {
      array_push($brands, $brand);
    }

  }
  if(!empty($data->os) && $data->os !== "none") {
    $os = $data->os;
  }

  $result = returnProductsByFilter($category, $brands, $os);

  if(empty($result)) {
    echo json_encode([
      "status" => "error",
      "message" => "Product doesn't exist"
    ]);
    die();
  }

  
  echo json_encode([
    "status" => "success",
    "message" => "successfully retrieved the products",
    "products" => $result
  ]);
  die();

}