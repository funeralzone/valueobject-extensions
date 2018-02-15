<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjectExtensions\ComplexScalars;

use const DATE_RFC3339;
use DateTimeImmutable;
use DateTimeInterface;
use Funeralzone\ValueObjects\ValueObject;

trait RFC3339Trait
{
    /**
     * @var DateTimeInterface
     */
    protected $dateTime;

    /**
     * RFC3339Trait constructor.
     * @param DateTimeInterface $dateTime
     */
    public function __construct(DateTimeInterface $dateTime)
    {
        $this->dateTime = $dateTime;
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
        return ($this->toNative() === $object->toNative());
    }

    /**
     * @param string $native
     * @return static
     */
    public static function fromNative($native)
    {
        if (!is_string($native)) {
            throw new \InvalidArgumentException('Can only instantiate this object with a string.');
        }

        $dateTime = DateTimeImmutable::createFromFormat(DATE_RFC3339, $native);
        if (!$dateTime) {
            throw new \InvalidArgumentException('Can only instantiate this object with a valid RFC3339 string.');
        }

        return new self($dateTime);
    }

    /**
     * @return string
     */
    public function toNative()
    {
        return $this->dateTime->format(DATE_RFC3339);
    }

    /**
     * @return DateTimeInterface
     */
    public function toDateTime(): DateTimeInterface
    {
        return $this->dateTime;
    }

    /**
     * @return int
     */
    public function toTimestamp(): int
    {
        return $this->dateTime->getTimestamp();
    }
}
