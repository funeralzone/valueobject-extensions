<?php

// @codingStandardsIgnoreFile

declare(strict_types=1);

namespace Funeralzone\ValueObjectExtensions\ComplexScalars;

use Funeralzone\ValueObjects\ValueObject;
use PHPUnit\Framework\TestCase;

final class TimeTraitTest extends TestCase
{
    public function test_is_null_returns_false()
    {
        $test = new _TimeTrait('10:10');
        $this->assertFalse($test->isNull());
    }

    public function test_is_same_returns_true_when_values_match()
    {
        $test1 = new _TimeTrait('10:10');
        $test2 = new _TimeTrait('10:10');

        $this->assertTrue($test1->isSame($test2));
    }

    public function test_is_same_returns_false_when_values_mismatch()
    {
        $test1 = new _TimeTrait('10:10');
        $test2 = new _TimeTrait('12:12');

        $this->assertFalse($test1->isSame($test2));
    }

    public function test_from_native_instantiates_with_valid_string()
    {
        $test = _TimeTrait::fromNative('10:10');
        $this->assertEquals('10:10', $test->toNative());
    }

    public function test_from_native_throws_exception_with_invalid_string()
    {
        $this->expectException(\InvalidArgumentException::class);
        _TimeTrait::fromNative('invalid');
    }

    public function test_from_native_throws_exception_with_invalid_hours()
    {
        $this->expectException(\InvalidArgumentException::class);
        _TimeTrait::fromNative('25:00');
    }

    public function test_from_native_throws_exception_with_invalid_minutes()
    {
        $this->expectException(\InvalidArgumentException::class);
        _TimeTrait::fromNative('10:61');
    }
}

final class _TimeTrait implements ValueObject
{
    use TimeTrait;
}
