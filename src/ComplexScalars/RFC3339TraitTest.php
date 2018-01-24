<?php

// @codingStandardsIgnoreFile

declare(strict_types=1);

namespace Funeralzone\ValueObjectExtensions\ComplexScalars;

use const DATE_RFC3339;
use DateTimeImmutable;
use Funeralzone\ValueObjects\ValueObject;
use PHPUnit\Framework\TestCase;

final class RFC3339TraitTest extends TestCase
{
    public function test_is_null_returns_false()
    {
        $test = new _RFC3339Trait(new DateTimeImmutable);
        $this->assertFalse($test->isNull());
    }

    public function test_is_same_returns_true_when_values_match()
    {
        $rfc3339 = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2010-01-01 00:00:00');

        $test1 = new _RFC3339Trait($rfc3339);
        $test2 = new _RFC3339Trait($rfc3339);

        $this->assertTrue($test1->isSame($test2));
    }

    public function test_is_same_returns_false_when_values_mismatch()
    {
        $rfc33391 = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2010-01-01 00:00:00');
        $rfc33392 = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2010-01-01 00:02:00');

        $test1 = new _RFC3339Trait($rfc33391);
        $test2 = new _RFC3339Trait($rfc33392);

        $this->assertFalse($test1->isSame($test2));
    }

    public function test_from_native_instantiates_with_valid_string()
    {
        $rfc3339String = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2010-01-01 00:00:00')->format(DATE_RFC3339);

        $test = _RFC3339Trait::fromNative($rfc3339String);
        $this->assertEquals($rfc3339String, $test->toNative());
    }

    public function test_from_native_throws_exception_with_invalid_string()
    {
        $this->expectException(\InvalidArgumentException::class);
        _RFC3339Trait::fromNative('invalid-rfc3339');
    }

    public function test_to_native_returns_correct_string_representation_of_rfc3339()
    {
        $rfc3339 = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2010-01-01 00:00:00');

        $test = new _RFC3339Trait($rfc3339);
        $this->assertEquals($rfc3339->format(DATE_RFC3339), $test->toNative());
    }
}

final class _RFC3339Trait implements ValueObject
{
    use RFC3339Trait;
}
