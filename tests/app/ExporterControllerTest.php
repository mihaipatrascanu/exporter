<?php
namespace app\exporter;

use PHPUnit\Framework\TestCase;

class ExporterControllerTest extends TestCase
{
    public function testPushAndPop(): void
    {
        $var = 5;
        $this->assertSame(5, $var);
        
        
        $today = date("Y-m-d");
        $data = ExporterFactory::getMoneyDay($today, $nextMonths = 11, $bonusDay = 10);
        
        //check number of rows
        $this->assertSame(12, count($data));

        //check a bonus day from Dec/22 -> 2022-12-12
        $this->assertSame("2022-12-12", $data[5]['bonusPayment']);

        //check a salary day from Dec/22 -> 2023-04-28
        $this->assertSame("2023-04-28", $data[9]['basicPayment']);


    }


}