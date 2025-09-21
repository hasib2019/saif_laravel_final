<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Show the order form for a specific product.
     */
    public function create(Request $request, $productSlug)
    {
        $product = Product::where('slug', $productSlug)
            ->where('is_active', true)
            ->firstOrFail();

        // Check if product is in stock
        if ($product->stock_quantity <= 0) {
            return redirect()->back()->with('error', 'This product is currently out of stock.');
        }

        $quantity = $request->get('quantity', 1);
        
        // Calculate pricing
        $unitPrice = $product->sale_price && $product->sale_price < $product->price 
            ? $product->sale_price 
            : $product->price;
        
        $subtotal = $unitPrice * $quantity;
        $taxAmount = $subtotal * 0.1; // 10% tax
        $shippingAmount = 15.00; // Fixed shipping
        $totalAmount = $subtotal + $taxAmount + $shippingAmount;

        return view('order-form', compact('product', 'quantity', 'unitPrice', 'subtotal', 'taxAmount', 'shippingAmount', 'totalAmount'));
    }

    /**
     * Store a new order.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
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
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $product = Product::findOrFail($request->product_id);

        // Check stock availability
        if ($product->stock_quantity < $request->quantity) {
            return redirect()->back()
                ->with('error', 'Insufficient stock. Only ' . $product->stock_quantity . ' items available.')
                ->withInput();
        }

        DB::beginTransaction();

        try {
            // Calculate pricing
            $unitPrice = $product->sale_price && $product->sale_price < $product->price 
                ? $product->sale_price 
                : $product->price;
            
            $subtotal = $unitPrice * $request->quantity;
            $taxAmount = $subtotal * 0.1; // 10% tax
            $shippingAmount = 15.00; // Fixed shipping
            $totalAmount = $subtotal + $taxAmount + $shippingAmount;

            // Create order
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'customer_name' => $request->first_name . ' ' . $request->last_name,
                'customer_email' => $request->email,
                'customer_phone' => $request->phone,
                'customer_address' => $request->address,
                'customer_city' => $request->city,
                'customer_country' => 'Bangladesh', // Default country
                'customer_postal_code' => $request->postal_code,
                'status' => 'pending',
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'shipping_amount' => $shippingAmount,
                'total_amount' => $totalAmount,
                'notes' => $request->notes,
                'order_date' => now(),
            ]);

            // Create order item
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_sku' => $product->sku,
                'product_price' => $product->price,
                'sale_price' => $product->sale_price,
                'product_image' => $product->image,
                'quantity' => $request->quantity,
                'unit_price' => $unitPrice,
                'total_price' => $subtotal,
            ]);

            // Update product stock
            $product->decrement('stock_quantity', $request->quantity);

            // Send order confirmation notification
            try {
                $order->notifyStatusUpdate();
            } catch (\Exception $e) {
                // Log the error but don't fail the order creation
                \Log::error('Failed to send order confirmation notification: ' . $e->getMessage());
            }

            DB::commit();

            return redirect()->route('order.success', $order->order_number)
                ->with('success', 'Your order has been placed successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'An error occurred while processing your order. Please try again.')
                ->withInput();
        }
    }

    /**
     * Show order success page.
     */
    public function success($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with('orderItems.product')
            ->firstOrFail();

        return view('order-success', compact('order'));
    }

    /**
     * Show order details.
     */
    public function show($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with('orderItems.product')
            ->firstOrFail();

        return view('order-details', compact('order'));
    }
}
