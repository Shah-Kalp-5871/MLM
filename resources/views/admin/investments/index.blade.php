@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Investment Management</h1>
            <p class="text-slate-400 text-sm">Monitor all active and historical investments across the platform.</p>
        </div>
        <div class="flex items-center gap-3">
             <div class="relative">
                <i data-lucide="search" class="w-4 h-4 text-muted absolute left-3 top-1/2 -translate-y-1/2"></i>
                <input type="text" placeholder="Search investments..." class="bg-[#121212] border border-[#1f1f1f] rounded-xl pl-10 pr-4 py-2 text-sm w-64 focus:outline-none focus:border-purple-600 transition-all text-muted">
            </div>
        </div>
    </div>

    <!-- Investments Table -->
    <div class="glass rounded-3xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-[#0c0c0c] text-slate-500 uppercase text-[10px] font-bold">
                    <tr>
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">ROI %</th>
                        <th class="px-6 py-4">Amount</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1f1f1f]">
                    @forelse($investments as $inv)
                    <tr class="hover:bg-white/[0.02] transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="font-bold text-slate-200">{{ $inv->user->name ?? 'Deleted User' }}</span>
                                <span class="text-[10px] text-slate-500 italic">{{ $inv->user->email ?? '' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-purple-500 shadow-[0_0_10px_rgba(168,85,247,0.5)]"></span>
                                <span class="text-slate-300 font-medium">{{ $inv->weekly_roi_percentage }}%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-mono font-bold text-emerald-400">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($inv->amount, 2) }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="badge-{{ $inv->status == 'active' ? 'active' : 'pending' }} text-[10px] px-2 py-0.5 rounded-full uppercase font-bold">
                                {{ $inv->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-500 text-xs">
                            {{ $inv->created_at->format('d M Y') }}
                            <div class="text-[9px] text-slate-600">{{ $inv->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.users.show', $inv->user_id ?? 0) }}" class="text-purple-500 hover:text-white transition-colors">
                                <i data-lucide="external-link" class="w-4 h-4"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500 italic">No investments found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($investments->hasPages())
        <div class="p-6 border-t border-[#1f1f1f]">
            {{ $investments->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

