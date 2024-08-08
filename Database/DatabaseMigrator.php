<?php

namespace Database;

use mysqli;

class DatabaseMigrator
{
    private string $host;
    private string $username;
    private string $password;
    private string $dbname;
    private string $port;
    private ?string $socket;

    public function __construct(string $host, string $username, string $password, string $dbname, string $port, ?string $socket = null)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
        $this->port = $port;
        $this->socket = $socket;
    }

    public function applyMigrations(string $filePath)
    {
        $conn = new mysqli($this->host, $this->username, $this->password, $this->dbname, (int)$this->port, $this->socket);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Read the migrations from the file
        $migrations = file_get_contents($filePath);
        if ($migrations === false) {
            die("Failed to read the migration file");
        }

        // Split the file contents into individual SQL statements
        $sqlStatements = explode(';', $migrations);
        foreach ($sqlStatements as $statement) {
            // Trim any whitespace
            $statement = trim($statement);
            if (!empty($statement)) {
                if ($conn->query($statement) !== TRUE) {
                    echo "Error applying migration: " . $conn->error . "\n";
                }
            }
        }

        $conn->close();
    }

    public function dropDatabase()
    {
        $conn = new mysqli($this->host, $this->username, $this->password, null, (int)$this->port, $this->socket);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "DROP DATABASE IF EXISTS $this->dbname";
        if ($conn->query($sql) !== TRUE) {
            echo "Error dropping database: " . $conn->error . "\n";
        }

        $conn->close();
    }
}
