<?php
session_start();
//Check if cookie exists
//include("appcookie.php");
//$cookies = new AppCookies();
/* not the best clients can forge cookies
if(!$cookies->is_logged_in()){
    header("Location: login.php");
}
*/
//var_dump($_SESSION);
if(!isset($_SESSION) || !$_SESSION['authenticated']){
    header($_SERVER['SERVER_PROTOCOL'] . " 418 I'm a teapot");
    die();
}
    //user is authenticated
//echo "you are logged in!";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Secrets</h1>
    <p>cool</p>
</body>
</html>