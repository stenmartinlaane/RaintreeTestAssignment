<?php

use App\DAL\DbProvider;

 function displayPatientsData(): void {
     $DbContext = new DbProvider();
     $sql = "SELECT patient.pn, patient.first, patient.last, insurance.iname, insurance.from_date, insurance.to_date
            FROM patient
            LEFT JOIN insurance ON patient._id = insurance.patient_id
            ORDER BY insurance.from_date ASC;
            ";

     $result = $DbContext->executeQuery($sql);

     if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) {
             echo join(",", $row) . "\n";
         }
     } else {
         echo "0 results";
     }
 }