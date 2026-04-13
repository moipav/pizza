<?php

namespace App\Enums;

enum CartStatus: string
{
    case ACTIVE = 'active';
    case COMPLETED = 'completed';
    case ABANDONED = 'abandoned';
    case EXPIRED = 'expired';

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Акитивна',
            self::COMPLETED => 'Завершена',
            self::ABANDONED => 'Заброшена',
            self::EXPIRED => 'Истекла'
        };
    }

    public function isEditable(): bool
    {
        return $this === self::ACTIVE;
    }
}
