<?php


header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Origin: http://192.168.0.13:5173");

if($_SERVER["REQUEST_METHOD"] == "GET") {
  require_once "../config/session.php";
  require_once "../database/ReadData.php";

  if(empty($_SESSION["username"])) {
    echo json_encode([
      "status" => "error",
      "message" => "You are not logged in"
    ]);
    die();
  }

  $username = $_SESSION["username"];
  $userData = returnUser($username);
  $email = $userData["email"];

  echo json_encode([
    "status" => "success",
    "message" => "successfully retrieved the user's username from the session",
    "username" => $username,
    "email" => $email
  ]);

  die();
}