<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #FDF5E6;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="text-gray-800">
    <div class="container mx-auto px-6 py-8">
        <div class="mb-6 flex items-center justify-between">
            <a href="#" id="backBtn"
                class="inline-flex items-center gap-2 px-3 py-2 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700"><i
                    class="fa-solid fa-arrow-left"></i><span>Kembali</span></a>
            <div class="text-sm text-gray-500">Checkout</div>
        </div>

        @if(session('error'))
            <div class="mb-4 rounded-xl bg-red-100 text-red-700 p-3">{{ session('error') }}</div>
        @endif

        <form method="post" action="/checkout/{{ $product->id }}" class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="md:col-span-2 space-y-6">
                <div class="rounded-3xl border border-gray-300 bg-white/70 p-6">
                    <div class="flex items-center justify-between">
                        <div class="font-semibold">Alamat Pengiriman</div>
                        <a href="#" class="text-sm text-yellow-700">Ubah</a>
                    </div>
                    <textarea name="address" required rows="3" class="mt-3 w-full rounded-xl bg-[#e7dccb] p-3"
                        placeholder="Tulis alamat lengkap, RT/RW, kecamatan, kota, kode pos">{{ old('address', $user->address ?? '') }}</textarea>
                </div>

                <div class="rounded-3xl border border-gray-300 bg-white/70 p-6">
                    <div class="font-semibold mb-4">Produk Dipesan</div>
                    <div class="flex items-center gap-4">
                        @if($product->image_path)
                            <img src="/{{ $product->image_path }}" class="w-20 h-20 object-contain rounded-xl"
                                alt="{{ $product->title }}">
                        @else
                            <div class="w-20 h-20 bg-gray-200 rounded-xl"></div>
                        @endif
                        <div class="flex-1">
                            <div class="font-semibold">{{ $product->title }}</div>
                            <div class="text-sm text-gray-600">Harga Satuan:
                                Rp.{{ number_format($product->price, 0, ',', '.') }}</div>
                            <div class="mt-2 flex items-center gap-2">
                                <label class="text-sm text-gray-600">Jumlah</label>
                                <input type="number" name="qty" min="1" value="{{ $qty }}"
                                    class="px-3 py-2 w-24 rounded-xl bg-[#e7dccb]">
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm text-gray-500">Subtotal Produk</div>
                            <div class="font-bold" id="subtotal">
                                Rp.{{ number_format($product->price * $qty, 0, ',', '.') }}</div>
                            <div class="text-xs text-gray-500 mt-1">Berat:
                                {{ number_format($product->weight_grams ?? 500) }} gram
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="text-sm text-gray-600">Pesan untuk penjual</label>
                        <input type="text" name="note" class="mt-2 w-full rounded-xl bg-[#e7dccb] p-2"
                            placeholder="Opsional, misalnya warna/ukuran">
                    </div>
                </div>

                <div class="rounded-3xl border border-gray-300 bg-white/70 p-6">
                    <div class="font-semibold mb-4">Opsi Pengiriman</div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="text-sm text-gray-600">Kota Tujuan</label>
                            <select name="shipping_city" class="mt-2 w-full rounded-xl bg-[#e7dccb] p-2"
                                id="citySelect">
                                <option value="Jakarta">Jakarta</option>
                                <option value="Bandung">Bandung</option>
                                <option value="Surabaya">Surabaya</option>
                                <option value="Yogyakarta">Yogyakarta</option>
                                <option value="Semarang">Semarang</option>
                                <option value="Denpasar">Denpasar</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-sm text-gray-600">Layanan</label>
                            <select name="shipping" class="mt-2 w-full rounded-xl bg-[#e7dccb] p-2" id="shippingSelect">
                                <option value="regular">Reguler</option>
                                <option value="express">Express</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <div class="text-sm text-gray-500">Estimasi: 2-5 hari kerja</div>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl border border-gray-300 bg-white/70 p-6">
                    <div class="font-semibold mb-4">Metode Pembayaran</div>
                    <select name="payment" class="rounded-xl bg-[#e7dccb] p-2">
                        <option value="cod">COD (Bayar di tempat)</option>
                        <option value="transfer">Transfer</option>
                    </select>
                </div>

                <div class="rounded-3xl border border-gray-300 bg-white/70 p-6">
                    <div class="font-semibold mb-2">Voucher</div>
                    <input type="text" name="voucher" id="voucherInput"
                        placeholder="Masukkan kode voucher (contoh: HEMAT10)"
                        class="w-full rounded-xl bg-[#e7dccb] p-2">
                    <div class="mt-2 text-xs text-gray-500">Kode tersedia: HEMAT10 (10%, max 50k), ONGKIR5 (-5k ongkir),
                        CASHBACK20 (20%, max 30k)</div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-3xl border border-gray-300 bg-white/70 p-6">
                    <div class="flex items-center justify-between">
                        <div class="font-semibold">Ringkasan Pembayaran</div>
                        <a href="#" class="text-sm text-yellow-700">Pilih Voucher</a>
                    </div>
                    <div class="mt-4 space-y-2 text-sm">
                        <div class="flex items-center justify-between"><span>Subtotal Produk</span><span
                                id="sumSubtotal">Rp.{{ number_format($product->price * $qty, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between"><span>Ongkir</span><span
                                id="sumShipping">Rp.0</span></div>
                        <div class="flex items-center justify-between"><span>Diskon</span><span
                                id="sumDiscount">Rp.0</span></div>
                        <div class="flex items-center justify-between font-bold text-[#5a3b10]"><span>Total
                                Pesanan</span><span
                                id="sumTotal">Rp.{{ number_format($product->price * $qty, 0, ',', '.') }}</span></div>
                    </div>
                    <button class="mt-6 w-full px-4 py-3 rounded-xl bg-yellow-600 hover:bg-yellow-700 text-white">Buat
                        Pesanan</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('backBtn')?.addEventListener('click', function (e) {
            e.preventDefault();
            if (history.length > 1) { history.back(); } else { window.location.href = '/products/{{ $product->id }}'; }
        });
        const qtyInput = document.querySelector('input[name="qty"]');
        const subtotal = document.getElementById('subtotal');
        const sumSubtotal = document.getElementById('sumSubtotal');
        const sumShipping = document.getElementById('sumShipping');
        const sumTotal = document.getElementById('sumTotal');
        const sumDiscount = document.getElementById('sumDiscount');
        const shippingSelect = document.getElementById('shippingSelect');
        const voucherInput = document.getElementById('voucherInput');
        const price = {{ $product->price }};
        const weightGrams = {{ $product->weight_grams ?? 500 }};
        const citySelect = document.getElementById('citySelect');
        const cityFees = { 'Jakarta': 10000, 'Bandung': 12000, 'Surabaya': 15000, 'Yogyakarta': 13000, 'Semarang': 14000, 'Denpasar': 20000 };
        function formatRupiah(n) { return 'Rp.' + (n || 0).toLocaleString('id-ID'); }
        function recalc() {
            const q = Math.max(1, parseInt(qtyInput.value || '1', 10));
            const sub = price * q;
            const baseCity = cityFees[citySelect?.value] ?? 15000;
            const addMethod = shippingSelect?.value === 'express' ? 15000 : 0;
            const weightKg = Math.max(1, Math.ceil((weightGrams || 500) / 1000));
            const extraPerKg = 4000;
            const ship = baseCity + addMethod + Math.max(0, weightKg - 1) * extraPerKg;
            subtotal.textContent = formatRupiah(sub);
            sumSubtotal.textContent = formatRupiah(sub);
            sumShipping.textContent = formatRupiah(ship);
            let discount = 0;
            const code = (voucherInput?.value || '').trim().toUpperCase();
            if (code) {
                if (code === 'HEMAT10') {
                    discount = Math.min(Math.round(sub * 0.10), 50000);
                } else if (code === 'ONGKIR5') {
                    discount = Math.min(5000, ship);
                } else if (code === 'CASHBACK20') {
                    discount = Math.min(Math.round(sub * 0.20), 30000);
                }
            }
            sumDiscount.textContent = formatRupiah(discount);
            sumTotal.textContent = formatRupiah(Math.max(0, sub + ship - discount));
        }
        qtyInput?.addEventListener('input', recalc);
        shippingSelect?.addEventListener('change', recalc);
        citySelect?.addEventListener('change', recalc);
        voucherInput?.addEventListener('input', recalc);
        recalc();
    </script>
</body>

</html>
