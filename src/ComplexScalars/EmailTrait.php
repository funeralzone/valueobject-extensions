<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjectExtensions\ComplexScalars;

use Funeralzone\ValueObjects\ValueObject;

trait EmailTrait
{
    /**
     * @var string
     */
    protected $string;


    /**
     * EmailTrait constructor.
     * @param string $string
     */
    public function __construct(string $string)
    {
        if (!filter_var($string, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid email address.');
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
