<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of active suppliers
     */
    public function index(Request $request)
    {
        $query = Supplier::active()->ordered();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $suppliers = $query->paginate(12);

        // Get featured suppliers (first 6 for hero section)
        $featuredSuppliers = Supplier::active()->ordered()->take(6)->get();

        return view('suppliers.index', compact('suppliers', 'featuredSuppliers'));
    }

    /**
     * Display the specified supplier
     */
    public function show($slug)
    {
        $supplier = Supplier::active()->where('slug', $slug)->firstOrFail();

        // Get related suppliers (excluding current one)
        $relatedSuppliers = Supplier::active()
            ->where('id', '!=', $supplier->id)
            ->ordered()
            ->take(6)
            ->get();

        // Get previous and next suppliers based on sort order
        $previousSupplier = Supplier::active()
            ->where('sort_order', '<', $supplier->sort_order)
            ->orderBy('sort_order', 'desc')
            ->first();

        $nextSupplier = Supplier::active()
            ->where('sort_order', '>', $supplier->sort_order)
            ->orderBy('sort_order', 'asc')
            ->first();

        return view('suppliers.show', compact('supplier', 'relatedSuppliers', 'previousSupplier', 'nextSupplier'));
    }

    /**
     * Get suppliers for AJAX requests (infinite scroll, search, etc.)
     */
    public function loadMore(Request $request)
    {
        $page = $request->get('page', 1);
        $perPage = $request->get('per_page', 6);

        $query = Supplier::active()->ordered();

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $suppliers = $query->paginate($perPage, ['*'], 'page', $page);

        if ($request->ajax()) {
            return response()->json([
                'suppliers' => $suppliers->items(),
                'has_more' => $suppliers->hasMorePages(),
                'next_page' => $suppliers->currentPage() + 1
            ]);
        }

        return redirect()->route('suppliers.index');
    }

    /**
     * Search suppliers (for autocomplete or search suggestions)
     */
    public function search(Request $request)
    {
        $search = $request->get('q', '');
        
        if (strlen($search) < 2) {
            return response()->json([]);
        }

        $suppliers = Supplier::active()
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('short_description', 'like', "%{$search}%");
            })
            ->select('id', 'name', 'slug', 'short_description')
            ->take(10)
            ->get();

        return response()->json($suppliers);
    }
}