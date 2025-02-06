<?php


ini_set("session.use_strict_mode",  1);
ini_set("session.use_only_cookies", 1);

session_set_cookie_params([
  "lifetime" => 1800,
  "secure" => false,
  "domain" => $_SERVER["HTTP_HOST"],
  "httponly" => true,
  "path" => '/'
]);

session_start();

if(empty($_SESSION["regeneration"])) {
  session_regenerate_id(true);
  $_SESSION["regeneration"] = time();
}

$interval = 30 * 60;
if(time() - $_SESSION["regeneration"] >= $interval) {
  session_regenerate_id(true);
  $_SESSION["regeneration"] = time();
}