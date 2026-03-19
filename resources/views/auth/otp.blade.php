@extends('layouts.auth')
@section('content')
<div class="glass-panel w-full max-w-[440px] p-10 rounded-[2rem] shadow-2xl relative overflow-hidden group">
    <!-- Glow -->
    <div class="absolute -top-20 -right-20 w-56 h-56 bg-indigo-600/10 rounded-full blur-3xl group-hover:bg-indigo-500/20 transition-all duration-700"></div>
    <div class="absolute -bottom-20 -left-20 w-56 h-56 bg-purple-600/10 rounded-full blur-3xl"></div>

    <div class="mb-8 text-center relative z-10">
        <img src="{{ asset('storage/logo.png') }}" alt="Logo" class="w-16 h-16 object-contain mx-auto mb-5 drop-shadow-2xl">
        <h1 class="text-2xl font-black text-white tracking-tight uppercase">Verify Your Email</h1>
        <p class="text-xs text-gray-400 font-medium mt-2 leading-relaxed">
            We sent a <span class="text-purple-400 font-bold">6-digit OTP</span> to your email.<br>
            Enter it below to complete registration.
        </p>
    </div>

    @if(session('resent'))
        <div class="mb-5 px-4 py-3 rounded-xl bg-green-500/10 border border-green-500/20 text-green-400 text-xs font-semibold text-center">
            {{ session('resent') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-5 px-4 py-3 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 text-xs font-semibold text-center">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('register.otp.verify') }}" method="POST" class="relative z-10" id="otp-form">
        @csrf

        <!-- OTP Digit Inputs -->
        <div class="flex gap-3 justify-center mb-8" id="otp-boxes">
            @for($i = 1; $i <= 6; $i++)
                <input
                    type="text"
                    maxlength="1"
                    class="otp-digit w-12 h-14 text-center text-xl font-black rounded-xl border border-white/10 bg-white/5 text-white focus:outline-none focus:border-purple-500 focus:bg-purple-500/10 transition-all"
                    inputmode="numeric"
                    pattern="[0-9]"
                    autocomplete="off"
                    id="d{{ $i }}"
                >
            @endfor
            <input type="hidden" name="otp" id="otp-hidden">
        </div>

        <button type="submit" id="submit-btn"
            class="w-full py-4 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white text-[11px] font-black uppercase tracking-[0.2em] transition-all shadow-xl shadow-purple-900/40 flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
            <i data-lucide="shield-check" class="w-4 h-4"></i>
            Verify OTP & Create Account
        </button>
    </form>

    <!-- Resend OTP -->
    <div class="mt-6 text-center relative z-10">
        <p class="text-[11px] text-gray-500 font-semibold">
            Didn't receive it?
            <a href="{{ route('register.otp.resend') }}"
               class="text-purple-400 font-black hover:text-white transition-colors ml-1 underline decoration-2 underline-offset-4">
                Resend OTP
            </a>
        </p>
        <p class="text-[11px] text-gray-600 mt-2">
            <a href="{{ route('register') }}" class="hover:text-gray-400 transition-colors">← Start over</a>
        </p>
    </div>

    <!-- Timer -->
    <div class="mt-4 text-center relative z-10">
        <p class="text-[11px] text-gray-600">OTP expires in <span id="timer" class="text-purple-400 font-bold">10:00</span></p>
    </div>
</div>

<script>
    // Auto-advance OTP digit inputs
    const digits = document.querySelectorAll('.otp-digit');
    digits.forEach((input, idx) => {
        input.addEventListener('input', () => {
            input.value = input.value.replace(/\D/g, '');
            if (input.value && idx < digits.length - 1) digits[idx + 1].focus();
            updateHidden();
        });
        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !input.value && idx > 0) digits[idx - 1].focus();
        });
        input.addEventListener('paste', (e) => {
            e.preventDefault();
            const text = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '').slice(0, 6);
            [...text].forEach((ch, i) => { if (digits[i]) digits[i].value = ch; });
            digits[Math.min(text.length, 5)].focus();
            updateHidden();
        });
    });

    function updateHidden() {
        document.getElementById('otp-hidden').value = [...digits].map(d => d.value).join('');
    }

    // Countdown timer (10 minutes)
    let secs = 600;
    const timerEl = document.getElementById('timer');
    const countdown = setInterval(() => {
        secs--;
        const m = String(Math.floor(secs / 60)).padStart(2, '0');
        const s = String(secs % 60).padStart(2, '0');
        timerEl.textContent = `${m}:${s}`;
        if (secs <= 0) {
            clearInterval(countdown);
            timerEl.textContent = 'Expired';
            timerEl.classList.replace('text-purple-400', 'text-rose-400');
        }
    }, 1000);
</script>
@endsection
