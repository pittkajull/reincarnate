<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Thrift Shop')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #FDF5E6;
        }

        .pixel-font {
            font-family: 'Courier New', Courier, monospace;
            font-weight: 900;
            text-transform: uppercase;
        }
    </style>
</head>

<body class="text-gray-800 antialiased">
    <nav id="mainNavbar"
        class="flex items-center justify-between px-6 py-4 bg-[#FDF5E6] sticky top-0 z-50 transition-colors duration-300">
        <div class="flex items-center gap-2 cursor-pointer">
            <img src="images/logo1.png" alt="" class="w-10 h-15">
        </div>
        <div class="hidden md:flex flex-1 max-w-xl mx-8">
            <div class="relative w-full">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3"><i
                        class="fas fa-search text-gray-400"></i></span>
                <input type="text"
                    class="w-full py-2.5 pl-10 pr-4 text-gray-700 bg-white border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-yellow-500 shadow-sm"
                    placeholder="Cari baju, celana, jaket...">
            </div>
        </div>
        <div class="flex items-center gap-6">
            @auth
                <a href="/products" class="text-gray-700 hover:text-yellow-700 font-semibold">Produk</a>
            @else
                <a href="#" id="productsLink" class="text-gray-700 hover:text-yellow-700 font-semibold">Produk</a>
            @endauth
            @auth
                @if(Auth::user()->is_seller)
                    <a href="/products/create" class="px-3 py-1 rounded-full bg-[#5a3b10] text-white">Jual Barang</a>
                    <a href="/profile/{{ auth()->id() }}" class="text-gray-700 hover:text-yellow-700 font-semibold">Toko
                        Saya</a>
                    <a href="/my/sales" class="text-gray-700 hover:text-yellow-700 font-semibold">Penjualan Saya</a>
                @endif
                <a href="/my/orders" class="text-gray-700 hover:text-yellow-700 font-semibold">Pesanan Saya</a>
            @endauth
            <a href="#" id="favBtn" class="relative text-gray-600 hover:text-yellow-700 text-xl transition">
                <i class="far fa-heart"></i>
                <span id="favBadge"
                    class="absolute -top-2 -right-2 bg-pink-500 text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full hidden">0</span>
            </a>
            <a href="#" id="cartBtn" class="relative text-gray-600 hover:text-yellow-700 text-xl transition">
                <i class="fas fa-shopping-cart"></i>
                <span id="cartBadge"
                    class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full hidden">0</span>
            </a>
            <a href="#" id="profileBtn"
                class="w-9 h-9 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 hover:bg-yellow-600 hover:text-white transition">
                <i class="fas fa-user"></i>
            </a>
        </div>
    </nav>

    <div id="cartDrawer" class="fixed inset-0 z-[60] pointer-events-none">
        <div class="backdrop absolute inset-0 bg-black/30 opacity-0 transition-opacity duration-300"></div>
        <div
            class="panel absolute right-0 top-0 h-full w-[90%] max-w-[420px] bg-[#FDF5E6] shadow-2xl translate-x-full transition-transform duration-300">
            <div class="flex items-center justify-between p-4 border-b border-gray-200">
                <div class="text-xl font-bold">Keranjang</div>
                <button id="closeCart"
                    class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center"><i
                        class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="p-4 space-y-5 overflow-y-auto h-[calc(100%-120px)]">
                <div id="cartItems" class="space-y-4"></div>
            </div>
            <div class="p-4 border-t border-gray-200">
                <button
                    class="w-full bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-3 rounded-xl shadow">Beli
                    Sekarang</button>
            </div>
        </div>
    </div>


    <div id="favDrawer" class="fixed inset-0 z-[60] pointer-events-none">
        <div class="backdrop absolute inset-0 bg-black/30 opacity-0 transition-opacity duration-300"></div>
        <div
            class="panel absolute right-0 top-0 h-full w-[90%] max-w-[420px] bg-[#FDF5E6] shadow-2xl translate-x-full transition-transform duration-300">
            <div class="flex items-center justify-between p-4 border-b border-gray-200">
                <div class="text-xl font-bold">Favorit</div>
                <button id="closeFav"
                    class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center"><i
                        class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="p-4 space-y-5 overflow-y-auto h-[calc(100%-80px)]">
                <div id="favItems" class="space-y-4"></div>
            </div>
        </div>
    </div>

    <main class="container mx-auto px-6 pb-12">
        @yield('content')
    </main>

    <div id="heroBanner"
        class="relative w-full max-w-[850px] h-[180px] md:h-[300px] rounded-[50px] overflow-hidden mt-6 mx-auto shadow-xl group">
        <div class="absolute inset-0">
            <div class="slides flex h-full transition-transform duration-700 ease-in-out">
                <img src="https://images.unsplash.com/photo-1523381210434-271e8be1f52b?q=80&w=2070&auto=format&fit=crop"
                    class="w-full h-full object-cover brightness-50 flex-shrink-0 min-w-full" alt="Banner 1">
                <img src="https://images.unsplash.com/photo-1512436991641-6745cdb1723f?q=80&w=2070&auto=format&fit=crop"
                    class="w-full h-full object-cover brightness-50 flex-shrink-0 min-w-full" alt="Banner 2">
                <img src="https://images.unsplash.com/photo-1514996937319-344454492b37?q=80&w=2070&auto=format&fit=crop"
                    class="w-full h-full object-cover brightness-50 flex-shrink-0 min-w-full" alt="Banner 3">
            </div>
        </div>
        <div class="absolute inset-0 z-10 flex flex-col justify-center items-start px-5 md:px-10 text-white">
            <h1 class="text-4xl md:text-6xl font-black leading-tight mb-4 drop-shadow-md">JUAL BELI PRELOVED<br>DAN
                THRIFT</h1>
            <p class="text-lg md:text-xl font-medium text-gray-200 mb-8 max-w-lg">Harga murah, Barang mewah.</p>
            <a href="#" id="ctaShop"
                class="bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-3 px-8 rounded-full transition-all transform hover:-translate-y-1 shadow-lg border-2 border-transparent">Belanja
                Sekarang</a>
        </div>
        <div class="absolute bottom-3 left-1/2 -translate-x-1/2 z-10 flex gap-2">
            <button class="dot w-2.5 h-2.5 rounded-full bg-white/40"></button>
            <button class="dot w-2.5 h-2.5 rounded-full bg-white/40"></button>
            <button class="dot w-2.5 h-2.5 rounded-full bg-white/40"></button>
        </div>
    </div>

    <div id="cartToast" class="fixed bottom-0 left-0 right-0 z-[70] translate-y-full transition-transform duration-300">
        <div class="mx-auto w-[95%] max-w-[850px]">
            <div
                class="bg-orange-500 text-white font-bold rounded-t-xl shadow-lg flex items-center justify-between px-4 py-3">
                <span id="toastCount">0 Pesanan</span>
                <div class="flex items-center gap-3">
                    <span id="toastTotal">Rp.0</span>
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
            </div>
        </div>
    </div>
    <div id="infoToast" class="fixed top-3 left-1/2 -translate-x-1/2 z-[80] hidden">
        <div class="bg-gray-900 text-white px-4 py-2 rounded-full shadow">
            <span id="infoMsg"></span>
        </div>
    </div>

    <!-- Drawer Autentikasi: Sign in / Register -->
    <div id="authDrawer" class="fixed inset-0 z-[70] pointer-events-none">
        <div class="backdrop absolute inset-0 bg-black/30 opacity-0 transition-opacity duration-300"></div>
        <div
            class="panel absolute left-1/2 -translate-x-1/2 top-8 w-[95%] max-w-[1000px] bg-[#FDF5E6] shadow-2xl rounded-3xl scale-95 opacity-0 transition-all duration-300">
            <!-- Header drawer: tab Sign in/Register dan tombol close -->
            <div class="flex items-center justify-end p-4">
                <div class="flex items-center gap-3">
                    <button id="authTabSignIn"
                        class="px-4 py-2 rounded-full border border-[#5a3b10] text-[#5a3b10]">Sign in</button>
                    <button id="authTabRegister"
                        class="px-4 py-2 rounded-full bg-[#5a3b10] text-white">Register</button>
                    <button id="closeAuth"
                        class="ml-2 w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center"><i
                            class="fa-solid fa-xmark"></i></button>
                </div>
            </div>
            <!-- Isi drawer: gambar kiri, form kanan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
                <div class="flex items-center justify-center">
                    <img src="images/ireng.png" class="w-500 h-[360px] md:h-[360px] object-cover rounded-2xl"
                        alt="Model">
                </div>
                <div>
                    <div id="authTitle" class="text-3xl md:text-4xl font-extrabold text-[#5a3b10] mb-6">Hello!</div>
                    <form id="authForm" class="space-y-4">
                        <input id="authName" type="text" placeholder="Enter Name"
                            class="w-full px-4 py-3 rounded-xl bg-[#e7dccb] placeholder-[#8a7a5e] focus:outline-none">
                        <input id="authEmail" type="email" placeholder="Enter Email"
                            class="w-full px-4 py-3 rounded-xl bg-[#e7dccb] placeholder-[#8a7a5e] focus:outline-none">
                        <div class="relative">
                            <input id="authPassword" type="password" placeholder="**********"
                                class="w-full px-4 py-3 rounded-xl bg-[#e7dccb] placeholder-[#8a7a5e] focus:outline-none pr-12">
                            <button id="togglePassword" type="button"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-[#5a3b10]">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                        <input id="authInvite" type="text" placeholder="Invite Code"
                            class="hidden w-full px-4 py-3 rounded-xl bg-[#e7dccb] placeholder-[#8a7a5e] focus:outline-none">
                        <button id="authSubmit" type="button"
                            class="w-full bg-[#5a3b10] hover:bg-[#4c320d] text-white font-bold py-3 rounded-xl">Sign
                            Up</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-12 container mx-auto px-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
            @foreach(($products ?? []) as $p)
                <a href="/products/{{ $p->id }}"
                    class="group block text-center bg-white/70 backdrop-blur-sm rounded-2xl shadow ring-1 ring-gray-200/40 hover:shadow-lg hover:ring-yellow-500/40 transition transform hover:-translate-y-0.5 p-4 relative"
                    data-name="{{ $p->title }}" data-price="{{ $p->price }}" data-image="{{ $p->image_path }}">
                    <div class="absolute top-3 right-3 flex items-center gap-2">
                        <button class="fav-btn text-gray-400 hover:text-pink-500 transition" data-name="{{ $p->title }}"
                            data-price="{{ $p->price }}" data-image="{{ $p->image_path }}" aria-label="Toggle Favorite"><i
                                class="fa-regular fa-heart"></i></button>
                        <button class="cart-btn text-gray-500 hover:text-yellow-700 transition" data-name="{{ $p->title }}"
                            data-price="{{ $p->price }}" data-image="{{ $p->image_path }}" aria-label="Add to Cart"><i
                                class="fas fa-shopping-cart"></i></button>
                    </div>
                    <div class="h-28 flex items-center justify-center">
                        @if($p->image_path)
                            <img src="/{{ $p->image_path }}"
                                class="max-h-28 object-contain transition-transform duration-300 group-hover:scale-105"
                                alt="{{ $p->title }}">
                        @else
                            <div class="w-24 h-24 bg-gray-200 rounded-xl"></div>
                        @endif
                    </div>
                    <div class="mt-2 text-lg font-semibold">Rp.{{ number_format($p->price, 0, ',', '.') }}</div>
                    <div class="text-sm text-gray-600">{{ $p->title }}</div>
                </a>
            @endforeach
            @if(empty($products) || count($products) === 0)
                <div class="col-span-full text-center text-gray-600">Belum ada produk. Jadilah yang pertama menerbitkan!
                </div>
            @endif
        </div>

        <h2 class="text-2xl font-bold mt-12 mb-6">Papan Iklan</h2>
        @php($adChunks = ($boardProducts ?? collect())->chunk(3))
        <div id="adBoard"
            class="relative w-full max-w-[1000px] h-[220px] md:h-[280px] rounded-[30px] overflow-hidden mt-2 mx-auto shadow-xl group bg-transparent">
            <div class="absolute inset-0">
                <div class="ad-slides flex h-full transition-transform duration-700 ease-in-out">
                    @foreach($adChunks as $chunk)
                        <div class="ad-slide min-w-full h-full px-2">
                            <div class="grid grid-cols-3 gap-4 h-full">
                                @foreach($chunk as $bp)
                                    <div class="block h-full rounded-2xl bg-white/70 shadow ring-1 ring-gray-200/40 p-3">
                                        <div class="h-[120px] md:h-[160px] flex items-center justify-center">
                                            @if($bp->image_path)
                                                <img src="/{{ $bp->image_path }}" class="max-h-full object-contain rounded-xl"
                                                    alt="{{ $bp->title }}">
                                            @else
                                                <div class="w-20 h-20 bg-gray-200 rounded-xl"></div>
                                            @endif
                                        </div>
                                        <div class="mt-2 text-sm md:text-base font-semibold">
                                            Rp.{{ number_format($bp->price, 0, ',', '.') }}</div>
                                        <div class="text-xs md:text-sm text-gray-600 truncate">{{ $bp->title }}</div>
                                    </div>
                                @endforeach
                                @for($i = $chunk->count(); $i < 3; $i++)
                                    <div class="rounded-2xl bg-white/60 ring-1 ring-gray-200/40 p-3"></div>
                                @endfor
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="absolute bottom-3 left-1/2 -translate-x-1/2 z-10 flex gap-2">
                @for($i = 0; $i < max($adChunks->count(), 1); $i++)
                    <button class="ad-dot w-2.5 h-2.5 rounded-full bg-white/40"></button>
                @endfor
            </div>
        </div>


    </div>

    <div class="mt-12 container mx-auto px-6">
        <h2 class="text-2xl font-bold mb-6">Contact Service</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            <a href="#" id="waLink" target="_blank"
                class="flex items-center gap-3 p-4 rounded-2xl bg-white/70 backdrop-blur-sm shadow ring-1 ring-gray-200/40 hover:shadow-lg hover:ring-yellow-500/40 transition">
                <i class="fa-brands fa-whatsapp text-2xl text-green-500"></i>
                <div>
                    <div class="font-semibold">WhatsApp</div>
                    <div class="text-sm text-gray-600">Chat kami untuk bantuan</div>
                </div>
            </a>
            <a href="https://www.instagram.com/reincarnate_id/"
                class="flex items-center gap-3 p-4 rounded-2xl bg-white/70 backdrop-blur-sm shadow ring-1 ring-gray-200/40 hover:shadow-lg hover:ring-yellow-500/40 transition">
                <i class="fa-brands fa-instagram text-2xl text-pink-500"></i>
                <div>
                    <div class="font-semibold">Instagram</div>
                    <div class="text-sm text-gray-600">Follow & DM untuk info</div>
                </div>
            </a>
            <a href="#" id="mailLink" target="_blank"
                class="flex items-center gap-3 p-4 rounded-2xl bg-white/70 backdrop-blur-sm shadow ring-1 ring-gray-200/40 hover:shadow-lg hover:ring-yellow-500/40 transition">
                <i class="fa-regular fa-envelope text-2xl text-yellow-600"></i>
                <div>
                    <div class="font-semibold">Gmail</div>
                    <div class="text-sm text-gray-600">Kirim email untuk pertanyaan</div>
                </div>
            </a>
            <a href="#" id="csLink" target="_blank"
                class="flex items-center gap-3 p-4 rounded-2xl bg-white/70 backdrop-blur-sm shadow ring-1 ring-gray-200/40 hover:shadow-lg hover:ring-yellow-500/40 transition">
                <i class="fa-solid fa-headset text-2xl text-blue-600"></i>
                <div>
                    <div class="font-semibold">Customer Service</div>
                    <div class="text-sm text-gray-600">Tim siap membantu setiap hari</div>
                </div>
            </a>
        </div>
    </div>

    <footer class="text-center py-6 text-sm text-gray-500 mt-10 border-t border-gray-200">&copy; 2025 Thrift Shop. All
        rights reserved.</footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if ({!! json_encode(session('ok') ? true : false) !!}) { showInfoToast({!! json_encode(session('ok')) !!}); }
            const waLink = document.getElementById('waLink');
            const mailLink = document.getElementById('mailLink');
            const csLink = document.getElementById('csLink');
            const waNumber = '6289603359402';
            const baseMsg = {!! json_encode(Auth::check() ? ('Halo CS, saya ' . (Auth::user()->name ?? '') . '.') : 'Halo CS, saya ingin bertanya.') !!};
            const msg = encodeURIComponent(baseMsg + ' Mohon bantuannya.');
            if (waLink) waLink.href = `https://wa.me/${waNumber}?text=${msg}`;
            if (csLink) csLink.href = `https://www.instagram.com/reincarnate_id/`;
            if (mailLink) mailLink.href = `mailto:dapitkajul@gmail.com?subject=Support%20Request&body=${encodeURIComponent(baseMsg)}`;
            // Blur navbar saat scroll
            const navbar = document.getElementById('mainNavbar');
            function syncNavbarBlur() {
                if (!navbar) return;
                if (window.scrollY > 0) {
                    navbar.classList.add('backdrop-blur-md', 'bg-[#FDF5E6]/70', 'shadow', 'border-b', 'border-gray-200');
                    navbar.classList.remove('bg-[#FDF5E6]');
                } else {
                    navbar.classList.remove('backdrop-blur-md', 'bg-[#FDF5E6]/70', 'shadow', 'border-b', 'border-gray-200');
                    navbar.classList.add('bg-[#FDF5E6]');
                }
            }
            syncNavbarBlur();
            window.addEventListener('scroll', syncNavbarBlur);
            // Banner slider
            const banner = document.getElementById('heroBanner');
            const track = banner ? banner.querySelector('.slides') : null;
            const slides = track ? track.querySelectorAll('img') : [];
            const dots = banner ? banner.querySelectorAll('.dot') : [];
            let index = 0;
            function update() {
                if (track) track.style.transform = `translateX(-${index * 100}%)`;
                dots.forEach((d, i) => { if (i === index) { d.classList.remove('bg-white/40'); d.classList.add('bg-white'); } else { d.classList.remove('bg-white'); d.classList.add('bg-white/40'); } });
            }
            if (banner) {
                update();
                let timer = setInterval(() => { index = (index + 1) % slides.length; update(); }, 4000);
                function restart() { clearInterval(timer); timer = setInterval(() => { index = (index + 1) % slides.length; update(); }, 4000); }
                dots.forEach((d, i) => { d.addEventListener('click', () => { index = i; update(); restart(); }); });
                let startX = 0; let deltaX = 0;
                banner.addEventListener('touchstart', (e) => { startX = e.touches[0].clientX; });
                banner.addEventListener('touchmove', (e) => { deltaX = e.touches[0].clientX - startX; });
                banner.addEventListener('touchend', () => { if (Math.abs(deltaX) > 50) { index = deltaX < 0 ? (index + 1) % slides.length : (index - 1 + slides.length) % slides.length; update(); } deltaX = 0; restart(); });
            }

            const adBoard = document.getElementById('adBoard');
            const adTrack = adBoard ? adBoard.querySelector('.ad-slides') : null;
            const adSlides = adTrack ? adTrack.querySelectorAll('.ad-slide') : [];
            const adDots = adBoard ? adBoard.querySelectorAll('.ad-dot') : [];
            let adIndex = 0;
            function adUpdate() {
                if (adTrack) adTrack.style.transform = `translateX(-${adIndex * 100}%)`;
                adDots.forEach((d, i) => { if (i === adIndex) { d.classList.remove('bg-white/40'); d.classList.add('bg-white'); } else { d.classList.remove('bg-white'); d.classList.add('bg-white/40'); } });
            }
            if (adBoard) {
                adUpdate();
                let adTimer = setInterval(() => { adIndex = (adIndex + 1) % (adSlides.length || 1); adUpdate(); }, 4000);
                function adRestart() { clearInterval(adTimer); adTimer = setInterval(() => { adIndex = (adIndex + 1) % (adSlides.length || 1); adUpdate(); }, 4000); }
                adDots.forEach((d, i) => { d.addEventListener('click', () => { adIndex = i; adUpdate(); adRestart(); }); });
            }

            // Elemen tombol dan drawer
            const cartBtn = document.getElementById('cartBtn');
            const favBtn = document.getElementById('favBtn');
            const profileBtn = document.getElementById('profileBtn');
            const drawer = document.getElementById('cartDrawer');
            const backdrop = drawer ? drawer.querySelector('.backdrop') : null;
            const panel = drawer ? drawer.querySelector('.panel') : null;
            const closeCart = document.getElementById('closeCart');
            const favDrawer = document.getElementById('favDrawer');
            const favBackdrop = favDrawer ? favDrawer.querySelector('.backdrop') : null;
            const favPanel = favDrawer ? favDrawer.querySelector('.panel') : null;
            const closeFav = document.getElementById('closeFav');
            const authDrawer = document.getElementById('authDrawer');
            const authBackdrop = authDrawer ? authDrawer.querySelector('.backdrop') : null;
            const authPanel = authDrawer ? authDrawer.querySelector('.panel') : null;
            const closeAuth = document.getElementById('closeAuth');
            const authTabSignIn = document.getElementById('authTabSignIn');
            const authTabRegister = document.getElementById('authTabRegister');
            const authTitle = document.getElementById('authTitle');
            const authName = document.getElementById('authName');
            const authEmail = document.getElementById('authEmail');
            const authPassword = document.getElementById('authPassword');
            const togglePassword = document.getElementById('togglePassword');
            const authInvite = document.getElementById('authInvite');
            const authSubmit = document.getElementById('authSubmit');
            let isAuth = !!JSON.parse(String({{ json_encode(Auth::check()) }}));
            const authUserId = {{ json_encode(Auth::id()) }};
            const productsLink = document.getElementById('productsLink');
            const ctaShop = document.getElementById('ctaShop');
            let authMode = 'register';
            let adminMode = false;
            const params = new URLSearchParams(window.location.search);
            const qAuth = params.get('auth');
            const adminParam = params.get('admin');
            if (adminParam === '1') { adminMode = true; }
            if (!isAuth && qAuth) { authMode = qAuth === 'signin' ? 'signin' : 'register'; renderAuth(); openAuth(); }
            function openDrawer() { if (!drawer || !panel || !backdrop) return; drawer.classList.remove('pointer-events-none'); drawer.classList.add('pointer-events-auto'); backdrop.classList.remove('opacity-0'); backdrop.classList.add('opacity-100'); panel.classList.remove('translate-x-full'); panel.classList.add('translate-x-0'); }
            function closeDrawer() { if (!drawer || !panel || !backdrop) return; panel.classList.add('translate-x-full'); panel.classList.remove('translate-x-0'); backdrop.classList.add('opacity-0'); backdrop.classList.remove('opacity-100'); drawer.classList.add('pointer-events-none'); drawer.classList.remove('pointer-events-auto'); }
            function openFav() { if (!favDrawer || !favPanel || !favBackdrop) return; favDrawer.classList.remove('pointer-events-none'); favDrawer.classList.add('pointer-events-auto'); favBackdrop.classList.remove('opacity-0'); favBackdrop.classList.add('opacity-100'); favPanel.classList.remove('translate-x-full'); favPanel.classList.add('translate-x-0'); }
            function closeFavDrawer() { if (!favDrawer || !favPanel || !favBackdrop) return; favPanel.classList.add('translate-x-full'); favPanel.classList.remove('translate-x-0'); favBackdrop.classList.add('opacity-0'); favBackdrop.classList.remove('opacity-100'); favDrawer.classList.add('pointer-events-none'); favDrawer.classList.remove('pointer-events-auto'); }
            // Buka/tutup drawer auth dengan transisi
            function openAuth() { if (!authDrawer || !authPanel || !authBackdrop) return; authDrawer.classList.remove('pointer-events-none'); authDrawer.classList.add('pointer-events-auto'); authBackdrop.classList.remove('opacity-0'); authBackdrop.classList.add('opacity-100'); authPanel.classList.remove('opacity-0', 'scale-95'); authPanel.classList.add('opacity-100', 'scale-100'); }
            function closeAuthDrawer() { if (!authDrawer || !authPanel || !authBackdrop) return; authPanel.classList.add('opacity-0', 'scale-95'); authPanel.classList.remove('opacity-100', 'scale-100'); authBackdrop.classList.add('opacity-0'); authBackdrop.classList.remove('opacity-100'); authDrawer.classList.add('pointer-events-none'); authDrawer.classList.remove('pointer-events-auto'); }
            // Ubah UI form sesuai mode (register/signin)
            function renderAuth() { if (authMode === 'register') { authTitle.innerHTML = 'Hello!'; authName.classList.remove('hidden'); authSubmit.textContent = 'Sign Up'; authTabRegister.classList.add('bg-[#5a3b10]', 'text-white'); authTabRegister.classList.remove('border', 'text-[#5a3b10]'); authTabSignIn.classList.remove('bg-[#5a3b10]', 'text-white'); authTabSignIn.classList.add('border', 'text-[#5a3b10]'); } else { authTitle.innerHTML = 'Hello!<br>Welcome Back'; authName.classList.add('hidden'); authSubmit.textContent = 'Sign in'; authTabSignIn.classList.add('bg-[#5a3b10]', 'text-white'); authTabSignIn.classList.remove('border', 'text-[#5a3b10]'); authTabRegister.classList.remove('bg-[#5a3b10]', 'text-white'); authTabRegister.classList.add('border', 'text-[#5a3b10]'); } }
            if (cartBtn) cartBtn.addEventListener('click', (e) => { e.preventDefault(); if (!isAuth) { showInfoToast('Silakan login untuk menggunakan fitur ini'); openAuth(); return; } openDrawer(); });
            if (backdrop) backdrop.addEventListener('click', closeDrawer);
            if (closeCart) closeCart.addEventListener('click', closeDrawer);
            if (favBtn) favBtn.addEventListener('click', (e) => { e.preventDefault(); if (!isAuth) { showInfoToast('Silakan login untuk menggunakan fitur ini'); openAuth(); return; } openFav(); });
            if (productsLink) productsLink.addEventListener('click', (e) => { e.preventDefault(); showInfoToast('Silakan login untuk melihat produk'); openAuth(); });
            if (ctaShop) ctaShop.addEventListener('click', (e) => { e.preventDefault(); if (!isAuth) { showInfoToast('Silakan login untuk belanja'); openAuth(); return; } window.location.href = '/products'; });
            if (favBackdrop) favBackdrop.addEventListener('click', closeFavDrawer);
            if (closeFav) closeFav.addEventListener('click', closeFavDrawer);
            if (profileBtn) profileBtn.addEventListener('click', (e) => {
                e.preventDefault();
                if (!isAuth) { openAuth(); return; }
                if (authUserId) { window.location.href = '/profile/' + authUserId; }
            });
            if (authBackdrop) authBackdrop.addEventListener('click', closeAuthDrawer);
            if (closeAuth) closeAuth.addEventListener('click', closeAuthDrawer);
            if (authTabSignIn) authTabSignIn.addEventListener('click', () => { authMode = 'signin'; renderAuth(); });
            if (authTabRegister) authTabRegister.addEventListener('click', () => { authMode = 'register'; renderAuth(); });
            // Mode admin tersembunyi: toggle dengan Ctrl+Alt+A, tampilkan field invite
            function updateAdminMode() {
                if (adminMode) { authInvite?.classList.remove('hidden'); }
                else { authInvite?.classList.add('hidden'); }
            }
            document.addEventListener('keydown', (e) => {
                if (e.ctrlKey && e.altKey && (e.key === 'a' || e.key === 'A')) { adminMode = !adminMode; updateAdminMode(); }
            });
            if (togglePassword && authPassword) {
                togglePassword.addEventListener('click', () => {
                    const isText = authPassword.getAttribute('type') === 'text';
                    authPassword.setAttribute('type', isText ? 'password' : 'text');
                    const icon = togglePassword.querySelector('i');
                    if (icon) {
                        icon.classList.toggle('fa-eye');
                        icon.classList.toggle('fa-eye-slash');
                    }
                });
            }
            // Helper AJAX JSON dengan CSRF
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            function postJSON(url, body) {
                return fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify(body),
                }).then(async (r) => {
                    const ct = r.headers.get('content-type') || '';
                    let data = null;
                    if (ct.includes('application/json')) {
                        try { data = await r.json(); } catch (_) { data = null; }
                    } else {
                        const text = await r.text();
                        data = { ok: r.ok, error: text?.slice(0, 200) || 'Unexpected response' };
                    }
                    if (data && typeof data === 'object') {
                        if (!('ok' in data)) data.ok = r.ok;
                        if (!r.ok && !data.error) data.error = 'HTTP ' + r.status;
                    }
                    return data;
                });
            }
            // Submit register/login, arahkan ke /admin bila role=admin
            if (authSubmit) authSubmit.addEventListener('click', async () => {
                const payload = { name: authName.value, email: authEmail.value, password: authPassword.value };
                try {
                    let res;
                    if (authMode === 'register') {
                        const body = adminMode && authInvite?.value ? { ...payload, invite: authInvite.value } : payload;
                        res = await postJSON('/auth/register', body);
                    } else {
                        res = await postJSON('/auth/login', { email: payload.email, password: payload.password });
                    }
                    if (res && res.ok) {
                        if (res.role === 'admin') { window.location.href = '/admin'; return; }
                        isAuth = true;
                        window.location.reload();
                    } else {
                        alert(res?.error || 'Gagal melakukan autentikasi');
                    }
                } catch (e) { alert('Terjadi kesalahan.'); }
            });
            document.addEventListener('keydown', (e) => { if (e.key === 'Escape') { closeDrawer(); closeFavDrawer(); } });
            renderAuth(); updateAdminMode();

            // State sederhana untuk keranjang & favorit
            const cart = [];
            const favorites = [];
            const badge = document.getElementById('cartBadge');
            const favBadge = document.getElementById('favBadge');
            const cartItems = document.getElementById('cartItems');
            const favItems = document.getElementById('favItems');
            const toast = document.getElementById('cartToast');
            const toastCount = document.getElementById('toastCount');
            const toastTotal = document.getElementById('toastTotal');
            const infoToast = document.getElementById('infoToast');
            const infoMsg = document.getElementById('infoMsg');

            function formatRupiah(n) { return 'Rp.' + (n || 0).toLocaleString('id-ID'); }
            function itemKey(i) { return `${i.name}|${i.price}`; }
            function totalQty() { return cart.reduce((s, i) => s + (i.qty || 0), 0); }
            function updateBadge() { if (!badge) return; const q = totalQty(); badge.textContent = q; if (q > 0) { badge.classList.remove('hidden'); } else { badge.classList.add('hidden'); } }
            function updateFavBadge() { if (!favBadge) return; favBadge.textContent = favorites.length; if (favorites.length > 0) { favBadge.classList.remove('hidden'); } else { favBadge.classList.add('hidden'); } }
            function renderCart() {
                if (!cartItems) return; cartItems.innerHTML = cart.map(item => `
<div class="rounded-xl border border-gray-200 shadow-sm p-3 flex items-center gap-3">
    <img src="${item.image}" class="w-16 h-16 object-contain rounded-lg" alt="${item.name}">
    <div class="flex-1">
        <div class="font-semibold">${item.name}</div>
        <div class="mt-1 flex items-center gap-2">
            <button class="w-7 h-7 rounded-md bg-gray-100 hover:bg-gray-200 flex items-center justify-center" data-action="dec" data-key="${itemKey(item)}">-</button>
            <span class="text-sm text-gray-600 min-w-[2ch] text-center">${item.qty}</span>
            <button class="w-7 h-7 rounded-md bg-gray-100 hover:bg-gray-200 flex items-center justify-center" data-action="inc" data-key="${itemKey(item)}">+</button>
            <button class="ml-2 text-red-500" data-action="remove" data-key="${itemKey(item)}"><i class="fa-solid fa-trash"></i></button>
        </div>
    </div>
    <div class="text-right">
        <div class="font-semibold">${formatRupiah(item.price * item.qty)}</div>
        <div class="text-xs text-gray-500">+ Shipping</div>
    </div>
</div>`).join('');
            }
            function renderFavorites() {
                if (!favItems) return; favItems.innerHTML = favorites.map(item => `
<div class="rounded-xl border border-gray-200 shadow-sm p-3 flex items-center gap-3">
    <img src="${item.image}" class="w-16 h-16 object-contain rounded-lg" alt="${item.name}">
    <div class="flex-1">
        <div class="font-semibold">${item.name}</div>
        <div class="text-sm text-gray-500">${formatRupiah(item.price)}</div>
    </div>
    <div class="flex items-center gap-2">
        <button class="px-3 py-1 bg-yellow-600 hover:bg-yellow-700 text-white rounded-md" data-action="fav-add" data-key="${itemKey(item)}">Keranjang</button>
        <button class="text-red-500" data-action="fav-remove" data-key="${itemKey(item)}"><i class="fa-solid fa-trash"></i></button>
    </div>
</div>`).join('');
            }
            function showToast() { if (!toast) return; const total = cart.reduce((s, i) => s + (i.price || 0) * (i.qty || 0), 0); toastCount.textContent = `${totalQty()} Pesanan`; toastTotal.textContent = formatRupiah(total); toast.classList.remove('translate-y-full'); toast.classList.add('translate-y-0'); clearTimeout(showToast._t); showToast._t = setTimeout(() => { toast.classList.add('translate-y-full'); toast.classList.remove('translate-y-0'); }, 2500); }
            function showInfoToast(msg) { if (!infoToast || !infoMsg) return; infoMsg.textContent = msg; infoToast.classList.remove('hidden'); clearTimeout(showInfoToast._t); showInfoToast._t = setTimeout(() => { infoToast.classList.add('hidden'); }, 2000); }
            function addToCart(item) { const key = itemKey(item); const found = cart.find(i => itemKey(i) === key); if (found) { found.qty = (found.qty || 0) + 1; } else { cart.push({ ...item, qty: 1 }); } updateBadge(); renderCart(); showToast(); }
            function toggleFavorite(item) { const key = itemKey(item); const idx = favorites.findIndex(i => itemKey(i) === key); if (idx >= 0) favorites.splice(idx, 1); else favorites.push({ ...item }); updateFavBadge(); renderFavorites(); updateCardFavoritesUI(); }
            function incByKey(key) { const it = cart.find(i => itemKey(i) === key); if (!it) return; it.qty++; updateBadge(); renderCart(); showToast(); }
            function decByKey(key) { const idx = cart.findIndex(i => itemKey(i) === key); if (idx < 0) return; cart[idx].qty--; if (cart[idx].qty <= 0) { cart.splice(idx, 1); } updateBadge(); renderCart(); showToast(); }
            function removeByKey(key) { const idx = cart.findIndex(i => itemKey(i) === key); if (idx < 0) return; cart.splice(idx, 1); updateBadge(); renderCart(); showToast(); }
            if (cartItems) { cartItems.addEventListener('click', (e) => { const btn = e.target.closest('[data-action]'); if (!btn) return; if (!isAuth) { showInfoToast('Silakan login untuk menggunakan fitur ini'); openAuth(); return; } const action = btn.getAttribute('data-action'); const key = btn.getAttribute('data-key'); if (action === 'inc') incByKey(key); else if (action === 'dec') decByKey(key); else if (action === 'remove') removeByKey(key); }); }
            if (favItems) { favItems.addEventListener('click', (e) => { const btn = e.target.closest('[data-action]'); if (!btn) return; if (!isAuth) { showInfoToast('Silakan login untuk menggunakan fitur ini'); openAuth(); return; } const action = btn.getAttribute('data-action'); const key = btn.getAttribute('data-key'); const item = favorites.find(i => itemKey(i) === key); if (!item) return; if (action === 'fav-add') addToCart(item); else if (action === 'fav-remove') { toggleFavorite(item); } }); }
            document.querySelectorAll('.product-card').forEach(card => {
                card.addEventListener('click', () => { if (!isAuth) { showInfoToast('Silakan login untuk menggunakan fitur ini'); openAuth(); return; } addToCart({ name: card.dataset.name, price: parseInt(card.dataset.price || '0', 10), image: card.dataset.image }); });
                const favBtnInside = card.querySelector('.fav-btn');
                if (favBtnInside) { favBtnInside.addEventListener('click', (e) => { e.preventDefault(); e.stopPropagation(); if (!isAuth) { showInfoToast('Silakan login untuk menggunakan fitur ini'); openAuth(); return; } toggleFavorite({ name: card.dataset.name, price: parseInt(card.dataset.price || '0', 10), image: card.dataset.image }); }); }
            });
            document.querySelectorAll('.fav-btn[data-name]').forEach(btn => {
                btn.addEventListener('click', (e) => { e.preventDefault(); if (!isAuth) { showInfoToast('Silakan login untuk menggunakan fitur ini'); openAuth(); return; } const name = btn.getAttribute('data-name') || ''; const price = parseInt(btn.getAttribute('data-price') || '0', 10); const image = btn.getAttribute('data-image') || ''; toggleFavorite({ name, price, image }); });
            });
            document.querySelectorAll('.cart-btn[data-name]').forEach(btn => {
                btn.addEventListener('click', (e) => { e.preventDefault(); e.stopPropagation(); if (!isAuth) { showInfoToast('Silakan login untuk menggunakan fitur ini'); openAuth(); return; } const name = btn.getAttribute('data-name') || ''; const price = parseInt(btn.getAttribute('data-price') || '0', 10); const image = btn.getAttribute('data-image') || ''; addToCart({ name, price, image }); });
            });
            function updateCardFavoritesUI() { document.querySelectorAll('.product-card').forEach(card => { const key = `${card.dataset.name}|${parseInt(card.dataset.price || '0', 10)}`; const isFav = favorites.some(i => `${i.name}|${i.price}` === key); const icon = card.querySelector('.fav-btn i'); if (!icon) return; if (isFav) { icon.classList.remove('fa-regular'); icon.classList.add('fa-solid', 'text-pink-500'); } else { icon.classList.remove('fa-solid', 'text-pink-500'); icon.classList.add('fa-regular'); } }); document.querySelectorAll('.fav-btn[data-name] i').forEach(icon => { const el = icon.closest('.fav-btn'); const name = el?.getAttribute('data-name') || ''; const price = parseInt(el?.getAttribute('data-price') || '0', 10); const key = `${name}|${price}`; const isFav = favorites.some(i => `${i.name}|${i.price}` === key); if (isFav) { icon.classList.remove('fa-regular'); icon.classList.add('fa-solid', 'text-pink-500'); } else { icon.classList.remove('fa-solid', 'text-pink-500'); icon.classList.add('fa-regular'); } }); }
            updateBadge(); updateFavBadge(); renderCart(); renderFavorites(); updateCardFavoritesUI();
        });
    </script>

</body>

</html>
