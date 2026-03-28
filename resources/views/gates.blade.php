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
    @if($gates->isEmpty())
    <div class="bg-white rounded-3xl p-12 text-center">
        <div class="relative mb-6">
            <div class="absolute inset-0 bg-indigo-100 rounded-full blur-3xl opacity-30"></div>
            <img src="{{ asset('images/empty.gif') }}" alt="empty" class="relative w-64 mix-blend-multiply">
        </div>
        <p class="text-center fs-5">လက်တလောတင်ပို့နေသောဂိတ်များမရှိသေးပါ</p>
    </div>
    @else
    {{-- Header Section --}}
    <div class="mb-10 text-center">
        <h2 class="text-2xl font-black text-slate-800">
            <span class="text-indigo-600">လက်တလောတင်ပို့နေသောဂိတ်များ</span>
        </h2>

    </div>
    {{-- Gate List --}}
    <div class="space-y-4">
        @foreach($gates as $gate)
        {{-- This component should now use the Tailwind structure we built --}}
        <x-item :item="$gate" :delete="'delete'" :type="'gate'" />
        @endforeach
    </div>

    {{-- Modern Pagination --}}
    <div class="mt-10 flex justify-center">
        <div class=" p-2   rounded-2xl  gap-4  shadow-sm">
            {{ $gates->links() }}
        </div>
    </div>
    @endif
</div>
@endsection