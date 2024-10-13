<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Option extends Model
{
    protected $fillable = ['key', 'value'];

    public $primaryKey = 'key';

    public $timestamps = false;

    protected static function booted(): void
    {
        static::saved(fn () => static::refreshCache());
        static::deleted(fn () => static::refreshCache());
    }

    /**
     * Get the specified option value.
     */
    public static function get(string $key, $default = null)
    {
        return self::loadAll()[$key] ?? $default;
    }

    /**
     * Set the given option value or array of values.
     */
    public static function set(string|array $key, $value = null)
    {
        if (! is_array($key)) {
            return self::query()
                ->updateOrCreate(['key' => $key], ['value' => $value]);
        }

        foreach ($key as $k => $v) {
            self::set($k, $v);
        }
    }

    /**
     * Load all options from database and keep it in cache.
     */
    public static function loadAll(): ?array
    {
        return Cache::rememberForever(
            'app.models.option',
            fn () => static::pluck('value', 'key')->toArray()
        );
    }

    /**
     * Refresh cache to sync with database.
     */
    public static function refreshCache(): void
    {
        Cache::forget('app.models.option');
        self::loadAll();
    }
}
