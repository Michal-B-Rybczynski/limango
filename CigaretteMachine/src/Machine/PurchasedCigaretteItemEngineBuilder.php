<?php


namespace App\Machine;


use App\Machine\Builder\CommandArgumentConverterInterface;
use App\Machine\Builder\ItemInterface;
use App\Machine\Builder\PurchasedItemEngineBuilderInterface;
use App\Machine\Builder\PurchasedItemMachineInterface;
use App\Machine\Builder\PurchaseTransactionInterface;
use App\Machine\Factory\PurchasedItemEngineFactory;
use App\Machine\Util\MathManager;

/**
 * Class PurchasedCigaretteEngineBuilder
 * @package App\Machine
 */
class PurchasedCigaretteItemEngineBuilder implements PurchasedItemEngineBuilderInterface
{
    /**
     * @var MathManager
     */
    private MathManager $_mathManager;

    /**
     * PurchasedCigaretteItemEngineBuilder constructor.
     * @param MathManager $mathManager
     */
    public function __construct(MathManager $mathManager)
    {
        $this->_mathManager = $mathManager;
    }

    /**
     * @param $inputArguments
     * @return PurchasedItemMachineInterface
     * @throws \Exception
     */
    public function buildPurchasedItemCigaretteEngine ($inputArguments){
        $itemDetails = $this->setItemDetails();
        $commandArgumentConverter = $this->setCommandArgumentConverter();
        $purchaseTransactionDetails = $this->setItemPurchaseTransaction(
            $inputArguments,
            $commandArgumentConverter,
            $itemDetails
        );
        return $this->getPurchaseItemEngine($itemDetails, $purchaseTransactionDetails);
    }

    /**
     * @return ItemInterface
     */
    public function setItemDetails(): ItemInterface{
            return (new CigaretteItem())->setItemDetails();
    }

    /**
     * @return CommandArgumentConverterInterface
     */
    public function setCommandArgumentConverter(): CommandArgumentConverterInterface{
            return new CigaretteCommandArgumentConverter($this->_mathManager);
    }

    /**
     * @param array $inputArguments
     * @param CommandArgumentConverterInterface $commandArgumentConverter
     * @param ItemInterface $itemDetails
     * @return PurchaseTransactionInterface
     */
    public function setItemPurchaseTransaction(
        array $inputArguments,
        CommandArgumentConverterInterface $commandArgumentConverter,
        ItemInterface $itemDetails
    ): PurchaseTransactionInterface{
            return new CigarettePurchaseTransaction(
            $inputArguments,
            $commandArgumentConverter,
            $itemDetails
        );
    }

    /**
     * @param ItemInterface $itemDetails
     * @param PurchaseTransactionInterface $purchaseTransactionDetails
     * @return PurchasedItemMachineInterface
     * @throws \Exception
     */
    public function getPurchaseItemEngine(
        ItemInterface $itemDetails,
        PurchaseTransactionInterface $purchaseTransactionDetails
    ): PurchasedItemMachineInterface{
        return PurchasedItemEngineFactory::getEngine(
            $itemDetails,
            $purchaseTransactionDetails,
            $this->_mathManager
        );
    }
}
