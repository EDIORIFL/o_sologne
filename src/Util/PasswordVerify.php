<?php
namespace  App\Util;

class PasswordVerify 
{
    public function verify($password) 
    {
        return strlen(trim($password)) && $password !== null;
    }
}