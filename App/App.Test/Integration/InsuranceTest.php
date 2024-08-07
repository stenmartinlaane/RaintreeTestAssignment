<?php

namespace Integration;

use App\DAL\DbProvider;
use App\Domain\Insurance;
use App\Domain\Patient;
use Base\BaseContractsDAL\IDbProvider;
use Base\BaseContractsTest\DatabaseTestCase;
use Database\DatabaseCreator;
use Database\DatabaseMigrator;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class InsuranceTest extends DatabaseTestCase
{

    public function testPatientConstructor()
    {
        $insurance = new Insurance(1, true, self::$dbProvider);
        $this->assertEquals(1, $insurance->getId());
        $this->assertEquals('HealthPlan A', $insurance->getIname());
        $this->assertEquals('2023-01-01', $insurance->getFromDate()->format("Y-m-d"));
        $this->assertEquals('2023-12-30', $insurance->getToDate()->format("Y-m-d"));
        $this->assertEquals(1, $insurance->getPatientId());
        $this->assertEquals('PN001', $insurance->getPn());
    }

    public function testisEffectiveOnDate()
    {
        $insurance = new Insurance(1, true, self::$dbProvider);
        $this->assertTrue($insurance->isEffectiveOnDate("01-01-23"));
        $this->assertTrue($insurance->isEffectiveOnDate("12-30-23"));
        $this->assertTrue($insurance->isEffectiveOnDate("6-15-23"));
        $this->assertFalse($insurance->isEffectiveOnDate("01-01-22"));
        $this->assertFalse($insurance->isEffectiveOnDate("01-01-24"));
    }
}