@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black uppercase tracking-tighter">Network Explorer</h1>
            <p class="text-slate-500 text-sm italic">Direct visualization of the MLM referral hierarchy.</p>
        </div>
        <form action="{{ route('admin.network.index') }}" method="GET" class="flex items-center gap-3">
            <div class="relative">
                <i data-lucide="search" class="w-4 h-4 text-slate-500 absolute left-3 top-1/2 -translate-y-1/2"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search User ID or Email..." class="bg-[#121212] border border-[#1f1f1f] rounded-xl pl-10 pr-4 py-2 text-sm w-72 focus:outline-none focus:border-purple-600 transition-all text-slate-300">
            </div>
            <button type="submit" class="bg-purple-600 px-6 py-2 rounded-xl text-sm font-black uppercase tracking-widest text-white shadow-lg shadow-purple-600/20">Find Node</button>
        </form>
    </div>

    <!-- Tree Viewer -->
    <div class="glass p-12 rounded-[2rem] border border-white/5 min-h-[600px] flex flex-col items-center">
        @if($rootUser)
            <div class="space-y-12 w-full max-w-4xl">
                <!-- Root Node -->
                <div class="flex flex-col items-center relative after:absolute after:top-full after:left-1/2 after:w-px after:h-12 after:bg-[#1f1f1f]">
                    <div class="glass p-6 rounded-3xl border border-purple-600/30 bg-purple-600/5 flex flex-col items-center min-w-[200px] shadow-2xl">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-slate-800 to-slate-900 border border-[#1f1f1f] flex items-center justify-center font-black text-purple-400 mb-2">
                            {{ strtoupper(substr($rootUser->name, 0, 1)) }}
                        </div>
                        <h3 class="font-black text-white">{{ $rootUser->name }}</h3>
                        <p class="text-[10px] text-slate-500 font-bold uppercase">{{ $rootUser->referral_code }}</p>
                        <a href="{{ route('admin.users.show', $rootUser->id) }}" class="mt-3 text-[10px] font-black text-purple-400 uppercase tracking-widest hover:underline">View Profile</a>
                    </div>
                </div>

                <!-- Children Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 pt-4">
                    @forelse($rootUser->referrals as $child)
                    <div class="flex flex-col items-center relative before:absolute before:bottom-full before:left-1/2 before:w-px before:h-8 before:bg-[#1f1f1f] {{ $loop->first ? 'after:absolute after:top-[-32px] after:left-1/2 after:right-0 after:h-px after:bg-[#1f1f1f]' : '' }} {{ $loop->last ? 'after:absolute after:top-[-32px] after:left-0 after:right-1/2 after:h-px after:bg-[#1f1f1f]' : '' }} {{ !$loop->first && !$loop->last ? 'after:absolute after:top-[-32px] after:left-0 after:right-0 after:h-px after:bg-[#1f1f1f]' : '' }}">
                        <div class="glass p-4 rounded-2xl border border-white/5 bg-white/[0.01] flex flex-col items-center min-w-[180px] hover:border-blue-500/30 transition-all cursor-pointer group">
                             <div class="w-10 h-10 rounded-xl bg-slate-900 border border-[#1f1f1f] flex items-center justify-center font-bold text-slate-500 group-hover:text-blue-400 transition-colors">
                                {{ strtoupper(substr($child->name, 0, 1)) }}
                            </div>
                            <h4 class="font-bold text-sm text-slate-300 mt-2 truncate w-full text-center">{{ $child->name }}</h4>
                            <p class="text-[9px] text-slate-500 font-bold uppercase">{{ $child->referral_code }}</p>
                            <div class="mt-2 flex items-center gap-2">
                                <span class="text-[8px] bg-slate-800 px-2 py-0.5 rounded uppercase font-bold text-slate-400">Team: {{ $child->mlmDescendants()->count() }}</span>
                                <a href="{{ route('admin.network.index', ['search' => $child->email]) }}" class="text-[14px] text-slate-600 hover:text-blue-400">
                                    <i data-lucide="external-link" class="w-3 h-3"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center text-slate-600 italic py-12">
                        No direct referrals found for this node.
                    </div>
                    @endforelse
                </div>
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-20 text-center space-y-4">
                <div class="w-20 h-20 rounded-full bg-slate-900 flex items-center justify-center text-slate-600 border border-[#1f1f1f]">
                    <i data-lucide="users" class="w-10 h-10"></i>
                </div>
                <div>
                    <h3 class="text-xl font-black text-slate-300">No User Found</h3>
                    <p class="text-slate-500 text-sm">Enter a user's email or referral code above to start exploring.</p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
