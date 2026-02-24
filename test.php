<?php

$server = "127.0.0.1";
$user = "root"; //TODO: Least Priv. make new user.
$password = "libby"; //TODO: weak password, hardcoded
$schema = "web_app";

//conn db 
$conn = new mysqli($server, $user, $password, $schema);

if(!$conn){
    die("Connection failed: ");
}

echo "Connected successfully";
