@extends('layouts.auth')
@section('content')
<div class="glass-panel w-full max-w-[540px] p-10 rounded-[2rem] shadow-2xl relative overflow-hidden group">
    <!-- Decor -->
    <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-indigo-600/10 rounded-full blur-3xl group-hover:bg-indigo-600/20 transition-all duration-700"></div>
    
    <div class="mb-10 text-center relative z-10">
        <div class="w-14 h-14 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-purple-500/20 mx-auto mb-6">
            <i data-lucide="user-plus" class="w-8 h-8 text-white"></i>
        </div>
        <h1 class="text-2xl font-black text-white tracking-tight uppercase">Join the Network</h1>
        <p class="text-xs text-gray-500 font-medium uppercase tracking-widest mt-2">Create your account to start earning</p>
    </div>

    <form action="/auth/login" class="relative z-10">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-6">
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Full Name</label>
                <input type="text" class="auth-input w-full px-4 py-3.5 rounded-xl text-sm" placeholder="John Doe">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Phone Number</label>
                <input type="text" class="auth-input w-full px-4 py-3.5 rounded-xl text-sm" placeholder="+91 98765 43210">
            </div>
        </div>

        <div class="space-y-5 mb-8">
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Email Address</label>
                <input type="email" class="auth-input w-full px-4 py-3.5 rounded-xl text-sm" placeholder="name@company.com">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Referral Code (Optional)</label>
                <input type="text" class="auth-input w-full px-4 py-3.5 rounded-xl text-sm font-mono text-purple-300" placeholder="REF-XXXX-XXXX">
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Password</label>
                    <input type="password" class="auth-input w-full px-4 py-3.5 rounded-xl text-sm" placeholder="••••••••">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Confirm</label>
                    <input type="password" class="auth-input w-full px-4 py-3.5 rounded-xl text-sm" placeholder="••••••••">
                </div>
            </div>
        </div>

        <button type="submit" class="w-full py-4 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white text-[11px] font-black uppercase tracking-[0.2em] transition-all shadow-xl shadow-purple-900/40 flex items-center justify-center gap-3">
            Register Account <i data-lucide="sparkles" class="w-4 h-4"></i>
        </button>
    </form>

    <div class="mt-10 pt-8 border-t border-white/5 text-center relative z-10">
        <p class="text-[11px] text-gray-500 font-semibold uppercase tracking-widest">
            Already a member? <a href="/auth/login" class="text-purple-400 font-black hover:text-white transition-colors ml-1 underline decoration-2 underline-offset-4">Sign In</a>
        </p>
    </div>
</div>