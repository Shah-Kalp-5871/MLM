@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Payment Methods</h1>
            <p class="text-slate-400 text-sm">Manage QR codes and payment instructions for user investments.</p>
        </div>
        <button onclick="toggleModal('addMethodModal')" class="bg-purple-600 hover:bg-purple-500 text-white px-6 py-3 rounded-2xl text-sm font-bold uppercase tracking-wider transition-all shadow-lg shadow-purple-900/40 flex items-center gap-2">
            <i data-lucide="plus-circle" class="w-4 h-4"></i> Add New Method
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($methods as $method)
        <div class="glass p-6 rounded-3xl relative overflow-hidden group border border-white/5">
            <div class="flex justify-between items-start mb-6">
                <div class="w-12 h-12 rounded-2xl bg-slate-800 border border-[#1f1f1f] flex items-center justify-center text-slate-300">
                    <i data-lucide="{{ $method->type == 'Crypto' ? 'bitcoin' : ($method->type == 'Bank Transfer' ? 'landmark' : 'qr-code') }}" class="w-6 h-6"></i>
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 bg-{{ $method->is_active ? 'emerald' : 'slate' }}-500/20 text-{{ $method->is_active ? 'emerald' : 'slate' }}-400 text-[10px] font-bold uppercase rounded-full">
                        {{ $method->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
            
            <div class="mb-6">
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">{{ $method->type }}</p>
                <h3 class="text-xl font-bold text-white">{{ $method->name }}</h3>
                <p class="text-xs text-slate-400 mt-2 line-clamp-2 h-8">{{ $method->instructions ?? 'No special instructions' }}</p>
            </div>

            <div class="bg-black/40 rounded-2xl p-4 border border-white/5 flex items-center justify-center mb-6 aspect-square overflow-hidden group-hover:border-purple-500/50 transition-all">
                @if($method->qr_code)
                    <img src="{{ asset('storage/' . $method->qr_code) }}" class="w-full h-full object-contain image-zoom" alt="QR Code">
                @else
                    <i data-lucide="image" class="w-12 h-12 text-slate-700"></i>
                @endif
            </div>

            <div class="flex items-center gap-3">
                <button onclick="editMethod({{ $method->id }})" class="flex-1 py-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-white text-xs font-bold uppercase tracking-wider transition-all border border-[#1f1f1f] flex items-center justify-center gap-2">
                    <i data-lucide="edit-3" class="w-3.5 h-3.5"></i> Edit
                </button>
                <form action="{{ route('admin.payment-methods.destroy', $method->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Delete this payment method?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full py-3 rounded-xl bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white text-xs font-bold uppercase tracking-wider transition-all border border-red-500/20 flex items-center justify-center gap-2">
                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Delete
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    @if($methods->isEmpty())
    <div class="glass p-12 rounded-3xl border border-white/5 text-center">
        <div class="w-20 h-20 rounded-full bg-slate-800 border border-[#1f1f1f] flex items-center justify-center mx-auto mb-6 text-slate-600">
            <i data-lucide="qr-code" class="w-10 h-10"></i>
        </div>
        <h3 class="text-lg font-bold text-slate-300">No Payment Methods</h3>
        <p class="text-slate-510 text-sm max-w-xs mx-auto mt-2 italic">Add your first deposit gateway to allow users to start investing.</p>
    </div>
    @endif
</div>

<!-- Modals -->
<div id="addMethodModal" class="modal-backdrop hidden">
    <div class="modal-content-wrapper max-w-md w-full p-4">
        <div class="glass rounded-3xl border border-white/10 shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-300">
            <div class="p-6 border-b border-white/5 flex items-center justify-between">
                <h3 class="text-lg font-bold">Add Payment Method</h3>
                <button onclick="toggleModal('addMethodModal')" class="text-slate-400 hover:text-white"><i data-lucide="x" class="w-5 h-5"></i></button>
            </div>
            <form action="{{ route('admin.payment-methods.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
                @csrf
                <div class="space-y-1.5">
                    <label class="text-[10px] uppercase font-bold text-slate-500 tracking-widest px-1">Method Name</label>
                    <input type="text" name="name" class="w-full bg-black/40 border border-white/10 rounded-2xl px-5 py-3.5 text-slate-200 text-sm focus:border-purple-600 focus:outline-none transition-all" placeholder="e.g. UPI Official" required>
                </div>
                <div class="space-y-1.5">
                    <label class="text-[10px] uppercase font-bold text-slate-500 tracking-widest px-1">Type</label>
                    <select name="type" class="w-full bg-black/40 border border-white/10 rounded-2xl px-5 py-3.5 text-slate-200 text-sm focus:border-purple-600 focus:outline-none transition-all appearance-none cursor-pointer">
                        <option value="UPI">UPI</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                        <option value="Paytm">Paytm</option>
                        <option value="Crypto">Crypto (USDT)</option>
                    </select>
                </div>
                <div class="space-y-1.5">
                    <label class="text-[10px] uppercase font-bold text-slate-500 tracking-widest px-1">QR Code Image</label>
                    <input type="file" name="qr_code" class="w-full bg-black/40 border border-white/10 rounded-2xl px-5 py-3.5 text-slate-200 text-sm focus:border-purple-600 focus:outline-none transition-all" required>
                </div>
                <div class="space-y-1.5">
                    <label class="text-[10px] uppercase font-bold text-slate-500 tracking-widest px-1">Instructions</label>
                    <textarea name="instructions" class="w-full bg-black/40 border border-white/10 rounded-2xl px-5 py-3.5 text-slate-200 text-sm focus:border-purple-600 focus:outline-none transition-all" rows="3" placeholder="Step-by-step payment guide..."></textarea>
                </div>
                <div class="pt-2">
                    <button type="submit" class="w-full py-4 rounded-2xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white text-xs font-black uppercase tracking-[0.2em] transition-all shadow-xl shadow-purple-900/40">
                        Save Method
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.8);
        backdrop-filter: blur(8px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 50;
    }
    .modal-backdrop.hidden {
        display: none;
    }
</style>

<script>
    function toggleModal(id) {
        document.getElementById(id).classList.toggle('hidden');
    }
    
    // Simple script to handle modals and edit data would go here
</script>
@endsection
