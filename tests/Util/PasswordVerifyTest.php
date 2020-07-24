<?php

namespace App\Tests\Util;

use App\Util\PasswordVerify;
use PHPUnit\Framework\TestCase;

class PasswordVerifyTest extends TestCase
{
    public function testVerify()
    {
        $pv = new PasswordVerify();
        $passwords = [
            [
                'pwd'      => 'azerty',
                'result' => true,
            ],
            [
                'pwd'      => 'a',
                'result' => false,
            ],
            [
                'pwd'      => 'a     a',
                'result' => true,
            ],
            [
                'pwd'      => '      ',
                'result' => false,
            ],
        ];

        foreach ($passwords as $password) {
            $result = $pv->verify($password['pwd']);
            $this->assertEquals($password['result'], $result);
        }
    }
}