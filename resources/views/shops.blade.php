@extends('layouts.app')
@section('title', 'Product Categories')
@section('content')
<div class="container">
    @if(session('error'))
    <div x-data="{ show: true }" x-show="show" class="fixed inset-0 z-[100] flex items-start my-3 justify-center px-4">
            <div class="bg-white/90 backdrop-blur-xl p-8 rounded-3xl shadow-2xl border border-white max-w-sm w-full text-center">
                <div class="mb-4 text-6xl">
                    <i class="fa-solid fa-xmark text-2xl text-red-600"></i>
                </div>
                <p class="font-bold text-lg mb-6 text-red-500">
                    {{ session('error') }}
                </p>
                <button @click="show = false" class="w-full py-3 bg-slate-900 text-white rounded-xl font-bold">
                    Done
                </button>
            </div>
        </div>
    @endif
    @if($shops->isEmpty())
    <div class="empty text-center">
        <img src="{{ asset('images/empty.gif') }}" alt="empty" style="max-width:250px;">
    </div>
    <p class="text-center fs-5">လက်တလောလွှဲပြောင်းဆိုင်များမရှိသေးပါ</p>
    @else
    {{-- Header Section --}}
    <div class="mb-10 text-center">
        <h2 class="text-2xl font-black text-slate-800">
            <span class="text-indigo-600">လွှဲပြောင်းဆိုင်များ</span>
        </h2>

    </div>
    {{-- Shop List --}}
    <div class="space-y-4">
        @foreach($shops as $shop)
        {{-- This component should now use the Tailwind structure we built --}}
        <x-item :item="$shop" :delete="'delete'" :type="'shop'" />
        @endforeach
    </div>

    {{-- Modern Pagination --}}
    <div class="mt-10 flex justify-center">
        <div class=" p-2   rounded-2xl  gap-4  shadow-sm">
            {{ $shops->links() }}
        </div>
    </div>
    @endif
</div>
@endsection