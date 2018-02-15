<?php

declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: kevbaldwyn
 * Date: 14/02/2018
 * Time: 14:58
 */

namespace Funeralzone\ValueObjectExtensions\ComplexScalars;


use Funeralzone\ValueObjects\ValueObject;
use League\Uri\Exception;
use League\Uri\Factory;
use Psr\Http\Message\UriInterface;

trait UriTrait
{
    /**
     * @var UriInterface
     */
    protected $uri;

    public function __construct(UriInterface $uri)
    {
        $this->uri = $uri;
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
     *
     * @return bool
     */
    public function isSame(ValueObject $object): bool
    {
        return ($this->toNative() === $object->toNative());
    }

    /**
     * @param string $native
     *
     * @throws Exception
     * @return static
     */
    public static function fromNative($native)
    {
        if (!is_string($native)) {
            throw new \InvalidArgumentException('Can only instantiate this object with a string.');
        }

        $factory = new Factory();
        $uri     = $factory->create($native);

        return new self($uri);
    }

    /**
     * @return string
     */
    public function toNative()
    {
        return $this->uri->__toString();
    }
}
