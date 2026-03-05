<?php
include_once("./secrets.php"); //path matters

class Encrypt{

    //Scheme: blowfish, DES, 3DES
    //SYMMETRIC ENCRYPTION
    //Use these: AES256, MODE (Galois/Counter Mode) 
    private const CIPHER = "aes-256-gcm";
    private const KEY = Secrets::ENC_KEY; //TODO: Dont hardcode, use env vars or config file outside of web root. Dont commit to git.
    function encrypt(string $plaintext){
        // Dont roll your own encryption

        //Leverage php encryption library
        $iv_len = openssl_cipher_iv_length(Encrypt::CIPHER);
        $iv = openssl_random_pseudo_bytes($iv_len);
        $tag = null; //used for integrity
        $ct = openssl_encrypt($plaintext, Encrypt::CIPHER, Encrypt::KEY, $options=0, $iv, $tag);
        return $iv . $tag . $ct;
    }

    function decrypt(string $input){
        $iv_len = openssl_cipher_iv_length(Encrypt::CIPHER);
        $iv = substr($input, 0, 12);
        $tag = substr($input, 12, 16); //tag is 16 bytes for GCM
        $ct = substr($input, 28);
        return openssl_decrypt($ct, Encrypt::CIPHER, Encrypt::KEY, $options=0, $iv, $tag);
    }
}