<?php
namespace  App\Util;

class PasswordVerify 
{
    public function verify($password) 
    {
        return $password !== null && strlen(trim($password)) > 3;
    }
}