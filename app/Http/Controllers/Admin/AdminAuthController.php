<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');
        
        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login');
    }

    public function dashboard(\App\Services\CacheService $cacheService)
    {
        $stats = $cacheService->getSiteStats();
        $categoriesCount = $stats['total_categories'];
        $productsCount = $stats['total_products'];
        $pagesCount = $stats['total_pages'];
        $featuredProductsCount = $stats['featured_products'];
        
        // Recent products still need to be fetched fresh for admin dashboard
        $recentProducts = \App\Models\Product::with(['category:id,name,slug'])
            ->select('id', 'name', 'slug', 'price', 'image', 'category_id', 'created_at', 'stock_quantity')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'categoriesCount',
            'productsCount', 
            'pagesCount',
            'featuredProductsCount',
            'recentProducts'
        ));
    }
}
