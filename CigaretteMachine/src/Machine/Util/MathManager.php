<?php


namespace App\Machine\Util;


/**
 * Class MathManager
 * @package App\Machine
 */
class MathManager
{
    /**
     * @param string $number
     * @return int
     */
    public function convertStringToInt(string $number): int
    {
        return (int)$number;
    }

    /**
     * @param string $paidAmount
     * @return float
     */
    public function convertStringToFloat(string $paidAmount): float
    {
        return floatval($paidAmount);
    }

}