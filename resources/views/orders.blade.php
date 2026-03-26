@extends("layouts.app")

@section("title", "Orders")

@section("content")
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    @if(isset($orders) && $orders->isNotEmpty())
    <div class="flex justify-end mb-6">
        <form action="{{ route('orders.export') }}" method="post">
            @csrf
            <input type="hidden" name="orders" value="{{ base64_encode(json_encode($orders)) }}">
            <button type="submit"
                class="flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl shadow-sm transition-all active:scale-95">
                <i class="fa-solid fa-file-export"></i>
                Export All Records
            </button>
        </form>
    </div>
    @endif

    @if(auth()->user()->role_id == 2 || auth()->user()->role_id == 1)
    <div class="bg-white rounded-2xl border border-slate-200 p-6 mb-8 shadow-sm">
        <form action="{{ auth()->user()->id == 2 ? url('/orders/') : url('/user/'.auth()->id().'/orders') }}" method="get" class="space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider ml-1">Status</label>
                    <x-status-dropdown></x-status-dropdown>
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider ml-1">Refer To</label>
                    <x-referto-dropdown></x-referto-dropdown>
                </div>
            </div>

            <hr class="border-slate-100">

            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                @if(request('shop')) <input type="hidden" name="shop" value="{{ request('shop') }}"> @endif
                @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif

                <div class="md:col-span-3">
                    <label for="fromDate" class="block text-sm font-semibold text-slate-600 mb-1">From Date</label>
                    <input type="date" id="fromDate" name="from_date" value="{{ request('from_date') }}"
                        class="w-full bg-slate-50 border-transparent rounded-xl px-4 py-3 focus:bg-white focus:ring-2 focus:ring-indigo-500 text-slate-700 transition-all">
                </div>

                <div class="md:col-span-3">
                    <label for="toDate" class="block text-sm font-semibold text-slate-600 mb-1">To Date</label>
                    <input type="date" id="toDate" name="to_date" value="{{ request('to_date') }}"
                        class="w-full bg-slate-50 border-transparent rounded-xl px-4 py-3 focus:bg-white focus:ring-2 focus:ring-indigo-500 text-slate-700 transition-all">
                </div>

                <div class="md:col-span-4">
                    <label for="nameunit" class="block text-sm font-semibold text-slate-600 mb-1">Quick Search</label>
                    <input type="text" id="nameunit" name="nameunit" value="{{ request('nameunit') }}"
                        placeholder="ကုန်ပစ္စည်းအမည် (သို့) unit ဖြင့်ရှာရန်"
                        class="w-full bg-slate-50 border-transparent rounded-xl px-4 py-3 focus:bg-white focus:ring-2 focus:ring-indigo-500 text-slate-700 transition-all">
                </div>

                <div class="md:col-span-2">
                    <button type="submit"
                        class="w-full py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-md flex justify-center items-center space-x-2 transition-all active:scale-95">
                        <i class="fa-solid fa-magnifying-glass text-sm"></i>
                        <span>Search</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
    @endif

    <div class="flex flex-col sm:flex-row justify-between items-baseline mb-6 px-2">
        <h2 class="text-2xl font-bold text-slate-800">တင်ပို့ကုန်စာရင်း</h2>
        <p class="text-sm text-slate-400 font-medium">
            Showing <span class="text-indigo-600 font-bold"></span> records
        </p>
    </div>

    <div class="grid grid-cols-1 gap-4">
        @forelse($orders as $order)
            <x-orderCard :order="$order" :shops="$shops" />
        @empty
            <div class="bg-white rounded-3xl p-12 border border-slate-100 flex flex-col items-center text-center">
                <img src="{{ asset('images/empty.gif') }}" alt="empty" class="w-48 mb-6 opacity-80">
                <h3 class="text-lg font-bold text-slate-700">မှတ်တမ်းများမရှိသေးပါ</h3>
                <p class="text-slate-400 text-sm mt-1">လက်တလောတင်ပို့ကုန်များမရှိသေးပါ</p>
            </div>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $orders->appends(request()->query())->links() }}
    </div>
</div>
@endsection
