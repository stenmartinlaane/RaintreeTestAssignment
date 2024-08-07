<?php

namespace Integration;

use App\Domain\Patient;
use Base\BaseContractsTest\DatabaseTestCase;

class PatientTest extends DatabaseTestCase
{
    public function testPatientConstructor()
    {
        $patient = new Patient('PN001', self::$dbProvider);
        $this->assertEquals('John', $patient->getFirst());
        $this->assertEquals('Doe', $patient->getLast());
        $this->assertEquals('1980-01-01', $patient->getDob()->format("Y-m-d"));
        $this->assertEquals(1, $patient->getId());
        $this->assertEquals('PN001', $patient->getPn());
    }

    public function testPatientConstructorSetsInsuranceRecords()
    {
        $patient = new Patient('PN001', self::$dbProvider);
        $this->assertEquals('HealthPlan E', $patient->getInsuranceRecords()[0]->getIname());
    }

    public function testPrintInsuranceStatusByDate()
    {
        $patient = new Patient('PN001', self::$dbProvider);
        ob_start();
        echo "PN001, John Doe, HealthPlan E, Yes\n";
        echo "PN001, John Doe, HealthPlan A, No\n";
        $expectedOutput = ob_get_clean();
        ob_start();
        $patient->printInsuranceStatusByDate("01-01-22");
        $output = ob_get_clean();

        $this->assertEquals($output, $expectedOutput);
    }
}