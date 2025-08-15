<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piano extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand',
        'model',
        'category_id',
        'year',
        'price',
        'condition',
        'description',
        'specifications',
        'featured_image',
        'gallery_images',
        'is_available',
        'is_featured',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'year' => 'integer',
        'gallery_images' => 'array',
        'specifications' => 'array',
        'is_available' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeCondition($query, $condition)
    {
        return $query->where('condition', $condition);
    }

    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 2);
    }

    public function getMainImageAttribute()
    {
        return $this->featured_image ?: '/images/placeholder-piano.jpg';
    }

    public function category()
    {
        return $this->belongsTo(PianoCategory::class, 'category_id');
    }

    public function shouldShowPrice()
    {
        return $this->category && $this->category->show_prices;
    }

    public function getDisplayPriceAttribute()
    {
        if ($this->shouldShowPrice()) {
            return $this->formatted_price;
        }
        return 'Contact for Price';
    }
}