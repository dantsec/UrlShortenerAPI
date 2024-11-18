<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Url extends Model
{
    use HasFactory;

    /**
     * Remove automatic laravel timestamp control.
     *
     * @var string[]
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'hash',
        'long_url',
        'created_at',
        'total_clicks'
    ];

    /**
     * Abstraction to search a item by it hash.
     *
     * @param ?string $hash
     */
    public static function findByHash(?string $hash): ?self
    {
        return self::where('hash', $hash)->first();
    }

    /**
     * Returns a 10-character hash that has not yet been registered in the database.
     *
     * @return string
     */
    public static function generateUniqueHash(): string
    {
        do {
            $hash = Str::random(10);
        } while (Url::where('hash', $hash)->exists());

        return $hash;
    }

    /**
     * Relationship (1...N) with `metrics` table.
     *
     * @return HasMany
     */
    public function metrics(): HasMany
    {
        return $this->hasMany(Metric::class, 'url_id', 'id');
    }
}
