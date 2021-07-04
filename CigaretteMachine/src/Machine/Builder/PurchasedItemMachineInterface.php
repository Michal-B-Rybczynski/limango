<?php

namespace App\Machine\Builder;

use Money\Money;

/**
 * Interface PurchasedItemMachineInterface
 * @package App\Machine
 */
interface PurchasedItemMachineInterface
{
    /**
     * @return integer
     */
    public function getItemQuantity(): int;

    /**
     * @return Money
     */
    public function getPaidAmount(): Money;

    /**
     * @return Money
     */
    public function getTotalPrice(): Money;

    /**
     * Returns the change in this format:
     *
     * Coin Count
     * 0.01 0
     * 0.02 0
     * .... .....
     *
     * @param float $change
     * @return array
     */
    public function getChangeCoinCombination(float $change): array;

    /**
     * @return float
     */
    public function calculateChange(): float;

    /**
     * @return ItemInterface
     */
    public function getItemDetails(): ItemInterface;

}