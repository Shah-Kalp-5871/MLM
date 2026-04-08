@extends('layouts.auth')
@section('content')
<div class="glass-panel mx-auto w-full max-w-[400px] p-10 rounded-[2rem] shadow-2xl relative overflow-hidden group">
    <!-- Decor -->
    <div class="absolute -top-24 -right-24 w-48 h-48 bg-purple-600/10 rounded-full blur-3xl group-hover:bg-purple-600/20 transition-all duration-700"></div>
    
    <div class="mb-10 text-center relative z-10">
        <img src="{{ asset('storage/logo.png') }}" alt="Logo" class="w-14 h-14 object-contain mx-auto mb-6 drop-shadow-2xl">
        <h1 class="text-2xl font-black text-white tracking-tight uppercase">Reset Password</h1>
        <p class="text-xs text-gray-400 font-medium uppercase tracking-widest mt-2 px-4">Enter your email to receive a password reset link</p>
    </div>

    @if (session('status'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-bold text-center uppercase tracking-wider">
            {{ session('status') }}
        </div>
    @endif

    <form action="{{ route('password.email') }}" method="POST" class="relative z-10">
        @csrf
        <div class="space-y-5 mb-8">
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Email Address</label>
                <div class="relative">
                    <i data-lucide="mail" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500"></i>
                    <input type="email" name="email" class="auth-input w-full pl-12 pr-4 py-3.5 rounded-xl text-sm" placeholder="name@elitematrixpro.com" required>
                </div>
                @error('email')
                    <span class="text-rose-500 text-[10px] mt-1 ml-1">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <button type="submit" class="w-full py-4 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white text-[11px] font-black uppercase tracking-[0.2em] transition-all shadow-xl shadow-purple-900/40 flex items-center justify-center gap-3">
            Send Reset Link <i data-lucide="send" class="w-4 h-4"></i>
        </button>
    </form>

    <div class="mt-10 pt-8 border-t border-white/5 text-center relative z-10">
        <p class="text-[11px] text-gray-500 font-semibold uppercase tracking-widest">
            Remember Password? <a href="{{ route('login') }}" class="text-purple-400 font-black hover:text-white transition-colors ml-1 underline decoration-2 underline-offset-4">Sign In</a>
        </p>
    </div>
</div>
@endsection
