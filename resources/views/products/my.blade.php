<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Saya</title>
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
                <h1 class="text-2xl font-bold">Toko Saya</h1>
            </div>
            <a href="/products/create" class="px-4 py-2 rounded-xl bg-[#5a3b10] text-white">Tambah Produk</a>
        </div>
        @if(session('error'))
            <div class="mb-6 rounded-xl bg-red-100 text-red-700 p-3 text-sm">{{ session('error') }}</div>
        @endif
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($products as $p)
                <div class="group rounded-2xl bg-white/70 shadow ring-1 ring-gray-200/40 hover:shadow-lg transition p-4">
                    <a href="/products/{{ $p->id }}/edit" class="block">
                        <div class="relative h-40 flex items-center justify-center">
                            <span
                                class="absolute top-2 left-2 px-2 py-1 text-xs rounded bg-[#5a3b10] text-white">Kelola</span>
                            @if($p->image_path)
                                <img src="/{{ $p->image_path }}" class="max-h-40 object-contain rounded-xl"
                                    alt="{{ $p->title }}">
                            @else
                                <div class="w-24 h-24 bg-gray-200 rounded-xl"></div>
                            @endif
                        </div>
                        <div class="mt-2 text-lg font-semibold">Rp.{{ number_format($p->price, 0, ',', '.') }}</div>
                        <div class="text-sm text-gray-600">{{ $p->title }}</div>
                        <div class="text-xs text-gray-500">Stok: {{ $p->stock }}</div>
                    </a>
                    <div class="mt-3 flex items-center gap-2">
                        <a href="/products/{{ $p->id }}/edit" class="px-3 py-1 rounded bg-gray-100">Atur</a>
                        @if(($p->orders_count ?? 0) > 0 && ($p->pending_orders_count ?? 0) === 0)
                            <form method="post" action="/products/{{ $p->id }}/delete"
                                onsubmit="return confirm('Hapus produk ini?')">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button class="px-3 py-1 rounded bg-red-100 text-red-600">Hapus</button>
                            </form>
                        @else
                            <button class="px-3 py-1 rounded bg-red-100 text-red-600 opacity-50 cursor-not-allowed" disabled
                                title="Hapus tersedia setelah ada pesanan dan tidak pending">Hapus</button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-gray-600">Belum ada produk. Tambahkan sekarang.</div>
            @endforelse
        </div>
        <div class="mt-6">{{ $products->links() }}</div>
    </div>
    <script>document.getElementById('backBtn')?.addEventListener('click', function (e) { e.preventDefault(); if (history.length > 1) { history.back(); } else { window.location.href = '/products' } });</script>
</body>

</html>