<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;

try {
    $product = Product::where('slug', 'fashion')->first();
    
    if ($product) {
        echo "Product Details:\n";
        echo "Name: " . $product->name . "\n";
        echo "Slug: " . $product->slug . "\n";
        echo "Stock: " . $product->stock_quantity . "\n";
        echo "Price: $" . $product->price . "\n";
        echo "Sale Price: $" . ($product->sale_price ?: 'N/A') . "\n";
        echo "Active: " . ($product->is_active ? 'Yes' : 'No') . "\n";
        echo "ID: " . $product->id . "\n";
    } else {
        echo "No product found with slug 'fashion'\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}