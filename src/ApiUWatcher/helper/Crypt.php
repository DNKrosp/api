<?php


namespace UWatcher\Helper;


class Crypt
{
    static function generateSalt()
    {
        return substr(md5(uniqid(rand(), true)), 0, 16);
    }

    static function getHash($pwd, $salt)
    {
        $hash = $pwd;
        for($i = 0; $i < 100; $i++)
            $hash = hash("sha512", $hash.$salt);

        return $hash;
    }

    static function assertPassword($pwd, $salt, $hash)
    {
        $newHash = static::getHash($pwd, $salt);
        return $newHash == $hash;
    }
}