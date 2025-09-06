<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Log;

class ImageOptimization
{
    /**
     * Maximum image dimensions
     */
    private const MAX_WIDTH = 1920;
    private const MAX_HEIGHT = 1080;
    private const THUMBNAIL_SIZE = 300;
    
    /**
     * Quality settings for different formats
     */
    private const QUALITY_SETTINGS = [
        'jpg' => 85,
        'jpeg' => 85,
        'png' => 9,
        'webp' => 85
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Process the request first
        $response = $next($request);
        
        // Check if request has file uploads
        if ($this->hasImageUploads($request)) {
            $this->optimizeUploadedimage($request);
        }
        
        return $response;
    }
    
    /**
     * Check if request has image uploads
     */
    private function hasImageUploads(Request $request): bool
    {
        $imageFields = ['image', 'featured_image', 'image', 'gallery'];
        
        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Optimize uploaded image
     */
    private function optimizeUploadedimage(Request $request)
    {
        $imageFields = ['image', 'featured_image', 'image', 'gallery'];
        
        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                $files = is_array($request->file($field)) ? $request->file($field) : [$request->file($field)];
                
                foreach ($files as $file) {
                    if ($file && $file->isValid() && $this->isImageFile($file)) {
                        $this->processImage($file);
                    }
                }
            }
        }
    }

    /**
     * Check if file is an image
     */
    private function isImageFile($file): bool
    {
        try {
            // Check if file exists and is readable
            if (!$file->isValid() || !is_readable($file->getRealPath())) {
                return false;
            }
            
            // Check mime type
            $mimeType = $file->getMimeType();
            return $mimeType && strpos($mimeType, 'image/') === 0;
        } catch (\Exception $e) {
            // If we can't determine the mime type, assume it's not an image
            return false;
        }
    }
    
    /**
     * Process and optimize image
     */
    private function processImage($file)
    {
        try {
            $image = Image::make($file->getRealPath());
            $originalPath = $file->getRealPath();
            
            // Get original dimensions
            $originalWidth = $image->width();
            $originalHeight = $image->height();
            
            // Resize if too large
            if ($originalWidth > self::MAX_WIDTH || $originalHeight > self::MAX_HEIGHT) {
                $image->resize(self::MAX_WIDTH, self::MAX_HEIGHT, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }
            
            // Auto-orient based on EXIF data
            $image->orientate();
            
            // Apply sharpening for better quality after resize
            if ($originalWidth > self::MAX_WIDTH || $originalHeight > self::MAX_HEIGHT) {
                $image->sharpen(10);
            }
            
            // Optimize based on file type
            $this->optimizeImageFormat($image, $file);
            
            // Save optimized image
            $image->save($originalPath);
            
            Log::info('Image optimized successfully', [
                'original_size' => filesize($originalPath),
                'original_dimensions' => $originalWidth . 'x' . $originalHeight,
                'new_dimensions' => $image->width() . 'x' . $image->height()
            ]);
            
        } catch (\Exception $e) {
            Log::warning('Image optimization failed: ' . $e->getMessage(), [
                'file' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType()
            ]);
        }
    }
    
    /**
     * Optimize image format and quality
     */
    private function optimizeImageFormat($image, $file)
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $mimeType = $file->getMimeType();
        
        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                // Enable progressive JPEG for better loading
                $image->interlace(true);
                $image->encode('jpg', self::QUALITY_SETTINGS['jpg']);
                break;
                
            case 'png':
                // Optimize PNG compression
                $image->encode('png', self::QUALITY_SETTINGS['png']);
                break;
                
            case 'webp':
                $image->encode('webp', self::QUALITY_SETTINGS['webp']);
                break;
                
            case 'gif':
                // For GIF, convert to PNG for better compression (unless animated)
                if (!$this->isAnimatedGif($file->getRealPath())) {
                    $image->encode('png', self::QUALITY_SETTINGS['png']);
                } else {
                    // Keep as GIF for animated image
                    $image->encode('gif');
                }
                break;
                
            default:
                // Convert unknown formats to JPEG
                $image->interlace(true);
                $image->encode('jpg', self::QUALITY_SETTINGS['jpg']);
                break;
        }
    }
    
    /**
     * Check if GIF is animated
     */
    private function isAnimatedGif($filePath): bool
    {
        if (!function_exists('imagecreatefromgif')) {
            return false;
        }
        
        $fileContent = file_get_contents($filePath);
        return strpos($fileContent, '\x00\x21\xF9\x04') !== false;
    }
    
    /**
     * Generate thumbnail (can be used for future enhancements)
     */
    private function generateThumbnail($image, $outputPath)
    {
        try {
            $thumbnail = clone $image;
            $thumbnail->fit(self::THUMBNAIL_SIZE, self::THUMBNAIL_SIZE);
            $thumbnail->encode('jpg', 80);
            $thumbnail->save($outputPath);
            
            return true;
        } catch (\Exception $e) {
            Log::warning('Thumbnail generation failed: ' . $e->getMessage());
            return false;
        }
    }
}
