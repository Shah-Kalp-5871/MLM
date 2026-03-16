@extends('layouts.auth')
@section('content')
<div class="glass-panel mx-auto w-full max-w-[400px] p-10 rounded-[2rem] shadow-2xl relative overflow-hidden group">
    <!-- Decor -->
    <div class="absolute -top-24 -right-24 w-48 h-48 bg-purple-600/10 rounded-full blur-3xl group-hover:bg-purple-600/20 transition-all duration-700"></div>
    
    <div class="mb-10 text-center relative z-10">
        <div class="w-14 h-14 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-purple-500/20 mx-auto mb-6">
            <i data-lucide="zap" class="w-8 h-8 text-white"></i>
        </div>
        <h1 class="text-2xl font-black text-white tracking-tight uppercase">Welcome Back</h1>
        <p class="text-xs text-gray-500 font-medium uppercase tracking-widest mt-2">Login to manage your earnings</p>
    </div>

    <form action="{{ route('login') }}" method="POST" class="relative z-10">
        @csrf
        <div class="space-y-5 mb-8">
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Email Address</label>
                <div class="relative">
                    <i data-lucide="mail" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500"></i>
                    <input type="email" name="email" class="auth-input w-full pl-12 pr-4 py-3.5 rounded-xl text-sm" placeholder="name@company.com" required>
                </div>
                @error('email')
                    <span class="text-rose-500 text-[10px] mt-1 ml-1">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Password</label>
                <div class="relative">
                    <i data-lucide="lock" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500"></i>
                    <input type="password" name="password" class="auth-input w-full pl-12 pr-4 py-3.5 rounded-xl text-sm" placeholder="••••••••" required>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between mb-8 px-1">
            <label class="flex items-center gap-2 cursor-pointer group/check">
                <input type="checkbox" class="w-4 h-4 rounded border-white/10 bg-white/5 text-purple-600 focus:ring-purple-500 transition-all cursor-pointer">
                <span class="text-[11px] text-gray-500 font-semibold uppercase tracking-wider group-hover/check:text-gray-300">Remember</span>
            </label>
            <a href="#" class="text-[11px] text-purple-400 font-bold uppercase tracking-wider hover:text-white transition-colors">Forgot Password?</a>
        </div>

        <button type="submit" class="w-full py-4 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white text-[11px] font-black uppercase tracking-[0.2em] transition-all shadow-xl shadow-purple-900/40 flex items-center justify-center gap-3">
            Sign In <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </button>
    </form>

    <div class="mt-10 pt-8 border-t border-white/5 text-center relative z-10">
        <p class="text-[11px] text-gray-500 font-semibold uppercase tracking-widest">
            New here? <a href="{{ route('register') }}" class="text-purple-400 font-black hover:text-white transition-colors ml-1 underline decoration-2 underline-offset-4">Create Account</a>
        </p>
    </div>
</div>

@endsection
