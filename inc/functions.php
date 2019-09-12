<?php 

function debug($variable) {
    echo '<pre>' . print_r($variable, true) . '</pre>';
}


// function pour généré un $token 
function str_random($length) {
    $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnaAZERTYUIOPQSDFGHJKLMWXCVBN";
   return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);

} 
