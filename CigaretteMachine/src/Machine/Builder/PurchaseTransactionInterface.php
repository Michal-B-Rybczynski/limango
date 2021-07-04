<?php

namespace App\Machine\Builder;

use Money\Money;

/**
 * Interface PurchaseTransactionInterface
 * @package App\Machine
 */
interface PurchaseTransactionInterface
{
    /**
     * @return integer
     */
    public function getItemQuantity();

    /**
     * @return Money
     */
    public function getPaidAmount(): Money;
}