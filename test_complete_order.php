<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

try {
    $product = Product::where('slug', 'fashion')->first();
    
    if (!$product) {
        echo "Product not found\n";
        exit;
    }
    
    echo "Starting complete order test...\n";
    echo "Product: " . $product->name . " (ID: " . $product->id . ")\n";
    echo "Stock before: " . $product->stock_quantity . "\n";
    
    // Simulate complete order creation
    DB::beginTransaction();
    
    try {
        $quantity = 1;
        $unitPrice = $product->sale_price && $product->sale_price < $product->price 
            ? $product->sale_price 
            : $product->price;
        
        $subtotal = $unitPrice * $quantity;
        $taxAmount = $subtotal * 0.1;
        $shippingAmount = 15.00;
        $totalAmount = $subtotal + $taxAmount + $shippingAmount;
        
        echo "Pricing calculation:\n";
        echo "- Unit price: $" . $unitPrice . "\n";
        echo "- Subtotal: $" . $subtotal . "\n";
        echo "- Tax: $" . $taxAmount . "\n";
        echo "- Shipping: $" . $shippingAmount . "\n";
        echo "- Total: $" . $totalAmount . "\n";
        
        // Create order
        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'customer_name' => 'Test User Complete',
            'customer_email' => 'testcomplete@example.com',
            'customer_phone' => '1234567890',
            'customer_address' => 'Test Address Complete',
            'customer_city' => 'Test City',
            'customer_country' => 'Bangladesh',
            'customer_postal_code' => '12345',
            'status' => 'pending',
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'shipping_amount' => $shippingAmount,
            'total_amount' => $totalAmount,
            'notes' => 'Complete test order',
            'order_date' => now(),
        ]);
        
        echo "Order created with ID: " . $order->id . "\n";
        echo "Order number: " . $order->order_number . "\n";
        
        // Create order item
        $orderItem = OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_sku' => $product->sku,
            'product_price' => $product->price,
            'sale_price' => $product->sale_price,
            'product_image' => $product->image,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total_price' => $subtotal,
        ]);
        
        echo "Order item created with ID: " . $orderItem->id . "\n";
        
        // Update product stock
        $product->decrement('stock_quantity', $quantity);
        $product->refresh();
        
        echo "Stock after: " . $product->stock_quantity . "\n";
        
        DB::commit();
        
        echo "Order completed successfully!\n";
        echo "Order can be viewed at: /order-details/" . $order->order_number . "\n";
        echo "Total orders in database: " . Order::count() . "\n";
        
    } catch (\Exception $e) {
        DB::rollback();
        echo "Order creation failed: " . $e->getMessage() . "\n";
        echo "Stack trace: " . $e->getTraceAsString() . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}