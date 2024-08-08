<?php

use App\DAL\DbProvider;
use Base\BaseContractsDAL\IDbProvider;

function displayPatientsData(?IDbProvider $dbProvider = null): void {
     global $container;
     $dbProvider = $dbProvider ?? $container->make(IDbProvider::class);
     $sql = "SELECT patient.pn, patient.first, patient.last, insurance.iname, insurance.from_date, insurance.to_date
            FROM patient
            LEFT JOIN insurance ON patient._id = insurance.patient_id
            ORDER BY insurance.from_date ASC;
            ";

     $result = $dbProvider->executeQuery($sql);

     if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) {
             echo join(",", $row) . "\n";
         }
     } else {
         echo "0 results";
     }
 }