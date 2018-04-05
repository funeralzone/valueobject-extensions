<?php

// @codingStandardsIgnoreFile

declare(strict_types=1);

namespace Funeralzone\ValueObjectExtensions\ComplexScalars;

use DateTimeImmutable;
use Funeralzone\ValueObjects\ValueObject;
use PHPUnit\Framework\TestCase;

final class DateTraitTest extends TestCase
{
    public function test_is_null_returns_false()
    {
        $test = new _DateTrait(new DateTimeImmutable);
        $this->assertFalse($test->isNull());
    }

    public function test_is_same_returns_true_when_values_match()
    {
        $dateTime1 = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2010-01-01 00:00:00');
        $dateTime2 = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2010-01-01 23:00:00');

        $test1 = new _DateTrait($dateTime1);
        $test2 = new _DateTrait($dateTime2);

        $this->assertTrue($test1->isSame($test2));
    }

    public function test_is_same_returns_false_when_values_mismatch()
    {
        $dateTime1 = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2010-01-01 00:00:00');
        $dateTime2 = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2010-01-02 00:02:00');

        $test1 = new _DateTrait($dateTime1);
        $test2 = new _DateTrait($dateTime2);

        $this->assertFalse($test1->isSame($test2));
    }

    public function test_from_native_instantiates_with_valid_string()
    {
        $test = _DateTrait::fromNative('2010-01-01');
        $this->assertEquals('2010-01-01', $test->toNative());
    }

    public function test_from_native_throws_exception_with_invalid_string()
    {
        $this->expectException(\InvalidArgumentException::class);
        _DateTrait::fromNative('invalid-date');
    }

    public function test_to_native_returns_correct_string_representation_of_date()
    {
        $dateTime = DateTimeImmutable::createFromFormat('Y-m-d', '2010-01-01');

        $test = new _DateTrait($dateTime);
        $this->assertEquals('2010-01-01', $test->toNative());
    }

    public function test_toDateTime_returns_constructed_dateTime()
    {
        $dateTime = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2010-01-01 22:30:45');

        $test = new _DateTrait($dateTime);
        $this->assertEquals('2010', $test->toDateTime()->format('Y'));
        $this->assertEquals('01', $test->toDateTime()->format('m'));
        $this->assertEquals('01', $test->toDateTime()->format('d'));
        $this->assertEquals('00', $test->toDateTime()->format('H'));
        $this->assertEquals('00', $test->toDateTime()->format('i'));
        $this->assertEquals('00', $test->toDateTime()->format('s'));
    }

    public function test_format_returns_string_based_on_internal_date_time()
    {
        $dateTime = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2010-01-01 22:30:45');

        $test = new _DateTrait($dateTime);
        $this->assertEquals('2010-01-01 00:00:00', $test->format('Y-m-d H:i:s'));
    }

    public function test_isBefore_returns_true_when_date_occurred_before_other_date()
    {
        $test = _DateTrait::fromNative('2009-12-31');
        $otherDate = _DateTrait::fromNative('2010-01-01');
        $this->assertTrue($test->isBefore($otherDate));
    }

    public function test_isBefore_returns_false_when_date_occurred_after_other_date()
    {
        $test = _DateTrait::fromNative('2010-01-02');
        $otherDate = _DateTrait::fromNative('2010-01-01');
        $this->assertFalse($test->isBefore($otherDate));
    }

    public function test_isBefore_returns_false_when_date_is_same_as_other_date()
    {
        $test = _DateTrait::fromNative('2010-01-01');
        $otherDate = _DateTrait::fromNative('2010-01-01');
        $this->assertFalse($test->isBefore($otherDate));
    }

    public function test_isAfter_returns_true_when_date_occurred_after_other_date()
    {
        $test = _DateTrait::fromNative('2010-01-02');
        $otherDate = _DateTrait::fromNative('2010-01-01');
        $this->assertTrue($test->isAfter($otherDate));
    }

    public function test_isAfter_returns_false_when_date_occurred_before_other_date()
    {
        $test = _DateTrait::fromNative('2010-01-01');
        $otherDate = _DateTrait::fromNative('2010-01-02');
        $this->assertFalse($test->isAfter($otherDate));
    }

    public function test_isAfter_returns_false_when_date_is_same_as_other_date()
    {
        $test = _DateTrait::fromNative('2010-01-01');
        $otherDate = _DateTrait::fromNative('2010-01-01');
        $this->assertFalse($test->isAfter($otherDate));
    }
}

final class _DateTrait implements ValueObject
{
    use DateTrait;
}