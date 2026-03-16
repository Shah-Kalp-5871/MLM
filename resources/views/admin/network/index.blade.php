@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Global Network Tree</h1>
            <p class="text-slate-400 text-sm">Visualize and traverse the entire NexaNet MLM hierarchy.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="relative">
                <i data-lucide="search" class="w-4 h-4 text-muted absolute left-3 top-1/2 -translate-y-1/2"></i>
                <input type="text" placeholder="Jump to user ID/Ref..." class="bg-[#121212] border border-[#1f1f1f] rounded-xl pl-10 pr-4 py-2 text-sm w-64 focus:outline-none focus:border-purple-600 transition-all text-muted">
            </div>
        </div>
    </div>

    <!-- Network Tree Visualization Stub -->
    <div class="glass rounded-3xl p-10 min-h-[600px] flex flex-col items-center justify-center relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(#1f1f1f_1px,transparent_1px)] [background-size:20px_20px] opacity-20"></div>
        
        <!-- Parent Node -->
        <div class="relative z-10 flex flex-col items-center gap-2 mb-16">
            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center text-xl font-black shadow-2xl shadow-purple-600/30 border-2 border-white/10">SA</div>
            <div class="text-center">
                <p class="font-bold text-slate-100">Super Admin</p>
                <p class="text-[10px] text-slate-500 font-bold tracking-widest uppercase">Root Node</p>
            </div>
            
            <!-- Lines -->
            <div class="absolute top-full left-1/2 w-0.5 h-16 bg-gradient-to-b from-purple-500 to-transparent"></div>
        </div>

        <!-- Children Level 1 -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-12 relative z-10 w-full max-w-4xl">
            <!-- Child 1 -->
            <div class="flex flex-col items-center gap-2 group cursor-pointer">
                <div class="w-14 h-14 rounded-xl glass border border-slate-700 flex items-center justify-center font-bold text-slate-300 group-hover:border-purple-500 transition-all">RK</div>
                <p class="text-xs font-semibold text-slate-400">Rahul Kumar</p>
                <span class="text-[8px] bg-slate-800 text-slate-500 px-1.5 py-0.5 rounded uppercase font-bold">128 Downlines</span>
            </div>
            <!-- Child 2 -->
            <div class="flex flex-col items-center gap-2 group cursor-pointer opacity-50 grayscale hover:grayscale-0 hover:opacity-100 transition-all">
                <div class="w-14 h-14 rounded-xl glass border border-slate-700 flex items-center justify-center font-bold text-slate-500">VP</div>
                <p class="text-xs font-semibold text-slate-400">Varun P.</p>
                <span class="text-[8px] bg-slate-800 text-slate-500 px-1.5 py-0.5 rounded uppercase font-bold">0 Downlines</span>
            </div>
             <!-- Child 3 -->
            <div class="flex flex-col items-center gap-2 group cursor-pointer">
                <div class="w-14 h-14 rounded-xl glass border border-slate-700 flex items-center justify-center font-bold text-slate-300 group-hover:border-purple-500 transition-all">SG</div>
                <p class="text-xs font-semibold text-slate-400">Sneha Gupta</p>
                <span class="text-[8px] bg-slate-800 text-slate-500 px-1.5 py-0.5 rounded uppercase font-bold">54 Downlines</span>
            </div>
             <!-- Child 4 -->
            <div class="flex flex-col items-center gap-2 group cursor-pointer">
                <div class="w-14 h-14 rounded-xl glass border border-slate-700 flex items-center justify-center font-bold text-slate-300 group-hover:border-purple-500 transition-all">MK</div>
                <p class="text-xs font-semibold text-slate-400">Mohan K.</p>
                <span class="text-[8px] bg-slate-800 text-slate-500 px-1.5 py-0.5 rounded uppercase font-bold">21 Downlines</span>
            </div>
        </div>

        <div class="mt-20">
             <button class="bg-[#121212] border border-[#1f1f1f] px-6 py-2 rounded-xl text-xs font-bold text-slate-500 hover:text-white transition-all">Load More Deep Levels...</button>
        </div>
    </div>
</div>
@endsection