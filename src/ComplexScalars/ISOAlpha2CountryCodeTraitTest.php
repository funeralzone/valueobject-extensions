<?php

// @codingStandardsIgnoreFile

declare(strict_types=1);

namespace Funeralzone\ValueObjectExtensions\ComplexScalars;

use Funeralzone\ValueObjects\ValueObject;
use PHPUnit\Framework\TestCase;

final class ISOAlpha2CountryCodeTraitTest extends TestCase
{
    public function test_construct_throws_error_when_value_is_not_defined_as_a_constant()
    {
        $this->expectException(\InvalidArgumentException::class);
        new _ISOAlpha2CountryCode(99999999999999);
    }

    public function test_is_null_returns_false()
    {
        $test = new _ISOAlpha2CountryCode(0);
        $this->assertFalse($test->isNull());
    }

    public function test_is_same_returns_true_if_values_match()
    {
        $test1 = new _ISOAlpha2CountryCode(0);
        $test2 = new _ISOAlpha2CountryCode(0);
        $this->assertTrue($test1->isSame($test2));
    }

    public function test_is_same_returns_false_if_values_mismatch()
    {
        $test1 = new _ISOAlpha2CountryCode(0);
        $test2 = new _ISOAlpha2CountryCode(1);
        $this->assertFalse($test1->isSame($test2));
    }

    public function test_from_native_only_accepts_a_string()
    {
        $this->expectException(\InvalidArgumentException::class);
        _ISOAlpha2CountryCode::fromNative(1);
        $this->expectException(\InvalidArgumentException::class);
        _ISOAlpha2CountryCode::fromNative(null);
    }

    public function test_from_native_creates_correct_value_based_on_string()
    {
        $this->assertEquals('GB', _ISOAlpha2CountryCode::fromNative('GB')->toNative());
    }

    public function test_to_native_returns_correct_string()
    {
        $test = new _ISOAlpha2CountryCode(0);
        $this->assertTrue(is_string($test->toNative()));
        $this->assertEquals('AF', $test->toNative());
    }

    public function test_magic_static_methods_return_objects_with_correct_value()
    {
        $this->assertEquals('GB', _ISOAlpha2CountryCode::GB()->toNative());
        $this->assertEquals('FR', _ISOAlpha2CountryCode::FR()->toNative());
        $this->assertEquals('US', _ISOAlpha2CountryCode::US()->toNative());
    }
}

final class _ISOAlpha2CountryCode implements ValueObject
{
    use ISOAlpha2CountryCodeTrait;
}
