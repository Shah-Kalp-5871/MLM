@extends('layouts.user')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-2xl font-bold text-white tracking-tight">Investments</h1>
        <p class="text-xs text-gray-500 font-medium uppercase tracking-widest mt-1">Manage your active plans</p>
    </div>
    <a href="/user/investments/create" class="px-6 py-3 rounded-xl bg-purple-600 hover:bg-purple-500 text-white text-xs font-bold uppercase tracking-wider transition-all shadow-lg shadow-purple-900/40 flex items-center gap-2"><i data-lucide="plus" class="w-4 h-4"></i> Invest Now</a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
    <div class="glass-panel p-6 rounded-2xl border border-purple-500/20 flex flex-col justify-center">
        <h2 class="text-sm font-bold text-white uppercase tracking-wider mb-2">ROI Explanation</h2>
        <p class="text-xs text-gray-400 leading-relaxed mb-4">
            Your investment generates passive weekly ROI based on the package value.
        </p>
        <div class="flex gap-4">
            <div class="bg-black/30 p-3 rounded-xl border border-white/5 flex-1">
                <p class="text-[10px] text-gray-500 uppercase font-bold mb-1">Weekly ROI</p>
                <p class="text-white font-black">3% – 3.5%</p>
            </div>
            <div class="bg-black/30 p-3 rounded-xl border border-white/5 flex-1">
                <p class="text-[10px] text-gray-500 uppercase font-bold mb-1">Monthly ROI</p>
                <p class="text-white font-black">12% – 14%</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div class="glass-panel p-6 rounded-2xl border-l-4 border-l-purple-500">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Investment</p>
            <h3 class="text-2xl font-black text-white">₹5,000.00</h3>
        </div>
        <div class="glass-panel p-6 rounded-2xl border-l-4 border-l-emerald-500">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Active Packages</p>
            <h3 class="text-2xl font-black text-white">1</h3>
        </div>
        <div class="glass-panel p-6 rounded-2xl border-l-4 border-l-amber-500 sm:col-span-2">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Expected Weekly Profit</p>
            <h3 class="text-2xl font-black text-white">₹150.00 – ₹175.00</h3>
        </div>
    </div>
</div>

<div class="glass-panel rounded-2xl overflow-hidden">
    <div class="table-wrapper p-4">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Package</th>
                    <th>Amount</th>
                    <th>ROI %</th>
                    <th>Status</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="font-mono text-gray-400 text-xs">#INV-1001</td>
                    <td class="font-bold text-white">Starter Package</td>
                    <td class="font-bold text-white">₹500.00</td>
                    <td class="text-xs">5% Weekly</td>
                    <td><span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 text-[10px] font-bold uppercase rounded-full">Active</span></td>
                    <td class="text-xs">10 Mar 2026</td>
                    <td class="text-xs text-gray-500">12 Jun 2026</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-white/5 flex justify-between items-center bg-white/[0.01]">
        <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Showing 1 to 1 of 1 records</span>
        <div class="pagination">
            <a href="#">&laquo; Prev</a>
            <a href="#" class="active">1</a>
            <a href="#">Next &raquo;</a>
        </div>
    </div>
</div>
@endsection