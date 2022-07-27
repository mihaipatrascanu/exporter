<?php
namespace app\exporter;

use PHPUnit\Framework\TestCase;

class ExporterControllerTest extends TestCase
{
    public function testPushAndPop(): void
    {
        $var = 5;
        $this->assertSame(5, $var);

    }


}