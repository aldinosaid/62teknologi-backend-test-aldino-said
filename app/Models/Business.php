<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'uuid',
        'alias',
        'name',
        'image_url',
        'is_claimed',
        'is_closed',
        'url',
        'phone',
        'display_phone',
        'review_count',
        'categories',
        'rating',
        'location',
        'coordinates',
        'photos',
        'price',
        'hours',
        'transactions'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'categories' => 'json',
        'location' => 'json',
        'coordinates' => 'json',
        'photos' => 'json',
        'transactions' => 'json',
        'hours' => 'json'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'businesses';
}
