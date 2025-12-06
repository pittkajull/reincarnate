<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>
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
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <a href="#" id="backBtn"
                    class="inline-flex items-center gap-2 px-3 py-2 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700"><i
                        class="fa-solid fa-arrow-left"></i><span>Kembali</span></a>
                <h1 class="text-2xl font-bold">Produk</h1>
            </div>
            <div class="flex items-center gap-3">
                <a href="/" class="px-4 py-2 rounded-xl bg-[#5a3b10] text-white">Home</a>
                @auth
                    @if(Auth::user()->is_seller)
                        <a href="/products/create" class="px-4 py-2 rounded-xl bg-yellow-600 text-white">Jual Barang</a>
                    @endif
                @endauth
            </div>
        </div>
        @if(session('ok'))
            <div class="mb-4 rounded-xl bg-green-100 text-green-700 p-3">{{ session('ok') }}</div>
        @endif
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $p)
                <a href="/products/{{ $p->id }}"
                    class="group block rounded-2xl bg-white/70 shadow ring-1 ring-gray-200/40 hover:shadow-lg hover:ring-yellow-500/40 transition p-4">
                    <div class="h-40 flex items-center justify-center">
                        @if($p->image_path)
                            <img src="/{{ $p->image_path }}" class="max-h-40 object-contain rounded-xl" alt="{{ $p->title }}">
                        @else
                            <div class="w-24 h-24 bg-gray-200 rounded-xl"></div>
                        @endif
                    </div>
                    <div class="mt-2 text-lg font-semibold">Rp.{{ number_format($p->price, 0, ',', '.') }}</div>
                    <div class="text-sm text-gray-600">{{ $p->title }}</div>
                    <div class="text-xs text-gray-500">Stok: {{ $p->stock }}</div>
                    <div class="text-xs text-gray-500">Penjual: {{ $p->user->name }}</div>
                </a>
            @endforeach
        </div>
        <div class="mt-6">{{ $products->links() }}</div>
        @if($products->isEmpty())
            <div class="text-gray-600 mt-4">Belum ada produk.</div>
        @endif
    </div>
    <script>document.getElementById('backBtn')?.addEventListener('click', function (e) { e.preventDefault(); if (history.length > 1) { history.back(); } else { window.location.href = '/' } });</script>
</body>

</html>