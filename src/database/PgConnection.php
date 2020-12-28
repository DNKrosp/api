<?php


namespace Database;

use Exception;
use PDO;

class PgConnection
{
    private PDO $connection;

    public function __construct($connectionString, $username, $password)
    {
        $this->connection = new PDO("pgsql:".$connectionString, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }

    /**
     * @param $jsonString
     * @return PgConnection
     * @throws Exception
     */
    public static function createFromJSON($jsonString)
    {
        $params = json_decode($jsonString, true);
        foreach (['host', 'port', 'user', 'password', 'dbname'] as $needed)
            if (!isset($params[$needed]))
                throw new Exception("Needed json param " . $needed . " didn't passed");
        return new self("host=" . $params['host'] . " dbname=" . $params['dbname'], $params['user'], $params['password']);
    }

    public function query($str, $placeholders=[])
    {
        $data = [];
        $res = $this->connection->prepare($str);
        foreach ($placeholders as $key => $value)
            $res->bindValue($key, $value);

        if ($res) {
            $res->execute();
            $data = $res->fetchAll(PDO::FETCH_ASSOC);
        }

        return $data;
    }
}