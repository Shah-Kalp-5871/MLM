@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">User Management</h1>
            <p class="text-slate-400 text-sm">Monitor and manage all platform participants.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="relative">
                <i data-lucide="search" class="w-4 h-4 text-muted absolute left-3 top-1/2 -translate-y-1/2"></i>
                <input type="text" placeholder="Search by name, email, ref..." class="bg-[#121212] border border-[#1f1f1f] rounded-xl pl-10 pr-4 py-2 text-sm w-64 focus:outline-none focus:border-purple-600 transition-all text-muted">
            </div>
            <button class="bg-[#121212] border border-[#1f1f1f] px-4 py-2 rounded-xl text-sm font-medium hover:border-slate-700 transition-all flex items-center gap-2">
                <i data-lucide="filter" class="w-4 h-4"></i> Filters
            </button>
        </div>
    </div>

    <!-- Users Table -->
    <div class="glass rounded-3xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-[#0c0c0c] text-slate-500 uppercase text-[10px] font-bold">
                    <tr>
                        <th class="px-6 py-4">User Details</th>
                        <th class="px-6 py-4">Referral Code</th>
                        <th class="px-6 py-4">Upline</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Wallet</th>
                        <th class="px-6 py-4">Join Date</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1f1f1f]">
                    @forelse($users as $user)
                    <tr class="hover:bg-white/[0.02] transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-slate-800 to-slate-900 border border-[#1f1f1f] flex items-center justify-center font-bold text-slate-300">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-200">{{ $user->name }}</span>
                                    <span class="text-xs text-slate-500 italic">{{ $user->email }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-mono text-purple-400 text-xs">{{ $user->referral_code ?? '—' }}</td>
                        <td class="px-6 py-4 text-slate-400 text-xs">
                            {{ $user->upline?->referral_code ?? '—' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="badge-{{ $user->status === 'active' ? 'active' : 'pending' }} text-[10px] px-2 py-0.5 rounded-full uppercase font-bold">
                                {{ ucfirst($user->status ?? 'pending') }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="font-bold">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($user->wallet->balance ?? 0, 2) }}</span>
                                <span class="text-[10px] text-slate-500">Balance</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-400 text-xs">{{ $user->created_at?->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.users.show', $user->id) }}" class="w-8 h-8 rounded-lg border border-[#1f1f1f] flex items-center justify-center text-slate-400 hover:text-white hover:border-purple-500 transition-all">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-500 italic">No users found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6 border-t border-[#1f1f1f] flex items-center justify-between">
            <span class="text-xs text-slate-500 font-medium">
                Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users
            </span>
            <div>
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
