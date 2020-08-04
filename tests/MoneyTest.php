<?php


namespace Kojirock5260\TddExample\Tests;


use Kojirock5260\TddExample\Bank;
use Kojirock5260\TddExample\Franc;
use Kojirock5260\TddExample\Money;
use Kojirock5260\TddExample\Sum;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    /**
     * @test
     */
    public function multiplication()
    {
        $five = Money::dollar(5);
        self::assertEquals(Money::dollar(10), $five->times(2));
        self::assertEquals(Money::dollar(15), $five->times(3));
    }

    /**
     * @test
     */
    public function equality()
    {
        self::assertTrue(Money::dollar(5)->equals(Money::dollar(5)), '同じ通貨で数量が同じなので真となる');
        self::assertFalse(Money::dollar(5)->equals(Money::dollar(6)), '同じ通貨で数量が違うので偽となる');
        self::assertTrue(Money::franc(5)->equals(Money::franc(5)), '同じ通貨で数量が同じなので真となる');
        self::assertFalse(Money::franc(5)->equals(Money::franc(6)), '同じ通貨で数量が違うので偽となる');
        self::assertFalse(Money::franc(5)->equals(Money::dollar(5)), '異なる通貨は偽となる');
    }

    /**
     * @test
     */
    public function francMultiplication()
    {
        $five = Money::franc(5);
        self::assertEquals(Money::franc(10), $five->times(2));
        self::assertEquals(Money::franc(15), $five->times(3));
    }

    /**
     * @test
     */
    public function currency()
    {
        self::assertSame('USD', Money::dollar(1)->currency());
        self::assertSame('CHF', Money::franc(1)->currency());
    }

    /**
     * @test
     */
    public function differentClassEquality()
    {
        self::assertTrue((new Money(10, 'CHF'))->equals(new Franc(10, 'CHF')));
    }

    /**
     * @test
     */
    public function simpleAddition()
    {
        $five = Money::dollar(5);
        $sum = $five->plus($five);
        $bank = new Bank();
        $reduced = $bank->reduce($sum, 'USD');
        self::assertEquals(Money::dollar(10), $reduced);
    }

    /**
     * @test
     */
    public function plusReturnsSum()
    {
        $five = Money::dollar(5);
        $result = $five->plus($five);
        self::assertEquals($five, $result->augend);
        self::assertEquals($five, $result->addend);
    }

    /**
     * @test
     */
    public function plusReduceSum()
    {
        $sum = new Sum(Money::dollar(3), Money::dollar(4));
        $bank = new Bank();
        $result = $bank->reduce($sum, 'USD');
        self::assertEquals(Money::dollar(7), $result);
    }

    /**
     * @test
     */
    public function plusReduceMoney()
    {
        $bank = new Bank();
        $result = $bank->reduce(Money::dollar(1), 'USD');
        self::assertEquals(Money::dollar(1), $result);
    }

    /**
     * @test
     */
    public function reduceMoneyDifferentCurrency()
    {
        $bank = new Bank();
        $bank->addRate("CHF", "USD", 2);
        $result = $bank->reduce(Money::franc(2), "USD");
        self::assertEquals(Money::dollar(1), $result);
    }

    /**
     * @test
     */
    public function identityRate()
    {
        self::assertEquals(1, (new Bank())->rate('USD', 'USD'));
    }

    /**
     * @test
     */
    public function mixedAddition()
    {
        $fiveBucks = Money::dollar(5);
        $tenFrancs = Money::franc(10);
        $bank = new Bank();
        $bank->addRate("CHF", "USD", 2);
        $result = $bank->reduce($fiveBucks->plus($tenFrancs), "USD");
        self::assertEquals(Money::dollar(10), $result);
    }

    /**
     * @test
     */
    public function sumPlusMoney()
    {
        $fiveBucks = Money::dollar(5);
        $tenFrancs = Money::franc(10);
        $bank = new Bank();
        $bank->addRate('CHF', 'USD', 2);
        $sum = (new Sum($fiveBucks, $tenFrancs))->plus($fiveBucks);
        $result = $bank->reduce($sum, 'USD');
        self::assertEquals(Money::dollar(15), $result);
    }

    /**
     * @test
     */
    public function sumTimes()
    {
        $fiveBucks = Money::dollar(5);
        $tenFrancs = Money::franc(10);
        $bank = new Bank();
        $bank->addRate('CHF', 'USD', 2);
        $sum = (new Sum($fiveBucks, $tenFrancs))->times(2);
        $result = $bank->reduce($sum, 'USD');
        self::assertEquals(Money::dollar(20), $result);
    }
}