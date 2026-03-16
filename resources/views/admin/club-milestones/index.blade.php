@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Club Milestone Configuration</h1>
            <p class="text-slate-400 text-sm">Set business volume targets and corresponding voucher rewards for the 7 club tiers.</p>
        </div>
        <div class="flex items-center gap-3">
             <button class="btn-gradient px-6 py-2 rounded-xl text-sm font-bold shadow-lg shadow-purple-600/10">Add Milestone</button>
        </div>
    </div>

    <!-- Milestones List -->
    <div class="glass rounded-[2rem] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-[#0c0c0c] text-slate-500 uppercase text-[10px] font-bold">
                    <tr>
                        <th class="px-8 py-4">Tier</th>
                        <th class="px-8 py-4">Club Name</th>
                        <th class="px-8 py-4">Direct BV Target</th>
                        <th class="px-8 py-4">Team BV Target</th>
                        <th class="px-8 py-4">Voucher Reward</th>
                        <th class="px-8 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1f1f1f]">
                    @forelse($milestones as $m)
                    <tr class="hover:bg-amber-500/[0.03] transition-colors group">
                        <form action="{{ route('admin.club-milestones.update', $m->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <td class="px-8 py-5">
                                <span class="text-xs font-black text-slate-500">#{{ str_pad($m->tier, 2, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td class="px-8 py-5">
                                <input type="text" name="name" value="{{ $m->name }}" class="bg-[#0c0c0c] border border-[#1f1f1f] rounded-xl px-4 py-2 text-sm font-black focus:border-amber-500 outline-none text-amber-500 uppercase italic tracking-tighter">
                            </td>
                            <td class="px-8 py-5">
                                 <div class="relative w-32">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-[10px] font-bold">{{ $settings['platform_currency_symbol'] ?? '$' }}</span>
                                    <input type="number" name="direct_business_target" value="{{ $m->direct_business_target }}" class="w-full bg-[#0c0c0c] border border-[#1f1f1f] rounded-xl pl-6 pr-3 py-2 text-sm font-bold focus:border-amber-500 outline-none text-slate-200">
                                </div>
                            </td>
                             <td class="px-8 py-5">
                                 <div class="relative w-32">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-[10px] font-bold">{{ $settings['platform_currency_symbol'] ?? '$' }}</span>
                                    <input type="number" name="team_business_target" value="{{ $m->team_business_target }}" class="w-full bg-[#0c0c0c] border border-[#1f1f1f] rounded-xl pl-6 pr-3 py-2 text-sm font-bold focus:border-amber-500 outline-none text-slate-200">
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <div class="relative w-32">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-[10px] font-bold">{{ $settings['platform_currency_symbol'] ?? '$' }}</span>
                                    <input type="number" name="voucher_value" value="{{ $m->voucher_value }}" class="w-full bg-[#0c0c0c] border border-[#1f1f1f] rounded-xl pl-6 pr-3 py-2 text-sm font-bold focus:border-amber-500 outline-none text-green-500">
                                </div>
                            </td>
                            <td class="px-8 py-5 text-right">
                                 <button type="submit" class="text-slate-500 hover:text-white transition-all"><i data-lucide="save" class="w-4 h-4"></i></button>
                            </td>
                        </form>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-12 text-center text-slate-500 font-bold">No milestones configured yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

