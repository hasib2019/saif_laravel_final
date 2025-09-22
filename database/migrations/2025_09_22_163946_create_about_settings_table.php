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
        Schema::create('about_settings', function (Blueprint $table) {
            $table->id();
            $table->string('hero_title');
            $table->text('hero_description');
            $table->string('hero_image')->nullable();
            $table->string('story_title');
            $table->text('story_description');
            $table->string('mission_title');
            $table->text('mission_description');
            $table->string('vision_title');
            $table->text('vision_description');
            $table->string('values_title');
            $table->text('values_description');
            $table->string('quality_title');
            $table->text('quality_description');
            $table->string('integrity_title');
            $table->text('integrity_description');
            $table->string('innovation_title');
            $table->text('innovation_description');
            $table->string('customer_focus_title');
            $table->text('customer_focus_description');
            $table->string('team_title');
            $table->text('team_description');
            $table->string('stats_years');
            $table->string('stats_customers');
            $table->string('stats_products');
            $table->string('stats_countries');
            $table->string('cta_title');
            $table->text('cta_description');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_settings');
    }
};
