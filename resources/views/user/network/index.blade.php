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
        <h3 class="text-xl font-black text-white">₹{{ number_format($team_investment_volume, 2) }}</h3>
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

    <!-- Tree Structure -->
    <div class="glass-panel rounded-2xl p-6 border border-white/10">
        <h2 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4">Live Network Tree</h2>
        <div class="bg-[#0f111a] p-6 rounded-xl border border-white/5 font-mono text-xs leading-8 text-gray-300 overflow-x-auto h-[320px] overflow-y-auto">
            <div class="text-purple-400 font-bold mb-2">You ({{ auth()->user()->name }})</div>
            <div class="ml-4 border-l border-white/10 pl-4 py-1">
                @forelse(auth()->user()->referrals as $child)
                <div class="text-white relative">
                    <span class="absolute -left-5 top-4 w-4 border-t border-white/10"></span> 
                    {{ $loop->last ? '└' : '├' }} {{ $child->name }} 
                    <span class="text-emerald-400 text-[10px]">(₹{{ number_format($child->investments->sum('amount'), 2) }})</span> 
                    <span class="text-gray-500 text-[10px]">Direct</span>
                </div>
                @if($child->referrals->count() > 0)
                <div class="ml-4 border-l border-white/10 pl-4 py-1">
                    @foreach($child->referrals->take(3) as $grandchild)
                    <div class="text-gray-400 relative">
                        <span class="absolute -left-5 top-4 w-4 border-t border-white/10"></span> 
                        {{ $loop->last ? '└' : '├' }} {{ $grandchild->name }} 
                        <span class="text-emerald-400 text-[10px]">(₹{{ number_format($grandchild->investments->sum('amount'), 2) }})</span> 
                        <span class="text-gray-500 text-[10px]">Level 2</span>
                    </div>
                    @endforeach
                    @if($child->referrals->count() > 3)
                    <div class="text-gray-600 italic text-[10px] ml-4">... and {{ $child->referrals->count() - 3 }} more</div>
                    @endif
                </div>
                @endif
                @empty
                <div class="text-gray-600 italic">No direct referrals yet.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="glass-panel rounded-2xl overflow-hidden">
    <div class="p-6 border-b border-white/5 bg-white/[0.02]">
        <h2 class="text-sm font-bold text-white uppercase tracking-wider">Team Matrix List</h2>
    </div>
    <div class="table-wrapper p-4">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Level</th>
                    <th>Join Date</th>
                    <th>Investment</th>
                </tr>
            </thead>
            <tbody>
                @forelse($team as $node)
                <tr>
                    <td class="font-bold text-white flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-purple-500/20 text-purple-400 flex items-center justify-center text-xs">{{ substr($node->descendant->name, 0, 1) }}</div> {{ $node->descendant->name }}
                    </td>
                    <td><span class="px-2 py-1 bg-white/10 rounded text-[10px] font-bold uppercase">Level {{ $node->distance }}</span></td>
                    <td class="text-xs">{{ $node->descendant->created_at->format('d M Y') }}</td>
                    <td class="font-mono text-emerald-400">₹{{ number_format($node->descendant->investments->sum('amount'), 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-gray-500 italic">No team members found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-white/5 flex justify-center bg-white/[0.01]">
        {{ $team->links() }}
    </div>
</div>

@endsection