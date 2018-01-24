<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjectExtensions\ComplexScalars;

use const DATE_RFC3339;
use DateTimeImmutable;
use Funeralzone\ValueObjects\ValueObject;

trait RFC3339Trait
{
    /**
     * @var \DateTimeInterface
     */
    protected $rfc3339;

    /**
     * RFC3339Trait constructor.
     * @param \DateTimeInterface $rfc3339
     */
    public function __construct(\DateTimeInterface $rfc3339)
    {
        $this->rfc3339 = $rfc3339;
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

        $datetime = DateTimeImmutable::createFromFormat(DATE_RFC3339, $native);
        if (!$datetime) {
            throw new \InvalidArgumentException('Can only instantiate this object with a valid RFC3339 string.');
        }

        return new self($datetime);
    }

    /**
     * @return string
     */
    public function toNative()
    {
        return $this->rfc3339->format(DATE_RFC3339);
    }
}
