<?php
/*
* use regex as needed
*/ 
function sanitize($string){
    trim($string);

    //BlackListing, regex (possible performance issues)
    return trim(preg_replace("/[\t\n\r=\"%;*<>\/]/i", "", $string));


    //BlackListing, hardcoded 
    //$bad_chars = ["<", ">", "\"", "'", "/", "\\", ";", "(", ")", "&", "%", "$", "#"];

    //$replacement = str_replace($bad_chars, "", $string);

    //inefficient 
    //str_replace("<", "");
}