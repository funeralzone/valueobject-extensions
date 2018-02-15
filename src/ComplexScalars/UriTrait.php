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

    /**
     * @return UriInterface
     */
    public function getPsr7Uri()
    {
        return $this->uri;
    }

    /**
     * @param string $scheme
     *
     * @return UriTrait
     */
    public function withScheme(string $scheme)
    {
        return new self($this->uri->withScheme($scheme));
    }

    /**
     * @param string      $user
     * @param string|null $password
     *
     * @return UriTrait
     */
    public function withUserInfo(string $user, string $password = null)
    {
        return new self($this->uri->withUserInfo($user, $password));
    }

    /**
     * @param string $host
     *
     * @return UriTrait
     */
    public function withHost(string $host)
    {
        return new self($this->uri->withHost($host));
    }

    /**
     * @param int $port
     *
     * @return UriTrait
     */
    public function withPort(int $port)
    {
        return new self($this->uri->withPort($port));
    }

    /**
     * @param string $path
     *
     * @return UriTrait
     */
    public function withPath(string $path)
    {
        return new self($this->uri->withPath($path));
    }

    /**
     * @param string $query
     *
     * @return UriTrait
     */
    public function withQuery(string $query)
    {
        return new self($this->uri->withQuery($query));
    }

    /**
     * @param string $fragment
     *
     * @return UriTrait
     */
    public function withFragment(string $fragment)
    {
        return new self($this->uri->withFragment($fragment));
    }
}
