<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Metric extends Model
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
        'url_id',
        'ip_addr',
        'device_type',
        'browser_type',
        'operating_system',
        'referrer_source',
        'created_at'
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
     * Relationship (1...N) with `urls` table.
     *
     * @return BelongsTo
     */
    public function url(): BelongsTo
    {
        return $this->belongsTo(Url::class);
    }
}