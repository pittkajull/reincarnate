<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
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
            <h1 class="text-2xl font-bold">Edit Produk</h1>
        </div>
        <form method="post" action="/products/{{ $product->id }}" enctype="multipart/form-data"
            class="max-w-xl space-y-4 rounded-2xl bg-white/70 p-6 shadow">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input name="title" type="text" value="{{ $product->title }}" placeholder="Judul"
                class="w-full px-4 py-3 rounded-xl bg-[#e7dccb]" required>
            <textarea name="description" placeholder="Deskripsi"
                class="w-full px-4 py-3 rounded-xl bg-[#e7dccb]">{{ $product->description }}</textarea>
            <input name="category" type="text" value="{{ $product->category }}" placeholder="Kategori"
                class="w-full px-4 py-3 rounded-xl bg-[#e7dccb]">
            <input name="price" type="number" value="{{ $product->price }}" placeholder="Harga"
                class="w-full px-4 py-3 rounded-xl bg-[#e7dccb]" required>
            <input name="stock" type="number" value="{{ $product->stock }}" placeholder="Stok"
                class="w-full px-4 py-3 rounded-xl bg-[#e7dccb]" required>
            <input name="weight_grams" type="number" value="{{ $product->weight_grams ?? 500 }}"
                placeholder="Berat (gram)" class="w-full px-4 py-3 rounded-xl bg-[#e7dccb]" min="1">
            <div>
                @if($product->image_path)
                    <img src="/{{ $product->image_path }}" class="w-24 h-24 object-contain rounded-xl mb-2"
                        alt="{{ $product->title }}">
                @endif
                <input name="image" type="file" accept="image/*" class="w-full">
            </div>
            <div class="flex items-center gap-3">
                <button type="submit" class="px-4 py-2 rounded-xl bg-[#5a3b10] text-white">Simpan</button>
                <a href="/my/shop" class="px-4 py-2 rounded-xl bg-gray-100">Batal</a>
            </div>
        </form>
    </div>
    <script>document.getElementById('backBtn')?.addEventListener('click', function (e) { e.preventDefault(); if (history.length > 1) { history.back(); } else { window.location.href = '/my/shop' } });</script>
</body>

</html>