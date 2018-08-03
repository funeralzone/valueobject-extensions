<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjectExtensions\ComplexScalars;

use Funeralzone\ValueObjects\ValueObject;
use function method_exists;
use Money\Currency;
use Money\Money;
use function var_dump;

trait MoneyTrait
{
    /**
     * @var Money
     */
    protected $money;

    /**
     * MoneyTrait constructor.
     * @param Money $money
     */
    public function __construct(Money $money)
    {
        $this->money = $money;
    }

    /**
     * @return bool
     */
    public function isNull(): bool
    {
        return false;
    }

    /**
     * @param ValueObject $object
     * @return bool
     */
    public function isSame(ValueObject $object): bool
    {
        return ($object->toNative() == $this->toNative());
    }

    /**
     * @param array $native
     * @return static
     */
    public static function fromNative($native)
    {
        return new static(new Money(
            (string) $native['amount'],
            new Currency($native['currency'])
        ));
    }

    /**
     * @return array
     */
    public function toNative()
    {
        return [
            'amount' => $this->money->getAmount(),
            'currency' => $this->money->getCurrency()->getCode(),
        ];
    }

    /**
     * @return Money
     */
    public function getMoney(): Money
    {
        return $this->money;
    }
}
