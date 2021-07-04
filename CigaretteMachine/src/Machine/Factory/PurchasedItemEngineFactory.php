<?php

namespace App\Machine\Factory;


use App\Enum\ItemTypeEnum;
use App\Machine\Builder\ItemInterface;
use App\Machine\Builder\PurchasedItemMachineInterface;
use App\Machine\Builder\PurchaseTransactionInterface;
use App\Machine\PurchasedCigaretteItemMachine;
use App\Machine\Util\MathManager;

/**
 * Class PurchaseEngineFactory
 * @package App\Machine
 */
class PurchasedItemEngineFactory
{
    /**
     * @param ItemInterface $itemDetails
     * @param PurchaseTransactionInterface $purchaseTransactionDetails
     * @param MathManager $mathManager
     * @return PurchasedItemMachineInterface
     * @throws \InvalidArgumentException
     */
    public static function getEngine(
        ItemInterface $itemDetails,
        PurchaseTransactionInterface $purchaseTransactionDetails,
        MathManager $mathManager
    )
    {
        switch ($itemDetails->getItemType()){
            case ItemTypeEnum::CIGARETTE:
                return new PurchasedCigaretteItemMachine(
                    $itemDetails,
                    $purchaseTransactionDetails,
                    $mathManager
                );
                break;
            default:
                throw new \InvalidArgumentException('Unsupported item');
                break;
        }
    }
}