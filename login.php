<?php

include "./sanitize.php";
include "./validate.php";
//include "./encrypt.php";

session_start();

/*
$e = new Encrypt();
$iv_t_ct = $e->encrypt("Encrypt me");
var_dump($iv_t_ct);

$pt = $e->decrypt($iv_t_ct);
var_dump($pt);
*/

//var_dump(is_username('mrr24'));

//only numbers and letters (whitelist)
$username = trim($_POST['username']);
$password = $_POST['password'];

//echo "<!--" $username . ":" . $password . "<br> -->";

//Home Brew login
if(strlen($username) > 0 && strlen($password) > 0){
    //Login attempt detected
    
    if(!is_username($username)){
        $failure = true;
    }else{
        include_once("sql.php"); //path matters

    $db = new Database();
    $is_valid_user = $db->login($username, $password);

    if($is_valid_user){
        //go to backend page

        //echo "success";

        //not secure, only checking for logged in user
        //setcookie("user", $username.":logged_in", time() + 84600 * 30, "/"); //30 days
        $_SESSION['username'] = $username;
        $_SESSION['authenticated'] = true;
        
        header("Location: backend.php");
    
        
    } else {
        $failure = true;
    }}
}


    

    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {background-color: #222;}
        *{color: #eee;}

        input{color: #222;}
    </style>
</head>
<body>
    <?php //echo "testing php"?>

   
    <h1>Login</h1>

     <?php if($failure): ?>
        <p style="color: red;">Not a user, try again</p>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <input type="text" name="username">
        <input type="password" name="password">
        <input type="submit" value="submit">
    </form>

</body>
</html>