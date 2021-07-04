<?php

namespace App\Machine;


use App\Machine\Builder\CommandArgumentConverterInterface;
use App\Machine\Builder\ItemInterface;
use App\Machine\Builder\PurchaseTransactionInterface;
use InvalidArgumentException;
use Money\Money;

/**
 * Class CigarettePurchaseTransaction
 * @package App\Machine
 */
class CigarettePurchaseTransaction implements PurchaseTransactionInterface
{
    /**
     * @var int
     */
    private int $_itemQuantity;
    /**
     * @var ItemInterface
     */
    private ItemInterface $_itemDetails;
    /**
     * @var Money
     */
    private Money $_paidAmount;
    /**
     * @var CommandArgumentConverterInterface
     */
    private CommandArgumentConverterInterface $_cigaretteCommandArgumentConverter;

    /**
     * CigarettePurchaseTransaction constructor.
     * @param array $inputArguments
     * @param CommandArgumentConverterInterface $cigaretteCommandArgumentConverter
     * @param ItemInterface $itemDetails
     */
    public function __construct(
        array $inputArguments,
        CommandArgumentConverterInterface $cigaretteCommandArgumentConverter,
        ItemInterface $itemDetails
    )
    {
        $this->_cigaretteCommandArgumentConverter = $cigaretteCommandArgumentConverter;
        $this->_itemDetails = $itemDetails;
        $this->validateArguments($inputArguments);
        $this->setItemQuantity($inputArguments);
        $this->setPaidAmount($inputArguments);
    }

    /**
     * @param $args
     */
    public function setItemQuantity($args){
        $this->_itemQuantity = $this->_cigaretteCommandArgumentConverter->convertToInt($args['packs']);
    }

    /**
     * @param $args
     */
    public function setPaidAmount($args){
        $itemCurrency = $this->_itemDetails->getItemCurrency();
        try {
            $this->_paidAmount = Money::$itemCurrency(
                $this->_cigaretteCommandArgumentConverter->convertToFloat($args['amount']) * 100
            );
        } Catch (InvalidArgumentException $e){
            Throw new InvalidArgumentException("Given amount has not right precision (2 digits)");
        }
    }

    /**
     * @return int
     */
    public function getItemQuantity(): int{
        return $this->_itemQuantity;
    }

    /**
     * @return Money
     */
    public function getPaidAmount(): Money{
        return $this->_paidAmount;
    }

    /**
     * @param $args
     */
    public function validateArguments($args){
        if(!is_numeric($args['packs']) || !is_numeric($args['amount'])){
            throw new InvalidArgumentException("script arguments should be numeric values");
        }
    }
}