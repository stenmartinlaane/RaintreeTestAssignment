<?php

namespace App\DAL;

use mysqli;
use mysqli_stmt;
use mysqli_result;
use Base\BaseContractsDAL\IDbProvider;

class DbProvider implements IDbProvider
{
    private mysqli $conn;
    private ?string $servername;
    private ?string $username;
    private ?string $password;
    private ?string $database;
    private ?string $port;
    private ?string $socket;

    public function __construct(?string $servername = null, ?string $username = null, ?string $password = null, ?string $database = null, ?string $port = null, ?string $socket = null)
    {
        $this->servername = $servername ?? $_ENV['DB_SERVER'];
        $this->username = $username ?? $_ENV['DB_ROOT_USERNAME'];
        $this->password = $password ?? $_ENV['DB_PASSWORD'];
        $this->database = $database ?? $_ENV['DB_DATABASE'];
        $this->port = $port ?? $_ENV['DB_PORT'];
        $this->socket = $socket ?? $_ENV['DB_SOCKET'];
        $this->conn = $this->connectToDataBase();
    }

    public function __destruct()
    {
        if(is_resource($this->conn) && get_resource_type($this->conn)==='mysql link'){
            $this->conn->close();
        }
    }

    private function connectToDataBase() {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->database, (int)$this->port, $this->socket);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }

    public function executeQuery(string $sql): bool|mysqli_result
    {
        $result = $this->conn->query($sql);

        if ($this->conn->error) {
            die("Query failed: " . $this->conn->error);
        }
        return $result;
    }

    public function executeStatement(mysqli_stmt $stmt): bool|mysqli_result
    {
        $stmt->execute();
        $result = $stmt->get_result();

        if ($this->conn->error) {
            die("Query failed: " . $this->conn->error);
        }
        return $result;
    }

    public function prepareStatement($sql): mysqli_stmt
    {
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }
        return $stmt;
    }
}