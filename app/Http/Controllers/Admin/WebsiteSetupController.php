<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WebsiteSetupController extends Controller
{
    /**
     * Display website setup dashboard
     */
    public function index()
    {
        $settings = WebsiteSettings::getSettings();
        return view('admin.website-setup.index', compact('settings'));
    }

    /**
     * Show video section setup form
     */
    public function videoSection()
    {
        $settings = WebsiteSettings::getSettings();
        return view('admin.website-setup.video-section', compact('settings'));
    }

    /**
     * Update video section
     */
    public function updateVideoSection(Request $request)
    {
        $request->validate([
            'video_badge_text' => 'required|string|max:255',
            'video_title_line1' => 'required|string|max:255',
            'video_title_line2' => 'required|string|max:255',
            'video_subtitle' => 'required|string',
            'video_file' => 'nullable|file|mimes:mp4,avi,mov|max:51200', // 50MB max
        ]);

        $data = $request->only([
            'video_badge_text',
            'video_title_line1',
            'video_title_line2',
            'video_subtitle'
        ]);

        // Handle video file upload
        if ($request->hasFile('video_file')) {
            $videoFile = $request->file('video_file');
            
            // Delete old video file if exists
            $settings = WebsiteSettings::getSettings();
            if ($settings->video_file_path && file_exists(public_path($settings->video_file_path))) {
                unlink(public_path($settings->video_file_path));
            }
            
            // Generate unique filename
            $fileName = time() . '_' . $videoFile->getClientOriginalName();
            
            // Move file to public/videos directory
            $videoFile->move(public_path('videos'), $fileName);
            
            // Store relative path
            $data['video_file_path'] = 'videos/' . $fileName;
        }

        WebsiteSettings::updateSettings($data);

        return redirect()->route('admin.website-setup.video-section')
                        ->with('success', 'Video section updated successfully!');
    }

    /**
     * Show company about section setup form
     */
    public function companyAbout()
    {
        $settings = WebsiteSettings::getSettings();
        return view('admin.website-setup.company-about', compact('settings'));
    }

    /**
     * Update company about section
     */
    public function updateCompanyAbout(Request $request)
    {
        $request->validate([
            'company_title' => 'required|string|max:255',
            'company_short_description' => 'required|string',
            'company_description' => 'required|string',
            'happy_clients' => 'required|integer|min:0',
            'awards_won' => 'required|integer|min:0',
            'projects_completed' => 'required|integer|min:0',
            'years_experience' => 'required|integer|min:0',
            'industry_leadership' => 'required|string',
            'quality_standards' => 'required|string',
            'innovative_design' => 'required|string',
        ]);

        $data = $request->only([
            'company_title',
            'company_short_description',
            'company_description',
            'happy_clients',
            'awards_won',
            'projects_completed',
            'years_experience',
            'industry_leadership',
            'quality_standards',
            'innovative_design'
        ]);

        WebsiteSettings::updateSettings($data);

        return redirect()->route('admin.website-setup.company-about')
                        ->with('success', 'Company about section updated successfully!');
    }

    /**
     * Show site identity & SEO setup form
     */
    public function siteIdentity()
    {
        $settings = WebsiteSettings::getSettings();
        return view('admin.website-setup.site-identity', compact('settings'));
    }

    /**
     * Update site identity & SEO settings
     */
    public function updateSiteIdentity(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png|max:1024',
            'meta_title' => 'required|string|max:60',
            'meta_description' => 'required|string|max:160',
            'meta_keywords' => 'nullable|string',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only([
            'site_name',
            'meta_title',
            'meta_description',
            'meta_keywords',
            'og_title',
            'og_description'
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $data['logo_path'] = $logoPath;
        }

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            $faviconPath = $request->file('favicon')->store('favicons', 'public');
            $data['favicon_path'] = $faviconPath;
        }

        // Handle OG image upload
        if ($request->hasFile('og_image')) {
            $ogImagePath = $request->file('og_image')->store('og-image', 'public');
            $data['og_image_path'] = $ogImagePath;
        }

        WebsiteSettings::updateSettings($data);

        return redirect()->route('admin.website-setup.site-identity')
                        ->with('success', 'Site identity and SEO settings updated successfully!');
    }

    /**
     * Show footer settings form
     */
    public function footerSettings()
    {
        $settings = WebsiteSettings::getSettings();
        return view('admin.website-setup.footer-settings', compact('settings'));
    }

    /**
     * Update footer settings
     */
    public function updateFooterSettings(Request $request)
    {
        $request->validate([
            'footer_description' => 'required|string|max:500',
            'footer_address' => 'required|string|max:255',
            'footer_phone' => 'required|string|max:50',
            'footer_email' => 'required|email|max:255',
            'footer_copyright' => 'required|string|max:255',
            'footer_privacy_policy' => 'required|string|max:255',
            'footer_terms_service' => 'required|string|max:255',
        ]);

        $data = $request->only([
            'footer_description',
            'footer_address',
            'footer_phone',
            'footer_email',
            'footer_copyright',
            'footer_privacy_policy',
            'footer_terms_service'
        ]);

        WebsiteSettings::updateSettings($data);

        return redirect()->route('admin.website-setup.footer-settings')
                        ->with('success', 'Footer settings updated successfully!');
    }
}
