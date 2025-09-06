<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class LanguageController extends Controller
{
    /**
     * Switch the application language
     *
     * @param Request $request
     * @param string $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchLanguage(Request $request, $locale)
    {
        // Define supported languages
        $supportedLocales = ['en', 'ar'];
        
        // Check if the requested locale is supported
        if (!in_array($locale, $supportedLocales)) {
            $locale = 'en'; // Default to English if unsupported locale
        }
        
        // Set the application locale
        App::setLocale($locale);
        
        // Store the locale in session for persistence
        Session::put('locale', $locale);
        
        // Redirect back to the previous page
        return Redirect::back()->with('success', 'Language changed successfully!');
    }
    
    /**
     * Get the current locale
     *
     * @return string
     */
    public function getCurrentLocale()
    {
        return App::getLocale();
    }
    
    /**
     * Get all supported locales
     *
     * @return array
     */
    public function getSupportedLocales()
    {
        return [
            'en' => [
                'name' => 'English',
                'native' => 'English',
                'flag' => '🇺🇸',
                'direction' => 'ltr'
            ],
            'ar' => [
                'name' => 'Arabic',
                'native' => 'العربية',
                'flag' => '🇸🇦',
                'direction' => 'rtl'
            ]
        ];
    }
}