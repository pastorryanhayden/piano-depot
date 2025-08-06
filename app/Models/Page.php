<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'title',
        'slug',
        'menu_title',
        'page_type',
        'content',
        'meta_description',
        'is_published',
        'show_in_menu',
        'menu_order',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'show_in_menu' => 'boolean',
        'menu_order' => 'integer',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Page::class, 'parent_id')->orderBy('menu_order');
    }

    public function publishedChildren(): HasMany
    {
        return $this->hasMany(Page::class, 'parent_id')
            ->where('is_published', true)
            ->orderBy('menu_order');
    }

    public function ancestors()
    {
        $ancestors = collect();
        $parent = $this->parent;

        while ($parent) {
            $ancestors->push($parent);
            $parent = $parent->parent;
        }

        return $ancestors->reverse();
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

    public function getFullSlugAttribute(): string
    {
        $slugs = $this->ancestors()->pluck('slug')->push($this->slug);
        return $slugs->implode('/');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeRootPages($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('page_type', $type);
    }

    public function isDescendantOf(Page $page): bool
    {
        return $this->ancestors()->contains('id', $page->id);
    }

    public function isAncestorOf(Page $page): bool
    {
        return $page->ancestors()->contains('id', $this->id);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}