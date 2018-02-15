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

        return new static($uri);
    }

    /**
     * @return string
     */
    public function toNative(): string
    {
        return $this->uri->__toString();
    }

    /**
     * @return UriInterface
     */
    public function getPsr7Uri(): UriInterface
    {
        return $this->uri;
    }

    /**
     * @param string $scheme
     *
     * @return static
     */
    public function withScheme(string $scheme)
    {
        return new static($this->uri->withScheme($scheme));
    }

    /**
     * @param string      $user
     * @param string|null $password
     *
     * @return static
     */
    public function withUserInfo(string $user, string $password = null)
    {
        return new static($this->uri->withUserInfo($user, $password));
    }

    /**
     * @param string $host
     *
     * @return static
     */
    public function withHost(string $host)
    {
        return new static($this->uri->withHost($host));
    }

    /**
     * @param int $port
     *
     * @return static
     */
    public function withPort(int $port)
    {
        return new static($this->uri->withPort($port));
    }

    /**
     * @param string $path
     *
     * @return static
     */
    public function withPath(string $path)
    {
        return new static($this->uri->withPath($path));
    }

    /**
     * @param string $query
     *
     * @return static
     */
    public function withQuery(string $query)
    {
        return new static($this->uri->withQuery($query));
    }

    /**
     * @param string $fragment
     *
     * @return static
     */
    public function withFragment(string $fragment)
    {
        return new static($this->uri->withFragment($fragment));
    }
}
