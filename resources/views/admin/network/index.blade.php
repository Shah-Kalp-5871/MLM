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

    <!-- Network Tree Visualization -->
    <div class="glass rounded-3xl p-10 min-h-[600px] flex flex-col items-center justify-start relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(#1f1f1f_1px,transparent_1px)] [background-size:20px_20px] opacity-20"></div>
        
        @forelse($rootUsers as $root)
        <div class="w-full flex flex-col items-center mb-20 last:mb-0">
            <!-- Root Node -->
            <div class="relative z-10 flex flex-col items-center gap-2 mb-16">
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center text-xl font-black shadow-2xl shadow-purple-600/30 border-2 border-white/10 uppercase">
                    {{ strtoupper(substr($root->name, 0, 1)) }}{{ strtoupper(substr(strrchr($root->name, " "), 1, 1)) ?: '' }}
                </div>
                <div class="text-center">
                    <p class="font-bold text-slate-100">{{ $root->name }}</p>
                    <p class="text-[10px] text-slate-500 font-bold tracking-widest uppercase">{{ $root->upline_id ? 'Node' : 'Root Node' }} ({{ $root->referral_code }})</p>
                </div>
                
                @if($root->referrals->count() > 0)
                <!-- Lines -->
                <div class="absolute top-full left-1/2 w-0.5 h-16 bg-gradient-to-b from-purple-500 to-transparent"></div>
                @endif
            </div>

            <!-- Children Level 1 -->
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-8 relative z-10 w-full px-4">
                @foreach($root->referrals as $child)
                <a href="{{ route('admin.users.show', $child->id) }}" class="flex flex-col items-center gap-2 group cursor-pointer transition-all">
                    <div class="w-14 h-14 rounded-xl glass border border-slate-700 flex items-center justify-center font-bold text-slate-300 group-hover:border-purple-500 group-hover:shadow-lg group-hover:shadow-purple-500/20 transition-all uppercase">
                        {{ strtoupper(substr($child->name, 0, 1)) }}{{ strtoupper(substr(strrchr($child->name, " "), 1, 1)) ?: '' }}
                    </div>
                    <p class="text-[10px] font-semibold text-slate-400 group-hover:text-white transition-all">{{ $child->name }}</p>
                    <span class="text-[8px] bg-slate-800 text-slate-500 px-1.5 py-0.5 rounded uppercase font-bold">{{ $child->referrals()->count() }} Downlines</span>
                </a>
                @endforeach
            </div>
        </div>
        @empty
        <div class="flex flex-col items-center justify-center py-20">
            <i data-lucide="network" class="w-16 h-16 text-slate-600 mb-4"></i>
            <p class="text-slate-400 font-bold">No root users found in the system.</p>
        </div>
        @endforelse

        <div class="mt-20">
             <button class="bg-[#121212] border border-[#1f1f1f] px-6 py-2 rounded-xl text-xs font-bold text-slate-500 hover:text-white transition-all">Traverse Deeper Levels...</button>
        </div>
    </div>
    </div>
</div>
@endsection