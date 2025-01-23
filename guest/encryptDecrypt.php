<?php
function encrypt($id)
{
    $password = "YourPasswordHere"; #needs a password only containing letters
    $iv = "1234567812345678"; #needs a 16 character number of you choice
    $encrypted = openssl_encrypt($id, 'aes-256-cbc', $password, 0, $iv);
    $hex = bin2hex($encrypted);
    return $hex;
}

function decrypt($id)
{
    $password = "YourPasswordHere"; #same password here
    $iv = "1234567812345678"; #same number here
    $encrypted = hex2bin($id);
    $decrypted = openssl_decrypt($encrypted, 'aes-256-cbc', $password, 0, $iv);
    return $decrypted;
}
?>