@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">System Activity Logs</h1>
            <p class="text-slate-400 text-sm">Immutable audit trail of all administrative and critical user actions.</p>
        </div>
        <div class="flex items-center gap-3">
             <button class="bg-[#121212] border border-[#1f1f1f] px-4 py-2 rounded-xl text-sm font-medium hover:border-slate-700 transition-all flex items-center gap-2 text-slate-400">
                <i data-lucide="download" class="w-4 h-4"></i> Export CSV
            </button>
        </div>
    </div>

    <!-- Logs Table -->
    <div class="glass rounded-3xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-[#0c0c0c] text-slate-500 uppercase text-[10px] font-bold">
                    <tr>
                        <th class="px-6 py-4">Timestamp</th>
                        <th class="px-6 py-4">Actor</th>
                        <th class="px-6 py-4">Action</th>
                        <th class="px-6 py-4">Resource/Target</th>
                        <th class="px-6 py-4">IP Address</th>
                        <th class="px-6 py-4 text-right">Details</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1f1f1f]">
                    @forelse($logs as $log)
                    <tr class="hover:bg-white/[0.02] transition-colors group">
                        <td class="px-6 py-4 text-xs text-slate-500">{{ $log->created_at->format('d M Y, H:i:s') }}</td>
                        <td class="px-6 py-4">
                            <span class="font-bold {{ $log->user && $log->user->role == 'admin' ? 'text-purple-400' : 'text-blue-400' }}">
                                {{ $log->user->name ?? 'System' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs {{ $log->direction == 'in' ? 'bg-green-500/10 text-green-500 border-green-500/20' : 'bg-amber-500/10 text-amber-500 border-amber-500/20' }} px-2 py-0.5 rounded border font-bold uppercase">
                                {{ $log->type }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-400">{{ $log->description }}</td>
                        <td class="px-6 py-4 font-mono text-[10px] text-slate-500">-</td>
                        <td class="px-6 py-4 text-right">
                             <button class="text-slate-500 hover:text-white transition-all"><i data-lucide="info" class="w-4 h-4"></i></button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500 font-bold">No activity logs found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
