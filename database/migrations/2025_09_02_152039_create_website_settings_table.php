<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('website_settings', function (Blueprint $table) {
            $table->id();
            
            // Video Section Fields
            $table->string('video_badge_text')->default('New launch');
            $table->string('video_title_line1')->default('We pioneer.');
            $table->string('video_title_line2')->default('You lead.');
            $table->text('video_subtitle')->default('Vela Fashion revolutionizes fashion production and collaboration');
            $table->string('video_file_path')->nullable();
            
            // Company About Section Fields
            $table->string('company_title')->default('About DEROWN Tech');
            $table->text('company_short_description')->default('Industrial Equipment Supplier providing comprehensive solutions across multiple industry sectors');
            $table->text('company_description')->default('We are a leading industrial equipment supplier dedicated to providing comprehensive solutions across multiple industry sectors. Our commitment to excellence drives us to deliver innovative products and exceptional service.');
            
            // Company Stats
            $table->integer('happy_clients')->default(500);
            $table->integer('awards_won')->default(25);
            $table->integer('projects_completed')->default(1000);
            $table->integer('years_experience')->default(10);
            
            // Company Features
            $table->text('industry_leadership')->default('Recognized as pioneers in our field with deep technical expertise');
            $table->text('quality_standards')->default('Committed to maintaining highest quality standards in all products');
            $table->text('innovative_design')->default('Continuous research to develop cutting-edge solutions');
            
            // Site Identity Fields
            $table->string('site_name')->default('DEROWN Tech');
            $table->string('logo_path')->nullable();
            $table->string('favicon_path')->nullable();
            
            // SEO Fields
            $table->string('meta_title')->default('DEROWN Tech - Industrial Equipment Supplier');
            $table->text('meta_description')->default('Leading industrial equipment supplier providing comprehensive solutions across multiple industry sectors with innovative products and exceptional service.');
            $table->text('meta_keywords')->nullable();
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image_path')->nullable();
            
            // Footer Settings
            $table->text('footer_description')->default('Your trusted partner for quality products and exceptional service.');
            $table->string('footer_address')->default('123 Business Street, City, Country');
            $table->string('footer_phone')->default('+1 (555) 123-4567');
            $table->string('footer_email')->default('info@company.com');
            $table->string('footer_copyright')->default('© 2025 Laravel. All rights reserved');
            $table->text('footer_privacy_policy')->default('Privacy Policy');
            $table->text('footer_terms_service')->default('Terms of Service');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_settings');
    }
};
