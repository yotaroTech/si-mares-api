<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\TranzilaService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(private TranzilaService $tranzila) {}

    public function createSession(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);

        $order = Order::where('id', $validated['order_id'])
            ->where('user_id', $request->user()->id)
            ->where('payment_status', 'pending')
            ->firstOrFail();

        $session = $this->tranzila->createPaymentSession(
            (float) $order->total,
            $order->order_number,
        );

        return response()->json($session);
    }

    public function callback(Request $request)
    {
        $result = $this->tranzila->processCallback($request->all());

        if (!$result['order_number']) {
            return response('Missing order number', 400);
        }

        $order = Order::where('order_number', $result['order_number'])->first();

        if (!$order) {
            return response('Order not found', 404);
        }

        if ($result['success']) {
            $order->update([
                'payment_status' => 'completed',
                'payment_method' => 'tranzila',
                'payment_reference' => $result['confirmation_code'],
                'status' => 'confirmed',
            ]);
        } else {
            $order->update([
                'payment_status' => 'failed',
                'payment_reference' => "ERR:{$result['response_code']}",
            ]);
        }

        return response('OK', 200);
    }

    public function verify(Request $request, string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        return response()->json([
            'order_number' => $order->order_number,
            'payment_status' => $order->payment_status->value,
            'order_status' => $order->status->value,
            'order_status_label' => $order->status->label(),
        ]);
    }
}
