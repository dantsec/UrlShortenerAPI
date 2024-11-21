<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class Url extends Model
{
    use HasFactory;

    /**
     * Remove automatic laravel timestamp control.
     *
     * @var string[]
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'hash',
        'long_url',
        'total_clicks',
        'expired_at'
    ];

    /**
     * Cast fields of database.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'expired_at' => 'datetime'
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
     * Check if URL is expired.
     *
     * @return bool
     */
    public function isExpired(): bool
    {
        if (isset($this->expired_at)) {
            return true;
        }

        $expirationTime = config('url.ttl');

        $now = Carbon::now();

        $diff = $this->created_at->diffInSeconds($now);

        if ($diff >= $expirationTime) {
            $this->update(['expired_at' => $now]);

            return true;
        }

        return false;
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
