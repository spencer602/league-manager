<?php

class SQLManager
{
    private $dbhost = 'localhost';
    private $dbname  = 'sharkhunt';   // Modify these...
    private $dbuser  = 'spencer';   // ...variables according
    private $dbpass = 'salute';   // ...to your installation

    private $connection;

    function __construct()
    {
        $this->connection = new mysqli($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname);
        if ($this->connection->connect_error)
            die("Fatal Error 1");
    }
}