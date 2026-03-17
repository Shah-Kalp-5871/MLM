@extends('layouts.user')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-white tracking-tight">My Network</h1>
    <p class="text-xs text-gray-500 font-medium uppercase tracking-widest mt-1">View your downline team</p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
    <div class="glass-panel p-6 rounded-2xl">
        <i data-lucide="users" class="w-6 h-6 text-purple-400 mb-3"></i>
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Direct Referrals</p>
        <h3 class="text-xl font-black text-white">{{ number_format($direct_referrals_count) }}</h3>
    </div>
    <div class="glass-panel p-6 rounded-2xl">
        <i data-lucide="network" class="w-6 h-6 text-blue-400 mb-3"></i>
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Team Members</p>
        <h3 class="text-xl font-black text-white">{{ number_format($total_team_count) }}</h3>
    </div>
    <div class="glass-panel p-6 rounded-2xl">
        <i data-lucide="dollar-sign" class="w-6 h-6 text-emerald-400 mb-3"></i>
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Team Investment Volume</p>
        <h3 class="text-xl font-black text-white">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($team_investment_volume, 2) }}</h3>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Direct vs Team Explanation -->
    <div class="glass-panel rounded-2xl p-6 border border-white/10 flex flex-col justify-center">
        <h2 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Understanding Your Network</h2>
        
        <div class="mb-6">
            <h3 class="text-xs font-bold text-purple-400 uppercase tracking-widest mb-1">What is Direct Business?</h3>
            <p class="text-xs text-gray-400 mb-2">Total deposits made by users you directly referred.</p>
            <div class="bg-black/30 p-3 rounded-xl border border-white/5 font-mono text-[10px] text-gray-300">
                You referred:<br>
                A → $2000<br>
                B → $1500<br>
                C → $1500<br>
                <div class="mt-1 text-purple-400 font-bold">Direct Business = $5000</div>
            </div>
        </div>

        <div>
            <h3 class="text-xs font-bold text-blue-400 uppercase tracking-widest mb-1">What is Team Business?</h3>
            <p class="text-xs text-gray-400 mb-2">Total deposits from your entire referral network (all levels).</p>
            <div class="bg-black/30 p-3 rounded-xl border border-white/5 font-mono text-[10px] text-gray-300">
                You<br>
                ├ A ($500)<br>
                │ └ C ($500)<br>
                └ B ($500)<br>
                <div class="mt-1 text-blue-400 font-bold">Team Business = $1500 (A+B+C)</div>
            </div>
        </div>
    </div>

    <!-- Breadcrumb Navigation for Tree -->
    <div class="col-span-full mb-4">
        <div class="glass-panel p-4 rounded-xl flex items-center gap-2 text-sm">
            @foreach($breadcrumbs as $crumb)
                <a href="{{ route('network.index', ['parent_id' => $crumb->id]) }}" class="text-purple-400 hover:text-purple-300 font-bold transition-colors">
                    {{ $crumb->id === auth()->id() ? 'My Network' : $crumb->name }}
                </a>
                <i data-lucide="chevron-right" class="w-4 h-4 text-gray-600"></i>
            @endforeach
            <span class="text-gray-400 font-bold">{{ $targetUser->id === auth()->id() ? 'My Network' : $targetUser->name . "'s Team" }}</span>
            
            @if($targetUser->id !== auth()->id())
                <a href="{{ route('network.index', ['parent_id' => $targetUser->upline_id]) }}" class="ml-auto flex items-center gap-1 text-[10px] uppercase font-bold tracking-widest bg-white/5 hover:bg-white/10 px-3 py-1.5 rounded-full transition-colors text-white">
                    <i data-lucide="arrow-left" class="w-3 h-3"></i> Back Up
                </a>
            @endif
        </div>
    </div>
</div>

<div class="glass-panel rounded-2xl overflow-hidden shadow-2xl">
    <div class="p-6 border-b border-white/5 bg-white/[0.02] flex items-center justify-between">
        <h2 class="text-sm font-bold text-white uppercase tracking-wider">
            @if($targetUser->id === auth()->id())
                Your Direct Referrals
            @else
                {{ $targetUser->name }}'s Direct Referrals
            @endif
        </h2>
        <span class="text-xs text-gray-500 font-mono">{{ $directReferrals->total() }} members</span>
    </div>
    
    <div class="table-wrapper p-4">
        <table>
            <thead>
                <tr>
                    <th>Member Name</th>
                    <th>Email</th>
                    <th>Join Date</th>
                    <th>Total Investment</th>
                    <th>Team Size</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($directReferrals as $member)
                <tr class="group hover:bg-white/[0.02] transition-colors">
                    <td class="font-bold text-white flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-500/20 to-indigo-500/20 border border-white/5 text-purple-400 flex items-center justify-center text-xs shadow-inner">
                            {{ substr($member->name, 0, 1) }}
                        </div>
                        <div>
                            {{ $member->name }}
                            @if($member->investments->sum('amount') > 0)
                                <span class="ml-2 w-2 h-2 rounded-full bg-emerald-500 inline-block" title="Active Investor"></span>
                            @endif
                        </div>
                    </td>
                    <td class="text-gray-400 text-xs">{{ $member->email }}</td>
                    <td class="text-xs text-gray-500">{{ $member->created_at->format('M d, Y') }}<br><span class="text-[9px] uppercase tracking-widest">{{ $member->created_at->diffForHumans() }}</span></td>
                    <td class="font-mono text-emerald-400 font-bold tracking-tight">
                        {{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($member->investments->sum('amount'), 2) }}
                    </td>
                    <td class="text-center">
                        <span class="px-2 py-1 bg-white/5 rounded-md text-xs font-mono text-gray-300 border border-white/5">
                            {{ $member->referrals()->count() }} direct
                        </span>
                    </td>
                    <td class="text-right">
                        @if($member->referrals()->count() > 0)
                        <a href="{{ route('network.index', ['parent_id' => $member->id]) }}" class="inline-flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest bg-purple-500/10 hover:bg-purple-500/20 text-purple-400 border border-purple-500/20 px-4 py-2 rounded-xl transition-all group-hover:shadow-lg group-hover:shadow-purple-500/10">
                            View Team <i data-lucide="chevron-right" class="w-3 h-3"></i>
                        </a>
                        @else
                        <span class="text-[10px] font-bold uppercase tracking-widest text-slate-600">No Team</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-12">
                        <div class="mx-auto w-16 h-16 rounded-full bg-white/5 flex items-center justify-center mb-4 text-slate-500">
                            <i data-lucide="users-round" class="w-8 h-8"></i>
                        </div>
                        <p class="text-slate-400 text-sm">No referrals found for this level.</p>
                        @if($targetUser->id === auth()->id())
                            <p class="text-xs text-slate-500 mt-2">Share your referral link to build your team!</p>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($directReferrals->hasPages())
    <div class="p-4 border-t border-white/5 flex justify-center bg-white/[0.01]">
        {{ $directReferrals->links() }}
    </div>
    @endif
</div>

@endsection
