<?php

header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");

if($_SERVER["REQUEST_METHOD"] == "POST") {

  require_once "../database/ReadData.php";
  require_once "../database/UpdateData.php";
  require_once "../config/session.php";

  $data = json_decode(file_get_contents("php://input"));

  $chosenOption = $data->UserLabel;
  $newData = $data->newInfo;
  $password = $data->password;

  if(empty($_SESSION["username"])) {
    echo json_encode([
      "status" => "error",
      "message" => "user not found"
    ]);
    die();
  }

  $userData = returnUser($_SESSION["username"]);

  if(empty($newData) || empty($password)) {
    echo json_encode([
      "status" => "error",
      "message" => "Empty input"
    ]);
    die();
  }

  if(!password_verify($password, $userData["pwd"])) {
    echo json_encode([
      "status" => "error",
      "message" => "Wrong password"
    ]);
    die();
  }

  switch($chosenOption) {
    case "USERNAME":
      if(!empty(returnUser($newData))) {
        echo json_encode([
          "status" => "error",
          "message" => "User exists"
        ]);
        die();
      }
      $oldUsername = $_SESSION["username"];
      $_SESSION["username"] = $newData;
      UpdateUser("USERNAME", $oldUsername, $newData);
      echo json_encode([
        "status" => "success",
        "type" => "username",
        "message" => $newData
      ]);
      break;

    case "NEW PASSWORD":
      $hashedPassword = password_hash($newData, PASSWORD_DEFAULT);
      UpdateUser("PASSWORD", $_SESSION["username"], $hashedPassword);
      echo json_encode([
        "status" => "success",
        "message" => $newData
      ]);
      break;

    case "EMAIL":
      UpdateUser("EMAIL", $_SESSION["username"], $newData);
      echo json_encode([
        "status" => "success",
        "type" => "email",
        "message" => $newData
      ]);
      break;

    default:
      echo json_encode([
        "status" => "error",
        "message" => "Invalid option"
      ]);
      break;
  }
}
?>
