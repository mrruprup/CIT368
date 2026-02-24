<?php

//Validation Functions

function is_username($input){
    //declare min and max length
    //whitelist 

    return preg_match("/^[A-Za-z0-9]{3,64}$/i", $input) === 1;
}

function is_realname($input){
    //declare min and max length
    //whitelist 

    return preg_match("/^[A-Za-z0-9 ',-]{3,64}$/i", $input) === 1;
}


function is_streetname($input){
    //declare min and max length
    //whitelist 

    return preg_match("/^[A-Za-z0-9 ',-]{3,64}$/i", $input) === 1;
}


function is_ssn($input){
    //declare min and max length
    //whitelist 

    return preg_match("/^[0-9]{3}-[0-9]{2}-[0-9]{4}$/i", $input) === 1;

}