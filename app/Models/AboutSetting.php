<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutSetting extends Model
{
    protected $fillable = [
        'hero_title',
        'hero_description',
        'hero_image',
        'story_title',
        'story_description',
        'mission_title',
        'mission_description',
        'vision_title',
        'vision_description',
        'values_title',
        'values_description',
        'quality_title',
        'quality_description',
        'integrity_title',
        'integrity_description',
        'innovation_title',
        'innovation_description',
        'customer_focus_title',
        'customer_focus_description',
        'team_title',
        'team_description',
        'stats_years',
        'stats_customers',
        'stats_products',
        'stats_countries',
        'cta_title',
        'cta_description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public static function getSettings()
    {
        return self::where('is_active', true)->first();
    }
}
