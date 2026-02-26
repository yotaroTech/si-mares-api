<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case Pending = 'pending';
    case Completed = 'completed';
    case Failed = 'failed';
    case Refunded = 'refunded';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'ממתין',
            self::Completed => 'שולם',
            self::Failed => 'נכשל',
            self::Refunded => 'הוחזר',
        };
    }
}
