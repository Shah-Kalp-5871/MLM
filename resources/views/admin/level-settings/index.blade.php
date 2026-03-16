@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Level Commission Configuration</h1>
            <p class="text-slate-400 text-sm">Define the percentage payout for all 15 levels of the MLM hierarchy.</p>
        </div>
        <div class="flex items-center gap-3">
             <button class="btn-gradient px-6 py-2 rounded-xl text-sm font-bold shadow-lg shadow-purple-600/10">Update All Levels</button>
        </div>
    </div>

    <!-- Levels List -->
    <div class="glass rounded-[2rem] overflow-hidden">
        <form action="{{ route('admin.level-settings.update') }}" method="POST">
            @csrf
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-[#0c0c0c] text-slate-500 uppercase text-[10px] font-bold">
                        <tr>
                            <th class="px-8 py-4 w-32 text-center">Level</th>
                            <th class="px-8 py-4">Commission Percentage (%)</th>
                            <th class="px-8 py-4">Contextual Label</th>
                            <th class="px-8 py-4 text-right">Preview Payout (on ₹100 ROI)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#1f1f1f]">
                        @foreach($levels as $level)
                        <tr class="hover:bg-purple-600/[0.03] transition-colors group">
                            <td class="px-8 py-5 text-center">
                                <span class="w-10 h-10 rounded-xl {{ $level->level == 1 ? 'bg-purple-600/10 border border-purple-600/20 text-purple-400' : 'glass border border-[#1f1f1f] text-slate-400' }} flex items-center justify-center font-bold">{{ $level->level }}</span>
                            </td>
                            <td class="px-8 py-5">
                                <div class="relative w-32">
                                    <input type="number" step="0.01" name="levels[{{ $level->id }}][percentage]" value="{{ $level->percentage }}" class="w-full bg-[#0c0c0c] border border-[#1f1f1f] rounded-xl px-4 py-2 text-sm font-bold focus:border-purple-600 outline-none text-slate-200">
                                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 font-bold">%</span>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <input type="text" name="levels[{{ $level->id }}][label]" value="{{ $level->label }}" class="bg-transparent border-none text-slate-500 text-xs font-bold uppercase tracking-widest outline-none w-full">
                            </td>
                            <td class="px-8 py-5 text-right font-black text-green-500">₹{{ number_format($level->percentage, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-6 bg-[#0c0c0c]/50 flex justify-end">
                <button type="submit" class="btn-gradient px-8 py-3 rounded-2xl text-sm font-black shadow-xl shadow-purple-600/20">Save All Configurations</button>
            </div>
        </form>
    </div>
</div>
@endsection
