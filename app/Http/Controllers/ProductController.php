<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('user')->latest()->paginate(12);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        if (!Auth::check() || !(Auth::user()->is_seller ?? false))
            return redirect('/products');
        return view('products.create');
    }

    public function store(Request $request)
    {
        if (!Auth::check() || !(Auth::user()->is_seller ?? false))
            return redirect('/products');
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'category' => ['nullable', 'string', 'max:100'],
            'stock' => ['required', 'integer', 'min:1'],
            'weight_grams' => ['nullable', 'integer', 'min:1'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);
        $path = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = uniqid('prod_') . '.' . $file->getClientOriginalExtension();
            $dir = public_path('uploads');
            if (!is_dir($dir))
                mkdir($dir, 0777, true);
            $file->move($dir, $name);
            $path = 'uploads/' . $name;
        }
        $product = Product::create([
            'user_id' => Auth::id(),
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'price' => $data['price'],
            'category' => $data['category'] ?? null,
            'stock' => $data['stock'],
            'weight_grams' => $data['weight_grams'] ?? 500,
            'image_path' => $path,
        ]);
        return redirect('/products')->with('ok', 'Produk berhasil diterbitkan');
    }

    public function show(Product $product)
    {
        $product->load('user');
        return view('products.show', compact('product'));
    }

    public function myShop()
    {
        if (!Auth::check() || !(Auth::user()->is_seller ?? false))
            return redirect('/products');
        $products = Product::where('user_id', Auth::id())
            ->withCount([
                'orders',
                'orders as pending_orders_count' => function ($q) {
                    $q->where('status', 'pending'); }
            ])
            ->latest()->paginate(12);
        return view('products.my', compact('products'));
    }

    public function edit(Product $product)
    {
        if (!Auth::check() || !(Auth::user()->is_seller ?? false) || $product->user_id !== Auth::id())
            return redirect('/products');
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        if (!Auth::check() || !(Auth::user()->is_seller ?? false) || $product->user_id !== Auth::id())
            return redirect('/products');
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'category' => ['nullable', 'string', 'max:100'],
            'stock' => ['required', 'integer', 'min:1'],
            'weight_grams' => ['nullable', 'integer', 'min:1'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);
        $path = $product->image_path;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = uniqid('prod_') . '.' . $file->getClientOriginalExtension();
            $dir = public_path('uploads');
            if (!is_dir($dir))
                mkdir($dir, 0777, true);
            $file->move($dir, $name);
            $path = 'uploads/' . $name;
        }
        $product->update([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'price' => $data['price'],
            'category' => $data['category'] ?? null,
            'stock' => $data['stock'],
            'weight_grams' => $data['weight_grams'] ?? $product->weight_grams ?? 500,
            'image_path' => $path,
        ]);
        return redirect('/products/' . $product->id);
    }

    public function destroy(Product $product)
    {
        if (!Auth::check() || !(Auth::user()->is_seller ?? false) || $product->user_id !== Auth::id())
            return redirect('/products');
        $hasAnyOrder = $product->orders()->exists();
        $hasPendingOrder = $product->orders()->where('status', 'pending')->exists();
        if (!$hasAnyOrder)
            return back()->with('error', 'Produk belum pernah dibeli sehingga tidak dapat dihapus');
        if ($hasPendingOrder)
            return back()->with('error', 'Produk masih memiliki pesanan pending');
        if ($product->image_path) {
            $full = public_path($product->image_path);
            if (is_file($full))
                @unlink($full);
        }
        $product->delete();
        return redirect('/my/shop');
    }
}
