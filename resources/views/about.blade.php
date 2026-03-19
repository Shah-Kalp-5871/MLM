<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | EliteMatrixPro · Decentralized Wealth</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('storage/logo.png') }}">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        deep: '#0a0b14',
                        cardBg: 'rgba(255, 255, 255, 0.03)',
                        glassBorder: 'rgba(255, 255, 255, 0.08)',
                        purple: { 400: '#a855f7', 500: '#9333ea', 600: '#7e22ce', 900: '#581c87' },
                        indigo: { 400: '#818cf8', 500: '#6366f1', 600: '#4f46e5' },
                        emerald: { 400: '#34d399', 500: '#10b981', 600: '#059669' },
                        red: { 400: '#f87171', 500: '#ef4444' }
                    },
                    animation: {
                        'pulse-slow': 'pulse 6s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'float': 'float 6s ease-in-out infinite',
                        'glow': 'glow 3s ease-in-out infinite alternate',
                        'marquee': 'marquee 25s linear infinite',
                    },
                    keyframes: {
                        float: { '0%,100%': { transform: 'translateY(0)' }, '50%': { transform: 'translateY(-20px)' } },
                        glow: { '0%': { boxShadow: '0 0 20px rgba(168,85,247,0.2)' }, '100%': { boxShadow: '0 0 50px rgba(99,102,241,0.4)' } },
                        marquee: { '0%': { transform: 'translateX(0)' }, '100%': { transform: 'translateX(-50%)' } },
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #0a0b14; color: #94a3b8; }
        .glass-panel { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.08); }
        .text-glow { text-shadow: 0 0 30px rgba(147, 51, 234, 0.7); }
        .hero-bg { background-image: radial-gradient(circle at top right, rgba(147,51,234,0.12), transparent 50%), radial-gradient(circle at bottom left, rgba(79,70,229,0.12), transparent 50%); }
        #mobile-menu { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); transform: translateY(-20px); opacity: 0; pointer-events: none; background: #0a0b14; border: 1px solid rgba(147,51,234,0.3); }
        #mobile-menu.active { transform: translateY(0); opacity: 1; pointer-events: auto; }
        .stats-bg { background: radial-gradient(ellipse at center, rgba(168,85,247,0.15) 0%, transparent 70%); }
        .hover-lift:hover { transform: translateY(-6px); transition: transform 0.25s ease; }
        .infinite-scroll { display: flex; animation: marquee 30s linear infinite; gap: 2rem; }
    </style>
</head>
<body class="bg-[#0a0b14] text-white min-h-screen hero-bg font-sans antialiased">

    <!-- navigation -->
    <nav class="fixed top-0 left-0 w-full z-50 px-4 md:px-8 py-6">
        <div class="max-w-7xl mx-auto flex justify-between items-center glass-panel px-6 py-4 rounded-3xl relative transition-all duration-300">
            <a href="{{ route('welcome') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('storage/logo.png') }}" alt="EliteMatrixPro" class="w-10 h-10 object-contain group-hover:scale-110 transition-transform duration-300">
                <span class="text-xl font-black text-white tracking-tighter italic">EliteMatrix<span class="text-purple-500">Pro</span></span>
            </a>
            <div class="hidden lg:flex items-center gap-8">
                <a href="{{ route('welcome') }}" class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 hover:text-white transition-colors">Home</a>
                <a href="{{ route('about') }}" class="text-[10px] font-black uppercase tracking-[0.2em] text-white border-b-2 border-purple-500 pb-1">About</a>
            </div>
            <div class="flex items-center gap-4">
                <div class="hidden sm:flex items-center gap-3">
                    <a href="{{ route('login') }}" class="px-6 py-2.5 rounded-xl bg-white/5 border border-white/10 text-[10px] font-black uppercase tracking-[0.2em] text-white hover:bg-white/10 transition-all">Login</a>
                    <a href="{{ route('register') }}" class="px-6 py-2.5 rounded-xl bg-purple-600 text-white text-[10px] font-black uppercase tracking-[0.2em] hover:bg-purple-500 transition-all shadow-lg shadow-purple-500/20">Sign Up</a>
                </div>
                <button id="menu-toggle" class="lg:hidden p-3 bg-purple-600/20 rounded-xl text-white border border-purple-500/30 hover:bg-purple-600/40 transition-all">
                    <i data-lucide="menu" id="icon-menu" class="w-6 h-6"></i>
                    <i data-lucide="x" id="icon-close" class="w-6 h-6 hidden"></i>
                </button>
            </div>
            <div id="mobile-menu" class="absolute top-[110%] left-0 w-full rounded-2xl p-8 flex flex-col gap-6 lg:hidden z-50 shadow-2xl">
                <a href="{{ route('welcome') }}" class="text-xs font-bold uppercase tracking-widest text-white border-b border-white/5 pb-4">Home</a>
                <a href="{{ route('about') }}" class="text-xs font-bold uppercase tracking-widest text-purple-400 border-b border-white/5 pb-4">About</a>
                <div class="flex flex-col gap-3 pt-4">
                    <a href="{{ route('login') }}" class="w-full py-4 text-center border border-white/10 rounded-2xl text-xs font-bold text-white uppercase tracking-widest">Login</a>
                    <a href="{{ route('register') }}" class="w-full py-4 text-center bg-purple-600 rounded-2xl text-xs font-bold text-white uppercase tracking-widest shadow-xl shadow-purple-500/20">Create Account</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- main content -->
    <div class="pt-40 pb-24 px-6 max-w-7xl mx-auto relative z-10">

        <!-- HERO with massive stats & trust badges -->
        <div class="text-center mb-24 animate-fade-in">
            <div class="inline-flex items-center gap-2 glass-panel px-4 py-2 rounded-full mb-8 border-purple-500/30">
                <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                <span class="text-[10px] font-black uppercase tracking-widest text-white">since 2024 · 17,200+ members · $189M AUM</span>
            </div>
            <h1 class="text-5xl md:text-7xl font-black text-white leading-[1.1] tracking-tighter mb-8 max-w-5xl mx-auto">
                We don't just predict the future of <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-indigo-400 text-glow">finance</span> — we build it.
            </h1>
            <p class="text-lg md:text-xl text-gray-400 max-w-3xl mx-auto leading-relaxed font-light">
                EliteMatrixPro combines algorithmic precision, decentralized infrastructure, and a global community to create a wealth ecosystem that’s transparent, scalable, and resilient. Every number is verifiable on‑chain.
            </p>
            
            <!-- expanded stats row (7 metrics) -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-16 stats-bg p-8 rounded-[4rem]">
                <div><div class="text-3xl md:text-4xl font-black text-white">$189M+</div><div class="text-xs uppercase tracking-widest text-gray-500 mt-1">total AUM</div></div>
                <div><div class="text-3xl md:text-4xl font-black text-white">62,400+</div><div class="text-xs uppercase tracking-widest text-gray-500 mt-1">active wallets</div></div>
                <div><div class="text-3xl md:text-4xl font-black text-white">3.18%</div><div class="text-xs uppercase tracking-widest text-gray-500 mt-1">avg weekly ROI (52w)</div></div>
                <div><div class="text-3xl md:text-4xl font-black text-white">15</div><div class="text-xs uppercase tracking-widest text-gray-500 mt-1">compression levels</div></div>
                <div><div class="text-3xl md:text-4xl font-black text-white">47</div><div class="text-xs uppercase tracking-widest text-gray-500 mt-1">countries</div></div>
                <div><div class="text-3xl md:text-4xl font-black text-white">$4.2M</div><div class="text-xs uppercase tracking-widest text-gray-500 mt-1">insurance fund</div></div>
                <div><div class="text-3xl md:text-4xl font-black text-white">0</div><div class="text-xs uppercase tracking-widest text-gray-500 mt-1">security breaches</div></div>
                <div><div class="text-3xl md:text-4xl font-black text-white">8</div><div class="text-xs uppercase tracking-widest text-gray-500 mt-1">external audits</div></div>
            </div>

            <!-- infinite trust marquee (logos as text) -->
            <div class="w-full overflow-hidden mt-12 opacity-60">
                <div class="infinite-scroll text-xs font-black tracking-[0.3em] text-gray-600 uppercase">
                    <span>audited by certik • chainlink oracle integration • polygon edge • licensed msb • iso 27001 pending • multi-sig 6/9 •</span>
                    <span>audited by certik • chainlink oracle integration • polygon edge • licensed msb • iso 27001 pending • multi-sig 6/9 •</span>
                </div>
            </div>
        </div>

        <!-- core philosophy (now with 4 pillars) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-24">
            <div class="glass-panel p-10 rounded-[2.5rem] space-y-6 hover:border-purple-500/30 transition-all group hover-lift">
                <div class="w-14 h-14 bg-purple-600/10 rounded-2xl flex items-center justify-center text-purple-400 group-hover:bg-purple-600 group-hover:text-white transition-all">
                    <i data-lucide="trending-up" class="w-8 h-8"></i>
                </div>
                <h3 class="text-2xl font-bold text-white uppercase tracking-tight">High‑frequency arbitrage engine</h3>
                <p class="text-sm text-gray-400 leading-relaxed font-medium">
                    Our proprietary stack monitors 62 exchanges (CEX/DEX) simultaneously, executing cross‑exchange and triangular arbitrage in 2‑4ms. We capture micro‑inefficiencies — as low as 0.015% — and aggregate them into consistent weekly returns. Every trade is logged on‑chain for verifiable proof.
                </p>
                <ul class="space-y-2 text-sm text-gray-400 font-medium">
                    <li class="flex items-center gap-3"><i data-lucide="check" class="w-4 h-4 text-emerald-400"></i> latency optimized < 5ms (p99 6.2ms)</li>
                    <li class="flex items-center gap-3"><i data-lucide="check" class="w-4 h-4 text-emerald-400"></i> 14,200+ backtested simulations daily</li>
                    <li class="flex items-center gap-3"><i data-lucide="check" class="w-4 h-4 text-emerald-400"></i> 2025 Sharpe ratio: 2.8</li>
                </ul>
            </div>
            <div class="glass-panel p-10 rounded-[2.5rem] space-y-6 hover:border-indigo-500/30 transition-all group hover-lift">
                <div class="w-14 h-14 bg-indigo-600/10 rounded-2xl flex items-center justify-center text-indigo-400 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                    <i data-lucide="shield-check" class="w-8 h-8"></i>
                </div>
                <h3 class="text-2xl font-bold text-white uppercase tracking-tight">Secure & multi‑layered yield</h3>
                <p class="text-sm text-gray-400 leading-relaxed font-medium">
                    Beyond arbitrage, we allocate to DeFi lending (Aave, Compound, Morpho), liquid staking (Lido, RocketPool, ether.fi), and real‑world asset vaults (Treasury bills, tokenized credit). All strategies are governed by real‑time risk‑parity models: if volatility exceeds thresholds, positions are automatically hedged.
                </p>
                <ul class="space-y-2 text-sm text-gray-400 font-medium">
                    <li class="flex items-center gap-3"><i data-lucide="check" class="w-4 h-4 text-emerald-400"></i> 4 independent security audits (2025)</li>
                    <li class="flex items-center gap-3"><i data-lucide="check" class="w-4 h-4 text-emerald-400"></i> insurance fund: $4.2M (Nexus Mutual coverage)</li>
                    <li class="flex items-center gap-3"><i data-lucide="check" class="w-4 h-4 text-emerald-400"></i> max drawdown 2025: -3.7%</li>
                </ul>
            </div>
            <!-- two more pillars (added) -->
            <div class="glass-panel p-10 rounded-[2.5rem] space-y-6 hover:border-emerald-500/30 transition-all group hover-lift">
                <div class="w-14 h-14 bg-emerald-600/10 rounded-2xl flex items-center justify-center text-emerald-400 group-hover:bg-emerald-600 group-hover:text-white transition-all">
                    <i data-lucide="globe" class="w-8 h-8"></i>
                </div>
                <h3 class="text-2xl font-bold text-white uppercase tracking-tight">real‑world asset tokenization</h3>
                <p class="text-sm text-gray-400 leading-relaxed font-medium">
                    We partner with regulated asset managers to bring institutional-grade real estate, private credit, and infrastructure debt on‑chain. Our members gain fractional exposure to assets previously requiring $1M+ minimums — fully collateralized and regularly audited.
                </p>
                <ul class="space-y-2 text-sm text-gray-400 font-medium">
                    <li class="flex items-center gap-3"><i data-lucide="check" class="w-4 h-4 text-emerald-400"></i> $41M tokenized real estate (Miami, Dubai)</li>
                    <li class="flex items-center gap-3"><i data-lucide="check" class="w-4 h-4 text-emerald-400"></i> private credit yield: 8.2% p.a. (senior secured)</li>
                </ul>
            </div>
            <div class="glass-panel p-10 rounded-[2.5rem] space-y-6 hover:border-red-500/30 transition-all group hover-lift">
                <div class="w-14 h-14 bg-red-600/10 rounded-2xl flex items-center justify-center text-red-400 group-hover:bg-red-600 group-hover:text-white transition-all">
                    <i data-lucide="bot" class="w-8 h-8"></i>
                </div>
                <h3 class="text-2xl font-bold text-white uppercase tracking-tight">AI‑driven portfolio rebalancing</h3>
                <p class="text-sm text-gray-400 leading-relaxed font-medium">
                    Our proprietary AI (MatrixMind) analyzes macroeconomic data, on‑chain flows, and sentiment indices to dynamically allocate between strategies. It predicts optimal risk‑adjusted positions and automatically rebalances every 6 hours.
                </p>
                <ul class="space-y-2 text-sm text-gray-400 font-medium">
                    <li class="flex items-center gap-3"><i data-lucide="check" class="w-4 h-4 text-emerald-400"></i> trained on 7 years of historical data</li>
                    <li class="flex items-center gap-3"><i data-lucide="check" class="w-4 h-4 text-emerald-400"></i> reduces volatility by 32% vs. static allocation</li>
                </ul>
            </div>
        </div>

        <!-- three investment pillars (restyled + extra data) -->
        <div class="glass-panel p-12 rounded-[3.5rem] relative overflow-hidden group mb-24">
            <div class="absolute -top-24 -right-24 w-80 h-80 bg-purple-600/10 rounded-full blur-[100px]"></div>
            <div class="relative z-10 text-center space-y-12">
                <h2 class="text-3xl md:text-5xl font-black text-white tracking-tighter uppercase">Strategic pillars</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-left">
                    <div class="space-y-4 p-6 rounded-3xl bg-white/5 border border-white/5">
                        <div class="text-purple-400 font-black text-3xl">01.</div>
                        <h4 class="text-white font-black text-xl">Neural arbitrage</h4>
                        <p class="text-sm text-gray-400 leading-relaxed font-medium">Transformer‑based models detect cross‑chain price dislocations before they propagate. In Q1 2026, this engine contributed 44% of total returns.</p>
                        <div class="text-[10px] font-bold text-purple-400 uppercase tracking-wider">latency: 2.4ms avg · 14μs outliers</div>
                        <div class="text-xs text-gray-500">profit factor: 3.1</div>
                    </div>
                    <div class="space-y-4 p-6 rounded-3xl bg-white/5 border border-white/5">
                        <div class="text-indigo-400 font-black text-3xl">02.</div>
                        <h4 class="text-white font-black text-xl">Venture capital syndicate</h4>
                        <p class="text-sm text-gray-400 leading-relaxed font-medium">We invest early in fininfra, modular L2s, and tokenized RWAs. Our community gets pro‑rata access — previously reserved for tier‑1 VCs. 9 active portfolio companies, 2 exits.</p>
                        <div class="text-[10px] font-bold text-indigo-400 uppercase tracking-wider">TVPI: 2.4x · DPI: 0.9x</div>
                    </div>
                    <div class="space-y-4 p-6 rounded-3xl bg-white/5 border border-white/5">
                        <div class="text-emerald-400 font-black text-3xl">03.</div>
                        <h4 class="text-white font-black text-xl">Institutional liquidity</h4>
                        <p class="text-sm text-gray-400 leading-relaxed font-medium">As a top‑tier LP for 7 DeFi protocols, we capture protocol‑owned liquidity incentives and trading fees, passed directly to members. $94M total value deployed.</p>
                        <div class="text-[10px] font-bold text-emerald-400 uppercase tracking-wider">avg APY from incentives: 5.8%</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 15‑level deep-dive + rewards + extra compression details -->
        <div class="mb-24">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-black text-white uppercase tracking-tight">matrix network: 15-level yield compression</h2>
                <p class="text-gray-400 mt-4 leading-relaxed max-w-2xl mx-auto uppercase text-sm font-bold tracking-widest">passive ROI from your entire downline — paid weekly</p>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="glass-panel p-10 rounded-[2.5rem] border-purple-500/20 relative overflow-hidden hover-lift">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-purple-500/10 blur-[50px] rounded-full"></div>
                    <h3 class="text-2xl font-bold text-white uppercase tracking-wider mb-6">level commissions (on ROI)</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center border-b border-white/5 pb-2"><span class="text-purple-400 font-bold">level 1 (direct)</span><span class="text-white font-black text-lg">20%</span></div>
                        <div class="flex justify-between items-center border-b border-white/5 pb-2"><span class="text-indigo-400 font-bold">level 2</span><span class="text-white font-black text-lg">12%</span></div>
                        <div class="flex justify-between items-center border-b border-white/5 pb-2"><span class="text-blue-400 font-bold">level 3</span><span class="text-white font-black text-lg">9%</span></div>
                        <div class="flex justify-between items-center border-b border-white/5 pb-2"><span class="text-gray-400 font-bold">levels 4‑6</span><span class="text-white font-black">6%</span></div>
                        <div class="flex justify-between items-center border-b border-white/5 pb-2"><span class="text-gray-400 font-bold">levels 7‑10</span><span class="text-white font-black">4%</span></div>
                        <div class="flex justify-between items-center"><span class="text-gray-400 font-bold">levels 11‑15</span><span class="text-white font-black">2%</span></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-6 font-medium">* percentages based on the ROI generated by your team (capped at 150% of own capital)</p>
                    <p class="text-xs text-gray-500 mt-1 font-medium">** unlimited depth compression: inactive members are skipped, you earn on active downline only.</p>
                </div>
                
                <div class="glass-panel p-10 rounded-[2.5rem] border-emerald-500/20 relative overflow-hidden hover-lift">
                    <div class="w-14 h-14 bg-emerald-600/10 rounded-2xl flex items-center justify-center text-emerald-400 mb-6">
                        <i data-lucide="award" class="w-8 h-8"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white uppercase tracking-wider mb-4">club vouchers & accelerator</h3>
                    <p class="text-sm text-gray-400 leading-relaxed font-semibold mb-4">
                        As your team grows, you unlock non‑cashable vouchers ($500 – $10,000) that act as synthetic principal — they generate ROI and commissions forever, without spending extra capital.
                    </p>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-center gap-3"><span class="w-24 text-purple-400 font-bold">10k DB*</span><span class="text-white">$500 voucher</span><span class="text-gray-500 text-[10px]">(unlocks 0.5% extra)</span></li>
                        <li class="flex items-center gap-3"><span class="w-24 text-indigo-400 font-bold">50k DB</span><span class="text-white">$2,500 voucher</span><span class="text-gray-500 text-[10px]">(+1% on level 1)</span></li>
                        <li class="flex items-center gap-3"><span class="w-24 text-emerald-400 font-bold">250k DB</span><span class="text-white">$7,500 voucher</span><span class="text-gray-500 text-[10px]">(elite status)</span></li>
                        <li class="flex items-center gap-3"><span class="w-24 text-amber-400 font-bold">1M DB</span><span class="text-white">$10,000 voucher</span><span class="text-gray-500 text-[10px]">+global profit share</span></li>
                    </ul>
                    <p class="text-[10px] text-gray-500 mt-4">* DB = direct business volume (level 1) · vouchers stack weekly</p>
                </div>
            </div>
        </div>

        <!-- core contributors expanded (with roles & linkedin mock) -->
        <div class="glass-panel p-12 rounded-[3.5rem] mb-24 border border-indigo-500/20">
            <h3 class="text-2xl font-black text-white text-center uppercase tracking-[0.2em] mb-12">core contributors & leadership</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div><div class="w-20 h-20 mx-auto bg-gradient-to-br from-purple-500 to-indigo-600 rounded-3xl flex items-center justify-center text-3xl font-black text-white mb-3">AV</div><div class="text-white font-bold">Alex V.</div><div class="text-[9px] uppercase tracking-widest text-gray-500">ex‑Citadel quant</div><div class="text-[8px] text-purple-400 mt-1">15y HFT</div></div>
                <div><div class="w-20 h-20 mx-auto bg-gradient-to-br from-indigo-500 to-purple-600 rounded-3xl flex items-center justify-center text-3xl font-black text-white mb-3">SC</div><div class="text-white font-bold">Sofia C.</div><div class="text-[9px] uppercase tracking-widest text-gray-500">blockchain security</div><div class="text-[8px] text-purple-400 mt-1">ex‑Trail of Bits</div></div>
                <div><div class="w-20 h-20 mx-auto bg-gradient-to-br from-emerald-500 to-indigo-600 rounded-3xl flex items-center justify-center text-3xl font-black text-white mb-3">MK</div><div class="text-white font-bold">Marcus K.</div><div class="text-[9px] uppercase tracking-widest text-gray-500">DeFi architect</div><div class="text-[8px] text-purple-400 mt-1">compound v3 contributor</div></div>
                <div><div class="w-20 h-20 mx-auto bg-gradient-to-br from-red-500 to-purple-600 rounded-3xl flex items-center justify-center text-3xl font-black text-white mb-3">DR</div><div class="text-white font-bold">Daria R.</div><div class="text-[9px] uppercase tracking-widest text-gray-500">head of strategy</div><div class="text-[8px] text-purple-400 mt-1">ex‑Goldman Sachs</div></div>
            </div>
            <p class="text-xs text-gray-500 text-center max-w-xl mx-auto mt-8 font-medium">Advised by a council with background in traditional finance, high‑frequency trading, and on‑chain governance. 7 advisors from top20 funds.</p>
        </div>

        <!-- security & operations (expanded with 8 items) -->
        <div class="glass-panel p-12 rounded-[3.5rem] border border-red-500/20 bg-gradient-to-b from-red-900/10 to-transparent mb-24">
            <h3 class="text-2xl font-black text-white text-center uppercase tracking-[0.3em] mb-4">fortified infrastructure & operations</h3>
            <p class="text-center text-gray-400 text-sm max-w-2xl mx-auto mb-12">Redundant, verifiable, and always auditable. We never take custody of user private keys.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="glass-panel p-6 rounded-2xl flex flex-col gap-3 hover:border-red-400/20">
                    <i data-lucide="lock" class="w-8 h-8 text-red-400"></i>
                    <h4 class="text-white font-bold text-base">multi‑sig treasury</h4><p class="text-sm text-gray-400">All assets in 6/9 multi‑signature wallets with 48h timelocks. Signers are distributed globally.</p>
                </div>
                <div class="glass-panel p-6 rounded-2xl flex flex-col gap-3 hover:border-indigo-400/20">
                    <i data-lucide="server" class="w-8 h-8 text-indigo-400"></i>
                    <h4 class="text-white font-bold text-base">cron‑scheduler + on‑chain proofs</h4><p class="text-sm text-gray-400">Weekly payouts executed by a tamper‑proof cron; each tx recorded on Polygon and Celestia.</p>
                </div>
                <div class="glass-panel p-6 rounded-2xl flex flex-col gap-3 hover:border-emerald-400/20">
                    <i data-lucide="eye" class="w-8 h-8 text-emerald-400"></i>
                    <h4 class="text-white font-bold text-base">real‑time reserve dashboard</h4><p class="text-sm text-gray-400">Audit the entire reserve wallet, verify inflows, and track protocol yields live (Dune analytics).</p>
                </div>
                <div class="glass-panel p-6 rounded-2xl flex flex-col gap-3 hover:border-blue-400/20">
                    <i data-lucide="shield" class="w-8 h-8 text-blue-400"></i>
                    <h4 class="text-white font-bold text-base">offline disaster recovery</h4><p class="text-sm text-gray-400">Daily encrypted snapshots across 3 regions; full recovery within 2 hours. Geographically distributed.</p>
                </div>
                <div class="glass-panel p-6 rounded-2xl flex flex-col gap-3 hover:border-purple-400/20">
                    <i data-lucide="fingerprint" class="w-8 h-8 text-purple-400"></i>
                    <h4 class="text-white font-bold text-base">biometric 2FA</h4><p class="text-sm text-gray-400">Hardware key support (YubiKey, Passkey) for all admin and withdrawal operations.</p>
                </div>
                <div class="glass-panel p-6 rounded-2xl flex flex-col gap-3 hover:border-amber-400/20">
                    <i data-lucide="scale" class="w-8 h-8 text-amber-400"></i>
                    <h4 class="text-white font-bold text-base">legal & compliance</h4><p class="text-sm text-gray-400">Registered in EU (Lithuania) as VASP, pending MiCA license. Regular financial audits by Grant Thornton.</p>
                </div>
                <div class="glass-panel p-6 rounded-2xl flex flex-col gap-3 hover:border-sky-400/20">
                    <i data-lucide="activity" class="w-8 h-8 text-sky-400"></i>
                    <h4 class="text-white font-bold text-base">24/7 monitoring</h4><p class="text-sm text-gray-400">Abnormal transaction detection, withdrawal velocity limits, and AI‑based fraud screening.</p>
                </div>
                <div class="glass-panel p-6 rounded-2xl flex flex-col gap-3 hover:border-rose-400/20">
                    <i data-lucide="file-check" class="w-8 h-8 text-rose-400"></i>
                    <h4 class="text-white font-bold text-base">proof of reserves</h4><p class="text-sm text-gray-400">Monthly merkle‑tree proof of liabilities vs. on‑chain assets, verified by third party.</p>
                </div>
            </div>
        </div>

        <!-- long‑term vision & roadmap (expanded) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-24">
            <div class="glass-panel p-10 rounded-[2.5rem] space-y-5">
                <i data-lucide="map" class="w-10 h-10 text-purple-400"></i>
                <h3 class="text-white font-black text-xl uppercase tracking-wide">2026 roadmap</h3>
                <ul class="space-y-4 text-sm">
                    <li class="flex gap-3"><span class="text-purple-400 font-black min-w-[3rem]">Q2</span><span class="text-gray-300">liquid staking vaults (Lido, RocketPool, ether.fi) integration; stETH/ETH loop strategies</span></li>
                    <li class="flex gap-3"><span class="text-purple-400 font-black min-w-[3rem]">Q3</span><span class="text-gray-300">tokenized real‑estate debt pool — $25M target (Miami, Dubai, Singapore)</span></li>
                    <li class="flex gap-3"><span class="text-purple-400 font-black min-w-[3rem]">Q4</span><span class="text-gray-300">EliteMatrix card (crypto‑to‑fiat) + mobile app with biometrics, P2P swaps</span></li>
                    <li class="flex gap-3"><span class="text-purple-400 font-black min-w-[3rem]">2027</span><span class="text-gray-300">institutional custody solution, licensed in HK & UAE; expansion to 100+ employees</span></li>
                </ul>
            </div>
            <div class="glass-panel p-10 rounded-[2.5rem] space-y-5">
                <i data-lucide="globe" class="w-10 h-10 text-indigo-400"></i>
                <h3 class="text-white font-black text-xl uppercase tracking-wide">global footprint & partners</h3>
                <p class="text-sm text-gray-300">Members in 47 countries · regional hubs in Dubai, Singapore, Panama · licensed MSB in 3 jurisdictions. Key partners:</p>
                <div class="flex flex-wrap gap-4 mt-2 text-xs font-bold text-gray-400">
                    <span class="glass-panel px-3 py-1">Fireblocks</span>
                    <span class="glass-panel px-3 py-1">Chainlink</span>
                    <span class="glass-panel px-3 py-1">Elliptic</span>
                    <span class="glass-panel px-3 py-1">Polygon</span>
                    <span class="glass-panel px-3 py-1">Avalanche</span>
                    <span class="glass-panel px-3 py-1">Circle</span>
                </div>
                <p class="text-xs text-gray-500 mt-4">We're a member of the Global Digital Finance (GDF) code of conduct.</p>
            </div>
        </div>

        <!-- FAQ snippet / trust indicators -->
        <div class="glass-panel p-12 rounded-[3.5rem] border border-white/5 mb-24">
            <h3 class="text-xl font-black text-white text-center uppercase tracking-[0.2em] mb-10">frequently asked questions</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div><h4 class="text-white font-bold mb-2">How is ROI generated?</h4><p class="text-sm text-gray-400">Through a combination of HFT arbitrage, liquidity provision, DeFi lending, and RWA yields — all diversified by AI risk engine.</p></div>
                <div><h4 class="text-white font-bold mb-2">Is principal guaranteed?</h4><p class="text-sm text-gray-400">Principal is not guaranteed in the traditional sense, but we maintain a $4.2M insurance fund to cover smart contract risks and black swans.</p></div>
                <div><h4 class="text-white font-bold mb-2">Can I withdraw anytime?</h4><p class="text-sm text-gray-400">Yes. Withdrawals are processed within 24h on weekdays. Large withdrawals (>1% of AUM) may take 48h for liquidity management.</p></div>
                <div><h4 class="text-white font-bold mb-2">What audits have you done?</h4><p class="text-sm text-gray-400">8 audits by Certik, Hacken, and Code4rena. Smart contracts are open source and verified.</p></div>
            </div>
        </div>

        <!-- final cta + social proof + guarantee -->
        <div class="mt-20 text-center">
            <a href="{{ route('register') }}" class="inline-flex items-center gap-4 px-12 py-6 rounded-2xl bg-gradient-to-r from-purple-600 to-indigo-600 text-white text-sm font-black uppercase tracking-widest hover:scale-105 transition-all shadow-2xl shadow-purple-900/40 animate-glow">
                Join 17,200+ forward thinkers <i data-lucide="arrow-right" class="w-5 h-5"></i>
            </a>
            <p class="text-[10px] text-gray-600 mt-6 font-bold tracking-widest">*your first deposit up to $1,000 is covered by the 7-day principal guarantee (terms apply)</p>
            <p class="text-[9px] text-gray-700 mt-2">EliteMatrixPro does not offer investment guarantees. Past performance does not guarantee future results. DYOR.</p>
        </div>
    </div>

    <!-- footer with extra links -->
    <footer class="py-12 border-t border-white/5 relative z-10">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <div class="flex items-center justify-center gap-3 mb-6">
                <img src="{{ asset('storage/logo.png') }}" alt="Logo" class="w-6 h-6 object-contain">
                <span class="text-lg font-black text-white italic">EliteMatrix<span class="text-purple-500">Pro</span></span>
            </div>
            <div class="flex flex-wrap justify-center gap-6 text-[9px] font-black uppercase tracking-widest text-gray-600 mb-6">
                <a href="#" class="hover:text-white">privacy</a>
                <a href="#" class="hover:text-white">terms</a>
                <a href="#" class="hover:text-white">risks</a>
                <a href="#" class="hover:text-white">audits</a>
                <a href="#" class="hover:text-white">proof of reserves</a>
            </div>
            <p class="text-[10px] text-gray-600 font-bold uppercase tracking-[0.3em]">© 2026 EliteMatrixPro · verifiable · decentralized · audited</p>
        </div>
    </footer>

    <script>
        lucide.createIcons();
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        const iconMenu = document.getElementById('icon-menu');
        const iconClose = document.getElementById('icon-close');

        function toggleMenu(forceClose = false) {
            const isActive = forceClose ? false : !mobileMenu.classList.contains('active');
            if (isActive) {
                mobileMenu.classList.add('active');
                iconMenu.classList.add('hidden');
                iconClose.classList.remove('hidden');
            } else {
                mobileMenu.classList.remove('active');
                iconMenu.classList.remove('hidden');
                iconClose.classList.add('hidden');
            }
        }
        menuToggle?.addEventListener('click', (e) => { e.stopPropagation(); toggleMenu(); });
        document.addEventListener('click', (e) => {
            if (mobileMenu?.classList.contains('active') && !mobileMenu.contains(e.target) && e.target.tagName !== 'BUTTON') toggleMenu(true);
        });
        window.addEventListener('scroll', () => {
            const navDiv = document.querySelector('nav div');
            if (navDiv) navDiv.classList.toggle('bg-deep/80', window.scrollY > 20);
        });
    </script>
</body>
</html>