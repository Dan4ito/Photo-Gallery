<?php
abstract class DatabaseContext
{
    private $host = 'PLACE_DB_ADDRESS_HERE';    // 3.89.35.197:3306 - mysql ec2
    private $dbname = 'php_gallery';
    private $username = 'admin';     // admin - mysql ec2
    private $password = 'admin';         // admin - mysql ec2
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
