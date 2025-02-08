<?php

header("Access-Control-Allow-Origin: http://192.168.0.13:5173");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");


if($_SERVER["REQUEST_METHOD"] == "GET")
{
  require_once "../../database/ReadData.php";

  $products = returnProducts();

  echo json_encode([
    "status" => "success",
    "message" => "Successfully retrieved the products",
    "products" => $products
  ]);
  die();
}