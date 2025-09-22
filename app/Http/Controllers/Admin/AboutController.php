<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    /**
     * Display the about settings form
     */
    public function index()
    {
        $settings = AboutSetting::getSettings();
        return view('admin.about.index', compact('settings'));
    }

    /**
     * Update the about settings
     */
    public function update(Request $request)
    {
        $request->validate([
            'hero_title' => 'required|string|max:255',
            'hero_description' => 'required|string',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'story_title' => 'required|string|max:255',
            'story_description' => 'required|string',
            'mission_title' => 'required|string|max:255',
            'mission_description' => 'required|string',
            'vision_title' => 'required|string|max:255',
            'vision_description' => 'required|string',
            'values_title' => 'required|string|max:255',
            'values_description' => 'required|string',
            'quality_title' => 'required|string|max:255',
            'quality_description' => 'required|string',
            'integrity_title' => 'required|string|max:255',
            'integrity_description' => 'required|string',
            'innovation_title' => 'required|string|max:255',
            'innovation_description' => 'required|string',
            'customer_focus_title' => 'required|string|max:255',
            'customer_focus_description' => 'required|string',
            'team_title' => 'required|string|max:255',
            'team_description' => 'required|string',
            'stats_years' => 'required|string|max:50',
            'stats_customers' => 'required|string|max:50',
            'stats_products' => 'required|string|max:50',
            'stats_countries' => 'required|string|max:50',
            'cta_title' => 'required|string|max:255',
            'cta_description' => 'required|string',
        ]);

        $data = $request->all();

        // Handle hero image upload
        if ($request->hasFile('hero_image')) {
            $settings = AboutSetting::getSettings();
            
            // Delete old image if exists
            if ($settings && $settings->hero_image) {
                $oldImagePath = public_path($settings->hero_image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $image = $request->file('hero_image');
            $filename = time() . '_hero.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/about');
            
            // Create directory if it doesn't exist
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $image->move($destinationPath, $filename);
            $data['hero_image'] = 'images/about/' . $filename;
        }

        $data['is_active'] = true;

        // Update or create settings
        $settings = AboutSetting::getSettings();
        if ($settings) {
            $settings->update($data);
        } else {
            AboutSetting::create($data);
        }

        return redirect()->route('admin.about.index')
                        ->with('success', 'About page settings updated successfully!');
    }
}