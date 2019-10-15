<?php

namespace App\Helper;

class Encryption{

    private $cipher='aes-128-gcm';
    private $key;

    public function __construct(){
        $this->key=md5(env('APP_KEY'));
    }

    public function set_key($text){
        $this->key=md5($text);
    }

    public function encrypt($text){
        $ivlen=openssl_cipher_iv_length($this->cipher);
        $iv=openssl_random_pseudo_bytes($ivlen);
        $ciphertext=openssl_encrypt($text,$this->cipher,$this->key,$options=0,$iv,$tag);
        return base64_encode($ciphertext).'|'.base64_encode($iv).'|'.base64_encode($tag);
    }

    public function decrypt($text){
        list($ciphertext,$iv,$tag)=explode('|',$text.'|');
        $ciphertext=base64_decode($ciphertext);
        $iv=base64_decode($iv);
        $tag=base64_decode($tag);
        return openssl_decrypt($ciphertext,$this->cipher,$this->key,$options=0,$iv,$tag);
    }
}