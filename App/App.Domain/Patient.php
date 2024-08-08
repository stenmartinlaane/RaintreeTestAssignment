<?php

namespace App\Domain;

use Base\BaseContractsDAL\IDbProvider;
use Base\BaseContractsDomain\PatientRecord;
use DateTime;
use Exception;
use Helpers\DateTimeHelper;

class Patient implements PatientRecord
{
    private int $id;
    private ?string $pn;
    private ?string $first;
    private ?string $last;
    private ?DateTime $dob;
    /**
     * @var Insurance[] Array of Insurance objects
     */
    private array $insuranceRecords;

    private IDbProvider $dbProvider;

    public function __construct(?string $pn, ?IDbProvider $dbProvider = null) {
        global $container;
        $this->dbProvider = $dbProvider ?? $container->make(IDbProvider::class);
        $patientData = $this->fetchPatientDataByPn($pn);

        if ($patientData) {
            $this->id = (int)$patientData['id'];
            $this->pn = $pn;
            $this->first = $patientData['first'];
            $this->last = $patientData['last'];
            $this->dob = $patientData['dob'] ? DateTimeHelper::stringToDate("Y-m-d", $patientData['dob']) : null;
            $this->insuranceRecords = $patientData['insuranceRecords'];
        } else {
            throw new \Exception("Patient not found.");
        }
    }

    private function fetchPatientDataByPn(string $pn): ?array
    {
        $sql = "SELECT patient._id AS patient_id, patient.first, patient.last, patient.dob, insurance._id AS insurance_id, insurance.iname, insurance.from_date, insurance.to_date
            FROM patient
            LEFT JOIN insurance ON patient._id = insurance.patient_id
            WHERE patient.pn = ?
            ORDER BY insurance.from_date ASC; 
            ";

        $stmt = $this->dbProvider->prepareStatement($sql);
        $stmt->bind_param("s", $pn);
        $result = $this->dbProvider->executeStatement($stmt);

        $patientData = array();
        if ($result->num_rows > 0) {
            $firstLoop = true;
            $insuranceRecords = array();
            while($row = $result->fetch_assoc()) {
                if($firstLoop) {
                    $patientData['id'] = $row["patient_id"];
                    $patientData['first'] = $row["first"];
                    $patientData['last'] = $row["last"];
                    $patientData['dob'] = $row["dob"];
                    $firstLoop = false;
                }
                if (!is_null($row['insurance_id'])) {
                    $from_date = $row['from_date'] ? DateTimeHelper::stringToDate("Y-m-d", $row['from_date']) : null;
                    $to_date = $row['to_date'] ? DateTimeHelper::stringToDate("Y-m-d", $row['to_date']) : null;
                    $insuranceRecords[] = new Insurance(
                        (int)$row['insurance_id'],
                        false,
                        null,
                        $row['patient_id'],
                        $pn, $row['iname'],
                        $from_date,
                        $to_date
                    );
                }
            }
            $patientData['insuranceRecords'] = $insuranceRecords;
            return $patientData;
        } else {
            return null;
        }
    }

    /**
     * Prints the insurance status by a given date.
     *
     * @param string $date The date to check, in 'MM-DD-YY' format.
     * @throws Exception If the date format is invalid.
     */
    public function printInsuranceStatusByDate(string $date): void {
        foreach ($this->insuranceRecords as $insurance) {
            $isValid = $insurance->isEffectiveOnDate($date) ? 'Yes' : 'No';
            echo "{$this->pn}, {$this->getFullName()}, {$insurance->getIname()}, $isValid\n";
        }
    }


    #[\Override] public function getId(): int
    {
        return $this->id;
    }

    #[\Override] public function getPn(): ?string
    {
        return $this->pn;
    }

    public function getFirst(): ?string
    {
        return $this->first;
    }

    public function getFullName(): ?string
    {
        $fullName = ($this->first ?: "") . " " . ($this->last ?: "");
        if (is_null($this->first) && is_null($this->last)) {
            return null;
        }
        return $fullName;
    }


    public function getLast(): ?string
    {
        return $this->last;
    }

    public function getDob(): ?DateTime
    {
        return $this->dob;
    }

    public function getInsuranceRecords(): array
    {
        return $this->insuranceRecords;
    }


}