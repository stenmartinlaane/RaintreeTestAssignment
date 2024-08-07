<?php

use App\Domain\Patient;
use Base\BaseContractsDAL\IDbProvider;

function displayInsuranceStatusByTodaysDate()
{
    global $container;
    $dbProvider = $container->make(IDbProvider::class);
    $sql = "SELECT patient.pn
            FROM patient";
    $result = $dbProvider->executeQuery($sql);
    $patients = array();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $patients[] = new Patient($row["pn"]);
        }
    } else {
        echo "0 results";
    }

    $todaysDate = date('m-d-y');
    foreach ($patients as $patient){
        $patient->printInsuranceStatusByDate($todaysDate);
    }
}