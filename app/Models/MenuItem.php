<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_location',
        'type',
        'page_id',
        'title',
        'url',
        'parent_id',
        'order',
        'is_active',
        'target',
        'css_class',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')
            ->orderBy('order');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByLocation($query, $location)
    {
        return $query->where('menu_location', $location);
    }

    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }

    public function getUrlAttribute($value)
    {
        if ($this->type === 'page' && $this->page) {
            return $this->page->url ?? '/';
        }

        if ($this->type === 'custom') {
            return $value ?: '#';
        }

        return $value;
    }

    public function getLinkTargetAttribute()
    {
        return $this->target ?: '_self';
    }

    public function hasChildren()
    {
        return $this->children()->active()->count() > 0;
    }

    public function descendants()
    {
        $descendants = collect();
        
        foreach ($this->children as $child) {
            $descendants->push($child);
            $descendants = $descendants->merge($child->descendants());
        }
        
        return $descendants;
    }

    public static function getMenuByLocation($location)
    {
        return static::active()
            ->byLocation($location)
            ->topLevel()
            ->with(['children' => function ($query) {
                $query->active()->orderBy('order');
            }, 'page'])
            ->orderBy('order')
            ->get();
    }

    public static function reorder($items, $parentId = null)
    {
        foreach ($items as $index => $item) {
            static::where('id', $item['id'])->update([
                'parent_id' => $parentId,
                'order' => $index + 1,
            ]);

            if (isset($item['children']) && !empty($item['children'])) {
                static::reorder($item['children'], $item['id']);
            }
        }
    }
}