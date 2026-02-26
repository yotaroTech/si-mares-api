<?php

namespace App\Console\Commands;

use App\Models\CartItem;
use Illuminate\Console\Command;

class CleanupCarts extends Command
{
    protected $signature = 'carts:cleanup {--days=30 : Days of inactivity}';
    protected $description = 'Remove abandoned guest cart items';

    public function handle(): void
    {
        $days = $this->option('days');
        $deleted = CartItem::whereNull('user_id')
            ->where('updated_at', '<', now()->subDays($days))
            ->delete();

        $this->info("Deleted {$deleted} abandoned cart item(s) older than {$days} days.");
    }
}
