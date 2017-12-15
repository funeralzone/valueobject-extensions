<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjectExtensions\ComplexScalars;

use PHPUnit\Framework\TestCase;

final class GeneratableUUIDTraitTest extends TestCase
{
    public function test_generates_different_uuids_each_time()
    {
        $test1 = _GeneratableUUIDTrait::generate();
        $test2 = _GeneratableUUIDTrait::generate();

        $this->assertNotEquals($test1->toNative(), $test2->toNative());
    }
}

final class _GeneratableUUIDTrait
{
    use GeneratableUUIDTrait;
    use UUIDTrait;
}
