<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
