<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jual Barang</title>
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
            <a href="#" id="backBtn"
                class="inline-flex items-center gap-2 px-3 py-2 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700"><i
                    class="fa-solid fa-arrow-left"></i><span>Kembali</span></a>
            <h1 class="text-2xl font-bold">Jual Barang</h1>
        </div>
        <form id="sellForm" method="post" action="/products" enctype="multipart/form-data"
            class="max-w-xl space-y-4 rounded-2xl bg-white/70 p-6 shadow">
            @if($errors->any())
                <div class="mb-4 rounded-xl bg-red-100 text-red-700 p-3 text-sm">
                    <ul class="list-disc ml-5">
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input id="title" name="title" type="text" placeholder="Judul"
                class="w-full px-4 py-3 rounded-xl bg-[#e7dccb]" required>
            <textarea id="description" name="description" placeholder="Deskripsi"
                class="w-full px-4 py-3 rounded-xl bg-[#e7dccb]"></textarea>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <select id="categorySelect" class="w-full px-4 py-3 rounded-xl bg-[#e7dccb]">
                    <option value="" selected>Pilih Kategori</option>
                    <option value="Top">Top</option>
                    <option value="Pants">Pants</option>
                    <option value="Outerwear">Outerwear</option>
                    <option value="Shoes">Shoes</option>
                    <option value="Accessories">Accessories</option>
                    <option value="Other">Lainnya</option>
                </select>
                <input id="categoryInput" name="category" type="text" placeholder="Kategori"
                    class="w-full px-4 py-3 rounded-xl bg-[#e7dccb]">
            </div>
            <div>
                <input id="price" name="price" type="number" placeholder="Harga"
                    class="w-full px-4 py-3 rounded-xl bg-[#e7dccb]" required min="0">
                <div id="pricePreview" class="mt-1 text-sm text-gray-600">Rp.0</div>
            </div>
            <input id="stock" name="stock" type="number" placeholder="Stok"
                class="w-full px-4 py-3 rounded-xl bg-[#e7dccb]" required min="1">
            <input id="weight_grams" name="weight_grams" type="number" placeholder="Berat (gram)"
                class="w-full px-4 py-3 rounded-xl bg-[#e7dccb]" min="1" value="500">
            <div class="space-y-2">
                <input id="image" name="image" type="file" accept="image/*" class="w-full">
                <div id="imageBox"
                    class="w-full h-40 rounded-2xl bg-gray-100 flex items-center justify-center overflow-hidden hidden">
                    <img id="imagePreview" src="" alt="Preview" class="max-h-full object-contain">
                </div>
            </div>
            <button id="submitBtn" type="submit"
                class="w-full px-4 py-3 rounded-xl bg-[#5a3b10] text-white">Terbitkan</button>
        </form>
    </div>
    <script>
        document.getElementById('backBtn')?.addEventListener('click', function (e) { e.preventDefault(); if (history.length > 1) { history.back(); } else { window.location.href = '/'; } });
        const categorySelect = document.getElementById('categorySelect');
        const categoryInput = document.getElementById('categoryInput');
        const price = document.getElementById('price');
        const pricePreview = document.getElementById('pricePreview');
        const stock = document.getElementById('stock');
        const image = document.getElementById('image');
        const imageBox = document.getElementById('imageBox');
        const imagePreview = document.getElementById('imagePreview');
        const form = document.getElementById('sellForm');
        const title = document.getElementById('title');
        function rupiah(n) { const x = Number(n) || 0; return 'Rp.' + x.toLocaleString('id-ID'); }
        if (categorySelect) categorySelect.addEventListener('change', () => {
            const v = categorySelect.value;
            if (v && v !== 'Other') { categoryInput.value = v; }
            if (v === 'Other') { categoryInput.value = ''; categoryInput.focus(); }
        });
        if (price && pricePreview) price.addEventListener('input', () => { pricePreview.textContent = rupiah(price.value); });
        if (image && imageBox && imagePreview) image.addEventListener('change', () => {
            const f = image.files && image.files[0];
            if (!f) { imageBox.classList.add('hidden'); imagePreview.src = ''; return; }
            if (f.size > 2 * 1024 * 1024) { alert('Ukuran gambar maksimal 2MB'); image.value = ''; imageBox.classList.add('hidden'); return; }
            const url = URL.createObjectURL(f);
            imagePreview.src = url;
            imageBox.classList.remove('hidden');
        });
        if (form) form.addEventListener('submit', (e) => {
            const errs = [];
            if (!title.value.trim()) errs.push('Judul tidak boleh kosong');
            const p = Number(price.value);
            if (!(p >= 0)) errs.push('Harga tidak valid');
            const s = Number(stock.value);
            if (!(s >= 1)) errs.push('Stok minimal 1');
            if (errs.length) { e.preventDefault(); alert(errs.join('\n')); }
        });
    </script>
</body>

</html>