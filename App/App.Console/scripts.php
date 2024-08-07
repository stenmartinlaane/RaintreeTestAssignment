<?php

use Base\BaseContractsDAL\IDbProvider;

const BASE_PATH = __DIR__ . '/../../';
require_once BASE_PATH . 'Config/startUp.php';
require_once 'patients-data.php';
require_once 'statistics.php';
require_once 'test-script.php';

$params = array_slice($argv, 1);

if ($params === ["patients-data"]) {
    displayPatientsData();
} elseif ($params === ["statistics"]){
    displayStatistics();
} elseif($params === ["test-script"]) {
    displayInsuranceStatusByTodaysDate();
} else {
    global $container;
    $patient = new \App\Domain\Patient('PN001');
    $patient->printInsuranceStatusByDate("01-01-22");
}