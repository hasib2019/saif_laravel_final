<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

try {
    $product = Product::where('slug', 'fashion')->first();
    
    if (!$product) {
        echo "Product not found\n";
        exit;
    }
    
    // Simulate form data
    $formData = [
        'product_id' => $product->id,
        'quantity' => 1,
        'first_name' => 'Test',
        'last_name' => 'User',
        'email' => 'test@example.com',
        'phone' => '1234567890',
        'address' => 'Test Address',
        'city' => 'Test City',
        'postal_code' => '12345',
        'notes' => 'Test order'
    ];
    
    // Test validation
    $validator = Validator::make($formData, [
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
        'address' => 'required|string',
        'city' => 'required|string|max:100',
        'postal_code' => 'nullable|string|max:20',
        'notes' => 'nullable|string',
    ]);
    
    if ($validator->fails()) {
        echo "Validation failed:\n";
        foreach ($validator->errors()->all() as $error) {
            echo "- $error\n";
        }
    } else {
        echo "Validation passed successfully!\n";
        
        // Check stock
        if ($product->stock_quantity < $formData['quantity']) {
            echo "Stock check failed: Insufficient stock\n";
        } else {
            echo "Stock check passed\n";
        }
        
        echo "Product stock: " . $product->stock_quantity . "\n";
        echo "Requested quantity: " . $formData['quantity'] . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}