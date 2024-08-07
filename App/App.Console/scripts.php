<?php

use Base\BaseContractsDAL\IDbProvider;

require_once __DIR__ . '/../../' . 'Config/startUp.php';
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
}