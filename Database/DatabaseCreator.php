<?php

namespace Database;

use mysqli;

class DatabaseCreator
{
    private string $host;
    private string $username;
    private string $password;
    private string $port;
    private ?string $socket;

    public function __construct(string $host, string $username, string $password, string $port, ?string $socket = null)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->port = $port;
        $this->socket = $socket;
        global $container;
    }

    public function createDatabase($dbname): void
    {
        $conn = new mysqli($this->host, $this->username, $this->password, null, (int)$this->port, $this->socket);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
        if ($conn->query($sql) !== TRUE) {
            echo "Error creating database: " . $conn->error . "\n";
        }

        $conn->close();
    }
}

