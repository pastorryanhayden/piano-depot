<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PianoCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'content',
        'featured_image',
        'show_prices',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'show_prices' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function pianos()
    {
        return $this->hasMany(Piano::class, 'category_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('name', 'asc');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name') && !$category->isDirty('slug')) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function getImageUrlAttribute()
    {
        return $this->featured_image 
            ? asset('storage/' . $this->featured_image)
            : asset('images/placeholder-category.jpg');
    }

    public function availablePianos()
    {
        return $this->pianos()->where('is_available', true);
    }
}
