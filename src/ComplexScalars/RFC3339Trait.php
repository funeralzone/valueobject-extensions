<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjectExtensions\ComplexScalars;

use Funeralzone\ValueObjects\ValueObject;
use Carbon\Carbon;

trait RFC3339Trait
{
    /**
     * @var \DateTime
     */
    protected $rfc3339;

    /**
     * RFC3339Trait constructor.
     * @param \DateTime $rfc3339
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

        $datetime = \DateTime::createFromFormat(\DateTime::RFC3339, $native);
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
        return Carbon::createFromTimestamp($this->rfc3339->getTimestamp(), $this->rfc3339->getTimezone())->toRfc3339String();
    }
}
