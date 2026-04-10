<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case SHIPPED = 'shipped';

    case DELIVERED = 'delivered';
    case CANCELLED = 'canceled';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Ожидает оплаты',
            self::PROCESSING => 'В обработке',
            self::SHIPPED => 'Отправлен',
            self::DELIVERED => 'Доставлен',
            self::CANCELLED => 'Отменен',
    };


    }
}
