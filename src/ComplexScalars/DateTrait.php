<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjectExtensions\ComplexScalars;

use DateTimeImmutable;
use Exception;
use Funeralzone\ValueObjects\ValueObject;

trait DateTrait
{
    /**
     * @var DateTimeImmutable
     */
    protected $date;

    /**
     * DateTrait constructor.
     * @param DateTimeImmutable $date
     */
    public function __construct(DateTimeImmutable $date)
    {
        $this->date = $date->setTime(0, 0, 0);
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
     * @return bool
     */
    public function isSame(ValueObject $object): bool
    {
        return ($this->toNative() === $object->toNative());
    }

    /**
     * @param string $native
     * @return static
     */
    public static function fromNative($native)
    {
        return new static(DateTimeImmutable::createFromFormat('Y-m-d', $native));
    }

    /**
     * @return string
     */
    public function toNative()
    {
        return $this->date->format('Y-m-d');
    }

    /**
     * @param string $format
     * @return string
     */
    public function format(string $format): string
    {
        return $this->date->format($format);
    }

    /**
     * @return DateTimeImmutable
     */
    public function toDateTime(): DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @param static $otherDate
     * @return bool
     */
    public function isBefore($otherDate): bool
    {
        $this->checkIsSameClass($otherDate);

        /* @var static $otherDate */
        return $this->date < $otherDate->toDateTime();
    }

    /**
     * @param static $otherDate
     * @return bool
     */
    public function isAfter($otherDate): bool
    {
        $this->checkIsSameClass($otherDate);

        /* @var static $otherDate */
        return $this->date > $otherDate->toDateTime();
    }

    /**
     * @param $instance
     * @throws Exception
     */
    private function checkIsSameClass($instance): void
    {
        if (!is_a($instance, static::class)) {
            throw new Exception('Can only compare other ' . static::class . ' instances');
        }
    }
}
