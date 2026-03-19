<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EliteMatrixPro | Premium Multi-Level Investment Network</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @include('layouts.theme-master')
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        deep: '#0a0b14',
                        accent: '#9333ea',
                        secondary: '#4f46e5',
                        glass: 'rgba(255, 255, 255, 0.03)',
                    },
                    animation: {
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'float': 'float 6s ease-in-out infinite',
                        'glow': 'glow 3s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' },
                        },
                        glow: {
                            '0%, 100%': { opacity: 0.5, filter: 'blur(20px)' },
                            '50%': { opacity: 0.8, filter: 'blur(40px)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #03040b; color: #94a3b8; scroll-behavior: smooth; overflow-x: hidden; }
        .glass-panel { background: rgba(255, 255, 255, 0.02); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.06); }
        .hero-bg { background: radial-gradient(circle at 50% 50%, rgba(147, 51, 234, 0.15) 0%, transparent 60%); }
        .text-glow { text-shadow: 0 0 20px rgba(147, 51, 234, 0.4); }
        .nav-link { position: relative; }
        .nav-link::after { content: ''; position: absolute; bottom: -4px; left: 0; width: 0; height: 2px; background: #9333ea; transition: width 0.3s; }
        .nav-link:hover::after { width: 100%; }
        
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
        
        .gradient-border {
            position: relative;
            background: #0a0b14;
            border-radius: 1.5rem;
            z-index: 0;
        }
        .gradient-border::before {
            content: "";
            position: absolute;
            inset: -1px;
            background: linear-gradient(45deg, #9333ea, #4f46e5, #9333ea);
            border-radius: 1.5rem;
            z-index: -1;
            opacity: 0.3;
        }
        .milestone-card:hover { transform: translateY(-5px); border-color: rgba(147, 51, 234, 0.5); }
    </style>
</head>
<body class="selection:bg-purple-500 selection:text-white">
    @include('partials.preloader')

    <!-- Navigation -->
    <nav class="fixed top-0 left-0 w-full z-50 px-4 md:px-8 py-6">
        <div class="max-w-7xl mx-auto flex justify-between items-center glass-panel px-6 py-4 rounded-3xl relative">
            <a href="{{ route('welcome') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-purple-500/20 group-hover:scale-110 transition-transform">
                    <i data-lucide="zap" class="w-6 h-6 text-white"></i>
                </div>
                <span class="text-xl font-black text-white tracking-tighter italic">EliteMatrix<span class="text-purple-500">Pro</span></span>
            </a>
            
            <div class="hidden lg:flex items-center gap-10">
                <a href="#about" class="nav-link text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 hover:text-white transition-colors">About</a>
                <a href="#plans" class="nav-link text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 hover:text-white transition-colors">Investment</a>
                <a href="#milestones" class="nav-link text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 hover:text-white transition-colors">Milestones</a>
                <a href="#how" class="nav-link text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 hover:text-white transition-colors">How it Works</a>
            </div>

            <div class="flex items-center gap-4">
                <div class="hidden sm:flex items-center gap-3">
                    <a href="{{ route('login') }}" class="px-6 py-3 text-[10px] font-bold text-white uppercase tracking-widest hover:bg-white/5 rounded-xl transition-all">Login</a>
                    <a href="{{ route('register') }}" class="px-7 py-3.5 rounded-xl bg-purple-600 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-purple-500 transition-all shadow-lg shadow-purple-500/20">Sign Up</a>
                </div>
                <button id="menu-toggle" class="lg:hidden p-3 bg-purple-600/20 rounded-xl text-white border border-purple-500/30 hover:bg-purple-600/40 transition-all">
                    <i data-lucide="menu" id="icon-menu" class="w-6 h-6"></i>
                    <i data-lucide="x" id="icon-close" class="w-6 h-6 hidden"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="absolute top-[110%] left-0 w-full rounded-2xl p-8 flex flex-col gap-6 lg:hidden z-50 shadow-2xl">
                <a href="#about" class="text-xs font-bold uppercase tracking-widest text-white border-b border-white/5 pb-4">About</a>
                <a href="#plans" class="text-xs font-bold uppercase tracking-widest text-white border-b border-white/5 pb-4">Investment</a>
                <a href="#milestones" class="text-xs font-bold uppercase tracking-widest text-white border-b border-white/5 pb-4">Milestones</a>
                <a href="#how" class="text-xs font-bold uppercase tracking-widest text-white border-b border-white/5 pb-4">How it Works</a>
                <div class="flex flex-col gap-3 pt-4">
                    <a href="{{ route('login') }}" class="w-full py-4 text-center border border-white/10 rounded-2xl text-xs font-bold text-white uppercase tracking-widest">Login</a>
                    <a href="{{ route('register') }}" class="w-full py-4 text-center bg-purple-600 rounded-2xl text-xs font-bold text-white uppercase tracking-widest shadow-xl shadow-purple-500/20">Create Account</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="min-h-screen pt-48 pb-24 relative overflow-hidden hero-bg flex items-center">
        <!-- Animated Blobs -->
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-purple-600/10 rounded-full blur-[120px] animate-pulse-slow"></div>
        <div class="absolute bottom-1/4 right-1/4 w-[500px] h-[500px] bg-indigo-600/10 rounded-full blur-[150px] animate-pulse-slow"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <div class="inline-flex items-center gap-3 px-5 py-2.5 rounded-full bg-white/5 border border-white/10 text-purple-400 text-[10px] font-black uppercase tracking-[0.3em] mb-10 animate-fade-in">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-purple-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-purple-500"></span>
                </span>
                Earn 3% - 3.5% Weekly ROI
            </div>
            
            <h1 class="text-5xl md:text-8xl font-black text-white leading-[1.1] tracking-tighter mb-8 max-w-5xl mx-auto">
                Decentralized <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 via-indigo-400 to-purple-500 text-glow">Wealth</span> Generation
            </h1>
            
            <p class="text-lg md:text-xl text-gray-400 font-medium max-w-2xl mx-auto mb-14 leading-relaxed">
                EliteMatrixPro offers a revolutionary investment model with guaranteed weekly returns and a multi-tier network expansion spanning 15 levels.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-6 mb-20">
                <a href="{{ route('register') }}" class="group w-full sm:w-auto px-12 py-6 rounded-2xl bg-white text-black text-sm font-black uppercase tracking-widest hover:bg-purple-600 hover:text-white transition-all shadow-2xl shadow-white/5 flex items-center justify-center gap-4">
                    Get Started Now
                    <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
                </a>
                <a href="{{ route('login') }}" class="w-full sm:w-auto px-12 py-6 rounded-2xl glass-panel text-white text-sm font-black uppercase tracking-widest hover:bg-white/5 transition-all flex items-center justify-center gap-4">
                    Member Login
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                </a>
            </div>

            <!-- Stats Bar -->
            <div class="max-w-4xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-8 py-10 border-t border-white/5">
                <div>
                    <h3 class="text-3xl font-black text-white mb-1">3.5%</h3>
                    <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest">Max Weekly ROI</p>
                </div>
                <div>
                    <h3 class="text-3xl font-black text-white mb-1">15 Levels</h3>
                    <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest">Network Commission</p>
                </div>
                <div>
                    <h3 class="text-3xl font-black text-white mb-1">12 - 14%</h3>
                    <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest">Monthly Growth</p>
                </div>
                <div>
                    <h3 class="text-3xl font-black text-white mb-1">Vouchers</h3>
                    <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest">Club Rewards</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Investment Plans -->
    <section id="plans" class="py-32 relative bg-white/[0.01]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-20">
                <h2 class="text-[10px] font-black text-purple-500 uppercase tracking-[0.5em] mb-4">Investment Protocol</h2>
                <h3 class="text-4xl md:text-5xl font-black text-white mb-6">Proven Returns for Every Tier</h3>
                <p class="text-gray-500 max-w-xl mx-auto">All active investments qualify for weekly ROI and deep level commissions from your network's success.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Example Plan -->
                <div class="glass-panel p-10 rounded-[2.5rem] border-white/5 hover:border-purple-500/30 transition-all group relative overflow-hidden">
                    <div class="mb-8">
                        <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Growth Tier</span>
                        <h4 class="text-2xl font-black text-white mt-2">Starter Matrix</h4>
                    </div>
                    <div class="text-4xl font-black text-white mb-4">
                        Any<span class="text-sm font-medium text-purple-200/50"> Amount</span>
                    </div>
                    <p class="text-xs text-gray-400 mb-8 italic">Minimum deposit set by admin</p>
                    <ul class="space-y-4 mb-10">
                        <li class="flex items-center gap-3 text-sm font-medium text-gray-300">
                            <i data-lucide="check" class="w-5 h-5 text-emerald-500"></i> ROI activates at $500 total
                        </li>
                        <li class="flex items-center gap-3 text-sm font-medium text-gray-300">
                            <i data-lucide="check" class="w-5 h-5 text-emerald-500"></i> Level Income activates at $500 total
                        </li>
                        <li class="flex items-center gap-3 text-sm font-medium text-gray-300">
                            <i data-lucide="check" class="w-5 h-5 text-emerald-500"></i> Full 15-Level Access once unlocked
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="block w-full py-5 rounded-2xl bg-white text-center text-xs font-black text-black uppercase tracking-widest hover:bg-purple-600 hover:text-white transition-all">Start Investing</a>
                </div>

                <!-- Featured -->
                <div class="p-10 rounded-[2.5rem] bg-gradient-to-br from-purple-600 to-indigo-600 hover:scale-105 transition-all shadow-2xl shadow-purple-900/40 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-6">
                        <span class="px-4 py-1.5 rounded-full bg-white/20 text-white text-[9px] font-black uppercase tracking-widest">Recommended</span>
                    </div>
                    <div class="mb-8">
                        <span class="text-[10px] font-bold text-white/60 uppercase tracking-widest">Strategic Asset</span>
                        <h4 class="text-2xl font-black text-white mt-2">Professional Node</h4>
                    </div>
                    <div class="text-4xl font-black text-white mb-4">
                        $2,000
                    </div>
                    <p class="text-xs text-white/70 mb-8 italic">Optimized for high-yield returns</p>
                    <ul class="space-y-4 mb-10">
                        <li class="flex items-center gap-3 text-sm font-medium text-white/90">
                            <i data-lucide="check" class="w-5 h-5 text-emerald-300"></i> $60 - $70 Weekly ROI
                        </li>
                        <li class="flex items-center gap-3 text-sm font-medium text-white/90">
                            <i data-lucide="check" class="w-5 h-5 text-emerald-300"></i> Higher Milestone Eligibility
                        </li>
                        <li class="flex items-center gap-3 text-sm font-medium text-white/90">
                            <i data-lucide="check" class="w-5 h-5 text-emerald-300"></i> Priority Withdrawals
                        </li>
                        <li class="flex items-center gap-3 text-sm font-medium text-white/90">
                            <i data-lucide="check" class="w-5 h-5 text-emerald-300"></i> Full Network Compression
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="block w-full py-5 rounded-2xl bg-white text-center text-xs font-black text-black uppercase tracking-widest hover:bg-black hover:text-white transition-all">Start with $2,000</a>
                </div>

                <!-- Elite -->
                <div class="glass-panel p-10 rounded-[2.5rem] border-white/5 hover:border-indigo-500/30 transition-all group">
                    <div class="mb-8">
                        <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Venture Tier</span>
                        <h4 class="text-2xl font-black text-white mt-2">Executive Matrix</h4>
                    </div>
                    <div class="text-4xl font-black text-white mb-4">
                        $5,000
                    </div>
                    <p class="text-xs text-gray-400 mb-8 italic">For founders and network leaders</p>
                    <ul class="space-y-4 mb-10">
                        <li class="flex items-center gap-3 text-sm font-medium text-gray-300">
                            <i data-lucide="check" class="w-5 h-5 text-emerald-500"></i> $150 - $175 Weekly ROI
                        </li>
                        <li class="flex items-center gap-3 text-sm font-medium text-gray-300">
                            <i data-lucide="check" class="w-5 h-5 text-emerald-500"></i> Instant Club Qualification
                        </li>
                        <li class="flex items-center gap-3 text-sm font-medium text-gray-300">
                            <i data-lucide="check" class="w-5 h-5 text-emerald-500"></i> VIP Support Line
                        </li>
                        <li class="flex items-center gap-3 text-sm font-medium text-gray-300">
                            <i data-lucide="check" class="w-5 h-5 text-emerald-500"></i> Infinite Legacy Growth
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="block w-full py-5 rounded-2xl bg-white text-center text-xs font-black text-black uppercase tracking-widest hover:bg-indigo-600 hover:text-white transition-all">Start with $5,000</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Club Milestones -->
    <section id="milestones" class="py-32 relative overflow-hidden bg-deep">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col lg:flex-row gap-16 items-start">
                <div class="w-full lg:w-1/3">
                    <h2 class="text-[10px] font-black text-purple-500 uppercase tracking-[0.5em] mb-4">Elite Club</h2>
                    <h3 class="text-4xl font-black text-white mb-6 leading-tight">Achievement Vouchers</h3>
                    <p class="text-gray-500 mb-10 leading-relaxed">Turn your team's growth into tangible rewards. Vouchers are awarded automatically when you reach business targets and can be redeemed for further investments.</p>
                    <div class="p-6 rounded-2xl glass-panel flex items-center gap-4 bg-purple-500/5">
                        <i data-lucide="info" class="w-6 h-6 text-purple-400"></i>
                        <p class="text-xs text-gray-400 leading-relaxed">Vouchers are credited based on combined Direct and Team business volume.</p>
                    </div>
                </div>
                
                <div class="w-full lg:w-2/3 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="glass-panel p-6 rounded-2xl milestone-card border-white/5 transition-all">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-[10px] font-bold text-gray-500 uppercase">Tier 1</span>
                            <span class="px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-400 text-[10px] font-bold">$500 Reward</span>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between text-xs font-bold text-white"><span>Direct Business</span><span>$5,000</span></div>
                            <div class="flex justify-between text-xs font-bold text-purple-400"><span>Team Business</span><span>$15,000</span></div>
                        </div>
                    </div>
                    <div class="glass-panel p-6 rounded-2xl milestone-card border-white/5 transition-all">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-[10px] font-bold text-gray-500 uppercase">Tier 2</span>
                            <span class="px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-400 text-[10px] font-bold">$1,000 Reward</span>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between text-xs font-bold text-white"><span>Direct Business</span><span>$7,000</span></div>
                            <div class="flex justify-between text-xs font-bold text-purple-400"><span>Team Business</span><span>$20,000</span></div>
                        </div>
                    </div>
                    <div class="glass-panel p-6 rounded-2xl milestone-card border-white/5 transition-all">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-[10px] font-bold text-gray-500 uppercase">Tier 3</span>
                            <span class="px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-400 text-[10px] font-bold">$2,000 Reward</span>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between text-xs font-bold text-white"><span>Direct Business</span><span>$10,000</span></div>
                            <div class="flex justify-between text-xs font-bold text-purple-400"><span>Team Business</span><span>$40,000</span></div>
                        </div>
                    </div>
                    <div class="glass-panel p-6 rounded-2xl milestone-card border-white/5 transition-all">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-[10px] font-bold text-gray-500 uppercase">Tier 5</span>
                            <span class="px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-400 text-[10px] font-bold">$3,000 Reward</span>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between text-xs font-bold text-white"><span>Direct Business</span><span>$20,000</span></div>
                            <div class="flex justify-between text-xs font-bold text-purple-400"><span>Team Business</span><span>$200,000</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How it Works Details -->
    <section id="how" class="py-32 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col lg:flex-row gap-20 items-center">
                <div class="w-full lg:w-1/2 space-y-12">
                    <div>
                        <h2 class="text-[10px] font-black text-purple-500 uppercase tracking-[0.5em] mb-4">The Logic</h2>
                        <h3 class="text-4xl font-black text-white leading-tight">Smart Multi-Stream Income</h3>
                    </div>
                    
                    <div class="space-y-8">
                        <div class="flex gap-6 group">
                            <div class="w-14 h-14 rounded-2xl glass-panel flex items-center justify-center font-black text-purple-400 text-xl shrink-0 group-hover:bg-purple-600 group-hover:text-white transition-all">01</div>
                            <div>
                                <h4 class="text-white font-bold text-lg mb-2">Automated ROI</h4>
                                <p class="text-sm text-gray-500 leading-relaxed">Earn 3% to 3.5% weekly returns on your principal investment, credited automatically every Friday.</p>
                            </div>
                        </div>
                        <div class="flex gap-6 group border-l-2 border-purple-600/20 pl-6 ml-7">
                            <div class="w-14 h-14 rounded-2xl glass-panel flex items-center justify-center font-black text-purple-400 text-xl shrink-0 group-hover:bg-purple-600 group-hover:text-white transition-all">02</div>
                            <div>
                                <h4 class="text-white font-bold text-lg mb-2">15-Level Network</h4>
                                <p class="text-sm text-gray-500 leading-relaxed">Earn a percentage of the ROI generated by your referrals up to 15 levels deep in your hierarchy.</p>
                            </div>
                        </div>
                        <div class="flex gap-6 group border-l-2 border-purple-600/20 pl-6 ml-7">
                            <div class="w-14 h-14 rounded-2xl glass-panel flex items-center justify-center font-black text-purple-400 text-xl shrink-0 group-hover:bg-purple-600 group-hover:text-white transition-all">03</div>
                            <div>
                                <h4 class="text-white font-bold text-lg mb-2">Direct & Team Volume</h4>
                                <p class="text-sm text-gray-500 leading-relaxed">Build your direct business and watch your cumulative team volume unlock higher status tiers.</p>
                            </div>
                        </div>
                        <div class="flex gap-6 group border-l-2 border-transparent pl-6 ml-7">
                            <div class="w-14 h-14 rounded-2xl glass-panel flex items-center justify-center font-black text-purple-400 text-xl shrink-0 group-hover:bg-purple-600 group-hover:text-white transition-all">04</div>
                            <div>
                                <h4 class="text-white font-bold text-lg mb-2">Voucher Redemption</h4>
                                <p class="text-sm text-gray-500 leading-relaxed">Redeem your milestone vouchers directly in our internal system to compounding your earnings.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-1/2">
                    <div class="relative">
                        <div class="absolute inset-0 bg-purple-600/20 blur-[120px]"></div>
                        <div class="glass-panel p-8 rounded-[3rem] border-white/10 relative mt-12 animate-float">
                            <div class="bg-deep rounded-[2rem] p-8 space-y-6">
                                <div class="flex justify-between items-center text-xs text-gray-400 uppercase font-black">
                                    <span>Network Earning Flow</span>
                                    <i data-lucide="info" class="w-4 h-4"></i>
                                </div>
                                <div class="space-y-4">
                                    <div class="p-4 rounded-xl border border-white/5 bg-white/5 flex justify-between items-center">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-purple-500 flex items-center justify-center text-[10px] font-bold text-white">A</div>
                                            <span class="text-xs text-white">Referrer (You)</span>
                                        </div>
                                        <span class="text-xs text-emerald-400 font-bold">+20%</span>
                                    </div>
                                    <div class="h-8 w-px bg-purple-500/30 mx-auto"></div>
                                    <div class="p-4 rounded-xl border border-purple-500/30 bg-purple-500/5 flex justify-between items-center">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-[10px] font-bold text-white">B</div>
                                            <span class="text-xs text-white">Referral ROI ($100)</span>
                                        </div>
                                        <div class="text-[10px] text-gray-500 uppercase font-bold">Generates Comission</div>
                                    </div>
                                </div>
                                <p class="text-[10px] text-gray-500 text-center uppercase tracking-widest leading-relaxed">Commissions are calculated from the ROI earnings of your network, ensuring sustainable growth.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Us / Security -->
    <section id="about" class="py-32 relative bg-deep">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="p-8 rounded-3xl hover:bg-white/5 transition-all text-center md:text-left border border-transparent hover:border-white/10">
                <div class="w-14 h-14 bg-purple-500/10 rounded-2xl flex items-center justify-center mb-6 mx-auto md:mx-0">
                    <i data-lucide="shield-check" class="w-7 h-7 text-purple-400"></i>
                </div>
                <h4 class="text-lg font-bold text-white mb-3">15 Levels Deep</h4>
                <p class="text-xs text-gray-500 leading-relaxed font-medium">Unrivaled depth in referral commissions, allowing for massive passive income scaling.</p>
            </div>
            <div class="p-8 rounded-3xl hover:bg-white/5 transition-all text-center md:text-left border border-transparent hover:border-white/10">
                <div class="w-14 h-14 bg-indigo-500/10 rounded-2xl flex items-center justify-center mb-6 mx-auto md:mx-0">
                    <i data-lucide="refresh-ccw" class="w-7 h-7 text-indigo-400"></i>
                </div>
                <h4 class="text-lg font-bold text-white mb-3">Sustainable ROI</h4>
                <p class="text-xs text-gray-500 leading-relaxed font-medium">ROI is generated from real EliteMatrixPro activities and distributed fairly each week to members.</p>
            </div>
            <div class="p-8 rounded-3xl hover:bg-white/5 transition-all text-center md:text-left border border-transparent hover:border-white/10">
                <div class="w-14 h-14 bg-emerald-500/10 rounded-2xl flex items-center justify-center mb-6 mx-auto md:mx-0">
                    <i data-lucide="globe" class="w-7 h-7 text-emerald-400"></i>
                </div>
                <h4 class="text-lg font-bold text-white mb-3">Milestone Vouchers</h4>
                <p class="text-xs text-gray-500 leading-relaxed font-medium">Achievement-based rewards that encourage continuous reinvestment and business growth.</p>
            </div>
            <div class="p-8 rounded-3xl hover:bg-white/5 transition-all text-center md:text-left border border-transparent hover:border-white/10">
                <div class="w-14 h-14 bg-amber-500/10 rounded-2xl flex items-center justify-center mb-6 mx-auto md:mx-0">
                    <i data-lucide="award" class="w-7 h-7 text-amber-400"></i>
                </div>
                <h4 class="text-lg font-bold text-white mb-3">Transparent Logic</h4>
                <p class="text-xs text-gray-500 leading-relaxed font-medium">Every transaction and commission is logged and traceable within your dashboard.</p>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-32 relative overflow-hidden">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-purple-600/5 rounded-full blur-[180px] pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-6 relative">
            <div class="p-12 md:p-24 rounded-[3.5rem] md:rounded-[5rem] bg-gradient-to-br from-purple-900/40 via-deep to-indigo-900/40 border border-white/10 text-center relative overflow-hidden shadow-3xl">
                <div class="absolute inset-0 bg-gradient-to-tr from-purple-500/10 to-transparent -z-10"></div>
                <h2 class="text-4xl md:text-6xl font-black text-white mb-8 tracking-tighter">Your Legacy Begins at<br><span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-indigo-500">EliteMatrixPro</span></h2>
                <p class="text-gray-400 text-lg mb-12 max-w-2xl mx-auto">Join thousands of leaders building generational wealth through our proven decentralized network protocol.</p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-12 py-6 rounded-2xl bg-white text-black text-sm font-black uppercase tracking-widest hover:bg-purple-600 hover:text-white transition-all shadow-xl shadow-white/5">Launch Your Matrix</a>
                    <a href="{{ route('login') }}" class="w-full sm:w-auto px-12 py-6 rounded-2xl border border-white/10 text-white text-sm font-black uppercase tracking-widest hover:bg-white/5 transition-all">Member Sign In</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-24 border-t border-white/5">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-16 mb-20">
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-lg flex items-center justify-center">
                            <i data-lucide="zap" class="w-5 h-5 text-white"></i>
                        </div>
                        <span class="text-lg font-black text-white italic">EliteMatrix<span class="text-purple-500">Pro</span></span>
                    </div>
                    <p class="text-xs text-gray-500 leading-relaxed uppercase font-bold tracking-widest">Empowering Decentralized Wealth Creation</p>
                </div>
                <div>
                    <h5 class="text-white font-bold text-xs uppercase tracking-[0.3em] mb-8">Ecosystem</h5>
                    <ul class="space-y-4">
                        <li><a href="#about" class="text-xs text-gray-500 hover:text-white transition-colors">Our Vision</a></li>
                        <li><a href="#plans" class="text-xs text-gray-500 hover:text-white transition-colors">Yield Protocols</a></li>
                        <li><a href="#milestones" class="text-xs text-gray-500 hover:text-white transition-colors">Club Rewards</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="text-white font-bold text-xs uppercase tracking-[0.3em] mb-8">Gateway</h5>
                    <ul class="space-y-4">
                        <li><a href="{{ route('login') }}" class="text-xs text-gray-500 hover:text-white transition-colors font-bold uppercase">Login</a></li>
                        <li><a href="{{ route('register') }}" class="text-xs text-gray-500 hover:text-white transition-colors font-bold uppercase">Register</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="text-white font-bold text-xs uppercase tracking-[0.3em] mb-8">Network</h5>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 rounded-xl glass-panel flex items-center justify-center text-gray-400 hover:text-white hover:bg-purple-600 transition-all"><i data-lucide="twitter" class="w-5 h-5"></i></a>
                        <a href="#" class="w-10 h-10 rounded-xl glass-panel flex items-center justify-center text-gray-400 hover:text-white hover:bg-blue-600 transition-all"><i data-lucide="facebook" class="w-5 h-5"></i></a>
                        <a href="#" class="w-10 h-10 rounded-xl glass-panel flex items-center justify-center text-gray-400 hover:text-white hover:bg-pink-600 transition-all"><i data-lucide="instagram" class="w-5 h-5"></i></a>
                    </div>
                </div>
            </div>
            <div class="text-center pt-10 border-t border-white/5">
                <p class="text-[10px] text-gray-600 font-bold uppercase tracking-[0.5em]">© 2026 EliteMatrixPro Protocol. Secure. Scalable. Sovereign.</p>
            </div>
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

        menuToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleMenu();
        });

        // Close menu on click outside or on links
        document.addEventListener('click', (e) => {
            const isClickInsideMenu = mobileMenu.contains(e.target);
            const isClickOnLink = e.target.tagName === 'A' || e.target.closest('a');
            
            if (mobileMenu.classList.contains('active')) {
                if (!isClickInsideMenu || (isClickInsideMenu && isClickOnLink)) {
                    toggleMenu(true);
                }
            }
        });

        // Sticky Nav Effect
        window.addEventListener('scroll', () => {
            const nav = document.querySelector('nav div');
            if (window.scrollY > 20) {
                nav.classList.add('shadow-2xl', 'shadow-purple-500/20', 'bg-deep/80');
            } else {
                nav.classList.remove('shadow-2xl', 'shadow-purple-500/20', 'bg-deep/80');
            }
        });
    </script>
</body>
</html>
