@extends('layouts.user')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-white tracking-tight">My Earnings</h1>
    <p class="text-xs text-gray-500 font-medium uppercase tracking-widest mt-1">ROI and Referral Income</p>
</div>

<!-- Earning Concepts -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="glass-panel p-5 rounded-2xl border border-emerald-500/20">
        <h3 class="text-xs font-bold text-emerald-400 uppercase tracking-widest mb-2">Passive ROI Income</h3>
        <p class="text-xs text-gray-400 leading-relaxed">
            ROI (Return on Investment) is profit generated automatically from your own active packages. 
            Paid <span class="text-white font-bold">weekly (3% – 3.5%)</span> directly into your wallet.
        </p>
    </div>
    <div class="glass-panel p-5 rounded-2xl border border-purple-500/20">
        <h3 class="text-xs font-bold text-purple-400 uppercase tracking-widest mb-2">Network Level Income</h3>
        <p class="text-xs text-gray-400 leading-relaxed">
            Earned when someone in your 15-level network receives their ROI. 
            You receive a <span class="text-white font-bold">percentage (up to 20%)</span> of their weekly profit.
        </p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <p class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest mb-1">ROI Income</p>
        <h3 class="text-3xl font-black text-white">₹{{ number_format($totalROI, 2) }}</h3>
        <p class="text-[10px] text-gray-500 mt-2">Returns from active investments</p>
    </div>
    <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group border border-purple-500/30">
        <div class="absolute inset-0 bg-gradient-to-r from-purple-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <p class="text-[10px] font-bold text-purple-400 uppercase tracking-widest mb-1">Level Income</p>
        <h3 class="text-3xl font-black text-white">₹{{ number_format($totalLevelIncome, 2) }}</h3>
        <p class="text-[10px] text-gray-500 mt-2">Commissions from network ROI</p>
    </div>
    <div class="glass-panel p-6 rounded-2xl bg-[#0a0f18] border border-blue-500/20 shadow-[0_0_30px_rgba(59,130,246,0.1)]">
        <p class="text-[10px] font-bold text-blue-400 uppercase tracking-widest mb-1">Total Earnings</p>
        <h3 class="text-3xl font-black text-white">₹{{ number_format($totalEarnings, 2) }}</h3>
        <p class="text-[10px] text-gray-500 mt-2">Historical Total</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
    <!-- ROI Table -->
    <div class="glass-panel rounded-2xl overflow-hidden flex flex-col">
        <div class="p-5 border-b border-white/5 bg-white/[0.02]">
            <h2 class="text-sm font-bold text-white uppercase tracking-wider"><i data-lucide="bar-chart" class="w-4 h-4 inline-block -mt-1 text-emerald-400 mr-2"></i> ROI History</h2>
        </div>
        <div class="table-wrapper flex-1 p-4">
            <table>
                <thead>
                    <tr>
                        <th>Week</th>
                        <th>ROI %</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roiRecords as $roi)
                    <tr>
                        <td>Week {{ $roi->week_number }}</td>
                        <td>{{ $roi->roi_percentage }}%</td>
                        <td class="text-emerald-400 font-bold">+₹{{ number_format($roi->roi_amount, 2) }}</td>
                        <td class="text-xs text-gray-400">{{ $roi->distributed_at ? $roi->distributed_at->format('d M Y') : 'N/A' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-500 italic text-xs">No ROI records yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3 border-t border-white/5 flex justify-center bg-white/[0.01]">
            {{ $roiRecords->links() }}
        </div>
    </div>

    <!-- Level Income Table -->
    <div class="glass-panel rounded-2xl overflow-hidden flex flex-col">
        <div class="p-5 border-b border-white/5 bg-white/[0.02]">
            <h2 class="text-sm font-bold text-white uppercase tracking-wider"><i data-lucide="users" class="w-4 h-4 inline-block -mt-1 text-purple-400 mr-2"></i> Level Commissions</h2>
        </div>
        <div class="table-wrapper flex-1 p-4">
            <table>
                <thead>
                    <tr>
                        <th>From User</th>
                        <th>Level</th>
                        <th>Commission</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($levelCommissions as $commission)
                    <tr>
                        <td class="font-bold text-white">{{ $commission->fromUser->name ?? 'System' }}</td>
                        <td><span class="px-2 py-1 bg-white/10 rounded text-[10px] font-bold uppercase text-purple-400">Level {{ $commission->level }}</span></td>
                        <td class="text-emerald-400 font-bold">+₹{{ number_format($commission->amount, 2) }}</td>
                        <td class="text-xs text-gray-400">{{ $commission->created_at ? \Carbon\Carbon::parse($commission->created_at)->format('d M Y') : 'N/A' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-500 italic text-xs">No commissions yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3 border-t border-white/5 flex justify-center bg-white/[0.01]">
            {{ $levelCommissions->links() }}
        </div>
    </div>
</div>
@endsection