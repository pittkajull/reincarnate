<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penjualan Saya</title>
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
        <div class="flex items-center gap-3 mb-6">
            <a href="#" id="backBtn"
                class="inline-flex items-center gap-2 px-3 py-2 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700"><i
                    class="fa-solid fa-arrow-left"></i><span>Kembali</span></a>
            <h1 class="text-2xl font-bold">Penjualan Saya</h1>
        </div>
        <div class="rounded-3xl border border-gray-300 bg-white/70">
            <div class="grid grid-cols-7 px-6 py-3 text-sm text-gray-600">
                <div>ID</div>
                <div>Produk</div>
                <div>Pembeli</div>
                <div>Qty</div>
                <div>Total</div>
                <div>Status</div>
                <div>Aksi</div>
            </div>
            @foreach($orders as $o)
            <div class="border-t px-6 py-4 grid grid-cols-7 text-sm items-center">
                <div>#{{ $o->id }}</div>
                <div><a href="/products/{{ $o->product->id }}" class="hover:underline">{{ $o->product->title }}</a>
                </div>
                <div><a href="/profile/{{ $o->buyer->id }}" class="hover:underline">{{ $o->buyer->name }}</a></div>
                <div>{{ $o->qty }}</div>
                <div>Rp.{{ number_format($o->total_amount ?? ($o->price * $o->qty), 0, ',', '.') }}</div>
                <div><span class="px-2 py-1 rounded bg-gray-200">{{ ucfirst($o->status) }}</span></div>
                <div class="flex items-center gap-2">
                    <form method="post" action="/orders/{{ $o->id }}/status">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <select name="status" class="px-2 py-1 rounded bg-[#e7dccb]">
                            @php($opts = $o->status === 'pending' ? ['paid', 'canceled'] : ($o->status === 'paid' ? ['shipped', 'canceled'] : ($o->status === 'shipped' ? ['completed', 'canceled'] : [])))
                            @foreach($opts as $st)
                                <option value="{{ $st }}">{{ ucfirst($st) }}</option>
                            @endforeach
                        </select>
                        <button class="px-3 py-1 rounded bg-yellow-600 text-white">Ubah</button>
                    </form>
                    @if(in_array($o->status, ['completed', 'canceled', 'paid', 'shipped']))
                        <form method="post" action="/products/{{ $o->product->id }}/delete"
                            onsubmit="return confirm('Hapus produk ini?')">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button class="px-3 py-1 rounded bg-red-100 text-red-600">Hapus Produk</button>
                        </form>
                    @else
                        <button class="px-3 py-1 rounded bg-red-100 text-red-600 opacity-50 cursor-not-allowed"
                            title="Hapus produk tersedia setelah pesanan tidak pending" disabled>Hapus Produk</button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $orders->links() }}</div>
    </div>
    <script>document.getElementById('backBtn')?.addEventListener('click', function (e) { e.preventDefault(); if (history.length > 1) { history.back(); } else { window.location.href = '/my/shop' } });</script>
</body>

</html>