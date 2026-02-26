<?php

namespace App\Console\Commands;

use App\Models\ProductImage;
use App\Models\HeroSlide;
use App\Models\Category;
use App\Models\Collection;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanupMedia extends Command
{
    protected $signature = 'media:cleanup {--dry-run : Show what would be deleted}';
    protected $description = 'Delete orphaned media files not referenced in DB';

    public function handle(): void
    {
        $disk = Storage::disk('public');
        $allFiles = $disk->allFiles();

        // Collect all image paths from DB
        $dbPaths = collect();
        $dbPaths = $dbPaths->merge(ProductImage::pluck('image_path'));
        $dbPaths = $dbPaths->merge(HeroSlide::pluck('image_path'));
        $dbPaths = $dbPaths->merge(Category::whereNotNull('image_path')->pluck('image_path'));
        $dbPaths = $dbPaths->merge(Collection::whereNotNull('image_path')->pluck('image_path'));

        // Filter to only local paths (skip external URLs)
        $dbPaths = $dbPaths->filter(fn($path) => !str_starts_with($path, 'http'))
            ->map(fn($path) => ltrim($path, '/'))
            ->toArray();

        $orphaned = array_diff($allFiles, $dbPaths);
        // Don't delete .gitignore files
        $orphaned = array_filter($orphaned, fn($f) => !str_ends_with($f, '.gitignore'));

        if (empty($orphaned)) {
            $this->info('No orphaned files found.');
            return;
        }

        $this->info(count($orphaned) . ' orphaned file(s) found.');

        if ($this->option('dry-run')) {
            foreach ($orphaned as $file) {
                $this->line("  Would delete: {$file}");
            }
            return;
        }

        foreach ($orphaned as $file) {
            $disk->delete($file);
            $this->line("  Deleted: {$file}");
        }

        $this->info('Cleanup complete.');
    }
}
