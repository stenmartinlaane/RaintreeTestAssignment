<?php

namespace App\Domain;

use Base\BaseContractsDAL\IDbProvider;
use Base\BaseContractsDomain\PatientRecord;
use DateTime;
use Exception;
use Helpers\DateTimeHelper;

class Insurance implements PatientRecord
{
    private int $_id;
    private int $patientId;
    private ?string $pn;
    private ?string $iname;
    private ?DateTime $fromDate;
    private ?DateTime $toDate;
    private IDbProvider $dbProvider;

    /**
     * @throws \Exception
     */
    public function __construct(
        int $_id,
        bool $dbProviderNeeded,
        ?IDbProvider $dbProvider = null,
        ?int $patientId = null,
        ?string $pn = null,
        ?string $iname = null,
        ?DateTime $fromDate = null,
        ?DateTime $toDate = null
    ) {
        if ($dbProviderNeeded) {
            global $container;
            $this->dbProvider = $dbProvider ?? $container->make(IDbProvider::class);
        }
        if (is_null($patientId) || is_null($pn) || is_null($iname) || is_null($fromDate) || is_null($toDate)) {
            $insuranceData = $this->fetchInsuranceDataById($_id);

            if ($insuranceData) {
                $this->_id = $_id;
                $this->patientId = $insuranceData['patient_id'];
                $this->pn = $insuranceData['pn'];
                $this->iname = $insuranceData['iname'];
                $this->fromDate = DateTimeHelper::stringToDate("Y-m-d", $insuranceData['from_date']);
                $this->toDate = DateTimeHelper::stringToDate("Y-m-d", $insuranceData['to_date']);
            } else {
                // Handle cases where no insurance data is found
                throw new \Exception("Insurance not found.");
            }
        } else {
            $this->_id = $_id;
            $this->patientId = $patientId;
            $this->pn = $pn;
            $this->iname = $iname;
            $this->fromDate = $fromDate;
            $this->toDate = $toDate;
        }
    }

    private function fetchInsuranceDataById(string $id): ?array
    {
        $sql = "SELECT insurance.patient_id, insurance.iname, insurance.from_date, insurance.to_date, patient.pn
            FROM insurance 
            LEFT JOIN patient on patient._id = insurance.patient_id
            WHERE insurance._id = ?
            ";

        $stmt = $this->dbProvider->prepareStatement($sql);
        $stmt->bind_param("s", $id);
        $result = $this->dbProvider->executeStatement($stmt);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    /**
     * Checks if the insurance is effective on a given date.
     *
     * @param string $date The date to check, in 'MM-DD-YY' format.
     * @return bool True if the insurance is effective on the given date, false otherwise.
     * @throws Exception If the date format is invalid.
     */
    public function isEffectiveOnDate(string $date): bool {
        $formattedDate = DateTimeHelper::stringToDate('m-d-y', $date);
        return $formattedDate >= $this->getFromDate() && ($this->getToDate() === null || $formattedDate <= $this->getToDate());
    }

    #[\Override] public function getId(): int
    {
        return $this->_id;
    }

    public function getPatientId(): int
    {
        return $this->patientId;
    }


    #[\Override] public function getPn(): ?string
    {
        return $this->pn;
    }

    public function getIname(): ?string
    {
        return $this->iname;
    }

    public function getFromDate(): ?DateTime
    {
        return $this->fromDate;
    }

    public function getToDate(): ?DateTime
    {
        return $this->toDate;
    }
}