<?php
namespace Config;
define('BASE_PATH', __DIR__ . '/../');
require_once BASE_PATH . 'vendor/autoload.php';

use Database\DatabaseCreator;
use Database\DatabaseMigrator;
use DI;
use App\DAL\DbProvider;
use Base\BaseContractsDAL\IDbProvider;
use Dotenv\Dotenv;

//ENV SETUP
//==========================================
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
$environment = $_ENV['APP_ENV'];


//CONTAINER SETUP
//==========================================
$containerBuilder = new DI\ContainerBuilder();
$containerBuilder->addDefinitions(BASE_PATH . 'config/config.php');
$containerBuilder->addDefinitions(BASE_PATH . "config/config.$environment.php");

global $container;
$container = $containerBuilder->build();

//DATABASE SETUP
//==========================================
if ($_ENV['APP_ENV'] === "dev") {
    $dataBase = $_ENV['DB_DATABASE'];
    $dbMigrator = new DatabaseMigrator($_ENV['DB_SERVER'], $_ENV['DB_ROOT_USERNAME'], $_ENV['DB_PASSWORD'], $dataBase, $_ENV['DB_PORT'], $_ENV['DB_SOCKET']);
    $dbMigrator->dropDatabase();
    $dbCreator = new DatabaseCreator($_ENV['DB_SERVER'], $_ENV['DB_ROOT_USERNAME'], $_ENV['DB_PASSWORD'], $_ENV['DB_PORT'], $_ENV['DB_SOCKET']);
    $dbCreator->createDatabase($dataBase);
    $dbMigrator->applyMigrations(BASE_PATH . "Database/Migrations/migrations.sql");
    $dbMigrator->applyMigrations(BASE_PATH . "Database/Seeds/TestSeedData.sql");
}