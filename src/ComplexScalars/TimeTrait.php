<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjectExtensions\ComplexScalars;

use Funeralzone\ValueObjects\ValueObject;

trait TimeTrait
{
    /**
     * @var string
     */
    protected $string;


    /**
     * TimeTrait constructor.
     * @param string $string
     */
    public function __construct(string $string)
    {
        $dateObj = \DateTime::createFromFormat('d.m.Y H:i', "10.10.2010 " . $string);
        if ($dateObj === false || !$dateObj || $dateObj->format('H:i') !== $string) {
            throw new \InvalidArgumentException('Can only instantiate this object with a valid time HH:MM');
        }

        $this->string = $string;
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
        return new static($native);
    }

    /**
     * @return string
     */
    public function toNative()
    {
        return $this->string;
    }
}
