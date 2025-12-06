<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil {{ $user->name }}</title>
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
            <h1 class="text-2xl font-bold">Profil</h1>
        </div>
        <div class="rounded-2xl bg-white/70 p-6 shadow">
            <div class="flex items-center gap-3">
                <div class="w-14 h-14 rounded-full bg-gray-200 flex items-center justify-center"><i
                        class="fa-solid fa-user"></i></div>
                <div>
                    <div class="text-xl font-bold">{{ $user->name }}</div>
                    <div class="text-sm text-gray-600">{{ $user->email }}</div>
                </div>
            </div>
            @auth
                @if(auth()->id() === $user->id)
                    <div class="mt-4 flex items-center gap-3">
                        <form method="post" action="/auth/logout">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button class="px-4 py-2 rounded-xl bg-red-600 text-white">Logout</button>
                        </form>
                    </div>
                @endif
            @endauth
            @auth
                @if(auth()->id() === $user->id && !($user->is_seller ?? false))
                    <form method="post" action="/profile/become-seller" class="mt-4">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button class="px-4 py-2 rounded-xl bg-[#5a3b10] text-white">Jadi Penjual</button>
                    </form>
                @endif
            @endauth
        </div>
        @auth
            @if(auth()->id() === $user->id)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                    <div class="rounded-2xl bg-white/70 p-6 shadow">
                        <div class="text-lg font-bold mb-4">Ubah Nama</div>
                        <form method="post" action="/profile/update-name" class="space-y-3">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="text" name="name" value="{{ $user->name }}"
                                class="w-full px-4 py-3 rounded-xl bg-[#e7dccb] placeholder-[#8a7a5e] focus:outline-none">
                            <button class="px-4 py-2 rounded-xl bg-[#5a3b10] text-white">Simpan</button>
                        </form>
                    </div>
                    <div class="rounded-2xl bg-white/70 p-6 shadow">
                        <div class="text-lg font-bold mb-4">Ubah Password</div>
                        <form method="post" action="/profile/update-password" class="space-y-3">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="password" name="current_password" placeholder="Password Saat Ini"
                                class="w-full px-4 py-3 rounded-xl bg-[#e7dccb] placeholder-[#8a7a5e] focus:outline-none">
                            <input type="password" name="new_password" placeholder="Password Baru"
                                class="w-full px-4 py-3 rounded-xl bg-[#e7dccb] placeholder-[#8a7a5e] focus:outline-none">
                            <input type="password" name="new_password_confirmation" placeholder="Konfirmasi Password Baru"
                                class="w-full px-4 py-3 rounded-xl bg-[#e7dccb] placeholder-[#8a7a5e] focus:outline-none">
                            <button class="px-4 py-2 rounded-xl bg-[#5a3b10] text-white">Simpan</button>
                        </form>
                        @if($errors->any())
                            <div class="mt-3 text-sm text-red-600">{{ $errors->first() }}</div>
                        @endif
                    </div>
                    <div class="rounded-2xl bg-white/70 p-6 shadow md:col-span-2">
                        <div class="text-lg font-bold mb-4">Ubah Alamat & Nomor HP</div>
                        <form method="post" action="/profile/update-address" class="space-y-3">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <textarea name="address" rows="3"
                                class="w-full px-4 py-3 rounded-xl bg-[#e7dccb] placeholder-[#8a7a5e] focus:outline-none"
                                placeholder="Alamat lengkap: jalan, RT/RW, kelurahan, kecamatan, kota, kode pos">{{ old('address', $user->address ?? '') }}</textarea>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}"
                                class="w-full px-4 py-3 rounded-xl bg-[#e7dccb] placeholder-[#8a7a5e] focus:outline-none"
                                placeholder="Nomor HP (opsional)">
                            <button class="px-4 py-2 rounded-xl bg-[#5a3b10] text-white">Simpan</button>
                        </form>
                    </div>
                </div>
            @endif
        @endauth
        <h2 class="text-2xl font-bold mt-8 mb-6">Produk dari {{ $user->name }}</h2>
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
                </a>
            @endforeach
        </div>
        <div class="mt-6">{{ $products->links() }}</div>
    </div>
    <script>document.getElementById('backBtn')?.addEventListener('click', function (e) { e.preventDefault(); if (history.length > 1) { history.back(); } else { window.location.href = '/' } });</script>
</body>

</html>