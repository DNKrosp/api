<?php


namespace Core;


abstract class Parser
{
    protected $host;
    protected $path;
    protected $query;

    public static function getInfo($path, $query)
    {
        $obj = new static($path, $query);
        return $obj->parse();
    }

    private function __construct($path, $query)
    {
        $this->path = $path;
        $this->query = $query;
    }

    protected abstract function parse();
}