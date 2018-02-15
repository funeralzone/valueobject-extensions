<?php
/**
 * Created by PhpStorm.
 * User: kevbaldwyn
 * Date: 14/02/2018
 * Time: 15:26
 */

// @codingStandardsIgnoreFile

declare(strict_types=1);

namespace Funeralzone\ValueObjectExtensions\ComplexScalars;

use Funeralzone\ValueObjects\ValueObject;
use League\Uri\Exception;
use League\Uri\Http;
use PHPUnit\Framework\TestCase;

class UriTraitTest extends TestCase
{
    public function test_isnull_returns_false()
    {
        $uri = new _UriTrait(Http::createFromString('http://example.com'));
        $this->assertFalse($uri->isNull());
    }

    public function test_is_same_returns_true_when_values_match()
    {
        $uri1 = new _UriTrait(Http::createFromString('http://example.com'));
        $uri2 = new _UriTrait(Http::createFromString('http://example.com'));

        $this->assertTrue($uri1->isSame($uri2));
    }

    public function test_is_same_returns_false_when_values_mismatch()
    {
        $uri1 = new _UriTrait(Http::createFromString('http://example.com'));
        $uri2 = new _UriTrait(Http::createFromString('https://example.com'));

        $this->assertFalse($uri1->isSame($uri2));
    }

    public function test_from_native_instantiates_with_valid_string()
    {
        $uri = 'http://example.com';

        $test = _UriTrait::fromNative($uri);
        $this->assertSame($uri, $test->toNative());
    }

    public function test_from_native_throws_exception_with_invalid_string()
    {
        $this->expectException(Exception::class);
        _UriTrait::fromNative('http:example.com');
    }
}

final class _UriTrait implements ValueObject
{
    use UriTrait;
}
