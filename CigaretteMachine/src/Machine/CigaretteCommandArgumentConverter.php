<?php

namespace App\Machine;


use App\Machine\Builder\CommandArgumentConverterInterface;
use App\Machine\Util\MathManager;

/**
 * Class CigaretteCommandArgumentConverter
 * @package App\Machine
 */
class CigaretteCommandArgumentConverter implements CommandArgumentConverterInterface
{
    /**
     * @var MathManager
     */
    private MathManager $_mathManager;

    /**
     * CigaretteCommandArgumentConverter constructor.
     * @param MathManager $mathManager
     */
    public function __construct(MathManager $mathManager)
    {
        $this->_mathManager = $mathManager;
    }

    /**
     * @param string $itemQuantity
     * @return int
     */
    public function convertToInt(string $itemQuantity){
        return $this->_mathManager->convertStringToInt($itemQuantity);
    }

    /**
     * @param string $paidAmount
     * @return float
     */
    public function convertToFloat(string $paidAmount){
        return $this->_mathManager->convertStringToFloat($paidAmount);
    }
}