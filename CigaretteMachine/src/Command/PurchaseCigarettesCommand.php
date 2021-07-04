<?php

namespace App\Command;

use App\Machine\PurchasedCigaretteItemEngineBuilder;
use App\Machine\Util\MathManager;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CigaretteMachine
 * @package App\Command
 */
class PurchaseCigarettesCommand extends Command
{
    /**
     * @return void
     */
    protected function configure()
    {
        $this->addArgument(
            'packs',
            InputArgument::REQUIRED,
            "How many packs do you want to buy? Shoudl be numeric. In case fload wit will be rounded down to int"
        );
        $this->addArgument(
            'amount',
            InputArgument::REQUIRED,
            "The amount in euro. Amount in 2 digits precision"
        );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $inputArguments = $input->getArguments();
        $purchasedCigaretteEngineBuilder = new PurchasedCigaretteItemEngineBuilder(new MathManager());
        $purchasedCigaretteEngine = $purchasedCigaretteEngineBuilder->buildPurchasedItemCigaretteEngine($inputArguments);
        $change = $purchasedCigaretteEngine->calculateChange();
        $changeCoins = $purchasedCigaretteEngine->getChangeCoinCombination($change);

        $itemPrice = $purchasedCigaretteEngine->getItemDetails()->getItemPrice();
        $totalPrice = $purchasedCigaretteEngine->getTotalPrice();

        $currencyFormatter = $this->getCurrencyFormatter();

        $this->printToConsole(
            $output,
            $changeCoins,
            $purchasedCigaretteEngine->getItemQuantity(),
            $currencyFormatter->format($totalPrice),
            $currencyFormatter->format($itemPrice)
        );
    }

    /**
     * @param OutputInterface $output
     * @param array $changeCoins
     * @param int $itemQuantity
     * @param string $totalPrice
     * @param string $itemPrice
     * @TODO last step would be to change this to flexible interface where we can chose type of the diplay like (consol, file, pdf ect)
     */
    private function printToConsole(
        OutputInterface $output,
        array $changeCoins,
        int $itemQuantity,
        string $totalPrice,
        string $itemPrice
    ){
        $output->writeln("You bought <info>$itemQuantity</info> " .
                                        "packs of cigarettes for <info>-$totalPrice</info>" .
                                            ", each for <info>-$itemPrice</info>. ");
        $output->writeln('Your change is:');
        $table = new Table($output);
        $table->setHeaders(array('Coins', 'Count'))->setRows($changeCoins);
        $table->render();
    }

    /**
     * @return IntlMoneyFormatter
     * @TODO parametrize to be aligned with country code
     */
    private function getCurrencyFormatter (){
        $currencies = new ISOCurrencies();
        $numberFormatter = new \NumberFormatter('en_US', \NumberFormatter::CURRENCY);
        return new IntlMoneyFormatter($numberFormatter, $currencies);
    }
}