<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/8/7 0007
 * Time: 16:31
 */
function getStaticPath()
{
    return __DIR__ . '';
}

function password_encrypt($password)
{
//    $salt = makeRandStrByLength(21);

//    $options = [
//        'cost' => 10, //指明递归算法的层数
//        'salt' => $salt
//    ];
    return $password = password_hash($password, PASSWORD_BCRYPT);
}

function verify_password($postPassword,$DbPassword)
{
    return password_verify($postPassword,$DbPassword);
}

function makeRandStrByLength($length = 8)
{
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_ []{}<>~`+=,.;:/?|';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[mt_rand(0, strlen($chars) - 1)];
    }
    return $password;

}