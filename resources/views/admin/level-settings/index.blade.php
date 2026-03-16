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
                    <!-- Level 1 -->
                    <tr class="hover:bg-purple-600/[0.03] transition-colors group">
                        <td class="px-8 py-5 text-center">
                            <span class="w-10 h-10 rounded-xl bg-purple-600/10 border border-purple-600/20 flex items-center justify-center font-bold text-purple-400">1</span>
                        </td>
                        <td class="px-8 py-5">
                            <div class="relative w-32">
                                <input type="number" value="20" class="w-full bg-[#0c0c0c] border border-[#1f1f1f] rounded-xl px-4 py-2 text-sm font-bold focus:border-purple-600 outline-none text-slate-200">
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 font-bold">%</span>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <input type="text" value="Direct Referrer" class="bg-transparent border-none text-slate-500 text-xs font-bold uppercase tracking-widest outline-none w-full">
                        </td>
                        <td class="px-8 py-5 text-right font-black text-green-500">₹20.00</td>
                    </tr>
                    <!-- Level 2 -->
                    <tr class="hover:bg-purple-600/[0.03] transition-colors group">
                        <td class="px-8 py-5 text-center">
                            <span class="w-10 h-10 rounded-xl glass border border-[#1f1f1f] flex items-center justify-center font-bold text-slate-400">2</span>
                        </td>
                        <td class="px-8 py-5">
                             <div class="relative w-32">
                                <input type="number" value="12" class="w-full bg-[#0c0c0c] border border-[#1f1f1f] rounded-xl px-4 py-2 text-sm font-bold focus:border-purple-600 outline-none text-slate-200">
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 font-bold">%</span>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <input type="text" value="Level 2 Upline" class="bg-transparent border-none text-slate-500 text-[10px] font-bold uppercase tracking-widest outline-none w-full italic">
                        </td>
                        <td class="px-8 py-5 text-right font-black text-green-500/80">₹12.00</td>
                    </tr>
                    <!-- More levels... -->
                    <tr>
                         <td colspan="4" class="px-8 py-4 text-center bg-[#0c0c0c]">
                             <p class="text-[10px] text-slate-600 font-bold uppercase tracking-widest">Levels 3 to 15 configured below in the full list</p>
                         </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
