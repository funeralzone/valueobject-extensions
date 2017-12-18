<?php

namespace Funeralzone\ValueObjectExtensions\ComplexScalars;

use Funeralzone\ValueObjects\ValueObject;
use PHPUnit\Framework\TestCase;
use Carbon\Carbon;

final class RFC3339TraitTest extends TestCase
{
    public function test_is_null_returns_false()
    {
        $test = new _RFC3339Trait(Carbon::create(1992, 8, 25, 20, 57, 8));
        $this->assertFalse($test->isNull());
    }

    public function test_is_same_returns_true_when_values_match()
    {
        $rfc3339 = Carbon::create(1992, 8, 25, 20, 57, 8);

        $test1 = new _RFC3339Trait($rfc3339);
        $test2 = new _RFC3339Trait($rfc3339);

        $this->assertTrue($test1->isSame($test2));
    }

    public function test_is_same_returns_false_when_values_mismatch()
    {
        $rfc33391 = Carbon::create(1992, 8, 25, 20, 57, 8);
        $rfc33392 = Carbon::create(2011, 4, 28, 15, 20, 19);

        $test1 = new _RFC3339Trait($rfc33391);
        $test2 = new _RFC3339Trait($rfc33392);

        $this->assertFalse($test1->isSame($test2));
    }

    public function test_from_native_instantiates_with_valid_string()
    {
        $rfc3339String = Carbon::create(1992, 8, 25, 20, 57, 8)->toRfc3339String();

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
        $rfc3339 = Carbon::create(1992, 8, 25, 20, 57, 8);

        $test = new _RFC3339Trait($rfc3339);
        $this->assertEquals($rfc3339->toRfc3339String(), $test->toNative());
    }
}

final class _RFC3339Trait implements ValueObject
{
    use RFC3339Trait;
}
