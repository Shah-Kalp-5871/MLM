@extends('layouts.user')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">New Investment</h1>
            <p class="text-xs text-gray-500 font-medium uppercase tracking-widest mt-1">Start your ROI journey</p>
        </div>
        <a href="{{ route('investments.index') }}" class="text-xs font-bold text-purple-400 uppercase tracking-widest hover:text-purple-300 transition-all flex items-center gap-2">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> My Investments
        </a>
    </div>

    @if($pendingDeposit)
    <div class="glass p-8 rounded-3xl border border-yellow-500/20 bg-yellow-500/5 relative overflow-hidden group animate-in slide-in-from-top-4 duration-500">
        <div class="absolute -top-12 -right-12 w-48 h-48 bg-yellow-500/10 rounded-full blur-3xl group-hover:bg-yellow-500/20 transition-all"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center gap-6">
            <div class="w-16 h-16 rounded-2xl bg-yellow-500/20 flex items-center justify-center text-yellow-500">
                <i data-lucide="clock" class="w-8 h-8"></i>
            </div>
            <div class="flex-1 text-center md:text-left">
                <h3 class="text-xl font-bold text-white uppercase tracking-tight">Pending Investment Found</h3>
                <p class="text-gray-400 mt-2">You already have a pending request for <span class="text-yellow-500 font-bold">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($pendingDeposit->amount, 2) }}</span>. Please wait for admin approval before making a new investment.</p>
            </div>
            <a href="{{ route('investments.index') }}" class="px-6 py-3 rounded-xl bg-yellow-500 text-black text-xs font-bold uppercase tracking-wider hover:bg-yellow-400 transition-all">
                View Status
            </a>
        </div>
    </div>
    @else
    <form action="{{ route('invest.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        
        <!-- Step 1: Investment Amount -->
        <div class="glass p-8 rounded-3xl border border-white/5 relative overflow-hidden group">
            <div class="absolute -top-24 -right-24 w-48 h-48 bg-purple-600/10 rounded-full blur-3xl group-hover:bg-purple-600/20 transition-all"></div>
            
            <div class="relative z-10 space-y-6">
                <div class="flex items-center gap-3 mb-2">
                   <span class="w-8 h-8 rounded-full bg-purple-600 flex items-center justify-center text-sm font-bold text-white italic">1</span>
                   <h2 class="text-lg font-bold text-white">Investment Details</h2>
                </div>
                
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3 ml-1">How much would you like to invest?</label>
                    <div class="relative">
                        <span class="absolute left-6 top-1/2 -translate-y-1/2 text-2xl font-bold text-purple-500">
                            {{ $settings['platform_currency_symbol'] ?? '$' }}
                        </span>
                        <input type="number" name="amount" min="1" step="0.01" value="100.00" 
                            class="w-full bg-black/40 border-2 border-white/5 focus:border-purple-600/50 rounded-2xl pl-12 pr-8 py-5 text-3xl font-black text-white focus:outline-none transition-all placeholder:text-gray-800"
                            placeholder="0.00" required>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4 ml-1">Choose Payment Gateway</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($paymentMethods as $method)
                        <label class="cursor-pointer group/card">
                            <input type="radio" name="payment_method_id" value="{{ $method->id }}" class="hidden peer" {{ $loop->first ? 'checked' : '' }} 
                                onchange="updatePaymentDetails('{{ $method->qr_code }}', '{{ addslashes($method->instructions) }}')">
                            <div class="p-5 rounded-2xl glass-panel border border-white/5 peer-checked:border-purple-500 peer-checked:bg-purple-500/10 transition-all">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-slate-800 border border-white/5 flex items-center justify-center text-slate-400 peer-checked:text-purple-400">
                                        <i data-lucide="{{ $method->type == 'Crypto' ? 'bitcoin' : ($method->type == 'Bank Transfer' ? 'landmark' : 'qr-code') }}" class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-gray-500 uppercase">{{ $method->type }}</p>
                                        <p class="text-white font-bold">{{ $method->name }}</p>
                                    </div>
                                </div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 2: Payment Receipt -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-1">
                <div class="glass p-6 rounded-3xl border border-white/5 text-center sticky top-8">
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-4">Scan to Pay</p>
                    <div class="bg-white p-4 rounded-2xl inline-block mb-4 shadow-xl">
                        <img id="qr-code-img" src="{{ asset('storage/' . ($paymentMethods->first()->qr_code ?? '')) }}" class="w-40 h-40 object-contain mx-auto" alt="QR Code">
                    </div>
                    <div class="text-left space-y-4">
                        <div class="p-4 rounded-xl bg-black/40 border border-white/5">
                            <p class="text-[10px] font-bold text-purple-500 uppercase tracking-widest mb-2">Instructions</p>
                            <p id="payment-instructions" class="text-xs text-gray-400 leading-relaxed italic">
                                {{ $paymentMethods->first()->instructions ?? 'No special instructions.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="md:col-span-2 space-y-8">
                <div class="glass p-8 rounded-3xl border border-white/5">
                    <div class="flex items-center gap-3 mb-6">
                       <span class="w-8 h-8 rounded-full bg-purple-600 flex items-center justify-center text-sm font-bold text-white italic">2</span>
                       <h2 class="text-lg font-bold text-white">Upload Payment Proof</h2>
                    </div>

                    <div class="space-y-6">
                        <div class="p-8 border-2 border-dashed border-white/5 rounded-3xl bg-black/20 text-center hover:border-purple-500/30 transition-all group/upload relative overflow-hidden">
                            <input type="file" name="payment_proof" class="absolute inset-0 opacity-0 cursor-pointer" id="proof-input" onchange="previewFile(this)">
                            <div id="upload-placeholder" class="space-y-4">
                                <div class="w-16 h-16 rounded-full bg-slate-800 mx-auto flex items-center justify-center text-slate-500 group-hover/upload:text-purple-500 transition-all">
                                    <i data-lucide="upload" class="w-8 h-8"></i>
                                </div>
                                <div>
                                    <p class="text-white font-bold">Upload Screenshot / Receipt</p>
                                    <p class="text-xs text-slate-500 mt-1">PNG, JPG or PDF (Max 2MB)</p>
                                </div>
                            </div>
                            <div id="upload-preview" class="hidden space-y-4">
                                <img src="" id="preview-img" class="max-h-48 mx-auto rounded-xl">
                                <p class="text-sm text-purple-400 font-bold" id="file-name"></p>
                            </div>
                        </div>

                        <div class="p-6 rounded-2xl bg-indigo-500/5 border border-indigo-500/10 flex gap-4">
                            <i data-lucide="info" class="w-5 h-5 text-indigo-400 flex-shrink-0"></i>
                            <p class="text-xs text-indigo-300 leading-relaxed italic">
                                Please ensure the transaction hash or reference ID is clearly visible in the screenshot for faster approval.
                            </p>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full py-5 rounded-3xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white font-black uppercase tracking-[0.3em] transition-all shadow-2xl shadow-purple-900/40 transform active:scale-[0.98]">
                    Submit for Approval
                </button>
            </div>
        </div>
    </form>
    @endif
</div>

<script>
    function updatePaymentDetails(qr, instructions) {
        document.getElementById('qr-code-img').src = '{{ asset("storage") }}/' + qr;
        document.getElementById('payment-instructions').innerText = instructions || 'No special instructions.';
        
        // Add a subtle animation to highlight the change
        const qrContainer = document.getElementById('qr-code-img').parentElement;
        qrContainer.classList.add('animate-pulse');
        setTimeout(() => qrContainer.classList.remove('animate-pulse'), 1000);
    }

    function previewFile(input) {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('upload-placeholder').classList.add('hidden');
                document.getElementById('preview-img').src = e.target.result;
                document.getElementById('file-name').innerText = file.name;
                document.getElementById('upload-preview').classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
