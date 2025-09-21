<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    /**
     * Display a listing of published news articles
     */
    public function index(Request $request)
    {
        $query = News::published()->latest('published_at');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category filter (if you have categories in the future)
        if ($request->filled('category')) {
            // $query->where('category_id', $request->get('category'));
        }

        // Featured filter
        if ($request->filled('featured') && $request->get('featured') == '1') {
            $query->featured();
        }

        $news = $query->paginate(12);

        // Get featured articles for hero section
        $featuredNews = News::published()->featured()->latest('published_at')->take(3)->get();

        // Get latest articles for sidebar
        $latestNews = News::published()->latest('published_at')->take(5)->get();

        // Get popular articles (most viewed)
        $popularNews = News::published()->orderBy('views', 'desc')->take(5)->get();

        return view('news.index', compact('news', 'featuredNews', 'latestNews', 'popularNews'));
    }

    /**
     * Display the specified news article
     */
    public function show($slug)
    {
        $news = News::published()->where('slug', $slug)->firstOrFail();

        // Increment view count
        $news->increment('views');

        // Get related articles (same category or similar content)
        $relatedNews = News::published()
            ->where('id', '!=', $news->id)
            ->latest('published_at')
            ->take(4)
            ->get();

        // Get previous and next articles
        $previousNews = News::published()
            ->where('published_at', '<', $news->published_at)
            ->orderBy('published_at', 'desc')
            ->first();

        $nextNews = News::published()
            ->where('published_at', '>', $news->published_at)
            ->orderBy('published_at', 'asc')
            ->first();

        // Get latest articles for sidebar
        $latestNews = News::published()
            ->where('id', '!=', $news->id)
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('news.show', compact('news', 'relatedNews', 'previousNews', 'nextNews', 'latestNews'));
    }

    /**
     * Get news articles for AJAX requests (infinite scroll, etc.)
     */
    public function loadMore(Request $request)
    {
        $page = $request->get('page', 1);
        $perPage = $request->get('per_page', 6);

        $query = News::published()->latest('published_at');

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('featured') && $request->get('featured') == '1') {
            $query->featured();
        }

        $news = $query->paginate($perPage, ['*'], 'page', $page);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $news->items(),
                'has_more' => $news->hasMorePages(),
                'next_page' => $news->currentPage() + 1,
                'total' => $news->total()
            ]);
        }

        return redirect()->route('news.index');
    }

    /**
     * Search news articles
     */
    public function search(Request $request)
    {
        $search = $request->get('q', '');
        
        if (empty($search)) {
            return redirect()->route('news.index');
        }

        $news = News::published()
            ->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                      ->orWhere('short_description', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
            })
            ->latest('published_at')
            ->paginate(12);

        // Get search suggestions
        $suggestions = News::published()
            ->where('title', 'like', "%{$search}%")
            ->pluck('title')
            ->take(5);

        return view('news.search', compact('news', 'search', 'suggestions'));
    }

    /**
     * Get featured news for homepage or other sections
     */
    public function featured(Request $request)
    {
        $limit = $request->get('limit', 6);
        
        $featuredNews = News::published()
            ->featured()
            ->latest('published_at')
            ->take($limit)
            ->get();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $featuredNews
            ]);
        }

        return view('news.featured', compact('featuredNews'));
    }

    /**
     * Get news archive by month/year
     */
    public function archive(Request $request, $year = null, $month = null)
    {
        $query = News::published();

        if ($year) {
            $query->whereYear('published_at', $year);
        }

        if ($month) {
            $query->whereMonth('published_at', $month);
        }

        $news = $query->latest('published_at')->paginate(12);

        // Get archive dates for sidebar
        $archiveDates = News::published()
            ->select(DB::raw('YEAR(published_at) as year, MONTH(published_at) as month, COUNT(*) as count'))
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        return view('news.archive', compact('news', 'archiveDates', 'year', 'month'));
    }

    /**
     * RSS feed for news
     */
    public function rss()
    {
        $news = News::published()
            ->latest('published_at')
            ->take(20)
            ->get();

        return response()->view('news.rss', compact('news'))
            ->header('Content-Type', 'application/rss+xml');
    }

    /**
     * Sitemap for news articles
     */
    public function sitemap()
    {
        $news = News::published()
            ->select(['slug', 'updated_at'])
            ->get();

        return response()->view('news.sitemap', compact('news'))
            ->header('Content-Type', 'application/xml');
    }
}