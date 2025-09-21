<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display the gallery page
     */
    public function index()
    {
        $galleries = Gallery::active()
            ->ordered()
            ->get();

        return view('gallery', compact('galleries'));
    }

    /**
     * Show a specific gallery item
     */
    public function show($id)
    {
        $gallery = Gallery::active()->findOrFail($id);
        
        return view('gallery.show', compact('gallery'));
    }
}