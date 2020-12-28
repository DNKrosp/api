<?php


namespace Database;


use Core\PathRoot;

class ConnectionSingleton
{
    private static $pgConnection = null;

    public function __construct(){}

    protected function __clone(){}

    public function __wakeup() { throw new \Exception("Cannot unserialize a singleton."); }

    public static function getPgConnect()
    {
        if (self::$pgConnection == null)
            self::$pgConnection = PgConnection::createFromJSON(file_get_contents(PathRoot::getRoot()."/config/postgres.json"));

        return self::$pgConnection;
    }
}