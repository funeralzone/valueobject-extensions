<?php

// @codingStandardsIgnoreFile

declare(strict_types=1);

namespace Funeralzone\ValueObjectExtensions\ComplexScalars;

use Funeralzone\ValueObjects\ValueObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class UUIDTraitTest extends TestCase
{
    public function test_is_null_returns_false()
    {
        $test = new _UUIDTrait(Uuid::uuid4());
        $this->assertFalse($test->isNull());
    }

    public function test_is_same_returns_true_when_values_match()
    {
        $uuid = Uuid::uuid4();

        $test1 = new _UUIDTrait($uuid);
        $test2 = new _UUIDTrait($uuid);

        $this->assertTrue($test1->isSame($test2));
    }

    public function test_is_same_returns_false_when_values_mismatch()
    {
        $uuid1 = Uuid::uuid4();
        $uuid2 = Uuid::uuid4();

        $test1 = new _UUIDTrait($uuid1);
        $test2 = new _UUIDTrait($uuid2);

        $this->assertFalse($test1->isSame($test2));
    }

    public function test_from_native_instantiates_with_valid_string()
    {
        $uuidString = Uuid::uuid4()->toString();

        $test = _UUIDTrait::fromNative($uuidString);
        $this->assertEquals($uuidString, $test->toNative());
    }

    public function test_from_native_throws_exception_with_invalid_string()
    {
        $this->expectException(\InvalidArgumentException::class);
        _UUIDTrait::fromNative('invalid-uuid');
    }

    public function test_to_native_returns_correct_string_representation_of_uuid()
    {
        $uuid = Uuid::uuid4();

        $test = new _UUIDTrait($uuid);
        $this->assertEquals($uuid->toString(), $test->toNative());
    }
}

final class _UUIDTrait implements ValueObject
{
    use UUIDTrait;
}
