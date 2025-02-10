<?php


header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Origin: http://shopiffy.iceiy.com/");
header("Access-Control-Allow-Credentials: true");

if($_SERVER["REQUEST_METHOD"] == "POST") {

  require_once "../../config/session.php";
  require_once "../../database/AddData.php";
  require_once "../../database/ReadData.php";

  $data = json_decode(file_get_contents("php://input"));
  if(empty($data->username) || empty($data->email) || empty($data->password)) {
    echo json_encode([
      "status" => "error",
      "message" => "Empty input"
    ]);
    die();
  }

  $username = htmlspecialchars($data->username);
  $email = htmlspecialchars($data->email);
  $password = htmlspecialchars($data->password);

  if(!empty(returnUser($username))) {
    echo json_encode([
      "status" => "error",
      "message" => "Username exists"
    ]);
    die();
  }

  $password = password_hash($data->password, PASSWORD_DEFAULT);
  $_SESSION["username"] = $username;

  AddUser($username, $password, $email);


  echo json_encode([
    "status" => "success",
    "message" => "successfully retrieved the user's username from the session",
    "username" => $_SESSION["username"],
    "email" => $email
  ]);

  die();
}