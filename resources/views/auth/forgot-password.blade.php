@extends('layouts.layout')
@section('title', 'Forgot Password')
@section('content')
<div class="relative flex flex-col items-center justify-center min-h-screen">
    <div class="w-full max-w-sm space-y-10 p-6 z-10">
            <form method="POST" action="{{ route('user.forgot-password') }}" class="space-y-6">
                @csrf

                {{-- phone --}}
                <div>
                    <label for="phone" class="block text-sm font-medium text-stone-700">ဖုန်းနံပါတ်</label>
                    <input id="phone" type="text" class="input-box mt-1.5 w-full @error('phone') border-red-500 ring-1 ring-red-500 @enderror" 
                        name="phone" value="{{ old('phone') }}" placeholder="09XXXXXXXXX" required autofocus>
                    
                    @error('phone')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- date of birth --}}
                <div>
                    <label for="dateOfBirth" class="block text-sm font-medium text-stone-700">မွေးသက္ကရာဇ်</label>
                    <input id="dateOfBirth" type="date" 
                        class="input-box mt-1.5 w-full @error('DOB') border-red-500 ring-1 ring-red-500 @enderror" 
                        name="DOB" required>
                    
                    @error('DOB')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" 
                        class="btn-primary w-full py-2  bg-indigo-400 text-white rounded-lg
                         hover:bg-indigo-500 transition shadow-md">
                    ဆက်သွားပါ
                </button>
                <a href="{{ route('user.login') }}" 
                    class="block text-center mt-4 text-sm text-stone-500 hover:text-stone-800">
                    ← နောက်သို့
                </a>
            </form>
    </div>
</div>
 <!--login css-->
@endsection