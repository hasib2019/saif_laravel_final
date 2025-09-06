<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteSettings extends Model
{
    protected $fillable = [
        // Video Section Fields
        'video_badge_text',
        'video_title_line1',
        'video_title_line2',
        'video_subtitle',
        'video_file_path',
        
        // Company About Section Fields
        'company_title',
        'company_short_description',
        'company_description',
        
        // Company Stats
        'happy_clients',
        'awards_won',
        'projects_completed',
        'years_experience',
        
        // Company Features
        'industry_leadership',
        'quality_standards',
        'innovative_design',
        
        // Site Identity Fields
        'site_name',
        'logo_path',
        'favicon_path',
        
        // SEO Fields
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_title',
        'og_description',
        'og_image_path',
        
        // Footer Settings
        'footer_description',
        'footer_address',
        'footer_phone',
        'footer_email',
        'footer_copyright',
        'footer_privacy_policy',
        'footer_terms_service',
    ];

    /**
     * Get the first (and should be only) website settings record
     * Create one if it doesn't exist
     */
    public static function getSettings()
    {
        $settings = self::first();
        
        if (!$settings) {
            $settings = self::create([]);
        }
        
        return $settings;
    }

    /**
     * Update website settings
     */
    public static function updateSettings(array $data)
    {
        $settings = self::getSettings();
        $settings->update($data);
        return $settings;
    }
}
