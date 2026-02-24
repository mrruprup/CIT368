<?php
class ApplCookies {

    public function is_logged_in() {

        if(!isset($_COOKIE['user'])) {
            return false;
        }
        
        $value = $_COOKIE['user'];

        if(str_contains($value, "logged_in")) {
            return true;
        }
            
    }
}