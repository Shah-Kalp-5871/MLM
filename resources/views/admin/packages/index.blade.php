@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Investment Packages</h1>
            <p class="text-slate-400 text-sm">Define and manage available plans for investors.</p>
        </div>
        <div class="flex items-center gap-3">
             <button class="btn-gradient px-6 py-2 rounded-xl text-sm font-bold shadow-lg shadow-purple-600/10 flex items-center gap-2">
                <i data-lucide="plus" class="w-4 h-4"></i> Create New Package
            </button>
        </div>
    </div>

    <!-- Package Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($packages as $package)
        <div class="glass p-8 rounded-3xl border-t-4 {{ $package->status == 'active' ? 'border-purple-600' : 'border-slate-500' }} relative overflow-hidden group shadow-2xl shadow-purple-900/10">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-black italic tracking-tighter uppercase text-purple-400">{{ $package->name }}</h3>
                <span class="badge {{ $package->status == 'active' ? 'badge-active' : 'badge-danger' }} text-[10px] px-2 py-0.5 rounded-full uppercase font-bold">{{ $package->status }}</span>
            </div>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-xs text-slate-500 font-bold uppercase tracking-widest">Price</span>
                    <span class="text-2xl font-black text-slate-200">$settings['platform_currency_symbol']{{ number_format($package->price, 2) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-slate-500 font-bold uppercase tracking-widest">Weekly ROI</span>
                    <span class="text-xl font-bold text-green-500">{{ number_format($package->roi_percentage, 2) }}%</span>
                </div>
            </div>
            <div class="mt-8 pt-6 border-t border-[#1f1f1f] flex items-center gap-3">
                <a href="{{ route('admin.packages.edit', $package->id) }}" class="flex-1 bg-white/5 hover:bg-white/10 text-xs text-center font-bold py-2 rounded-lg transition-all">Edit Plan</a>
                <form action="{{ route('admin.packages.destroy', $package->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-10 h-10 rounded-lg border border-red-500/20 text-red-500 flex items-center justify-center hover:bg-red-500 hover:text-white transition-all">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 text-center glass rounded-3xl">
            <i data-lucide="package-search" class="w-12 h-12 text-slate-600 mx-auto mb-4"></i>
            <p class="text-slate-400 font-bold">No packages found. Create your first investment plan.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection

