




@extends('layouts.app')

@section('title', 'change password')
@section('content')
<section class="relative flex flex-col items-center justify-center min-h-screen">

    {{-- Success Message ပြသရန် (Optional) --}}
    @if (session('success'))
        <div class="absolute top-10 max-w-sm w-full bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded text-center">
            {{ session('success') }}
        </div>
    @endif

    <div class="w-full max-w-sm space-y-5 p-3 z-10">
        <div class="space-y-3 text-center">
            <h1 class="text-3xl font-bold text-stone-900">Change Your Password</h1>
            <p class="text-stone-500 text-base leading-relaxed">
                စကားဝှက်ပြောင်းရန်
            </p>
        </div>

        <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Current pwd --}}
            <div>
                <label for="curpwd" class="block text-sm font-medium text-stone-700">လက်ရှိစကားဝှက်</label>
                <input type="password" name="current_password" id="curpwd"  autofocus
                    class="input-box mt-1.5 w-full 
                    @error('current_password') border-red-500 ring-1 ring-red-500 @enderror 
                    " placeholder="********">

                @error('current_password')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            {{-- New pwd --}}
            <div>
                <label for="newpwd" class="block text-sm font-medium text-stone-700">စကားဝှက်အသစ်</label>
                <input type="password" name="new_password" id="newpwd"
                    class="input-box mt-1.5 w-full @error('new_password') border-red-500 ring-1 ring-red-500 @enderror"
                    placeholder="********">

                @error('new_password')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            {{-- Confirm pwd --}}
            <div>
                <label for="confirmpwd" class="block text-sm font-medium text-stone-700">စကားဝှက်အသစ်အတည်ပြုပါ</label>
                <input type="password" name="new_password_confirmation" id="confirmpwd"
                    class="input-box mt-1.5 w-full @error('new_password') border-red-500 ring-1 ring-red-500 @enderror"
                    placeholder="********">

                @error('new_password')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="pt-2">
                <button type="submit" class="btn-primary w-full py-2  bg-indigo-400 text-white rounded-lg hover:bg-indigo-500 transition shadow-md">
                    စကားဝှက်ပြောင်းရန်
                </button>
            </div>
        </form>
    </div>
</section>
@endsection
