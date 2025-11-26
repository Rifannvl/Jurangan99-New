<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerOrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = Order::where('user_id', $request->user()->id)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('shop.orders.index', compact('orders'));
    }

    public function show(Request $request, Order $order): View
    {
        $this->authorizeOrder($order, $request);

        $order->load('items', 'review.user');

        return view('shop.orders.show', compact('order'));
    }

    public function invoice(Request $request, Order $order): View
    {
        $this->authorizeOrder($order, $request);

        $order->load('items');

        return view('shop.orders.invoice', compact('order'));
    }

    public function storeReview(Request $request, Order $order): RedirectResponse
    {
        $this->authorizeOrder($order, $request);

        if ($order->status !== Order::STATUS_COMPLETED) {
            return back()->withErrors(['rating' => __('You can only review completed orders.')])->withInput();
        }

        if ($order->review) {
            return back()->with('success', __('You already submitted a review for this order.'));
        }

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['required', 'string', 'min:10', 'max:1000'],
        ]);

        $order->review()->create([
            'user_id' => $request->user()->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return back()->with('success', __('Terima kasih atas ulasannya.'));
    }

    protected function authorizeOrder(Order $order, Request $request): void
    {
        if ($order->user_id !== $request->user()->id) {
            abort(403);
        }
    }
}
