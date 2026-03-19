@extends('layouts.user')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-white tracking-tight">Referrals & Affiliates</h1>
    <p class="text-xs text-gray-500 font-medium uppercase tracking-widest mt-1">Invite friends and earn level income</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
    <div class="lg:col-span-2 glass-panel p-8 rounded-2xl border border-purple-500/30 flex flex-col justify-center">
        <h2 class="text-sm font-bold text-white uppercase tracking-wider mb-2">Your Invite Code</h2>
        <p class="text-xs text-gray-400 mb-6">Share this code with your friends. They can enter it during signup.</p>
        
        <div class="flex flex-col lg:flex-row items-stretch lg:items-center gap-4">
            @php
                $refCode = auth()->user()->referral_code;
                $refLink = route('register') . '?ref=' . $refCode;
            @endphp
            <div class="flex-1 bg-black/40 border border-white/10 rounded-xl px-4 py-4 sm:py-3 font-mono text-xl sm:text-2xl tracking-[0.1em] sm:tracking-[0.2em] text-center text-purple-400 select-all overflow-hidden text-ellipsis">
                {{ $refCode }}
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <button id="copy-btn" type="button" class="flex-1 sm:w-auto px-6 py-4 rounded-xl bg-purple-600 hover:bg-purple-500 text-white text-xs font-bold uppercase tracking-wider transition-all shadow-lg shadow-purple-900/40 flex items-center justify-center gap-2" onclick="copyReferralContent('{{ $refCode }}', 'copy-btn', 'Code')">
                    <i data-lucide="copy" class="w-4 h-4"></i> <span class="btn-text">Copy Code</span>
                </button>
                <button id="copy-link-btn" type="button" class="flex-1 sm:w-auto px-6 py-4 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold uppercase tracking-wider transition-all shadow-lg shadow-indigo-900/40 flex items-center justify-center gap-2" onclick="copyReferralContent('{{ $refLink }}', 'copy-link-btn', 'Link')">
                    <i data-lucide="link" class="w-4 h-4"></i> <span class="btn-text">Copy Link</span>
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function copyReferralContent(content, btnId, type) {
            navigator.clipboard.writeText(content).then(() => {
                const btn = document.getElementById(btnId);
                const textSpan = btn.querySelector('.btn-text');
                const icon = btn.querySelector('i');
                const originalText = `Copy ${type}`;
                const originalIcon = type === 'Code' ? 'copy' : 'link';
                const originalBg = type === 'Code' ? 'bg-purple-600' : 'bg-indigo-600';
                const originalHover = type === 'Code' ? 'hover:bg-purple-500' : 'hover:bg-indigo-500';

                textSpan.innerText = 'Copied!';
                icon.setAttribute('data-lucide', 'check');
                btn.classList.remove(originalBg, originalHover);
                btn.classList.add('bg-emerald-600', 'hover:bg-emerald-500');
                
                lucide.createIcons();
                
                setTimeout(() => {
                    textSpan.innerText = originalText;
                    icon.setAttribute('data-lucide', originalIcon);
                    btn.classList.remove('bg-emerald-600', 'hover:bg-emerald-500');
                    btn.classList.add(originalBg, originalHover);
                    lucide.createIcons();
                }, 3000);
            });
        }
    </script>
    @endpush

    <div class="grid grid-cols-1 gap-4">
        <div class="glass-panel p-5 rounded-2xl border-l-[6px] border-l-purple-500 flex items-center justify-between">
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Direct Referrals</p>
                <h3 class="text-2xl font-black text-white">{{ $referrals->total() }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-purple-500/20 flex items-center justify-center text-purple-400"><i data-lucide="users" class="w-6 h-6"></i></div>
        </div>
        <div class="glass-panel p-5 rounded-2xl border-l-[6px] border-l-blue-500 flex items-center justify-between">
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Team Member</p>
                <h3 class="text-2xl font-black text-white">{{ $referrals->total() }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400"><i data-lucide="network" class="w-6 h-6"></i></div>
        </div>
    </div>
</div>

<div class="glass-panel rounded-2xl overflow-hidden">
    <div class="p-6 border-b border-white/5 bg-white/[0.02]">
        <h2 class="text-sm font-bold text-white uppercase tracking-wider">Referral List</h2>
    </div>
    <div class="table-wrapper p-4">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Join Date</th>
                    <th>Investment Vol</th>
                </tr>
            </thead>
            <tbody>
                @forelse($referrals as $ref)
                <tr>
                    <td class="font-bold text-white">{{ $ref->name }}</td>
                    <td class="text-gray-400 text-xs">{{ $ref->email }}</td>
                    <td class="text-xs text-gray-500">{{ $ref->created_at?->format('d M Y') }}</td>
                    <td class="font-mono text-emerald-400">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($ref->wallet->total_deposited ?? 0, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-8 text-gray-500 italic">No referrals yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-white/5 flex justify-center bg-white/[0.01]">
        {{ $referrals->links() }}
    </div>
</div>
@endsection
