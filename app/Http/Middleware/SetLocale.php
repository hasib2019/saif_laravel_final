<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Define supported locales
        $supportedLocales = ['en', 'ar'];
        
        // Get locale from various sources in order of priority
        $locale = $this->getLocale($request, $supportedLocales);
        
        // Set the application locale
        App::setLocale($locale);
        
        // Store in session for persistence
        Session::put('locale', $locale);
        
        return $next($request);
    }
    
    /**
     * Get the locale from various sources
     *
     * @param Request $request
     * @param array $supportedLocales
     * @return string
     */
    private function getLocale(Request $request, array $supportedLocales): string
    {
        // 1. Check if locale is in the URL (for language switching)
        if ($request->has('locale') && in_array($request->get('locale'), $supportedLocales)) {
            return $request->get('locale');
        }
        
        // 2. Check session for previously set locale
        if (Session::has('locale') && in_array(Session::get('locale'), $supportedLocales)) {
            return Session::get('locale');
        }
        
        // 3. Check browser's preferred language
        $browserLocale = $this->getBrowserLocale($request, $supportedLocales);
        if ($browserLocale) {
            return $browserLocale;
        }
        
        // 4. Fall back to default locale from config
        $defaultLocale = config('app.locale', 'en');
        return in_array($defaultLocale, $supportedLocales) ? $defaultLocale : 'en';
    }
    
    /**
     * Get locale from browser's Accept-Language header
     *
     * @param Request $request
     * @param array $supportedLocales
     * @return string|null
     */
    private function getBrowserLocale(Request $request, array $supportedLocales): ?string
    {
        $acceptLanguage = $request->header('Accept-Language');
        
        if (!$acceptLanguage) {
            return null;
        }
        
        // Parse Accept-Language header
        $languages = [];
        foreach (explode(',', $acceptLanguage) as $lang) {
            $parts = explode(';', trim($lang));
            $locale = trim($parts[0]);
            $quality = 1.0;
            
            if (count($parts) > 1 && strpos($parts[1], 'q=') === 0) {
                $quality = (float) substr($parts[1], 2);
            }
            
            $languages[$locale] = $quality;
        }
        
        // Sort by quality (preference)
        arsort($languages);
        
        // Find the first supported locale
        foreach (array_keys($languages) as $locale) {
            // Check exact match
            if (in_array($locale, $supportedLocales)) {
                return $locale;
            }
            
            // Check language part only (e.g., 'en' from 'en-US')
            $languagePart = explode('-', $locale)[0];
            if (in_array($languagePart, $supportedLocales)) {
                return $languagePart;
            }
        }
        
        return null;
    }
}