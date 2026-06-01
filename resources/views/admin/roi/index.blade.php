@extends('layouts.admin')

@section('content')
<div class="space-y-10">
    @if(session('success'))
        <div class="glass p-4 rounded-xl border-l-4 border-green-500 text-green-500 text-sm font-bold flex items-center gap-3 animate-pulse">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="glass p-4 rounded-xl border-l-4 border-red-500 text-red-500 text-sm font-bold flex items-center gap-3">
            <i data-lucide="alert-circle" class="w-5 h-5"></i>
            {{ session('error') }}
        </div>
    @endif

    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">ROI Engine Control</h1>
            <p class="text-slate-400 text-sm">Automate and monitor weekly profit distribution.</p>
        </div>
        <div class="flex items-center gap-3">
             @if($executable_count > 0)
            <form id="executeRoiForm" action="{{ route('admin.roi.trigger') }}" method="POST" class="inline-block">
                @csrf
                <button type="button" onclick="confirmExecuteRoi()" class="group px-6 py-3 rounded-2xl bg-purple-600/20 text-purple-300 font-bold uppercase tracking-widest text-xs hover:bg-purple-600 hover:text-white transition-all border border-purple-500/30 flex items-center gap-3 shadow-[0_0_15px_rgba(147,51,234,0.3)]">
                    <i data-lucide="play" class="w-4 h-4 text-purple-400 group-hover:text-white"></i>
                    Execute {{ $executable_count }} Payout{{ $executable_count > 1 ? 's' : '' }}
                </button>
            </form>
        @else
            <button type="button" disabled class="group px-6 py-3 rounded-2xl bg-gray-500/10 text-gray-500 font-bold uppercase tracking-widest text-xs border border-gray-500/20 flex items-center gap-3 cursor-not-allowed">
                <i data-lucide="check-circle" class="w-4 h-4"></i>
                Caught Up (Pending: 0)
            </button>
        @endif
        </div>
    </div>

    <!-- ROI Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="glass p-6 rounded-2xl border-l-4 border-purple-600">
            <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Next Payout (Monday)</h4>
            <div class="flex items-end justify-between">
                <span class="text-2xl font-bold">{{ $next_payout }}</span>
                <span class="text-[10px] text-purple-400 font-bold uppercase tracking-widest">In {{ $days_left }} days</span>
            </div>
            <p class="text-[10px] text-slate-600 mt-2 font-medium">📅 All payouts are processed every Monday night</p>
        </div>
        <div class="glass p-6 rounded-2xl border-l-4 border-blue-600">
            <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Eligible Amount</h4>
            <div class="flex items-end justify-between">
                <span class="text-2xl font-bold text-blue-400">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($eligible_amount, 2) }}</span>
                <span class="text-[10px] text-blue-400 font-bold uppercase tracking-widest">{{ $total_investments }} Active Assets</span>
            </div>
        </div>
        <div class="glass p-6 rounded-2xl border-l-4 border-green-600">
            <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Engine Status</h4>
            <div class="flex items-end justify-between">
                <span class="text-2xl font-bold text-green-500">READY</span>
                <span class="text-[10px] text-amber-400 font-bold uppercase tracking-widest">Manual · Every Monday</span>
            </div>
        </div>
    </div>

    <!-- ROI History -->
    <div class="glass rounded-3xl overflow-hidden">
        <div class="p-6 border-b border-[#1f1f1f] flex items-center justify-between">
            <h3 class="font-bold flex items-center gap-2">
                <i data-lucide="history" class="w-4 h-4 text-slate-500"></i>
                Distribution Logs
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-[#0c0c0c] text-slate-500 uppercase text-[10px] font-bold">
                    <tr>
                        <th class="px-6 py-4">Batch ID</th>
                        <th class="px-6 py-4">Execution Date</th>
                        <th class="px-6 py-4">Total Distributed</th>
                        <th class="px-6 py-4">Accounts Paid</th>
                        <th class="px-6 py-4">Level Commission Triggered</th>
                        <th class="px-6 py-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1f1f1f]">
                    @forelse($roi_history as $inc)
                    <tr>
                        <td class="px-6 py-4 font-mono text-xs text-purple-400">#ROI-{{ $inc->id }}</td>
                        <td class="px-6 py-4 text-slate-400">{{ $inc->distributed_at ? \Carbon\Carbon::parse($inc->distributed_at)->format('d M Y, h:i A') : 'N/A' }}</td>
                        <td class="px-6 py-4 font-bold text-green-400">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($inc->roi_amount, 2) }}</td>
                        <td class="px-6 py-4">{{ $inc->investment?->user?->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-blue-400 font-bold">INV-{{ $inc->investment_id }}</td>
                        <td class="px-6 py-4">
                            <span class="badge-active text-[10px] px-2 py-0.5 rounded-full uppercase font-bold">Completed</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-6 py-12 text-center text-slate-500 italic">No ROI records found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-[#1f1f1f]">
            {{ $roi_history->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmExecuteRoi() {
        Swal.fire({
            title: 'Distribute ROI?',
            html: "You are about to distribute <strong style='color:#a855f7'>{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($executable_amount, 2) }}</strong> across <strong>{{ $executable_count }} active asset(s)</strong>.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#9333ea',
            cancelButtonColor: '#475569',
            confirmButtonText: 'Yes, Execute Now!',
            cancelButtonText: 'Cancel',
            background: '#0a0b14',
            color: '#fff'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show a loading state
                Swal.fire({
                    title: 'Executing...',
                    text: 'Please wait while the ROI is distributed.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    },
                    background: '#0a0b14',
                    color: '#fff'
                });
                document.getElementById('executeRoiForm').submit();
            }
        });
    }
</script>
@endpush

