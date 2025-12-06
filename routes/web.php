<?php

// Routing utama aplikasi.

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AuthController;
use App\Models\Sale;
use App\Models\User;
use App\Models\Product;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;

// Halaman storefront.
Route::get('/', function () {
    $products = Product::with('user')->latest()->limit(10)->get();
    $boardProducts = Product::with('user')->latest()->limit(20)->get();
    return view('home', ['products' => $products, 'boardProducts' => $boardProducts]);
});

Route::get('/login', function () {
    return redirect('/?auth=signin');
})->name('login');
Route::get('/register', function () {
    return redirect('/?auth=register');
})->name('register');

Route::get('/dev/products', function () {
    $list = \App\Models\Product::orderByDesc('id')->limit(5)->get(['id', 'title', 'price', 'user_id']);
    return response()->json(['count' => \App\Models\Product::count(), 'latest' => $list]);
});
Route::get('/dev/products/seed', function () {
    $userId = \App\Models\User::value('id');
    if (!$userId)
        return response()->json(['error' => 'no user'], 400);
    $p = \App\Models\Product::create([
        'user_id' => $userId,
        'title' => 'Sample Item',
        'description' => 'Generated for debug',
        'price' => 12345,
        'category' => 'Debug',
        'stock' => 5,
        'image_path' => null,
    ]);
    return response()->json(['created' => $p->id]);
});

Route::get('/dev/products/cleanup', function () {
    $count = \App\Models\Product::where('title', 'Sample Item')->orWhere('price', 12345)->delete();
    return response()->json(['deleted' => $count]);
});

// Endpoint autentikasi dipanggil dari UI (AJAX JSON)
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout']);

// Proteksi akses admin: redirect ke '/' jika bukan admin
Route::get('/admin', function () {
    $user = Auth::user();
    if (!$user || ($user->role ?? 'user') !== 'admin') {
        return redirect('/');
    }

    $soldQty = (int) (Sale::sum('qty') ?? 0);
    $revenue = (int) (Sale::select(DB::raw('SUM(price * qty) as total'))->value('total') ?? 0);
    $activeUsers = (int) User::count();

    $popular = Sale::select('category', DB::raw('SUM(qty) as qty'))
        ->groupBy('category')
        ->orderByDesc('qty')
        ->limit(3)
        ->get();

    $latestCustomers = Sale::with('user')
        ->orderByDesc('created_at')
        ->limit(5)
        ->get();

    $series = Sale::select(DB::raw('DATE(created_at) as d'), DB::raw('SUM(qty) as qty'))
        ->groupBy('d')
        ->orderBy('d')
        ->get();
    $n = max(count($series), 1);
    $maxQty = max($series->pluck('qty')->all() ?: [1]);
    $points = [];
    for ($i = 0; $i < $n; $i++) {
        $q = (int) ($series[$i]->qty ?? 0);
        $x = 10 + ($n > 1 ? $i * ((500 - 20) / ($n - 1)) : 0);
        $y = 150 - ($maxQty ? ($q / $maxQty) * 100 : 0);
        $points[] = intval($x) . ',' . intval($y);
    }

    $metrics = [
        'soldQty' => $soldQty,
        'revenue' => $revenue,
        'activeUsers' => $activeUsers,
        'popular' => $popular,
        'latestCustomers' => $latestCustomers,
        'chart' => [
            'points' => implode(' ', $points),
        ],
    ];

    return view('admin.dashboard', ['user' => $user, 'metrics' => $metrics]);
});

//

Route::middleware('auth')->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/create', [ProductController::class, 'create']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/products/{product}/edit', [ProductController::class, 'edit']);
    Route::post('/products/{product}/buy', [OrderController::class, 'buy']);
    Route::post('/products/{product}', [ProductController::class, 'update']);
    Route::post('/products/{product}/delete', [ProductController::class, 'destroy']);
    Route::get('/products/{product}', [ProductController::class, 'show']);
    Route::get('/checkout/{product}', [OrderController::class, 'checkout']);
    Route::post('/checkout/{product}', [OrderController::class, 'place']);
    Route::get('/my/shop', [ProductController::class, 'myShop']);
    Route::get('/my/orders', [OrderController::class, 'myOrders']);
    Route::get('/my/sales', [OrderController::class, 'mySales']);
    Route::post('/orders/{order}/status', [OrderController::class, 'updateStatus']);
    Route::post('/profile/become-seller', [ProfileController::class, 'becomeSeller']);
    Route::post('/profile/update-name', [ProfileController::class, 'updateName']);
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword']);
    Route::post('/profile/update-address', [ProfileController::class, 'updateAddress']);
    Route::get('/profile/{user}', [ProfileController::class, 'show']);
});
