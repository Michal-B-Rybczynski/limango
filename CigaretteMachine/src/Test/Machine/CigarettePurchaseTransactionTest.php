<?php

namespace App\Test\Machine;


use App\Machine\CigaretteCommandArgumentConverter;
use App\Machine\CigaretteItem;
use App\Machine\CigarettePurchaseTransaction;
use App\Machine\Util\MathManager;
use InvalidArgumentException;
use Money\Money;
use PHPUnit\Framework\TestCase;

/**
 * Class CigarettePurchaseTransactionTest
 * @package App\Test\Machine
 */
class CigarettePurchaseTransactionTest extends TestCase
{

    /**
     * @var MathManager
     */
    protected static MathManager $mathManager;
    /**
     * @var CigaretteItem
     */
    protected static CigaretteItem $cigaretteItem;
    /**
     * @var CigaretteCommandArgumentConverter
     */
    protected static CigaretteCommandArgumentConverter $cigaretteCommandArgumentConverter;

    /**
     *
     */
    public static function setUpBeforeClass(): void
    {
        self::$mathManager = new MathManager();
        //basic settings 4.99 currency EURs
        self::$cigaretteItem = (new CigaretteItem())->setItemDetails();
        self::$cigaretteCommandArgumentConverter = new CigaretteCommandArgumentConverter(self::$mathManager);
    }

    /**
     * @dataProvider argumentValidatorProvider
     * @param array $expected
     * @param array $given
     */
    public function testValidateArguments(array $expected, array $given)
    {
        $cigarettePurchaseTransaction =
            new CigarettePurchaseTransaction(
                $given,
                self::$cigaretteCommandArgumentConverter,
                self::$cigaretteItem
            );
        $this->assertEquals($expected[0], $cigarettePurchaseTransaction->getItemQuantity());
    }

    /**
     * @dataProvider argumentValidatorExceptionProvider
     * @param array $given
     */
    public function testValidateArgumentsException(array $given)
    {
        $this->expectException(InvalidArgumentException::class);
        new CigarettePurchaseTransaction(
            $given,
            self::$cigaretteCommandArgumentConverter,
            self::$cigaretteItem
        );
    }

    /**
     * @dataProvider argumentValidatorProvider
     * @param array $expected
     * @param array $given
     */
    public function testGetPaidAmount(array $expected, array $given)
    {
        $cigarettePurchaseTransaction = new CigarettePurchaseTransaction(
            $given,
            self::$cigaretteCommandArgumentConverter,
            self::$cigaretteItem
        );
        $this->assertInstanceOf(Money::class, $cigarettePurchaseTransaction->getPaidAmount());
    }

    /**
     * @dataProvider argumentValidatorProvider
     * @param array $expected
     * @param array $given
     */
    public function testGetItemQuantity(array $expected, array $given)
    {
        $cigarettePurchaseTransaction = new CigarettePurchaseTransaction(
            $given,
            self::$cigaretteCommandArgumentConverter,
            self::$cigaretteItem
        );
        $this->assertEquals($expected[0], $cigarettePurchaseTransaction->getItemQuantity());
    }

    /**
     * @dataProvider argumentValidatorProvider
     * @param array $expected
     * @param array $given
     */
    public function test__construct(array $expected, array $given)
    {
        $cigarettePurchaseTransaction = new CigarettePurchaseTransaction(
            $given,
            self::$cigaretteCommandArgumentConverter,
            self::$cigaretteItem
        );
        $this->assertEquals($expected[0], $cigarettePurchaseTransaction->getItemQuantity());
        $this->assertInstanceOf(Money::class, $cigarettePurchaseTransaction->getPaidAmount());
    }

    /**
     * @return array
     */
    public function argumentValidatorProvider(): array
    {
        return [
            [[1, 0], ['packs' => '1', 'amount' =>'0']],
            [[2, 10.1], ['packs' => '2.0', 'amount' =>'10.1']],
            [[3, 100.00], ['packs' => '3.1', 'amount' =>'10.1']],
        ];
    }

    /**
     * @return array
     */
    public function argumentValidatorExceptionProvider(): array
    {
        return [
            [['packs' => '1s', 'amount' =>'0']],
            [['packs' => '2.0s', 'amount' =>'10.1']],
            [['packs' => 'dsds', 'amount' =>'10.1']],
            [['packs' => '1', 'amount' =>'10.104']],
            [['packs' => '1', 'amount' =>'-10.101']],
            [['packs' => 's11', 'amount' =>'10.10']],
        ];
    }
}
