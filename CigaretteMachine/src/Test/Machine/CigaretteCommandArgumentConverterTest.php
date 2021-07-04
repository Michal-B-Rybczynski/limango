<?php

namespace App\Test\Machine;


use App\Machine\Util\MathManager;
use PHPUnit\Framework\TestCase;

/**
 * Class CigaretteCommandArgumentConverterTest
 * @package App\Test\Machine
 */
class CigaretteCommandArgumentConverterTest extends TestCase
{
    /**
     * @dataProvider intValueProvider
     * @param int $expected
     * @param string $given
     */
    public function testConvertToInt(int $expected, string $given)
    {
       $mathManager = new MathManager();
       $this->assertEquals($expected, $mathManager->convertStringToInt($given));
    }

    /**
     * @dataProvider floatValueProvider
     * @param float $expected
     * @param string $given
     */
    public function testConvertToFloat(float $expected, string $given)
    {
        $mathManager = new MathManager();
        $this->assertEquals($expected, $mathManager->convertStringToFloat($given));
    }

    /**
     * @return array
     */
    public function intValueProvider(): array
    {
        return [
            [0, '0'],
            [1, '1'],
            [2, '2.0'],
            [3, '3.5']
        ];
    }

    /**
     * @return array
     */
    public function floatValueProvider(): array
    {
        return [
            [0, '0'],
            [1.0, '1'],
            [2.11, '2.11'],
            [3.5, '3.5']
        ];
    }
}
