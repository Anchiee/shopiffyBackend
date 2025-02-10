<?php


header("Access-Control-Allow-Origin: http://192.168.0.13");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Content-Type");


if($_SERVER["REQUEST_METHOD"] == "DELETE") {
  require_once "../../config/session.php";
  session_destroy();

  echo json_encode([
    "status" => "success",
    "message" => "logged out successfully"
  ]);
  die();
}