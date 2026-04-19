<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'is_blindbox',
        'description',
        'image_url',
        'release_date'
    ];

    protected $casts = [
        'is_blindbox' => 'boolean',
        'release_date' => 'datetime',
    ];

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }
}
