<?php
require_once ("../../vendor/autoload.php");

use UWatcher\Core\RouterUWatcher;

$table = new Swoole\Table(1024);
$table->column('result', Swoole\Table::TYPE_STRING, 1024);
$table->create();

$http = new Swoole\HTTP\Server("127.0.0.1", 9501);

$http->on('request', function ($request, $response) use ($http, $table) {

    $result = RouterUWatcher::Index(
        $request->header["user-agent"],
        $request->server["remote_addr"],
        $request->cookie,
        $request->server["path_info"],
        $request->get,
        $request->post
    );

    $response->end($result);
});

$http->start();