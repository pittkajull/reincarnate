<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Thrift Shop')</title>

    <!-- Tailwind CSS CDN (Agar tampilan bagus) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome (Untuk Icon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #FDF5E6;
            /* Warna cream background */
        }

        .pixel-font {
            font-family: 'Courier New', Courier, monospace;
            font-weight: 900;
            text-transform: uppercase;
        }
    </style>
</head>

<body class="text-gray-800 antialiased">

    <!-- NAVBAR -->
    <nav class="flex items-center justify-between px-6 py-4 bg-[#FDF5E6] sticky top-0 z-50">
        <!-- Logo (Kiri) -->
        <div class="flex items-center gap-2 cursor-pointer">
            <div
                class="w-10 h-10 bg-yellow-600 rounded-full flex items-center justify-center text-white font-bold text-xl">
                T
            </div>
            <span class="font-bold text-xl tracking-wide">THRIFT.</span>
        </div>

        <!-- Search Bar (Tengah) -->
        <div class="hidden md:flex flex-1 max-w-xl mx-8">
            <div class="relative w-full">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <i class="fas fa-search text-gray-400"></i>
                </span>
                <input type="text"
                    class="w-full py-2.5 pl-10 pr-4 text-gray-700 bg-white border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-yellow-500 shadow-sm"
                    placeholder="Cari baju, celana, jaket...">
            </div>
        </div>

        <!-- Icons (Kanan) -->
        <div class="flex items-center gap-6">
            <a href="#" class="text-gray-600 hover:text-yellow-700 text-xl transition">
                <i class="far fa-heart"></i>
            </a>
            <a href="#" class="relative text-gray-600 hover:text-yellow-700 text-xl transition">
                <i class="fas fa-shopping-cart"></i>
                <span
                    class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full">2</span>
            </a>
            <a href="#"
                class="w-9 h-9 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 hover:bg-yellow-600 hover:text-white transition">
                <i class="fas fa-user"></i>
            </a>
        </div>
    </nav>

    <!-- CONTAINER UTAMA -->
    <main class="container mx-auto px-6 pb-12">
        <!-- Di sinilah konten home.blade.php akan muncul -->
        @yield('content')
    </main>

    <!-- FOOTER SEDERHANA -->
    <footer class="text-center py-6 text-sm text-gray-500 mt-10 border-t border-gray-200">
        &copy; 2025 Thrift Shop. All rights reserved.
    </footer>

</body>

</html>