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

    /**
     * @expectedException ArgumentCountError
     */
    public function testAddTwoValueWithThresholdWithoutValue(){

        $calculator = new Calculate();
        $result = $calculator->addTwoValueWithThreshold();
    }

    public function testAddTwoValueWithThresholdWithTwoValueInt(){

        $calculator = new Calculate();
        $result = $calculator->addTwoValueWithThreshold(5, 5);

        $this->assertEquals(10, $result);

    }

    public function testAddTwoValueWithThresholdWithTwoValueIntNegative(){

        $calculator = new Calculate();
        $result = $calculator->addTwoValueWithThreshold(-5, -5);

        $this->assertEquals(Calculate::min, $result);

    }

    public function testAddTwoValueWithThresholdWithTwoValueIntPositive(){

        $calculator = new Calculate();
        $result = $calculator->addTwoValueWithThreshold(200, 200);

        $this->assertEquals(Calculate::max, $result);

    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testAddTwoValueWithThresholdWithValueNotInt(){

        $calculator = new Calculate();
        $result = $calculator->addTwoValueWithThreshold(true, 25);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testAddTwoValueWithThresholdWithValueNotIntSecondParameter(){

        $calculator = new Calculate();
        $result = $calculator->addTwoValueWithThreshold(15, null);
    }


}
