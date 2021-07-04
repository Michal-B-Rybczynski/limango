<?php

namespace App\Machine;


use App\Machine\Builder\ItemInterface;
use App\Machine\Builder\PurchasedItemMachineInterface;
use App\Machine\Builder\PurchaseTransactionInterface;
use App\Machine\Util\MathManager;
use InvalidArgumentException;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;

/**
 * Class PurchasedCigaretteItemEngine
 * @package App\Machine
 */
class PurchasedCigaretteItemMachine implements PurchasedItemMachineInterface
{
    /**
     * @var ItemInterface
     */
    private ItemInterface $_itemDetails;

    /**
     * @var MathManager
     */
    private MathManager $_mathManager;

    /**
     * @var Money
     */
    private Money $_totalPrice;

    /**
     * @var PurchaseTransactionInterface
     */
    private PurchaseTransactionInterface $_purchaseTransactionDetails;

    /**
     * PurchasedCigaretteItemEngine constructor.
     * @param ItemInterface $itemDetails
     * @param PurchaseTransactionInterface $purchaseTransactionDetails
     * @param MathManager $mathManager
     */
    public function __construct(
        ItemInterface $itemDetails,
        PurchaseTransactionInterface $purchaseTransactionDetails,
        MathManager $mathManager
    )
    {
        $this->_itemDetails = $itemDetails;
        $this->_purchaseTransactionDetails = $purchaseTransactionDetails;
        $this->_mathManager = $mathManager;
    }

    /**
     * @return integer
     */
    public function getItemQuantity() : int
    {
        return $this->_purchaseTransactionDetails->getItemQuantity();
    }

    /**
     * @return ItemInterface
     */
    public function getItemDetails() : ItemInterface
    {
        return $this->_itemDetails;
    }

    /**
     * @return Money
     */
    public function getPaidAmount(): Money
    {
        return $this->_purchaseTransactionDetails->getPaidAmount();
    }

    /**
     * @return Money
     */
    public function getTotalPrice(): Money
    {
        return $this->_totalPrice;
    }

    /**
     * @return float
     */
    public function calculateChange(): float
    {
        $this->_totalPrice =
            $this->_itemDetails->getItemPrice()
                ->multiply($this->getItemQuantity());
        $totalChange =
            $this->getPaidAmount()->subtract(
                $this->_itemDetails->getItemPrice()
                    ->multiply($this->getItemQuantity())
            );

        $currencies = new ISOCurrencies();
        $moneyFormatter = new DecimalMoneyFormatter($currencies);
        if($moneyFormatter->format($totalChange) < 0){
            throw new InvalidArgumentException('Not enough money to perform requested operation.');
        }
        return $moneyFormatter->format($totalChange);
    }

    /**
     * @param float $totalChange
     * @return array
     */
    public function getChangeCoinCombination(float $totalChange): array{
        $changeCoins = $this->_itemDetails->getCurrencyCoins();

        foreach ($changeCoins as $coin => $coinDetails) {
            if($totalChange >= $coinDetails[0]) {
                $coinCounter = $this->bcFloor(bcdiv($totalChange, $coinDetails[0], 2));
                if ($coinCounter) {
                    $changeCoins[$coin][1] = $coinCounter;
                    $totalChange -= bcmul($coinCounter, $coinDetails[0], 2);
                }
            }
        }

        return array_filter(
            array_values($changeCoins),
            function($coinCounter){
                if($coinCounter[1] > 0){
                    return $coinCounter;
                }
            }
        );
    }

    /**
     * @param $number
     * @param int $precision
     * @return string
     */
    function bcFloor($number, $precision = 0) {
        return bcadd($number, '0', $precision);
    }
}