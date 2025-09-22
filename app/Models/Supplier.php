<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Supplier extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'images',
        'pdf_file',
        'video_file',
        'youtube_link',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'images' => 'array',
        'is_active' => 'boolean'
    ];

    public function getImagesAttribute($value)
    {
        if (is_null($value)) {
            return [];
        }
        
        if (is_array($value)) {
            return $value;
        }
        
        // Handle JSON string
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }
        
        return [];
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($supplier) {
            if (empty($supplier->slug)) {
                $supplier->slug = Str::slug($supplier->name);
            }
        });
        
        static::updating(function ($supplier) {
            if ($supplier->isDirty('name') && empty($supplier->slug)) {
                $supplier->slug = Str::slug($supplier->name);
            }
        });
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
}
