<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Shipping Record System</title>
    <link rel="icon" href="{{ asset('images/logo1.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=nunito:400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        [x-cloak] { display: none !important; }
        .nav-link-custom { @apply hover:text-indigo-600 transition-colors font-semibold text-slate-600; }
        .mobile-link {
            display: block;
            padding: 12px;
            background: #f8fafc;
            border-radius: 10px;
            font-weight: 700;
            color: #334155;
            text-align: center;
            font-size: 14px;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-slate-50 font-['Nunito'] antialiased text-slate-900">
<div id="app" class="flex flex-col min-h-screen" x-data="{ mobileOpen: false }">

    <header class="sticky top-0 z-[100] h-20 bg-white border-b border-slate-200 px-6 md:px-12 flex items-center justify-between">

        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo1.png') }}" class="h-10" alt="Logo">
            <a href="{{ url('/home') }}" class="text-xl font-bold italic tracking-tight">
                <span class="text-green-600">Shipping</span>
                <span class="text-indigo-600">Record</span>
            </a>
        </div>

        <nav class="hidden md:flex items-center space-x-8">
            @auth
                @if(auth()->user()->role_id == 1)
                    <a href="{{ url('/order/add') }}" class="nav-link-custom">တင်ပို့ကုန်ထည့်သွင်းရန်</a>
                    <a href="{{ url('/user/'.auth()->id().'/orders') }}" class="nav-link-custom">အချက်လက်ကြည့်ရန်</a>
                @endif

                @if(auth()->user()->role_id == 2)
                    <a href="{{ url('/orders') }}" class="nav-link-custom">ပို့ကုန်စာရင်း</a>
                    <a href="{{ url('/facts/add') }}" class="nav-link-custom">အချက်လက်ထည့်ရန်</a>

                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button class="flex items-center gap-1 py-7 nav-link-custom outline-none">
                            အချက်အလက်များ
                            <i class="fas fa-chevron-down text-[10px]"></i>
                        </button>
                        <div x-show="open" x-cloak style="display: none;" class="absolute left-0 w-60 bg-white rounded-xl shadow-xl border border-slate-200 py-3 z-50">
                            <a href="/categories" class="block px-4 py-2 hover:bg-indigo-50 hover:text-indigo-600 text-sm">ကုန်ပစ္စည်းအမျိုးအစားများ</a>
                            <a href="/products" class="block px-4 py-2 hover:bg-indigo-50 hover:text-indigo-600 text-sm">ကုန်အမည်များ</a>
                            <a href="/sourceareas" class="block px-4 py-2 hover:bg-indigo-50 hover:text-indigo-600 text-sm">ပွဲရုံများ</a>
                            <a href="/gates" class="block px-4 py-2 hover:bg-indigo-50 hover:text-indigo-600 text-sm">တင်ပို့ဂိတ်များ</a>
                            <a href="/shops" class="block px-4 py-2 hover:bg-indigo-50 hover:text-indigo-600 text-sm">ဆိုင်များ</a>
                            <div class="my-2 border-t border-slate-100"></div>
                            <a href="/units" class="block px-4 py-2 hover:bg-indigo-50 hover:text-indigo-600 text-sm font-bold">ယူနစ်များ</a>
                        </div>
                    </div>
                @endif
            @endauth
        </nav>

        <div class="flex items-center gap-4">
            @guest
                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ route('login') }}" class="font-bold text-slate-600 hover:text-indigo-600">Login</a>
                    <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-6 py-2 rounded-full font-bold hover:bg-indigo-700 shadow-md">Register</a>
                </div>
            @endguest

            @auth
                <div class="hidden md:block relative" x-data="{ userOpen: false }" @click.away="userOpen = false">
                    <button @click="userOpen = !userOpen"
                            class="flex items-center gap-2 px-4 py-2 bg-slate-100 rounded-full hover:bg-indigo-50 border border-slate-200 outline-none">
                        <div class="w-7 h-7 bg-indigo-600 text-white rounded-full flex items-center justify-center text-xs font-bold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <span class="text-sm font-bold text-slate-700">{{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down text-[10px] text-slate-400"></i>
                    </button>

                    <div x-show="userOpen" x-cloak style="display: none;" class="absolute right-0 mt-2 w-56 bg-white shadow-xl rounded-xl border border-slate-200 py-3 z-50">
                        <a href="/change-password" class="block px-4 py-2 text-sm text-slate-600 hover:bg-indigo-50 hover:text-indigo-600">
                           <i class="fas fa-key mr-2"></i>စကားဝှက်ပြောင်းရန်
                        </a>
                        <div class="my-2 border-t border-slate-100"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="px-4 py-2 hover:bg-red-50 text-sm text-red-600 font-bold w-full text-left">
                                <i class="fas fa-sign-out-alt mr-2"></i>ထွက်ရန်
                            </button>
                        </form>
                    </div>
                </div>
            @endauth

            <button @click="mobileOpen = !mobileOpen" class="md:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-lg">
                <i class="fas" :class="mobileOpen ? 'fa-times text-xl' : 'fa-bars text-xl'"></i>
            </button>
        </div>
    </header>

    <div x-show="mobileOpen" x-cloak style="display: none;"
         class="fixed inset-0 top-20 bg-white z-[90] md:hidden p-6 overflow-y-auto space-y-4">

        @auth
            <div class="flex items-center gap-3 p-4 bg-indigo-50 rounded-2xl mb-4">
                <div class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <p class="text-xs text-indigo-400 font-bold uppercase tracking-widest">Logged in as</p>
                    <p class="font-bold text-slate-800">{{ Auth::user()->name }}</p>
                </div>
            </div>

            @if(auth()->user()->role_id == 1)
                <a href="/order/add" class="mobile-link">တင်ပို့ကုန်ထည့်ရန်</a>
                <a href="{{ url('/user/'.auth()->id().'/orders') }}" class="mobile-link">အချက်လက်ကြည့်ရန်</a>
            @else

            <a href="{{ url('/orders') }}" class="mobile-link  w-full ">ပို့ကုန်စာရင်း</a>
            <a href="{{ url('/facts/add') }}" class=" mobile-link  w-full">အချက်လက်ထည့်ရန်</a>

            <!-- Mobile Dropdown -->
            <div x-data="{ open: false }" class="space-y-2 ">

                <button @click="open = !open"
                    class="mobile-link flex justify-between w-full items-center">
                    အချက်အလက်များ
                    <i class="fas fa-chevron-down transition-transform duration-300"
                       :class="{ 'rotate-180': open }"></i>
                </button>

                <!-- Dropdown Content -->
                <div x-show="open"
                     x-transition
                     class="space-y-2 pl-2">

                    <a href="/categories" class="mobile-link">ကုန်ပစ္စည်းအမျိုးအစားများ</a>
                    <a href="/products" class="mobile-link">ကုန်အမည်များ</a>
                    <a href="/sourceareas" class="mobile-link">ပွဲရုံများ</a>
                    <a href="/gates" class="mobile-link">တင်ပို့ဂိတ်များ</a>
                    <a href="/shops" class="mobile-link">ဆိုင်များ</a>
                    <a href="/units" class="mobile-link bg-indigo-50 text-indigo-600 font-bold">ယူနစ်များ</a>

                </div>
            </div>
            @endif

            <div class="pt-4 border-t border-slate-100 space-y-2">
                <a href="/change-password" class="mobile-link bg-slate-50">
                    <i class="fas fa-key mr-2"></i>စကားဝှက်ပြောင်းရန်
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="mobile-link bg-red-50 text-red-600 w-full">
                        <i class="fas fa-sign-out-alt mr-2"></i>ထွက်ရန်
                    </button>
                </form>
            </div>
        @endauth

        @guest
            <a href="{{ route('login') }}" class="mobile-link">Login</a>
            <a href="{{ route('register') }}" class="mobile-link bg-indigo-600 text-white">Register</a>
        @endguest
    </div>

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-white border-t border-slate-200 py-6 px-6 text-center">
        <p class="text-xs text-slate-400">© 2026 Yangon–Lashio Shipping Record System.</p>
    </footer>

</div>
</body>
</html>
