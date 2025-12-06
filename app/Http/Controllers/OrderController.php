<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout(Product $product)
    {
        if (!Auth::check())
            return redirect('/');
        $qty = max(1, (int) request('qty'));
        return view('checkout', ['product' => $product, 'qty' => $qty, 'user' => Auth::user()]);
    }

    public function place(Request $request, Product $product)
    {
        if (!Auth::check())
            return redirect('/');
        $data = $request->validate([
            'qty' => ['required', 'integer', 'min:1'],
            'address' => ['required', 'string', 'max:500'],
            'shipping' => ['required', 'in:regular,express'],
            'shipping_city' => ['required', 'string', 'max:100'],
            'payment' => ['required', 'in:cod,transfer'],
            'voucher' => ['nullable', 'string', 'max:50'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);
        $qty = (int) ($data['qty'] ?? 1);
        if ($product->stock < $qty) {
            return back()->with('error', 'Stock tidak cukup');
        }
        DB::transaction(function () use ($product, $qty, $data) {
            $cityFees = [
                'Jakarta' => 10000,
                'Bandung' => 12000,
                'Surabaya' => 15000,
                'Yogyakarta' => 13000,
                'Semarang' => 14000,
                'Denpasar' => 20000,
            ];
            $baseCity = $cityFees[$data['shipping_city']] ?? 15000;
            $methodAdd = ($data['shipping'] ?? 'regular') === 'express' ? 15000 : 0;
            $shippingFee = $baseCity + $methodAdd;
            $weightKg = max(1, (int) ceil(($product->weight_grams ?? 500) / 1000));
            $extraPerKg = 4000;
            $shippingFee = $shippingFee + max(0, $weightKg - 1) * $extraPerKg;
            $subtotal = ($product->price * $qty);
            $discount = 0;
            $code = trim((string) ($data['voucher'] ?? ''));
            if ($code) {
                if (strtoupper($code) === 'HEMAT10') {
                    $discount = min((int) round($subtotal * 0.10), 50000);
                } elseif (strtoupper($code) === 'ONGKIR5') {
                    $discount = min(5000, $shippingFee);
                } elseif (strtoupper($code) === 'CASHBACK20') {
                    $discount = min((int) round($subtotal * 0.20), 30000);
                }
            }
            $total = max(0, $subtotal + $shippingFee - $discount);
            Order::create([
                'buyer_id' => Auth::id(),
                'seller_id' => $product->user_id,
                'product_id' => $product->id,
                'price' => $product->price,
                'qty' => $qty,
                'status' => 'pending',
                'address' => $data['address'] ?? null,
                'shipping_method' => $data['shipping'] ?? 'regular',
                'shipping_city' => $data['shipping_city'] ?? 'Jakarta',
                'payment_method' => $data['payment'] ?? 'cod',
                'voucher_code' => $code ?: null,
                'note' => $data['note'] ?? null,
                'shipping_fee' => $shippingFee,
                'discount_amount' => $discount,
                'total_amount' => $total,
            ]);
            Sale::create([
                'user_id' => Auth::id(),
                'item_name' => $product->title,
                'category' => $product->category ?? 'General',
                'price' => $product->price,
                'qty' => $qty,
            ]);
            $product->decrement('stock', $qty);
        });
        return redirect('/my/orders')->with('ok', 'Pesanan dibuat');
    }
    public function myOrders()
    {
        if (!Auth::check())
            return redirect('/');
        $orders = Order::with(['product', 'seller'])
            ->where('buyer_id', Auth::id())
            ->latest()->paginate(12);
        return view('orders.my_orders', compact('orders'));
    }

    public function mySales()
    {
        if (!Auth::check())
            return redirect('/');
        $orders = Order::with(['product', 'buyer'])
            ->where('seller_id', Auth::id())
            ->latest()->paginate(12);
        return view('orders.my_sales', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        if (!Auth::check() || $order->seller_id !== Auth::id())
            return redirect('/');
        $data = $request->validate(['status' => ['required', 'in:paid,shipped,completed,canceled']]);
        $current = $order->status;
        $next = $data['status'];
        $allowed = [
            'pending' => ['paid', 'canceled'],
            'paid' => ['shipped', 'canceled'],
            'shipped' => ['completed', 'canceled'],
            'completed' => [],
            'canceled' => [],
        ];
        if (!in_array($next, $allowed[$current] ?? [])) {
            return back()->with('error', 'Perubahan status tidak valid');
        }
        $order->update(['status' => $next]);
        return back()->with('ok', 'Status diperbarui');
    }
    public function buy(Request $request, Product $product)
    {
        if (!Auth::check())
            return redirect('/');
        $data = $request->validate([
            'qty' => ['nullable', 'integer', 'min:1']
        ]);
        $qty = $data['qty'] ?? 1;
        if ($product->stock < $qty) {
            return back()->with('error', 'Stock tidak cukup');
        }
        return redirect('/checkout/' . $product->id . '?qty=' . $qty);
    }
}
