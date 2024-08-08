<?php

namespace Integration;

use Base\BaseContractsTest\DatabaseTestCase;
require_once BASE_PATH . "App/App.Console/statistics.php";
require_once BASE_PATH . "App/App.Console/patients-data.php";

class ScriptsTest extends DatabaseTestCase
{
    public function testDisplayPatientsData()
    {
        $expectedOutput = "PN005,,,,,
PN004,Bob,Ross,HealthPlan B,2009-03-01,2026-03-14
PN002,Jane,Smith,HealthPlan A,2016-02-01,2023-06-03
PN003,Alice,Johnson,HealthPlan C,2019-08-01,2022-07-15
PN001,John,Doe,HealthPlan E,2021-05-01,2024-09-30
PN005,,,HealthPlan E,2021-05-01,2024-09-30
PN001,John,Doe,HealthPlan A,2023-01-01,2023-12-30
PN002,Jane,Smith,HealthPlan B,2023-06-01,2024-05-30
PN003,Alice,Johnson,HealthPlan C,2024-03-01,2024-10-30
PN004,Bob,Ross,HealthPlan D,2024-04-01,2024-11-30
";
        ob_start();
        displayPatientsData(self::$dbProvider);
        $output = ob_get_clean();

        $this->assertEquals($output, $expectedOutput);
    }

    public function testDisplayStatistics()
    {
        //TODO: replace with easily controllable data
        $expectedOutput = "A\t2\t5.71%
B\t2\t5.71%
C\t1\t2.86%
D\t1\t2.86%
E\t3\t8.57%
H\t3\t8.57%
I\t2\t5.71%
J\t3\t8.57%
L\t1\t2.86%
M\t1\t2.86%
N\t4\t11.43%
O\t6\t17.14%
R\t1\t2.86%
S\t4\t11.43%
T\t1\t2.86%
";
        ob_start();
        displayStatistics(self::$dbProvider);
        $output = ob_get_clean();

        $this->assertEquals($output, $expectedOutput);
    }
}