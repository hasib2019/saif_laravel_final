<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WebsiteSettings;

class WebsiteSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WebsiteSettings::create([
            // Video Section
            'video_badge_text' => 'New launch',
            'video_title_line1' => 'We pioneer.',
            'video_title_line2' => 'You lead.',
            'video_subtitle' => 'Vela Fashion revolutionizes fashion production and collaboration',
            'video_file_path' => null,
            
            // Company About Section
            'company_title' => 'About DEROWN Tech',
            'company_short_description' => 'Industrial Equipment Supplier providing comprehensive solutions across multiple industry sectors',
            'company_description' => 'We are a leading industrial equipment supplier dedicated to providing comprehensive solutions across multiple industry sectors. Our commitment to excellence drives us to deliver innovative products and exceptional service.',
            'happy_clients' => 500,
            'awards_won' => 25,
            'projects_completed' => 1000,
            'years_experience' => 10,
            'industry_leadership' => 'Recognized as pioneers in our field with deep technical expertise',
            'quality_standards' => 'Committed to maintaining highest quality standards in all products',
            'innovative_design' => 'Continuous research to develop cutting-edge solutions',
            
            // Site Identity
            'site_name' => 'DEROWN Tech',
            'logo_path' => null,
            'favicon_path' => null,
            
            // SEO Settings
            'meta_title' => 'DEROWN Tech - Industrial Equipment Supplier',
            'meta_description' => 'Leading industrial equipment supplier providing comprehensive solutions across multiple industry sectors with innovative products and exceptional service.',
            'meta_keywords' => 'industrial equipment, supplier, technology, innovation, quality',
            'og_title' => 'DEROWN Tech - Industrial Equipment Supplier',
            'og_description' => 'Leading industrial equipment supplier providing comprehensive solutions across multiple industry sectors with innovative products and exceptional service.',
            'og_image_path' => null
        ]);
    }
}
