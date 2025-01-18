<?php

require_once "../config/session.php";
require_once "../database/AddData.php";
require_once "../database/ReadData.php";

$code = $_GET["code"];


$url = "https://github.com/login/oauth/access_token";


$postFields = [
  "client_id" => "Iv23lilBfiDMZpuPtzbu",
  "client_secret" => "0086399b6d95517a672f06f01cfa234f16f4b9c6",
  "redirect_uri" => "http://localhost/shopiffy/server/callbacks/github.php",
  "code" => $code
];

$headers = [
  "Accept: application/json"
];

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postFields));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
curl_close($ch);

$decodedResult = json_decode($result, true);

$accessToken = $decodedResult["access_token"];

$url = "https://api.github.com/user";
$headers = [
  "Authorization: Bearer $accessToken",
  "Accept: application/json",
  "User-Agent: shopWebsitee"
];

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

curl_close($ch);

$result = curl_exec($ch);

$decodedResult = json_decode($result, true);

$username = $decodedResult["login"];
$password = $accessToken;


$url = "https://api.github.com/user/emails";
$headers = [
  "Authorization: Bearer $accessToken",
  "Accept: application/json",
  "User-Agent: shopWebsitee"
];

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);


$result = curl_exec($ch);


curl_close($ch);

$decodedResult = json_decode($result, true);

$email = $decodedResult[0]["email"];


if(!returnUser($username)) {
  AddUser($username, $password, $email);
  $_SESSION["username"] = $username;
  header("Location: http://localhost:5173/menu");
  die();
}

$_SESSION["username"] = $username;
header("Location: http://localhost:5173/menu");
die();
