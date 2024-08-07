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

    public function __construct(string $host, string $username, string $password, string $dbname, string $port)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
        $this->port = $port;
    }

    public function applyMigrations(string $filePath)
    {
        $conn = new mysqli($this->host, $this->username, $this->password, $this->dbname, (int)$this->port);

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
                if ($conn->query($statement) === TRUE) {
                    echo "Migration applied successfully\n";
                } else {
                    echo "Error applying migration: " . $conn->error . "\n";
                }
            }
        }

        $conn->close();
    }

    public function dropDatabase()
    {
        $conn = new mysqli($this->host, $this->username, $this->password);

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
