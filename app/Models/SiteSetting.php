<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'key',
    'value',
])]
class SiteSetting extends Model
{
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'value' => 'string',
        ];
    }

    /**
     * Get a stored setting value with an optional fallback.
     */
    public static function valueFor(string $key, ?string $fallback = null): ?string
    {
        return static::query()
            ->where('key', $key)
            ->value('value') ?? $fallback;
    }
}