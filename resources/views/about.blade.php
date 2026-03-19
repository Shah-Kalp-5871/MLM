<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | EliteMatrixPro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('storage/logo.png') }}">
    @include('layouts.theme-master')
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        deep: '#0a0b14',
                        cardBg: 'rgba(255, 255, 255, 0.03)',
                        glassBorder: 'rgba(255, 255, 255, 0.08)',
                    },
                    animation: {
                        'pulse-slow': 'pulse 6s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #0a0b14; color: #94a3b8; }
        .glass-panel { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.08); }
        .text-glow { text-shadow: 0 0 20px rgba(147, 51, 234, 0.5); }
        .hero-bg { background-image: radial-gradient(circle at top right, rgba(88, 28, 135, 0.15), transparent 40%), radial-gradient(circle at bottom left, rgba(49, 46, 129, 0.15), transparent 40%); }
        
        /* Mobile Menu */
        #mobile-menu {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateY(-20px);
            opacity: 0;
            pointer-events: none;
            background: #0a0b14; /* Solid background for visibility */
            border: 1px solid rgba(147, 51, 234, 0.3);
        }
        #mobile-menu.active {
            transform: translateY(0);
            opacity: 1;
            pointer-events: auto;
        }
    </style>
</head>
<body class="selection:bg-purple-500 selection:text-white min-h-screen hero-bg">
    @include('partials.preloader')

    <!-- Navigation -->
    <nav class="fixed top-0 left-0 w-full z-50 px-4 md:px-8 py-6">
        <div class="max-w-7xl mx-auto flex justify-between items-center glass-panel px-6 py-4 rounded-3xl relative">
            <a href="{{ route('welcome') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('storage/logo.png') }}" alt="Logo" class="w-10 h-10 object-contain group-hover:scale-110 transition-transform">
                <span class="text-xl font-black text-white tracking-tighter italic">EliteMatrix<span class="text-purple-500">Pro</span></span>
            </a>
            <div class="hidden lg:flex items-center gap-8">
                <a href="{{ route('welcome') }}" class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 hover:text-white transition-colors">Home</a>
                <a href="{{ route('about') }}" class="text-[10px] font-black uppercase tracking-[0.2em] text-white">About</a>
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

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="absolute top-[110%] left-0 w-full rounded-2xl p-8 flex flex-col gap-6 lg:hidden z-50 shadow-2xl">
                <a href="{{ route('welcome') }}" class="text-xs font-bold uppercase tracking-widest text-white border-b border-white/5 pb-4">Home</a>
                <a href="{{ route('about') }}" class="text-xs font-bold uppercase tracking-widest text-white border-b border-white/5 pb-4">About</a>
                <div class="flex flex-col gap-3 pt-4">
                    <a href="{{ route('login') }}" class="w-full py-4 text-center border border-white/10 rounded-2xl text-xs font-bold text-white uppercase tracking-widest">Login</a>
                    <a href="{{ route('register') }}" class="w-full py-4 text-center bg-purple-600 rounded-2xl text-xs font-bold text-white uppercase tracking-widest shadow-xl shadow-purple-500/20">Create Account</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content Area -->
    <div class="pt-40 pb-24 px-6 max-w-5xl mx-auto relative z-10">
        <div class="text-center mb-20 animate-fade-in">
            <h1 class="text-4xl md:text-6xl font-black text-white leading-tight tracking-tighter mb-6">
                Redefining <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-indigo-400 text-glow">Wealth</span> Through Technology
            </h1>
            <p class="text-lg text-gray-400 max-w-2xl mx-auto leading-relaxed">
                At EliteMatrixPro, we don't just manage investments; we pioneer decentralized financial ecosystems built on transparency and algorithmic precision.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-20">
            <div class="glass-panel p-10 rounded-[2.5rem] space-y-6 hover:border-purple-500/30 transition-all group">
                <div class="w-14 h-14 bg-purple-600/10 rounded-2xl flex items-center justify-center text-purple-400 group-hover:bg-purple-600 group-hover:text-white transition-all">
                    <i data-lucide="trending-up" class="w-8 h-8"></i>
                </div>
                <h3 class="text-2xl font-bold text-white uppercase tracking-tight">How We Generate ROI</h3>
                <p class="text-sm text-gray-400 leading-relaxed font-medium capitalize">
                    Our unique return model is powered by a multi-layered trading infrastructure. We utilize high-frequency quantitative analysis and cross-exchange arbitrage to capture micro-fluctuations in global markets. by aggregating community liquidity, we provide essential volume to decentralized finance (DeFi) protocols, earning premium yields that are distributed back to our members as weekly ROI.
                </p>
            </div>
            <div class="glass-panel p-10 rounded-[2.5rem] space-y-6 hover:border-indigo-500/30 transition-all group">
                <div class="w-14 h-14 bg-indigo-600/10 rounded-2xl flex items-center justify-center text-indigo-400 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                    <i data-lucide="shield-check" class="w-8 h-8"></i>
                </div>
                <h3 class="text-2xl font-bold text-white uppercase tracking-tight">Secure & Scalable</h3>
                <p class="text-sm text-gray-400 leading-relaxed font-medium capitalize">
                    Transparency is our core pillar. Every transaction is governed by verifiable protocols, ensuring that your principal and earnings are always protected. Our 15-level network structure is mathematically optimized to ensure long-term sustainability while providing maximum growth potential for our dedicated partners.
                </p>
            </div>
        </div>

        <div class="glass-panel p-12 rounded-[3.5rem] relative overflow-hidden group mb-20">
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-purple-600/10 rounded-full blur-[80px]"></div>
            <div class="relative z-10 text-center space-y-8">
                <h2 class="text-3xl md:text-5xl font-black text-white tracking-tighter uppercase">Our Strategic Investment Pillars</h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 text-left">
                    <div class="space-y-3">
                        <div class="text-purple-400 font-black text-xl">01.</div>
                        <h4 class="text-white font-bold uppercase tracking-widest text-sm">AI Arbitrage</h4>
                        <p class="text-xs text-gray-500 leading-relaxed uppercase font-bold">Leveraging artificial intelligence to scan thousands of data points and execute profitable trades in milliseconds. Our neural networks analyze order books across 50+ central and decentralized exchanges simultaneously.</p>
                    </div>
                    <div class="space-y-3">
                        <div class="text-indigo-400 font-black text-xl">02.</div>
                        <h4 class="text-white font-bold uppercase tracking-widest text-sm">Global Venture Capital</h4>
                        <p class="text-xs text-gray-500 leading-relaxed uppercase font-bold">Investing in early-stage fintech disruptions and sustainable energy projects that promise exponential long-term growth. We bridge the gap between community capital and high-impact industrial opportunities.</p>
                    </div>
                    <div class="space-y-3">
                        <div class="text-emerald-400 font-black text-xl">03.</div>
                        <h4 class="text-white font-bold uppercase tracking-widest text-sm">Liquidity Provision</h4>
                        <p class="text-xs text-gray-500 leading-relaxed uppercase font-bold">Acting as a major liquidity provider for emerging fintech platforms to capture consistent service-based revenue. We facilitate institutional-grade flow while maintaining robust risk management protocols.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-20 animate-fade-in">
             <div class="glass-panel p-8 rounded-3xl border-white/5 space-y-4">
                <h4 class="text-white font-black text-lg uppercase italic">Corporate Governance</h4>
                <p class="text-[10px] text-gray-500 leading-relaxed uppercase font-bold">We operate under a strict framework of internal audits and real-time monitoring. Every dollar invested is tracked through our proprietary MatrixLedger system, ensuring that the ROI we deliver is backed by actual market performance and strategic yields.</p>
             </div>
             <div class="glass-panel p-8 rounded-3xl border-white/5 space-y-4">
                <h4 class="text-white font-black text-lg uppercase italic">Risk Mitigation</h4>
                <p class="text-[10px] text-gray-500 leading-relaxed uppercase font-bold">Our risk engine uses predictive modeling to identify market downturns before they occur. By maintaining a diverse portfolio of HFT, real-world assets, and crypto-derivatives, we ensure a stable payout even during periods of high volatility.</p>
             </div>
             <div class="glass-panel p-8 rounded-3xl border-white/5 space-y-4">
                <h4 class="text-white font-black text-lg uppercase italic">Future Roadmap</h4>
                <p class="text-[10px] text-gray-500 leading-relaxed uppercase font-bold">EliteMatrixPro is expanding into tokenized real estate and cross-border payment gateways. Our vision is to create a unified platform where our members can participate in global wealth generation with zero barriers to entry. By 2027, we aim to be the primary liquidity hub for emerging markets, bridging the gap between traditional finance and the decentralized future.</p>
             </div>
        </div>

        <div class="glass-panel p-12 rounded-[3.5rem] border border-purple-500/20 bg-gradient-to-b from-purple-900/10 to-transparent mb-20">
            <h3 class="text-2xl font-black text-white text-center uppercase tracking-[0.3em] mb-10">Why EliteMatrixPro?</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div class="space-y-4">
                    <h4 class="text-white font-bold uppercase tracking-widest text-sm flex items-center gap-3">
                        <i data-lucide="check-circle" class="w-5 h-5 text-emerald-400"></i>
                        Proven Track Record
                    </h4>
                    <p class="text-[11px] text-gray-500 leading-relaxed uppercase font-bold">Our core team consists of quantitative analysts and financial engineers with over a decade of experience in traditional hedge funds. We've weathered market cycles by strictly adhering to our automated risk-parity models.</p>
                </div>
                <div class="space-y-4">
                    <h4 class="text-white font-bold uppercase tracking-widest text-sm flex items-center gap-3">
                        <i data-lucide="check-circle" class="w-5 h-5 text-emerald-400"></i>
                        Community First
                    </h4>
                    <p class="text-[11px] text-gray-500 leading-relaxed uppercase font-bold">Unlike traditional VC funds, we believe in the power of the crowd. EliteMatrixPro is designed to democratize access to high-yield opportunities that were previously reserved for institutional players.</p>
                </div>
                <div class="space-y-4">
                    <h4 class="text-white font-bold uppercase tracking-widest text-sm flex items-center gap-3">
                        <i data-lucide="check-circle" class="w-5 h-5 text-emerald-400"></i>
                        Verifiable Payouts
                    </h4>
                    <p class="text-[11px] text-gray-500 leading-relaxed uppercase font-bold">Our weekly 3%-3.5% ROI is not a promise; it's a reflection of our actual performance. We maintain a reserve fund to guarantee consistency even during weeks of lower market volatility.</p>
                </div>
                <div class="space-y-4">
                    <h4 class="text-white font-bold uppercase tracking-widest text-sm flex items-center gap-3">
                        <i data-lucide="check-circle" class="w-5 h-5 text-emerald-400"></i>
                        Global Scalability
                    </h4>
                    <p class="text-[11px] text-gray-500 leading-relaxed uppercase font-bold">With members in over 40 countries, our network effects are our greatest asset. As we scale, our bargaining power with liquidity protocols increases, allowing for even better yield capture.</p>
                </div>
            </div>
        </div>

        <!-- 15-Level Network Plan Section -->
        <div class="mb-20">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-black text-white uppercase tracking-tight">The Power of the Matrix Network</h2>
                <p class="text-gray-400 mt-4 leading-relaxed max-w-2xl mx-auto uppercase text-xs font-bold tracking-widest">
                    Your wealth accelerates through our 15-level deep compensation plan. When your network earns, you earn.
                </p>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                <div class="glass-panel p-10 rounded-[2.5rem] border-purple-500/20 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-purple-500/10 blur-[50px] rounded-full"></div>
                    <h3 class="text-xl font-bold text-white uppercase tracking-wider mb-6">Passive Level Income</h3>
                    <p class="text-[11px] text-gray-400 leading-relaxed uppercase font-bold mb-6">
                        Every time a member in your network receives their weekly ROI, you receive a percentage of that return. This is real, verifiable yield-sharing, extending all the way down to 15 levels of your tree.
                    </p>
                    <ul class="space-y-4">
                        <li class="flex items-center justify-between text-sm glass-panel py-3 px-4 rounded-xl">
                            <span class="text-purple-400 font-bold">Level 1 (Direct)</span>
                            <span class="text-white font-black">20% of ROI</span>
                        </li>
                        <li class="flex items-center justify-between text-sm glass-panel py-3 px-4 rounded-xl">
                            <span class="text-indigo-400 font-bold">Level 2</span>
                            <span class="text-white font-black">12% of ROI</span>
                        </li>
                        <li class="flex items-center justify-between text-sm glass-panel py-3 px-4 rounded-xl">
                            <span class="text-blue-400 font-bold">Level 3</span>
                            <span class="text-white font-black">9% of ROI</span>
                        </li>
                        <li class="flex items-center justify-between text-[10px] text-gray-500 uppercase font-bold px-4">
                            Levels 4-6: 6% • Levels 7-10: 4% • Levels 11-15: 2%
                        </li>
                    </ul>
                </div>
                
                <div class="glass-panel p-10 rounded-[2.5rem] border-emerald-500/20 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/10 blur-[50px] rounded-full"></div>
                    <div class="w-14 h-14 bg-emerald-600/10 rounded-2xl flex items-center justify-center text-emerald-400 mb-6">
                        <i data-lucide="award" class="w-8 h-8"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white uppercase tracking-wider mb-4">Elite Club Vouchers</h3>
                    <p class="text-[11px] text-gray-400 leading-relaxed uppercase font-bold mb-6">
                        We turn incredible growth into tangible rewards. As your **Direct Business** (Level 1 volume) and **Team Business** (Total Network volume) cross key milestones, you automatically unlock compounding Club Vouchers.
                    </p>
                    <p class="text-[11px] text-gray-400 leading-relaxed uppercase font-bold">
                        These vouchers act as digital investment tokens, ranging from **$500 to $5,000**, which are instantly reinvested into the ecosystem to turbo-charge your weekly returns without any additional out-of-pocket capital.
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-20 text-center animate-float">
            <a href="{{ route('register') }}" class="inline-flex items-center gap-4 px-12 py-6 rounded-2xl bg-gradient-to-r from-purple-600 to-indigo-600 text-white text-sm font-black uppercase tracking-widest hover:scale-105 transition-all shadow-2xl shadow-purple-900/40">
                Join our success story <i data-lucide="arrow-right" class="w-5 h-5"></i>
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="py-12 border-t border-white/5 relative z-10 text-center">
        <div class="flex items-center justify-center gap-3 mb-6">
            <img src="{{ asset('storage/logo.png') }}" alt="Logo" class="w-6 h-6 object-contain">
            <span class="text-lg font-black text-white italic">EliteMatrix<span class="text-purple-500">Pro</span></span>
        </div>
        <p class="text-[10px] text-gray-600 font-bold uppercase tracking-[0.3em]">&copy; 2026 EliteMatrixPro. Empowering Decentralized Wealth.</p>
    </footer>

    <script>
        lucide.createIcons();

        // Mobile Menu Logic
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

        if (menuToggle) {
            menuToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                toggleMenu();
            });
        }

        // Close menu on click outside or on links
        document.addEventListener('click', (e) => {
            if (mobileMenu && mobileMenu.classList.contains('active')) {
                const isClickInsideMenu = mobileMenu.contains(e.target);
                const isClickOnLink = e.target.tagName === 'A' || e.target.closest('a');
                
                if (!isClickInsideMenu || (isClickInsideMenu && isClickOnLink)) {
                    toggleMenu(true);
                }
            }
        });

        // Sticky Nav Effect
        window.addEventListener('scroll', () => {
            const nav = document.querySelector('nav div');
            if (nav) {
                if (window.scrollY > 20) {
                    nav.classList.add('shadow-2xl', 'shadow-purple-500/20', 'bg-deep/80');
                } else {
                    nav.classList.remove('shadow-2xl', 'shadow-purple-500/20', 'bg-deep/80');
                }
            }
        });
    </script>
</body>
</html>
