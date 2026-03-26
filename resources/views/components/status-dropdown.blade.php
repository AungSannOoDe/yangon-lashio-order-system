<div class="relative w-full" x-data="{ open: false }">
    <button
        @click="open = !open"
        type="button"
        class="w-full bg-slate-50 border border-slate-200 text-slate-700 font-bold py-3 px-4 rounded-xl flex justify-between items-center hover:bg-white hover:border-indigo-400 transition-all focus:outline-none focus:ring-2 focus:ring-indigo-500/20">

        <span class="text-sm truncate">
            <i class="fa-solid fa-filter mr-2 text-slate-400 text-xs"></i>
            {{ request('status') ?: 'Filter By Status' }}
        </span>

        <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
    </button>

    <ul
        x-show="open"
        x-cloak
        style="display: none;"
        @click.outside="open = false"
        class="absolute left-0 right-0 mt-2 bg-white border border-slate-200 rounded-xl shadow-xl z-[110] max-h-60 overflow-y-auto py-1 px-0">

        <li>
            <a href="{{ auth()->user()->role_id == 2 ? url('/orders') : url('/user/'.auth()->id().'/orders') }}"
               class="w-full block px-4 py-2.5 text-xs font-bold text-indigo-600 hover:bg-indigo-50 border-b border-slate-50">
                <i class="fa-solid fa-rotate-left mr-2"></i>အားလုံးကြည့်ရန်
            </a>
        </li>

        @foreach($statuses as $status)
        <li>
            @php
                $baseUrl = auth()->user()->role_id == 2 ? '/orders' : '/user/'.auth()->id().'/orders';
                $params = request()->all();
                $params['status'] = $status;
                $url = $baseUrl . '?' . http_build_query($params);
            @endphp
            <a href="{{ $url }}"
                class="w-full block px-4 py-2.5 text-sm text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                {{ $status }}
            </a>
        </li>
        @endforeach
    </ul>
</div>
