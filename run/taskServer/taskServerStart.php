<?php

$table = new Swoole\Table(1024);
$table->column('result', Swoole\Table::TYPE_STRING, 1024);
$table->create();

$http = new Swoole\HTTP\Server("127.0.0.1", 9501);

$http->on('request', function ($request, $response) use ($http, $table) {


    file_put_contents("rows.json", json_encode([
        "header"=>$request->header,
        "server"=>$request->server,
        "get"=>$request->get,
        "post"=>$request->post,
        "cookie"=>$request->cookie,
        "rawookie"=>$request->rawookie,
        "files"=>$request->files,
        "rawContent"=>$request->rawContent,
        "getContent"=>$request->getContent(),
        "getData"=>$request->getData(),
        "session"=>$_SESSION
    ]));
    $_SESSION["hi"] = true;

    $response->cookie("hello","den", 999, "/say");

    $response->end($table["result"]??"null");
});

$http->start();