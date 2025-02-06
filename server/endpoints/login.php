<?php


header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Origin: http://192.168.0.13:5173");

if($_SERVER["REQUEST_METHOD"] == "POST") {

  require_once "../database/ReadData.php";
  require_once "../config/session.php";

  $data = json_decode(file_get_contents("php://input"));

  if(empty($data->username) || empty($data->password)) {
    echo json_encode([
      "status" => "error",
      "message" => "Empty input"
    ]);
    die();
  }

  $username = htmlspecialchars($data->username);
  $password = htmlspecialchars($data->password);

  $userData = returnUser($username);

  if(empty($userData)) {
    echo json_encode([
      "status" => "error",
      "message" => "User doesn't exist"
    ]);
    die();
  }
  else if(!password_verify($password, $userData["pwd"])) {
    echo json_encode([
      "status" => "error",
      "message" => "Wrong password"
    ]);
    die();
  }

  $_SESSION["username"] = $username;
  $email = $userData["email"];

  echo json_encode([
    "status" => "success",
    "message" => "successfully retrieved the user's username from the session",
    "username" => $username,
    "email" => $email
  ]);
  die();

}