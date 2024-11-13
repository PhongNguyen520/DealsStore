<?php

include_once __DIR__ . "/../config/Config.php";
class Database{
    public $connection;
    public $statusConnect = true;

    function __construct()
    {
        $this->connection = new mysqli(Config::DB_HOST, Config::DB_USER, Config::DB_PASS, Config::DB_NAME);
        if(!is_null($this->connection->connect_error)){
            echo "Lỗi: " . $this->connection->connect_error;
            $this->statusConnect = false;
            exit;
        }
    }
}