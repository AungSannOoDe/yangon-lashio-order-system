<div class="relative w-full" x-data="{ open: false }">
    <button
        @click="open = !open"
        type="button"
        class="w-full bg-slate-50 border border-slate-200 text-slate-700 font-bold py-3 px-4 rounded-xl flex justify-between items-center hover:bg-white hover:border-indigo-400 transition-all focus:outline-none focus:ring-2 focus:ring-indigo-500/20">

        <span class="text-sm truncate">
            <i class="fa-solid fa-shop mr-2 text-slate-400 text-xs"></i>
            {{ request('shop') ? request('shop') : 'Filter By Refers To' }}
        </span>

        <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
    </button>

    <ul
        x-show="open"
        x-cloak
        @click.outside="open = false"
        class="absolute left-0 right-0 mt-2 bg-white border border-slate-200 rounded-xl shadow-xl z-[110] max-h-60 overflow-y-auto py-1 px-0">

        {{-- ၁။ ဆိုင်အားလုံး (Shop filter ကို ဖြုတ်လိုက်ပြီး Page 1 ကို ပြန်သွားမယ်) --}}
        <li>
            <a href="{{ request()->fullUrlWithQuery(['shop' => null, 'page' => 1]) }}"
               class="block px-4 py-2.5 text-xs font-bold text-indigo-600 hover:bg-indigo-50 border-b border-slate-50">
                <i class="fa-solid fa-list mr-2"></i>လွှဲပြောင်းဆိုင်အားလုံး
            </a>
        </li>

        {{-- ၂။ ဆိုင်တစ်ခုချင်းစီအလိုက် Filter လုပ်ခြင်း --}}
        @foreach($shops as $shop)
        <li>
            <a href="{{ request()->fullUrlWithQuery(['shop' => $shop->name, 'page' => 1]) }}"
                class="block px-4 py-2.5 text-sm text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-colors {{ request('shop') == $shop->name ? 'bg-indigo-50 text-indigo-600' : '' }}">
                {{ $shop->name }}
            </a>
        </li>
        @endforeach
    </ul>
</div>
