<?php

namespace Helper;

use PHPUnit\Framework\TestCase;
use UWatcher\Helper\Crypt;

class CryptTest extends TestCase
{
    public function testCrypt()
    {
        $password = "MyWond";
        $salt = Crypt::generateSalt();
        $hash = Crypt::getHash($password, $salt);

        $this->assertEquals(true, Crypt::assertPassword($password, $salt, $hash));
    }
}
