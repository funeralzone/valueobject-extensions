<?php
/**
 * Created by PhpStorm.
 * User: kevbaldwyn
 * Date: 06/08/2018
 * Time: 10:37
 */declare(strict_types=1);

namespace Funeralzone\ValueObjectExtensions\ComplexScalars\Support;

use Funeralzone\ValueObjects\Enums\EnumTrait;

trait ArrayDefinedEnum
{
    use EnumTrait;

    /**
     * @return array
     */
    abstract protected static function getArrayConstants(): array;

    /**
     * @return array
     */
    private static function constants(): array
    {
        $array = static::getArrayConstants();

        /**
         * [
         *    'VALUE_1' => 0
         *    'VALUE_2' => 1
         *    ...
         * ]
         */
        return array_combine(
            $array,
            array_keys($array)
        );
    }

    /**
     * @param $name
     * @param $arguments
     * @return static
     */
    public static function __callStatic($name, $arguments)
    {
        if (!in_array($name, static::constantKeys())) {
            throw new \RuntimeException($name . ' is an invalid value for this enum.');
        }

        return new static(static::constants()[$name]);
    }
}
