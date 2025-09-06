# CDN Integration Guide

This Laravel application includes built-in CDN (Content Delivery Network) integration to serve static assets from a CDN for improved performance and reduced server load.

## Configuration

### Environment Variables

Add the following variables to your `.env` file:

```env
# CDN Configuration
CDN_ENABLED=false
CDN_URL=https://cdn.yourdomain.com
ASSET_URL=
```

### Configuration Options

- `CDN_ENABLED`: Set to `true` to enable CDN integration
- `CDN_URL`: Your CDN base URL (without trailing slash)
- `ASSET_URL`: Alternative asset URL (used when CDN is disabled)

## Usage

### Blade Directives

The application provides custom Blade directives for CDN-aware asset URLs:

```blade
<!-- CDN-aware asset URL -->
<link rel="stylesheet" href="@cdnAsset('css/app.css')">
<script src="@cdnAsset('js/app.js')"></script>

<!-- CDN-aware Mix assets (with versioning) -->
<link rel="stylesheet" href="@cdnMix('css/app.css')">
<script src="@cdnMix('js/app.js')"></script>

<!-- CDN-aware image -->
<img src="@cdnImage('image/logo.png')" alt="Logo">
<img src="@cdnImage($product->image, 'image/default-product.png')" alt="Product">
```

### PHP Service

You can also use the `CdnService` class directly in your PHP code:

```php
use App\Services\CdnService;

// Get CDN URL for an asset
$cssUrl = CdnService::asset('css/app.css');

// Get CDN URL for a Mix asset
$jsUrl = CdnService::mix('js/app.js');

// Get CDN URL for an image with fallback
$imageUrl = CdnService::image($product->image, 'image/default.png');

// Check if CDN is enabled
if (CdnService::isEnabled()) {
    // CDN is active
}

// Get CDN configuration
$config = CdnService::getConfig();
```

## CDN Setup Examples

### CloudFlare

1. Set up a CNAME record pointing to your domain:
   ```
   cdn.yourdomain.com -> yourdomain.com
   ```

2. Configure your `.env`:
   ```env
   CDN_ENABLED=true
   CDN_URL=https://cdn.yourdomain.com
   ```

### Amazon CloudFront

1. Create a CloudFront distribution with your domain as origin
2. Configure your `.env`:
   ```env
   CDN_ENABLED=true
   CDN_URL=https://d1234567890.cloudfront.net
   ```

### MaxCDN/StackPath

1. Create a pull zone with your domain as origin
2. Configure your `.env`:
   ```env
   CDN_ENABLED=true
   CDN_URL=https://yourzone-12345.maxcdn.com
   ```

## Configuration File

Advanced CDN settings can be configured in `config/cdn.php`:

```php
return [
    'enabled' => env('CDN_ENABLED', false),
    'url' => env('CDN_URL'),
    'asset_url' => env('ASSET_URL'),
    
    // Multiple CDN domains for load balancing
    'domains' => [
        // 'https://cdn1.yourdomain.com',
        // 'https://cdn2.yourdomain.com',
    ],
    
    // File extensions to serve via CDN
    'extensions' => [
        'css', 'js', 'png', 'jpg', 'jpeg', 'gif', 'svg', 'webp',
        'woff', 'woff2', 'ttf', 'eot', 'ico', 'pdf', 'zip',
    ],
    
    // Cache control settings
    'cache' => [
        'max_age' => 31536000, // 1 year
        'public' => true,
    ],
];
```

## Testing

To test CDN integration:

1. Enable CDN in your `.env` file
2. Set a test CDN URL
3. Check that asset URLs in your application use the CDN URL
4. Verify assets load correctly from the CDN

## Performance Benefits

- **Reduced Server Load**: Static assets served from CDN
- **Improved Loading Speed**: Assets served from geographically closer locations
- **Better Caching**: CDN provides optimized caching strategies
- **Bandwidth Savings**: Reduced bandwidth usage on your origin server

## Troubleshooting

### Assets Not Loading from CDN

1. Check that `CDN_ENABLED=true` in your `.env` file
2. Verify the CDN URL is correct and accessible
3. Ensure your CDN is properly configured to pull from your origin
4. Clear application cache: `php artisan config:clear`

### Mixed Content Warnings

- Ensure your CDN URL uses HTTPS if your site uses HTTPS
- Check that all asset references use the CDN directives

### Performance Issues

- Monitor CDN cache hit rates
- Verify CDN configuration matches your needs
- Consider using multiple CDN domains for load balancing