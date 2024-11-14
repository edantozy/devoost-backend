<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(middleware: 'auth:sanctum'),
        ];
    }

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $orders = Order::with(['client', 'items.product'])->latest()->paginate($perPage);

        return new OrderCollection($orders);
    }

    public function show(Order $order)
    {
        $order->load('client', 'items.product');

        return new OrderResource($order);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'status' => 'required|in:pending,completed,cancelled',
            'items' => 'nullable|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $order = Order::create([
                'client_id' => $validated['client_id'],
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'status' => $validated['status'],
                'total' => 0,
            ]);

            $total = 0;

            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);
                $quantity = $item['quantity'];
                $subtotal = $product->price * $quantity;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ]);

                $total += $subtotal;
            }

            $order->update(['total' => $total]);

            DB::commit();

            $order->load('client', 'items.product');

            return response()->json([
                'success' => true,
                'data' => new OrderResource($order),
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la orden',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'status' => 'required|in:pending,completed,cancelled',
            'items' => 'nullable|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            // // Buscar la orden
            // $order = Order::findOrFail($order->id);

            $order->update([
                'client_id' => $validated['client_id'],
                'status' => $validated['status'],
            ]);

            $total = 0;

            $order->items()->delete();

            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);
                $quantity = $item['quantity'];
                $subtotal = $product->price * $quantity;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ]);

                $total += $subtotal;
            }

            $order->update(['total' => $total]);

            DB::commit();

            $order->load('client', 'items.product');

            return response()->json([
                'success' => true,
                'data' => new OrderResource($order),
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la orden',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
