<?php

namespace App\Traits;

trait EnumToArray
{

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function array(): array
    {
        return array_combine(self::names(), self::values());
    }

    public static function revArray(): array
    {
        return array_combine(self::values(), self::names());
    }

    public static function asSelectable(): array
    {
        $result = [];

        foreach (self::cases() as $key => $case) {
            $result[$key]['uuid'] = $case->value;
            $result[$key]['name'] = self::getLabel($case);
        }

        return $result;
    }
}
