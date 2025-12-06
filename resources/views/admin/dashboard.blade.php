<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
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
    <div class="flex min-h-screen">
        <!-- Sidebar: ikon berfungsi sebagai switch section (Home, Orders, Finance, Users, Settings) -->
        <aside class="w-20 bg-[#5a3b10] text-white flex flex-col items-center py-6 gap-6">
            <button data-section="home" class="w-12 h-12 rounded-xl flex items-center justify-center bg-white/10"><i
                    class="fa-solid fa-house"></i></button>
            <button data-section="orders" class="w-12 h-12 rounded-xl flex items-center justify-center bg-white/10"><i
                    class="fa-solid fa-cart-shopping"></i></button>
            <button data-section="finance" class="w-12 h-12 rounded-xl flex items-center justify-center bg-white/10"><i
                    class="fa-solid fa-dollar-sign"></i></button>
            <button data-section="users" class="w-12 h-12 rounded-xl flex items-center justify-center bg-white/10"><i
                    class="fa-solid fa-user"></i></button>
            <button data-section="settings" class="w-12 h-12 rounded-xl flex items-center justify-center bg-white/10"><i
                    class="fa-solid fa-gear"></i></button>
        </aside>
        <main class="flex-1">
            <!-- Header: informasi user yang sedang login -->
            <header class="flex items-center justify-between px-6 py-4 bg-[#FDF5E6] border-b border-gray-200">
                <a href="#" id="backBtn"
                    class="inline-flex items-center gap-2 px-3 py-2 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700"><i
                        class="fa-solid fa-arrow-left"></i><span>Kembali</span></a>
                <div class="text-right">
                    <div class="font-semibold">{{ $user->name ?? 'Admin' }}</div>
                    <div class="text-xs text-gray-500">Admin</div>
                </div>
                <div class="ml-3 w-9 h-9 rounded-full bg-gray-200 flex items-center justify-center"><i
                        class="fa-solid fa-user"></i></div>
            </header>
            <!-- Section: Home overview dashboard -->
            <div id="section-home" class="p-6 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="rounded-3xl bg-gray-800 text-white p-6">
                        <div class="flex items-center justify-between">
                            <div class="text-lg font-bold">Total Penjualan</div>
                            <i class="fa-solid fa-cart-shopping text-2xl"></i>
                        </div>
                        <div class="mt-3">
                            <div class="text-3xl font-black">{{ $metrics['soldQty'] ?? 0 }}</div>
                            <div class="text-sm">&nbsp;</div>
                        </div>
                    </div>
                    <div class="rounded-3xl border border-gray-300 bg-white/70 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm text-gray-600 font-semibold">Total Pemasukan</div>
                                <div class="text-2xl md:text-3xl font-black text-[#5a3b10]">
                                    Rp.{{ number_format($metrics['revenue'] ?? 0, 0, ',', '.') }}</div>
                                <div class="text-sm text-gray-500">&nbsp;</div>
                            </div>
                            <div class="w-12 h-12 rounded-full bg-black/90 text-white flex items-center justify-center">
                                <i class="fa-solid fa-dollar-sign"></i>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-3xl border border-gray-300 bg-white/70 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm text-gray-600 font-semibold">User Aktif</div>
                                <div class="text-2xl md:text-3xl font-black text-[#5a3b10]">
                                    {{ $metrics['activeUsers'] ?? 0 }}
                                </div>
                                <div class="text-sm text-gray-500">&nbsp;</div>
                            </div>
                            <div
                                class="w-12 h-12 rounded-full bg-[#5a3b10] text-white flex items-center justify-center">
                                <i class="fa-solid fa-user"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2 rounded-3xl border border-gray-300 bg-white/70 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="text-lg font-bold">Performa Penjualan</div>
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                        <svg viewBox="0 0 500 180" class="w-full h-40">
                            <rect x="0" y="0" width="500" height="180" fill="transparent" />
                            <polyline points="10,150 460,150" fill="none" stroke="#d1d5db" stroke-width="3" />
                            <polyline points="{{ $metrics['chart']['points'] ?? '' }}" fill="none" stroke="#111827"
                                stroke-width="3" />
                        </svg>
                        <div class="mt-2 text-xs text-gray-500">Apr · Jun · Sep · Okt · Nov · Des</div>
                    </div>
                    <div class="rounded-3xl border border-gray-300 bg-white/70 p-6">
                        <div class="text-lg font-bold mb-4">Kategori Populer</div>
                        <div class="flex items-center justify-center">
                            <svg viewBox="0 0 120 120" class="w-40 h-40">
                                <circle cx="60" cy="60" r="50" fill="#e5e7eb" />
                                <path d="M60 10 A50 50 0 1 1 40 18 L60 60 Z" fill="#3b82f6" />
                                <path d="M60 10 A50 50 0 0 1 100 60 L60 60 Z" fill="#60a5fa" />
                            </svg>
                        </div>
                        <div class="mt-3 text-sm text-gray-600">
                            {{ collect($metrics['popular'] ?? [])->map(fn($p) => $p['category'])->implode(' · ') }}
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl border border-gray-300 bg-white/70">
                    <div class="px-6 py-4 font-bold">Customer Terbaru</div>
                    <div class="border-t">
                        <div class="grid grid-cols-4 px-6 py-3 text-sm text-gray-600">
                            <div>Nama</div>
                            <div>Tanggal Order</div>
                            <div>Nomor HP</div>
                            <div>Register</div>
                        </div>
                        @foreach(($metrics['latestCustomers'] ?? []) as $sale)
                            <div class="border-t px-6 py-4 grid grid-cols-4 text-sm">
                                <div>{{ optional($sale->user)->name ?? 'Guest' }}</div>
                                <div>{{ $sale->created_at->format('d M, Y · H:i') }}</div>
                                <div>-</div>
                                <div>Yes</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <form method="post" action="/auth/logout" class="">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button class="px-4 py-2 rounded-xl bg-red-600 text-white hover:bg-red-700">Logout</button>
                </form>
            </div>
            <!-- Section: Orders (daftar pesanan) -->
            <div id="section-orders" class="hidden p-6 space-y-8">
                <div class="text-2xl font-bold mb-4">Daftar Order</div>
                <div class="rounded-3xl border border-gray-300 bg-white/70">
                    <div class="grid grid-cols-5 px-6 py-3 text-sm text-gray-600">
                        <div>ID</div>
                        <div>Customer</div>
                        <div>Tanggal</div>
                        <div>Status</div>
                        <div>Total</div>
                    </div>
                    <div class="border-t px-6 py-4 grid grid-cols-5 text-sm">
                        <div>#INV-001</div>
                        <div>Pak Dedyy</div>
                        <div>20 May 2025</div>
                        <div><span class="px-2 py-1 rounded bg-yellow-100 text-yellow-700">Pending</span></div>
                        <div>Rp.200.000</div>
                    </div>
                    <div class="border-t px-6 py-4 grid grid-cols-5 text-sm">
                        <div>#INV-002</div>
                        <div>Bu Sinta</div>
                        <div>21 May 2025</div>
                        <div><span class="px-2 py-1 rounded bg-green-100 text-green-700">Paid</span></div>
                        <div>Rp.150.000</div>
                    </div>
                </div>
            </div>
            <!-- Section: Finance (ringkasan keuangan & grafik) -->
            <div id="section-finance" class="hidden p-6 space-y-8">
                <div class="text-2xl font-bold mb-4">Keuangan</div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="rounded-3xl border border-gray-300 bg-white/70 p-6">
                        <div class="text-sm text-gray-600">Pendapatan Bulan Ini</div>
                        <div class="text-3xl font-black text-[#5a3b10]">Rp.5.400.000</div>
                    </div>
                    <div class="rounded-3xl border border-gray-300 bg-white/70 p-6">
                        <div class="text-sm text-gray-600">Pengeluaran Bulan Ini</div>
                        <div class="text-3xl font-black text-[#5a3b10]">Rp.1.200.000</div>
                    </div>
                    <div class="rounded-3xl border border-gray-300 bg-white/70 p-6">
                        <div class="text-sm text-gray-600">Profit Bulan Ini</div>
                        <div class="text-3xl font-black text-[#5a3b10]">Rp.4.200.000</div>
                    </div>
                </div>
                <div class="rounded-3xl border border-gray-300 bg-white/70 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="font-bold">Grafik Pendapatan</div><i class="fa-solid fa-chart-line"></i>
                    </div>
                    <svg viewBox="0 0 500 180" class="w-full h-40">
                        <rect x="0" y="0" width="500" height="180" fill="transparent" />
                        <polyline points="10,150 60,130 110,120 160,110 210,90 260,80 310,70 360,60 410,55 460,50"
                            fill="none" stroke="#3b82f6" stroke-width="3" />
                    </svg>
                </div>
            </div>
            <!-- Section: Users (manajemen pengguna) -->
            <div id="section-users" class="hidden p-6 space-y-8">
                <div class="text-2xl font-bold mb-4">Pengguna</div>
                <div class="rounded-3xl border border-gray-300 bg-white/70 p-6">
                    <div class="mb-4 flex gap-3">
                        <input type="text" class="px-4 py-2 rounded-xl bg-[#e7dccb] w-64" placeholder="Cari user">
                        <button class="px-4 py-2 rounded-xl bg-yellow-600 text-white">Tambah User</button>
                    </div>
                    <div class="grid grid-cols-5 px-2 md:px-6 py-3 text-sm text-gray-600">
                        <div>Nama</div>
                        <div>Email</div>
                        <div>Role</div>
                        <div>Status</div>
                        <div>Aksi</div>
                    </div>
                    <div class="border-t px-2 md:px-6 py-4 grid grid-cols-5 text-sm items-center">
                        <div>Admin Reincarnate</div>
                        <div>admin@example.com</div>
                        <div><span class="px-2 py-1 rounded bg-[#5a3b10] text-white">Admin</span></div>
                        <div>Aktif</div>
                        <div class="flex gap-2"><button class="px-3 py-1 rounded bg-gray-100">Edit</button><button
                                class="px-3 py-1 rounded bg-red-100 text-red-600">Hapus</button></div>
                    </div>
                    <div class="border-t px-2 md:px-6 py-4 grid grid-cols-5 text-sm items-center">
                        <div>Test User</div>
                        <div>test@example.com</div>
                        <div><span class="px-2 py-1 rounded bg-gray-200">User</span></div>
                        <div>Aktif</div>
                        <div class="flex gap-2"><button class="px-3 py-1 rounded bg-gray-100">Edit</button><button
                                class="px-3 py-1 rounded bg-red-100 text-red-600">Hapus</button></div>
                    </div>
                </div>
            </div>
            <!-- Section: Settings (pengaturan toko & keamanan) -->
            <div id="section-settings" class="hidden p-6 space-y-8">
                <div class="text-2xl font-bold mb-4">Pengaturan</div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <form class="rounded-3xl border border-gray-300 bg-white/70 p-6 space-y-4">
                        <div class="font-semibold">Toko</div>
                        <input type="text" class="w-full px-4 py-2 rounded-xl bg-[#e7dccb]" placeholder="Nama Toko">
                        <input type="text" class="w-full px-4 py-2 rounded-xl bg-[#e7dccb]"
                            placeholder="Currency (IDR)">
                        <input type="text" class="w-full px-4 py-2 rounded-xl bg-[#e7dccb]" placeholder="WhatsApp Link">
                        <input type="text" class="w-full px-4 py-2 rounded-xl bg-[#e7dccb]"
                            placeholder="Instagram Link">
                        <input type="email" class="w-full px-4 py-2 rounded-xl bg-[#e7dccb]" placeholder="Email">
                        <button type="button" class="px-4 py-2 rounded-xl bg-yellow-600 text-white">Simpan</button>
                    </form>
                    <form class="rounded-3xl border border-gray-300 bg-white/70 p-6 space-y-4">
                        <div class="font-semibold">Keamanan</div>
                        <input type="password" class="w-full px-4 py-2 rounded-xl bg-[#e7dccb]"
                            placeholder="Password Lama">
                        <input type="password" class="w-full px-4 py-2 rounded-xl bg-[#e7dccb]"
                            placeholder="Password Baru">
                        <input type="password" class="w-full px-4 py-2 rounded-xl bg-[#e7dccb]"
                            placeholder="Ulangi Password Baru">
                        <button type="button" class="px-4 py-2 rounded-xl bg-yellow-600 text-white">Ubah
                            Password</button>
                    </form>
                </div>
            </div>
        </main>
        <script>document.getElementById('backBtn')?.addEventListener('click', function (e) { e.preventDefault(); if (history.length > 1) { history.back(); } else { window.location.href = '/' } });</script>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // List section yang tersedia & tombol sidebar untuk toggle
            const sections = ['home', 'orders', 'finance', 'users', 'settings'];
            const buttons = Array.from(document.querySelectorAll('aside [data-section]'));
            // Tampilkan satu section dan sembunyikan yang lain, serta highlight tombol aktif
            function showSection(name) {
                sections.forEach(s => {
                    const el = document.getElementById('section-' + s);
                    if (!el) return;
                    if (s === name) el.classList.remove('hidden'); else el.classList.add('hidden');
                });
                buttons.forEach(b => {
                    if (b.getAttribute('data-section') === name) { b.classList.add('ring-2', 'ring-white'); }
                    else { b.classList.remove('ring-2', 'ring-white'); }
                });
                // Simpan state aktif di URL hash untuk back/forward
                location.hash = name;
            }
            // Baca hash awal agar refresh/URL langsung membuka section yang benar
            const initial = location.hash ? location.hash.replace('#', '') : 'home';
            showSection(sections.includes(initial) ? initial : 'home');
            buttons.forEach(b => b.addEventListener('click', () => showSection(b.getAttribute('data-section'))));
        });
    </script>
</body>

</html>