<?php

// encryption.php

// Define your secret key and method
define('SECRET_KEY', 'SCHOOL_PROJECT_SECRET_KEY');
define('METHOD', 'AES-256-CBC');

function encrypt($data) {
    $key = hash('sha256', SECRET_KEY);
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(METHOD));
    $encrypted = openssl_encrypt($data, METHOD, $key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}

function decrypt($data) {
    $key = hash('sha256', SECRET_KEY);
    list($encrypted_data, $iv) = array_pad(explode('::', base64_decode($data), 2), 2, null);
    return openssl_decrypt($encrypted_data, METHOD, $key, 0, $iv);
}



?>