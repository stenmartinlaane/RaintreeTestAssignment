<?php

namespace Integration;

use Base\BaseContractsTest\DatabaseTestCase;
require_once BASE_PATH . "App/App.Console/statistics.php";
require_once BASE_PATH . "App/App.Console/patients-data.php";

class ScriptsTest extends DatabaseTestCase
{
    public function testDisplayPatientsData()
    {
        $expectedOutput = "PN005,Jacob,Capek,,,
PN001,John,Doe,HealthPlan E,2021-05-01,2024-09-30
PN001,John,Doe,HealthPlan A,2023-01-01,2023-12-30
PN002,Jane,Smith,HealthPlan B,2023-06-01,2024-05-30
PN003,Alice,Johnson,HealthPlan C,2024-03-01,2024-10-30
PN004,Bob,Ross,HealthPlan D,2024-04-01,2024-11-30
";
        ob_start();
        displayPatientsData();
        $output = ob_get_clean();

        $this->assertEquals($output, $expectedOutput);
    }

    public function testDisplayStatistics()
    {

        //TODO: replace with easily controllable data
        $expectedOutput = "A\t4\t8.89%
B\t3\t6.67%
C\t3\t6.67%
D\t1\t2.22%
E\t4\t8.89%
H\t3\t6.67%
I\t2\t4.44%
J\t4\t8.89%
K\t1\t2.22%
L\t1\t2.22%
M\t1\t2.22%
N\t4\t8.89%
O\t7\t15.56%
P\t1\t2.22%
R\t1\t2.22%
S\t4\t8.89%
T\t1\t2.22%
";
        ob_start();
        displayStatistics();
        $output = ob_get_clean();
        $this->assertEquals($output, $expectedOutput);
    }
}