<?php


namespace Kojirock5260\TddExample\Tests;


use Kojirock5260\TddExample\Franc;
use Kojirock5260\TddExample\Money;
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
}