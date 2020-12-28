<?php


namespace Server;


class Request
{
    private $path;
    private $post;
    private $get;
    private $cookie;

    public function __construct($path, $post, $get, $cookie)
    {
        $this->path = $path;
        $this->post = $post;
        $this->get = $get;
        $this->cookie = $cookie;
    }

    public static function create($path, $post, $get, $cookie)
    {
        return new self($path, $post, $get, $cookie);
    }
}