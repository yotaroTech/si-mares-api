<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService) {}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipping_address' => 'required|array',
            'shipping_address.first_name' => 'required|string',
            'shipping_address.last_name' => 'required|string',
            'shipping_address.street' => 'required|string',
            'shipping_address.city' => 'required|string',
            'shipping_address.zip' => 'nullable|string',
            'shipping_address.phone' => 'required|string',
            'shipping_zone_id' => 'required|exists:shipping_zones,id',
            'coupon_code' => 'nullable|string',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            $order = $this->orderService->createFromCart(
                $request->user()->id,
                $validated['shipping_address'],
                $validated['shipping_zone_id'],
                $validated['coupon_code'] ?? null,
                $validated['notes'] ?? null,
            );

            return response()->json([
                'order' => $this->formatOrder($order),
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function index(Request $request)
    {
        $orders = Order::with('items')
            ->where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'orders' => $orders->through(fn($order) => $this->formatOrder($order)),
        ]);
    }

    public function show(Request $request, string $orderNumber)
    {
        $order = Order::with(['items.variant.product.primaryImage'])
            ->where('user_id', $request->user()->id)
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        return response()->json([
            'order' => $this->formatOrder($order),
        ]);
    }

    private function formatOrder(Order $order): array
    {
        return [
            'id' => $order->id,
            'order_number' => $order->order_number,
            'status' => $order->status->value,
            'status_label' => $order->status->label(),
            'subtotal' => (float) $order->subtotal,
            'shipping_cost' => (float) $order->shipping_cost,
            'discount' => (float) $order->discount,
            'total' => (float) $order->total,
            'shipping_address' => $order->shipping_address,
            'payment_status' => $order->payment_status->value,
            'items' => $order->items->map(fn($item) => [
                'product_name' => $item->product_name,
                'variant_info' => $item->variant_info,
                'sku' => $item->sku,
                'quantity' => $item->quantity,
                'unit_price' => (float) $item->unit_price,
                'total_price' => (float) $item->total_price,
                'image' => $item->variant?->product?->primaryImage?->image_path,
            ]),
            'created_at' => $order->created_at->toISOString(),
        ];
    }
}
