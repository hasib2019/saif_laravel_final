<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'featured_image',
        'status',
        'is_active',
        'show_in_menu',
        'sort_order'
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'status' => 'boolean',
        'is_active' => 'boolean',
        'show_in_menu' => 'boolean'
    ];

    /**
     * Scope a query to only include published pages.
     */
    public function scopePublished($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Accessor for is_active attribute (maps to status)
     */
    public function getIsActiveAttribute()
    {
        return $this->status;
    }

    /**
     * Mutator for is_active attribute (maps to status)
     */
    public function setIsActiveAttribute($value)
    {
        $this->attributes['status'] = $value;
    }

    /**
     * Accessor for show_in_menu attribute (default to true if not set)
     */
    public function getShowInMenuAttribute()
    {
        return $this->attributes['show_in_menu'] ?? true;
    }

    /**
     * Mutator for show_in_menu attribute
     */
    public function setShowInMenuAttribute($value)
    {
        $this->attributes['show_in_menu'] = $value;
    }
}
