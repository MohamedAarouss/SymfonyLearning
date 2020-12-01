<?php

namespace App\Tests\Service;

use App\Service\Calculate;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    public function testAddWithPossitiveValue()
    {
        $calculator = new Calculate();
        $result = $calculator->addTwoValue(10, 10);

        $this->assertEquals(20, $result);
    }

    /**
     * @expectedException ArgumentCountError
     */
    public function testAddWithoutValue()
    {
        $calculator = new Calculate();
        $result = $calculator->addTwoValue();
    }



}
