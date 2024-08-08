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

        $dbCreator = new DatabaseCreator($_ENV['DB_SERVER'], $_ENV['DB_ROOT_USERNAME'], $_ENV['DB_PASSWORD'], $_ENV['DB_PORT'], $_ENV['DB_SOCKET']);
        $dbCreator->createDatabase($dbname);
        self::$migrator = new DatabaseMigrator($_ENV['DB_SERVER'], $_ENV['DB_ROOT_USERNAME'], $_ENV['DB_PASSWORD'], $dbname, $_ENV['DB_PORT'], $_ENV['DB_SOCKET']);
        self::$migrator->applyMigrations(BASE_PATH . "Database/Migrations/migrations.sql");
        self::$migrator->applyMigrations(BASE_PATH . "Database/Seeds/TestSeedData.sql");
        self::$dbProvider = new DbProvider($_ENV['DB_SERVER'], $_ENV['DB_ROOT_USERNAME'], $_ENV['DB_PASSWORD'], $dbname, $_ENV['DB_PORT'], $_ENV['DB_SOCKET']);
    }

    public static function tearDownAfterClass(): void
    {
        self::$migrator->dropDatabase();
    }
}