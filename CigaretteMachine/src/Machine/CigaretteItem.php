<?php

namespace App\Machine;


use App\Enum\ItemTypeEnum;
use App\Enum\PriceCurrencyTypeEnum;
use App\Machine\Builder\ItemInterface;
use Money\Money;

/**
 * Class CigaretteItem
 * @package App\Machine
 */
class CigaretteItem implements ItemInterface
{
    /**
     * @var Money
     */
    private Money $_itemPrice;
    /**
     * @var string
     */
    private string $_itemCurrency;
    /**
     * @var string
     */
    private string $_itemType;

    /**
     * @param int $itemPrice
     * @param PriceCurrencyTypeEnum|null $currency
     * @return $this
     */
    public function setItemDetails(int $itemPrice = 499, PriceCurrencyTypeEnum $currency = null): self
    {
        $this->_itemCurrency = $currency ?? PriceCurrencyTypeEnum::EURO;
        $this->_itemPrice = Money::{$this->_itemCurrency}($itemPrice);
        $this->_itemType = ItemTypeEnum::CIGARETTE;
        return $this;
    }

    /**
     * @return Money
     */
    public function getItemPrice():Money
    {
        return $this->_itemPrice;
    }

    /**
     * @return string
     */
    public function getItemCurrency(): string
    {
        return $this->_itemCurrency;
    }

    /**
     * @return string
     */
    public function getItemType(): string
    {
        return $this->_itemType;
    }

    /**
     * @return array
     */
    public function getCurrencyCoins(): array{
        $coins = [];
        switch ($this->_itemCurrency){
            case PriceCurrencyTypeEnum::EURO:
                $coins = [
                    "2" => [2 , 0],
                    "1" => [1 , 0],
                    "0.5" => [0.5, 0],
                    "0.2" => [0.2, 0],
                    "0.1" => [0.1, 0],
                    "0.05" => [0.05, 0],
                    "0.02" => [0.02, 0],
                    "0.01" => [0.01, 0]
                ];
                break;
            default: break;
        }
        return $coins;
    }

}