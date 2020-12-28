<?php


namespace UWatcher\Query;

use Server\Queries;

class UserQuery extends Queries
{
    protected const QUERIES = [
        "getUserInfo" => "SELECT id, nickname, create_tst, update_tst FROM sys.users limit :limit OFFSET :ofs ",
        "getUserFromLogin" => "SELECT id FROM sys.users WHERE nickname = :login",
        "getAuth" => "SELECT pwd, salt FROM sys.users WHERE id = :id",
        "findByNickname" => "SELECT nickname FROM sys.users WHERE nickname = :login",
        "createUser" => "INSERT INTO sys.users VALUES (DEFAULT, :login, :pwd, :salt, :createTst, DEFAULT) RETURNING id",
        
        "setWatchUrl" => "INSERT INTO watcher.urls VALUES (DEFAULT, :tst, DEFAULT, :resourceId, :userId, :path, :query) RETURNING id",
        "findResourceByHost" => "SELECT id FROM watcher.resources WHERE host = :host"
    ];
}