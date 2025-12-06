<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #FDF5E6;
        }
    </style>
</head>

<body class="text-gray-800">
    <div class="container mx-auto px-6 py-8">
        <div class="mb-6">
            <a href="#" id="backBtn"
                class="inline-flex items-center gap-2 px-3 py-2 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700"><i
                    class="fa-solid fa-arrow-left"></i><span>Kembali</span></a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="rounded-2xl bg-white/70 p-6 shadow flex items-center justify-center">
                @if($product->image_path)
                    <img src="/{{ $product->image_path }}" class="max-h-96 object-contain rounded-xl"
                        alt="{{ $product->title }}">
                @else
                    <div class="w-40 h-40 bg-gray-200 rounded-xl"></div>
                @endif
            </div>
            <div class="rounded-2xl bg-white/70 p-6 shadow">
                <div class="text-3xl font-black text-[#5a3b10]">Rp.{{ number_format($product->price, 0, ',', '.') }}
                </div>
                <div class="mt-1 text-lg font-semibold">{{ $product->title }}</div>
                <div class="mt-2 text-sm text-gray-600">Kategori: {{ $product->category ?? '-' }}</div>
                <div class="mt-1 text-sm text-gray-600">Stok: {{ $product->stock }}</div>
                <div class="mt-1 text-sm text-gray-600">Berat: {{ number_format($product->weight_grams ?? 500) }} gram
                </div>
                <div class="mt-1 text-sm">Penjual: <a class="text-yellow-700 hover:underline"
                        href="/profile/{{ $product->user->id }}">{{ $product->user->name }}</a></div>
                <div class="mt-4 text-sm text-gray-700">{{ $product->description }}</div>
                @php($isOwner = Auth::check() && Auth::id() === $product->user_id)
                @if($isOwner)
                    <div class="mt-6 flex items-center gap-3">
                        <a href="/products/{{ $product->id }}/edit"
                            class="px-4 py-2 rounded-xl bg-[#5a3b10] text-white">Atur</a>
                        <a href="/my/shop" class="px-4 py-2 rounded-xl bg-gray-100">Toko Saya</a>
                    </div>
                @else
                    <form method="get" action="/checkout/{{ $product->id }}" class="mt-6 flex items-center gap-3">
                        <input type="number" name="qty" min="1" value="{{ max(1, (int) request('qty')) }}"
                            class="px-4 py-2 rounded-xl bg-[#e7dccb] w-24">
                        <button class="px-4 py-2 rounded-xl bg-yellow-600 text-white">Beli</button>
                    </form>
                @endif
                @if(session('ok'))
                    <div class="mt-3 text-green-700">{{ session('ok') }}</div>
                @endif
                @if(session('error'))
                    <div class="mt-3 text-red-700">{{ session('error') }}</div>
                @endif
            </div>
        </div>
    </div>
    <script>document.getElementById('backBtn')?.addEventListener('click', function (e) { e.preventDefault(); if (history.length > 1) { history.back(); } else { window.location.href = '/products' } });</script>
</body>

</html>