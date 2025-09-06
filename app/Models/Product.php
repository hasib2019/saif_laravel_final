<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'price',
        'sale_price',
        'sku',
        'stock_quantity',
        'image',
        'pdf_file',
        'video_file',
        'video_link',
        'category_id',
        'is_active',
        'featured',
        'meta_data'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'is_active' => 'boolean',
        'featured' => 'boolean',
        'meta_data' => 'array'
    ];

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Scope a query to only include active products.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include featured products.
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Scope a query to only include products in stock.
     */
    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }

    /**
     * Accessor for is_featured attribute (backward compatibility).
     */
    public function getIsFeaturedAttribute()
    {
        return $this->featured;
    }

    /**
     * Mutator for is_featured attribute (backward compatibility).
     */
    public function setIsFeaturedAttribute($value)
    {
        $this->attributes['featured'] = $value;
    }

    /**
     * Accessor for image attribute (backward compatibility).
     */
    public function getImageAttribute()
    {
        $image = $this->getRawOriginal('image');
        if (is_string($image)) {
            $image = json_decode($image, true);
        }
        if (is_array($image) && !empty($image)) {
            $imageName = $image[0];
            // Check if the image name already contains the full path
            return str_contains($imageName, 'images/products/') ? $imageName : 'images/products/' . $imageName;
        }
        return null;
    }

    /**
     * Mutator for image attribute (backward compatibility).
     */
    public function setImageAttribute($value)
    {
        if ($value) {
            $this->attributes['image'] = json_encode([$value]);
        }
    }
}
