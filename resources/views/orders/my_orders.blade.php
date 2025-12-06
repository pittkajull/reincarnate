<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya</title>
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
            <h1 class="text-2xl font-bold">Pesanan Saya</h1>
        </div>
        <div class="rounded-3xl border border-gray-300 bg-white/70">
            <div class="grid grid-cols-6 px-6 py-3 text-sm text-gray-600">
                <div>ID</div>
                <div>Produk</div>
                <div>Penjual</div>
                <div>Qty</div>
                <div>Total</div>
                <div>Status</div>
            </div>
            @foreach($orders as $o)
                <div class="border-t px-6 py-4 grid grid-cols-6 text-sm items-center">
                    <div>#{{ $o->id }}</div>
                    <div><a href="/products/{{ $o->product->id }}" class="hover:underline">{{ $o->product->title }}</a>
                    </div>
                    <div><a href="/profile/{{ $o->seller->id }}" class="hover:underline">{{ $o->seller->name }}</a></div>
                    <div>{{ $o->qty }}</div>
                    <div>Rp.{{ number_format($o->total_amount ?? ($o->price * $o->qty), 0, ',', '.') }}</div>
                    <div><span class="px-2 py-1 rounded bg-gray-200">{{ ucfirst($o->status) }}</span></div>
                </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $orders->links() }}</div>
    </div>
    <script>document.getElementById('backBtn')?.addEventListener('click', function (e) { e.preventDefault(); if (history.length > 1) { history.back(); } else { window.location.href = '/' } });</script>
</body>

</html>