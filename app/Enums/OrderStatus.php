<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Processing = 'processing';
    case Shipped = 'shipped';
    case Delivered = 'delivered';
    case Cancelled = 'cancelled';
    case Refunded = 'refunded';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'ממתין',
            self::Confirmed => 'אושר',
            self::Processing => 'בטיפול',
            self::Shipped => 'נשלח',
            self::Delivered => 'נמסר',
            self::Cancelled => 'בוטל',
            self::Refunded => 'הוחזר',
        };
    }
}
