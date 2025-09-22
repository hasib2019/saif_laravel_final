<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Supplier::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $status = $request->get('status');
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $suppliers = $query->ordered()->paginate(10);

        return view('admin.suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:suppliers,slug',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
            'video_file' => 'nullable|file|mimes:mp4,avi,mov,wmv|max:51200',
            'youtube_link' => 'nullable|url',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|string',
        ]);

        $data = $request->all();
        
        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        
        // Ensure boolean values
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        $data['sort_order'] = $request->get('sort_order', 0);

        // Handle multiple image uploads
        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('suppliers/images', 'public');
                $imagePaths[] = $path;
            }
            $data['images'] = $imagePaths;
        }

        // Handle PDF upload
        if ($request->hasFile('pdf_file')) {
            $data['pdf_file'] = $request->file('pdf_file')->store('suppliers/pdfs', 'public');
        }

        // Handle video upload
        if ($request->hasFile('video_file')) {
            $data['video_file'] = $request->file('video_file')->store('suppliers/videos', 'public');
        }

        Supplier::create($data);

        return redirect()->route('admin.suppliers.index')
                        ->with('success', 'Supplier created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        return view('admin.suppliers.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view('admin.suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:suppliers,slug,' . $supplier->id,
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
            'video_file' => 'nullable|file|mimes:mp4,avi,mov,wmv|max:51200',
            'youtube_link' => 'nullable|url',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|string',
        ]);

        $data = $request->all();
        
        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        
        // Ensure boolean values
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        $data['sort_order'] = $request->get('sort_order', $supplier->sort_order);

        // Handle multiple image uploads
        if ($request->hasFile('images')) {
            // Delete old images
            if ($supplier->images) {
                foreach ($supplier->images as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('suppliers/images', 'public');
                $imagePaths[] = $path;
            }
            $data['images'] = $imagePaths;
        }

        // Handle PDF upload
        if ($request->hasFile('pdf_file')) {
            // Delete old PDF
            if ($supplier->pdf_file) {
                Storage::disk('public')->delete($supplier->pdf_file);
            }
            $data['pdf_file'] = $request->file('pdf_file')->store('suppliers/pdfs', 'public');
        }

        // Handle video upload
        if ($request->hasFile('video_file')) {
            // Delete old video
            if ($supplier->video_file) {
                Storage::disk('public')->delete($supplier->video_file);
            }
            $data['video_file'] = $request->file('video_file')->store('suppliers/videos', 'public');
        }

        $supplier->update($data);

        return redirect()->route('admin.suppliers.show', $supplier)
                        ->with('success', 'Supplier updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        // Delete associated files
        if ($supplier->images) {
            foreach ($supplier->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }
        
        if ($supplier->pdf_file) {
            Storage::disk('public')->delete($supplier->pdf_file);
        }
        
        if ($supplier->video_file) {
            Storage::disk('public')->delete($supplier->video_file);
        }

        $supplier->delete();

        return redirect()->route('admin.suppliers.index')
                        ->with('success', 'Supplier deleted successfully!');
    }
}