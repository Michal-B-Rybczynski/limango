<?php


namespace App\Machine\Builder;



/**
 * Interface PurchasedItemEngineBuilderInterface
 * @package App\Machine
 */
interface PurchasedItemEngineBuilderInterface
{
    /**
     * @return ItemInterface
     */
    public function setItemDetails(): ItemInterface;

    /**
     * @return CommandArgumentConverterInterface
     */
    public function setCommandArgumentConverter(): CommandArgumentConverterInterface;

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
    ): PurchaseTransactionInterface;

    /**
     * @param ItemInterface $itemDetails
     * @param PurchaseTransactionInterface $purchaseTransactionDetails
     * @return PurchasedItemMachineInterface
     */
    public function getPurchaseItemEngine(
        ItemInterface $itemDetails,
        PurchaseTransactionInterface $purchaseTransactionDetails
    ): PurchasedItemMachineInterface;
}