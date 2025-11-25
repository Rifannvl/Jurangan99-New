<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'category',
        'cut_type',
        'description',
        'price',
        'discount',
        'weight',
        'weight_variant',
        'cooking_tips',
        'stock',
        'image_path',
        'image_disk',
        'halal_certified',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
        'weight' => 'decimal:2',
        'stock' => 'integer',
        'halal_certified' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function getWeightVariantOptionsAttribute(): array
    {
        if (! $this->weight_variant) {
            return [];
        }

        return collect(explode(',', $this->weight_variant))
            ->map(fn ($variant) => trim($variant))
            ->filter()
            ->map(function (string $label) {
                return [
                    'label' => $label,
                    'kilograms' => $this->normalizeWeightLabelToKilograms($label),
                ];
            })
            ->filter(fn ($variant) => $variant['kilograms'] > 0)
            ->values()
            ->all();
    }

    protected function normalizeWeightLabelToKilograms(string $label): float
    {
        $value = trim($label);

        if ($value === '') {
            return 0.0;
        }

        if (! preg_match('/([\d.,]+)\s*(kg|g)?/i', $value, $matches)) {
            return 0.0;
        }

        $number = str_replace(',', '.', $matches[1]);
        $weight = (float) $number;
        $unit = strtolower($matches[2] ?? 'kg');

        return $unit === 'g' ? $weight / 1000 : $weight;
    }

    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image_path) {
            return null;
        }

        $disk = $this->image_disk ?: config('filesystems.default');
        /** @var FilesystemAdapter $storage */
        $storage = Storage::disk($disk);
        $url = $storage->url($this->image_path);

        return $this->normalizeStorageUrl($url, $disk);
    }

    protected function normalizeStorageUrl(string $url, string $disk): string
    {
        $driver = config("filesystems.disks.{$disk}.driver");

        if ($driver !== 'local') {
            return $url;
        }

        return preg_replace('#^https?://[^/]+#', '', $url) ?: $url;
    }
}
