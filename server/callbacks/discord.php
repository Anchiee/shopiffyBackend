<?php


require_once "../config/session.php";
require_once "../database/AddData.php";
require_once "../database/ReadData.php";

$code = $_GET["code"];

$url = "https://discord.com/api/oauth2/token";

$ch = curl_init($url);

$headers = [
  "Content-Type: application/x-www-form-urlencoded"
];

$postFields = [
  "client_id" => "1329212800610074766",
  "client_secret" => "E6erh4JwBOl25sHTnOHpGGOUCB10Zo6_",
  "redirect_uri" => "http://localhost/shopiffy/server/callbacks/discord.php",
  "grant_type" => "authorization_code",
  "code" => $_GET["code"]
];


curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postFields));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);
curl_close($ch);

$decodedResult = json_decode($result, true);

$accessToken = $decodedResult["access_token"];


$url = "https://discord.com/api/users/@me";

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
  "Content-Type: application/x-www-form-urlencoded",
  "Authorization: Bearer $accessToken"
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);
$decodedResult = json_decode($result, true);


$username = $decodedResult["username"];
$email = $decodedResult["email"];
$password = $accessToken;

if(!returnUser($username)) {
  AddUser($username, $password, $email);
  $_SESSION["username"] = $username;
  header("Location: http://localhost:5173/menu");
  die();
}

$_SESSION["username"] = $username;
header("Location: http://localhost:5173/menu");
die();