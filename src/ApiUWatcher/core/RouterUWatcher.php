<?php

namespace UWatcher\Core;

use Server\Router;
use UWatcher\Controller\UserController;

class RouterUWatcher extends Router
{
    const ROUTE_ROLES = [
        UserController::class => [0],
    ];

    const ROUTES = [
        "user"=>UserController::class,
    ];

    const ROUTES_METHOD = [
        UserController::class => "GET",
    ];

    public static function index($userAgent, $clientIp, $cookie, $path, $get, $post)
    {
        session_start();

        return self::Route($path, $get, $post);
    }
}