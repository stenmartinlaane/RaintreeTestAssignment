<?php

namespace Base\BaseContractsTest;

use App\DAL\DbProvider;
use Base\BaseContractsDAL\IDbProvider;
use Database\DatabaseCreator;
use Database\DatabaseMigrator;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

abstract class DatabaseTestCase extends TestCase
{
    protected static DatabaseMigrator $migrator;
    protected static IDbProvider $dbProvider;

    public static function setUpBeforeClass(): void
    {
        $uuid = Uuid::uuid4();
        $dbname = "testDatabase-" . $uuid->toString();
        $dbname = str_replace("-", "_", $dbname);

        $dbCreator = new DatabaseCreator('localhost', $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $_ENV['DB_PORT']);
        $dbCreator->createDatabase($dbname);
        self::$migrator = new DatabaseMigrator('localhost', $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $dbname, $_ENV['DB_PORT']);
        self::$migrator->applyMigrations(BASE_PATH . "Database/Migrations/migrations.sql");
        self::$migrator->applyMigrations(BASE_PATH . "Database/Seeds/TestSeedData.sql");
        self::$dbProvider = new DbProvider('localhost', $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $dbname, $_ENV['DB_PORT']);
    }

    public static function tearDownAfterClass(): void
    {
        self::$migrator->dropDatabase();
    }
}