<?php

namespace App\Enums;

enum UserStatusesEnum: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';

    public function label(): string
    {
        return match ($this) {
            static::ACTIVE => 'Active',
            static::INACTIVE => 'Inactive',
        };
    }
}