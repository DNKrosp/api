<?php


namespace Server;


class Queries
{
    protected const QUERIES = [ ];

    static function findByName($name)
    {
        $query = "";
        if (key_exists($name, static::QUERIES))
            $query = static::QUERIES[$name];
        return $query;
    }

    static function getParams($name)
    {
        $query = static::findByName($name);
        $matches = explode(":", $query);
        array_pop($matches);
        return $matches;
    }
}