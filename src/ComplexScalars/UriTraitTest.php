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
        $this->assertSame('http://example.com/', $test->toNative());
    }

    public function test_from_native_throws_exception_with_invalid_string()
    {
        $this->expectException(Exception::class);
        _UriTrait::fromNative('http:example.com/');
    }

    public function test_withScheme_changes_scheme_and_returns_new_object()
    {
        $initial = _UriTrait::fromNative('http://example.com');
        $changed = $initial->withScheme('https');

        $this->assertSame('https://example.com/', $changed->toNative());
        $this->assertNotSame($initial, $changed);
    }

    public function test_withUserInfo_changes_user_and_returns_new_object()
    {
        $initial = _UriTrait::fromNative('http://example.com');
        $changed = $initial->withUserInfo('mike');

        $this->assertSame('http://mike@example.com/', $changed->toNative());
        $this->assertNotSame($initial, $changed);
    }

    public function test_withUserInfo_adds_pass_and_returns_new_object()
    {
        $initial = _UriTrait::fromNative('http://example.com');
        $changed = $initial->withUserInfo('mike', 'password123');

        $this->assertSame('http://mike:password123@example.com/', $changed->toNative());
        $this->assertNotSame($initial, $changed);
    }

    public function test_withHost_changes_host_and_returns_new_object()
    {
        $initial = _UriTrait::fromNative('http://example.com');
        $changed = $initial->withHost('boom.com');

        $this->assertSame('http://boom.com/', $changed->toNative());
        $this->assertNotSame($initial, $changed);
    }

    public function test_withPort_changes_port_and_returns_new_object()
    {
        $initial = _UriTrait::fromNative('http://example.com');
        $changed = $initial->withPort(8080);

        $this->assertSame('http://example.com:8080/', $changed->toNative());
        $this->assertNotSame($initial, $changed);
    }

    public function test_withPath_changes_path_and_returns_new_object()
    {
        $initial = _UriTrait::fromNative('http://example.com/some/path');
        $changed = $initial->withPath('/new/path');

        $this->assertSame('http://example.com/new/path', $changed->toNative());
        $this->assertNotSame($initial, $changed);
    }

    public function test_withQuery_changes_query_and_returns_new_object()
    {
        $initial = _UriTrait::fromNative('http://example.com');
        $changed = $initial->withQuery('foo=bar');

        $this->assertSame('http://example.com/?foo=bar', $changed->toNative());
        $this->assertNotSame($initial, $changed);
    }

    public function test_withFragment_changes_fragment_and_returns_new_object()
    {
        $initial = _UriTrait::fromNative('http://example.com');
        $changed = $initial->withFragment('foo');

        $this->assertSame('http://example.com/#foo', $changed->toNative());
        $this->assertNotSame($initial, $changed);
    }
}

final class _UriTrait implements ValueObject
{
    use UriTrait;
}
