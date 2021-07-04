<?php

namespace App\Machine\Builder;

use App\Enum\PriceCurrencyTypeEnum;
use Money\Money;

/**
 * Interface ItemInterface
 * @package App\Machine
 */
interface ItemInterface
{
    /**
     * @param int $itemPrice
     * @param PriceCurrencyTypeEnum $priceCurrency
     * @return $this
     */
    public function setItemDetails(int $itemPrice, PriceCurrencyTypeEnum $priceCurrency): self;

    /**
     * @return string
     */
    public function getItemType(): string;

    /**
     * @return Money
     */
    public function getItemPrice(): Money;

    /**
     * @return string
     */
    public function getItemCurrency(): string;

    /**
     * @return string
     */
    public function getCurrencyCoins(): array;
}