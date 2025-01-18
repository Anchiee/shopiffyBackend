<?php

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Credentials: true");


if($_SERVER["REQUEST_METHOD"] == "DELETE") 
{
  require_once "../config/session.php";
  require_once "../database/DeleteData.php";

  $username = $_SESSION["username"];

  DeleteUser($username);

  echo json_encode([
    "status" => "success",
    "message" => "successfully deleted the account"
  ]);
}