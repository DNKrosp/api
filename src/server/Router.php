<?php


namespace Server;


abstract class Router
{
    const ROUTE_ROLES = [];

    const ROUTES = [];

    const ROUTES_METHOD = [];

    abstract static function index($userAgent, $clientIp, $cookie, $path, $get, $post);

    public static function Route($path, $get, $post)
    {
        $response = "";
        $path = trim($path, "/");
        if ($path !== "")
        {
            $role = (key_exists("roleId", $_SESSION)?$_SESSION["roleId"]:0);
            if (key_exists($path, static::ROUTES))
            {
                $controllerName = static::ROUTES[$path];

                if (key_exists($controllerName, static::ROUTES_METHOD))
                {
                    $data = static::ROUTES_METHOD[$controllerName] == "POST" ? $post: $get;

                    if (in_array($role, static::ROUTE_ROLES[$controllerName]))
                    {

                        if (key_exists("method", $data))
                        {
                            if (key_exists("params", $data))
                            {
                                $method = $data["method"];
                                $params = json_decode($data["params"], true);

                                $controller = new $controllerName();

                                if (method_exists($controller, $method . "Action"))
                                    $response = $controller->run($method, array_merge($params));
                                else
                                    $response = Response::message(["message"=>"wrong path", "code"=>10], false);
                            }else
                                $response = Response::message(["message"=>"params not found", "code"=>21], false);
                        } else
                            $response = Response::message(["message"=>"path not found", "code"=>21], false);
                    } else
                        $response = Response::message(["message"=>"wrong path", "code"=>10], false);
                } else
                    $response = Response::message(["message"=>"wrong path", "code"=>10], false);
            } else
                $response = Response::message(["message"=>"wrong path", "code"=>10], false);
        }

        return $response;
    }
}