<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category:id,name,slug'])
            ->select('id', 'name', 'slug', 'price', 'image', 'category_id', 'created_at', 'stock_quantity', 'is_active', 'featured');
        
        // Filter by category if provided
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }
        
        $products = $query->orderBy('created_at', 'desc')->paginate(12);
        $categories = Category::where('is_active', true)
            ->select('id', 'name')
            ->get();
        
        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $categories = Category::where('is_active', true)->get();
        $selectedCategory = $request->get('category');
        
        return view('admin.products.create', compact('categories', 'selectedCategory'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sku' => 'nullable|string|max:100|unique:products',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
            'video_file' => 'nullable|file|mimes:mp4,avi,mov,wmv|max:51200',
            'video_link' => 'nullable|url',
            'is_active' => 'nullable|string',
            'featured' => 'nullable|string',
            'stock_quantity' => 'nullable|integer|min:0'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        $data['featured'] = $request->has('is_featured') ? 1 : 0;

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
            $data['image'] = 'images/products/' . $imageName;
        }

        // Handle PDF file upload
        if ($request->hasFile('pdf_file')) {
            $pdfName = time() . '_pdf.' . $request->pdf_file->extension();
            $request->pdf_file->move(public_path('files/products'), $pdfName);
            $data['pdf_file'] = 'files/products/' . $pdfName;
        }

        // Handle video file upload
        if ($request->hasFile('video_file')) {
            $videoName = time() . '_video.' . $request->video_file->extension();
            $request->video_file->move(public_path('videos/products'), $videoName);
            $data['video_file'] = 'videos/products/' . $videoName;
        }

        // Handle video link
        if ($request->filled('video_link')) {
            $data['video_link'] = $request->video_link;
        }

        try {
            Product::create($data);
            return redirect()->route('admin.products.index')
                ->with('success', 'Product created successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['slug' => 'A product with this slug already exists. Please choose a different name.']);
            }
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['category:id,name,slug']);
        
        // Get related products from the same category (excluding current product)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->select('id', 'name', 'slug', 'price', 'image')
            ->latest()
            ->limit(5)
            ->get();
        
        return view('admin.products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->get();
        
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sku' => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
            'video_file' => 'nullable|file|mimes:mp4,avi,mov,wmv|max:51200',
            'video_link' => 'nullable|url',
            'is_active' => 'nullable|string',
            'featured' => 'nullable|string',
            'stock_quantity' => 'nullable|integer|min:0'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        $data['featured'] = $request->has('is_featured') ? 1 : 0;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                $oldImagePath = str_contains($product->image, 'images/products/') 
                    ? public_path($product->image) 
                    : public_path('images/products/' . $product->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
            $data['image'] = 'images/products/' . $imageName;
        }

        // Handle PDF file upload
        if ($request->hasFile('pdf_file')) {
            // Delete old PDF if exists
            if ($product->pdf_file && file_exists(public_path('files/products/' . $product->pdf_file))) {
                unlink(public_path('files/products/' . $product->pdf_file));
            }
            
            $pdfName = time() . '_' . $request->pdf_file->getClientOriginalName();
            $request->pdf_file->move(public_path('files/products'), $pdfName);
            $data['pdf_file'] = $pdfName;
        }

        // Handle video file upload
        if ($request->hasFile('video_file')) {
            // Delete old video if exists
            if ($product->video_file && file_exists(public_path('videos/products/' . $product->video_file))) {
                unlink(public_path('videos/products/' . $product->video_file));
            }
            
            $videoName = time() . '_' . $request->video_file->getClientOriginalName();
            $request->video_file->move(public_path('videos/products'), $videoName);
            $data['video_file'] = $videoName;
        }

        // Handle video link
        if ($request->filled('video_link')) {
            $data['video_link'] = $request->video_link;
        }

        try {
            $product->update($data);
            return redirect()->route('admin.products.index')
                ->with('success', 'Product updated successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['slug' => 'A product with this slug already exists. Please choose a different name.']);
            }
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete image if exists
        if ($product->image) {
            $imagePath = str_contains($product->image, 'images/products/') 
                ? public_path($product->image) 
                : public_path('images/products/' . $product->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Delete PDF file if exists
        if ($product->pdf_file && file_exists(public_path('files/products/' . $product->pdf_file))) {
            unlink(public_path('files/products/' . $product->pdf_file));
        }

        // Delete video file if exists
        if ($product->video_file && file_exists(public_path('videos/products/' . $product->video_file))) {
            unlink(public_path('videos/products/' . $product->video_file));
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
