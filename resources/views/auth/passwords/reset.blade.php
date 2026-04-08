@extends('layouts.auth')
@section('content')
<div class="glass-panel mx-auto w-full max-w-[400px] p-10 rounded-[2rem] shadow-2xl relative overflow-hidden group">
    <!-- Decor -->
    <div class="absolute -top-24 -right-24 w-48 h-48 bg-purple-600/10 rounded-full blur-3xl group-hover:bg-purple-600/20 transition-all duration-700"></div>
    
    <div class="mb-10 text-center relative z-10">
        <img src="{{ asset('storage/logo.png') }}" alt="Logo" class="w-14 h-14 object-contain mx-auto mb-6 drop-shadow-2xl">
        <h1 class="text-2xl font-black text-white tracking-tight uppercase">Set New Password</h1>
        <p class="text-xs text-gray-400 font-medium uppercase tracking-widest mt-2">Enter your new credentials below</p>
    </div>

    <form action="{{ route('password.update') }}" method="POST" class="relative z-10">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        
        <div class="space-y-5 mb-8">
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Email Address</label>
                <div class="relative">
                    <i data-lucide="mail" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500"></i>
                    <input type="email" name="email" value="{{ $email ?? old('email') }}" class="auth-input w-full pl-12 pr-4 py-3.5 rounded-xl text-sm" placeholder="name@elitematrixpro.com" required readonly>
                </div>
                @error('email')
                    <span class="text-rose-500 text-[10px] mt-1 ml-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">New Password</label>
                <div class="relative">
                    <i data-lucide="lock" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500"></i>
                    <input type="password" name="password" id="password" class="auth-input w-full pl-12 pr-12 py-3.5 rounded-xl text-sm" placeholder="••••••••" required>
                    <button type="button" onclick="togglePassword('password', 'eye-icon')" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 hover:text-purple-400 transition-colors">
                        <i data-lucide="eye" id="eye-icon" class="w-4 h-4"></i>
                    </button>
                </div>
                @error('password')
                    <span class="text-rose-500 text-[10px] mt-1 ml-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Confirm Password</label>
                <div class="relative">
                    <i data-lucide="shield-check" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500"></i>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="auth-input w-full pl-12 pr-12 py-3.5 rounded-xl text-sm" placeholder="••••••••" required>
                </div>
            </div>
        </div>

        <button type="submit" class="w-full py-4 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-[11px] font-black uppercase tracking-[0.2em] transition-all shadow-xl shadow-emerald-900/40 flex items-center justify-center gap-3">
            Update Password <i data-lucide="check-circle" class="w-4 h-4"></i>
        </button>
    </form>
</div>
@endsection
