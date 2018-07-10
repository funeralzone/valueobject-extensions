<?php

// @codingStandardsIgnoreFile

declare(strict_types=1);

namespace Funeralzone\ValueObjectExtensions\ComplexScalars;

use Funeralzone\ValueObjects\ValueObject;
use Money\Currency;
use Money\Money;
use PHPUnit\Framework\TestCase;

final class MoneyTraitTest extends TestCase
{
    public function test_is_null_returns_false()
    {
        $test = new _MoneyTrait(new Money('500', new Currency('USD')));
        $this->assertFalse($test->isNull());
    }

    public function test_is_same_returns_true_when_amount_and_currency_match()
    {
        $money = new Money('1000', new Currency('USD'));

        $test1 = new _MoneyTrait($money);
        $test2 = new _MoneyTrait($money);

        $this->assertTrue($test1->isSame($test2));
    }

    public function test_is_same_returns_false_amount_does_not_match()
    {
        $money1 = new Money('1000', new Currency('USD'));
        $money2 = new Money('1001', new Currency('USD'));

        $test1 = new _MoneyTrait($money1);
        $test2 = new _MoneyTrait($money2);

        $this->assertFalse($test1->isSame($test2));
    }

    public function test_is_same_returns_false_currency_does_not_match()
    {
        $money1 = new Money('50', new Currency('USD'));
        $money2 = new Money('50', new Currency('SGD'));

        $test1 = new _MoneyTrait($money1);
        $test2 = new _MoneyTrait($money2);

        $this->assertFalse($test1->isSame($test2));
    }

    public function test_from_native_instantiates()
    {
        $native = [
            'amount' => '63',
            'currency' => 'USD'
        ];

        $test = _MoneyTrait::fromNative($native);
        $this->assertEquals($native, $test->toNative());
    }


    public function test_to_native_returns_correct_representation_of_money()
    {
        $money = new Money('1200', new Currency('USD'));

        $test = new _MoneyTrait($money);
        $this->assertEquals([
            'amount' => '1200',
            'currency' => 'USD'
        ], $test->toNative());
    }

    public function test_returns_correct_money_object()
    {
        $money = new Money('5000', new Currency('GBP'));

        $test = new _MoneyTrait($money);
        $this->assertEquals('5000', $test->getMoney()->getAmount());
        $this->assertEquals('GBP', $test->getMoney()->getCurrency()->getCode());
    }
}

final class _MoneyTrait implements ValueObject
{
    use MoneyTrait;
}
