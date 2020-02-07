<?php
abstract class DatabaseContext
{
    private $host = 'localhost';
    private $dbname = 'php_gallery';
    private $username = 'root';
    private $password = '';
    private $charset = 'utf8';
    private $connection;

    public function getConnection()
    {
        $this->connection = null;

        try {
            $this->connection = mysqli_connect($this->host, $this->username, $this->password, $this->dbname);
        } catch (Exception $e) {
            echo 'Connection error: ' . $e->getMessage();
        }
        return $this->connection;
    }
}
