<?php

namespace Core;

class PathRoot
{
    static function getRoot()
    {
        return realpath(__DIR__."/../..");
    }
}