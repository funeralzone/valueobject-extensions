<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjectExtensions\ComplexScalars;

use Ramsey\Uuid\Uuid;

trait GeneratableUUIDTrait
{
    /**
     * @return static
     */
    public static function generate()
    {
        return new static(Uuid::uuid4());
    }
}
