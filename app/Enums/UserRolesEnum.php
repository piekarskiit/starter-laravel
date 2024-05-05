<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum UserRolesEnum: string
{
    use EnumToArray;

    case ADMINISTRATOR = 'administrator';
    case MODERATOR = 'moderator';

    case USER = 'user';

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::ADMINISTRATOR => __('roles.administrator'),
            self::MODERATOR => __('roles.moderator'),
            self::USER => __('roles.user'),
        };
    }
}
