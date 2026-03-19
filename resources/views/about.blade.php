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
        .hero-bg { background: radial-gradient(circle at top right, rgba(88, 28, 135, 0.15), transparent 40%), radial-gradient(circle at bottom left, rgba(49, 46, 129, 0.15), transparent 40%); }
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
            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('welcome') }}" class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 hover:text-white transition-colors">Home</a>
                <a href="{{ route('about') }}" class="text-[10px] font-black uppercase tracking-[0.2em] text-white">About</a>
                <a href="{{ route('login') }}" class="px-6 py-2.5 rounded-xl bg-white/5 border border-white/10 text-[10px] font-black uppercase tracking-[0.2em] text-white hover:bg-white/10 transition-all">Login</a>
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

        <div class="glass-panel p-12 rounded-[3.5rem] relative overflow-hidden group">
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-purple-600/10 rounded-full blur-[80px]"></div>
            <div class="relative z-10 text-center space-y-8">
                <h2 class="text-3xl md:text-5xl font-black text-white tracking-tighter uppercase">Our Strategic Investment Pillars</h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 text-left">
                    <div class="space-y-3">
                        <div class="text-purple-400 font-black text-xl">01.</div>
                        <h4 class="text-white font-bold uppercase tracking-widest text-sm">AI Arbitrage</h4>
                        <p class="text-xs text-gray-500 leading-relaxed">Leveraging artificial intelligence to scan thousands of data points and execute profitable trades in milliseconds.</p>
                    </div>
                    <div class="space-y-3">
                        <div class="text-indigo-400 font-black text-xl">02.</div>
                        <h4 class="text-white font-bold uppercase tracking-widest text-sm">Real Estate Portfolios</h4>
                        <p class="text-xs text-gray-500 leading-relaxed">Diversifying into high-yield commercial real estate to provide a stable, asset-backed foundation for our growth.</p>
                    </div>
                    <div class="space-y-3">
                        <div class="text-emerald-400 font-black text-xl">03.</div>
                        <h4 class="text-white font-bold uppercase tracking-widest text-sm">Liquidity Provision</h4>
                        <p class="text-xs text-gray-500 leading-relaxed">Acting as a major liquidity provider for emerging fintech platforms to capture consistent service-based revenue.</p>
                    </div>
                </div>
                <div class="pt-8 text-center">
                    <p class="text-xs text-gray-500 leading-relaxed max-w-3xl mx-auto uppercase font-bold tracking-[0.2em]">
                        Your success is our priority. We are committed to maintaining a transparent and high-performing environment for all members.
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
    </script>
</body>
</html>
