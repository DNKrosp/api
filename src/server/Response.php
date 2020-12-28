<?php


namespace Server;


class Response
{
    public static function message($data, $status=true)
    {
        return json_encode(["data" => $data, "status"=>$status]);
    }
}