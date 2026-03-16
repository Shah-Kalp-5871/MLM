<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexaNet | Next-Gen Multi-Level Network</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        deep: '#0a0b14',
                        accent: '#9333ea',
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #0a0b14; color: #94a3b8; scroll-behavior: smooth; }
        .glass-panel { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.08); }
        .hero-gradient { background: radial-gradient(circle at 50% 50%, rgba(147, 51, 234, 0.1) 0%, transparent 70%); }
        .nav-link { transition: all 0.3s; }
        .nav-link:hover { color: white; text-shadow: 0 0 10px rgba(147,51,234,0.5); }
        .animate-float { animation: float 6s ease-in-out infinite; }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-20px); } }
    </style>
</head>
<body class="selection:bg-purple-500 selection:text-white">

    <!-- Top Navigation -->
    <nav class="fixed top-0 left-0 w-full z-50 px-6 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center glass-panel px-8 py-4 rounded-2xl">
            <a href="/" class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-purple-500/20">
                    <i data-lucide="zap" class="w-6 h-6 text-white"></i>
                </div>
                <span class="text-xl font-black text-white tracking-tighter italic">Nexa<span class="text-purple-500">Net</span></span>
            </a>
            
            <div class="hidden md:flex items-center gap-8">
                <a href="#features" class="nav-link text-xs font-bold uppercase tracking-widest">Features</a>
                <a href="#how" class="nav-link text-xs font-bold uppercase tracking-widest">How it Works</a>
                <a href="#rewards" class="nav-link text-xs font-bold uppercase tracking-widest">Rewards</a>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}" class="text-xs font-bold text-gray-400 uppercase tracking-widest hover:text-white transition-colors">Login</a>
                <a href="{{ route('register') }}" class="px-6 py-3 rounded-xl bg-white text-black text-xs font-bold uppercase tracking-wider hover:bg-purple-500 hover:text-white transition-all shadow-xl shadow-white/5">Get Started</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="min-h-screen pt-40 pb-20 relative overflow-hidden hero-gradient flex items-center">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-20 items-center relative z-10">
            <div class="space-y-8 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-purple-500/10 border border-purple-500/20 text-purple-400 text-[10px] font-bold uppercase tracking-[0.2em]">
                    <span class="w-1.5 h-1.5 rounded-full bg-purple-500 animate-pulse"></span> Now Live Globally
                </div>
                <h1 class="text-5xl md:text-7xl font-black text-white leading-tight tracking-tighter">
                    Build Your <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-indigo-500">Financial</span> Legacy
                </h1>
                <p class="text-lg text-gray-400 font-medium max-w-xl mx-auto lg:mx-0 leading-relaxed">
                    Join the next generation of network marketing. Secure, transparent, and built for your growth. Earn through ROI, referral networks, and milestone rewards.
                </p>
                <div class="flex flex-col sm:flex-row items-center gap-4 justify-center lg:justify-start">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-10 py-5 rounded-2xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white text-sm font-black uppercase tracking-widest transition-all shadow-2xl shadow-purple-900/40">Launch Dashboard</a>
                    <a href="#how" class="w-full sm:w-auto px-10 py-5 rounded-2xl glass-panel text-white text-sm font-black uppercase tracking-widest hover:bg-white/5 transition-all">Learn More</a>
                </div>
                <div class="pt-8 grid grid-cols-3 gap-8 border-t border-white/5 max-w-md">
                    <div>
                        <p class="text-2xl font-black text-white">{{ number_format($stats['total_users'] ?? 10) }}+</p>
                        <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest mt-1">Investors</p>
                    </div>
                    <div>
                        <p class="text-2xl font-black text-white">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($stats['total_payouts'] ?? 1000000) }}+</p>
                        <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest mt-1">Distributed</p>
                    </div>
                    <div>
                        <p class="text-2xl font-black text-white">10 Levels</p>
                        <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest mt-1">Network Depth</p>
                    </div>
                </div>
            </div>

            <div class="relative hidden lg:block">
                <div class="animate-float">
                    <div class="glass-panel p-8 rounded-[3rem] border-purple-500/20 relative">
                        <div class="absolute -inset-1 bg-gradient-to-br from-purple-600/20 to-indigo-600/20 blur-2xl -z-10"></div>
                        <div class="space-y-6">
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-bold text-purple-400 uppercase tracking-widest">Network Overview</span>
                                <i data-lucide="more-horizontal" class="w-4 h-4 text-gray-600"></i>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="p-6 rounded-2xl bg-white/5 border border-white/5">
                                    <p class="text-[10px] text-gray-500 uppercase mb-1">ROI Income</p>
                                    <h4 class="text-xl font-black text-white">{{ $settings['platform_currency_symbol'] ?? '$' }}12,450</h4>
                                </div>
                                <div class="p-6 rounded-2xl bg-emerald-500/5 border border-emerald-500/10">
                                    <p class="text-[10px] text-emerald-500 uppercase mb-1">Growth</p>
                                    <h4 class="text-xl font-black text-emerald-400">+24%</h4>
                                </div>
                            </div>
                            <div class="h-40 relative flex items-center justify-center">
                                <div class="w-20 h-20 rounded-full bg-purple-600 flex items-center justify-center shadow-2xl shadow-purple-600/50 z-20">
                                    <i data-lucide="user" class="w-10 h-10 text-white"></i>
                                </div>
                                <!-- Tree Lines -->
                                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                    <svg class="w-full h-full stroke-purple-500/20 stroke-2" style="transform: scale(1.2)">
                                        <line x1="50%" y1="50%" x2="20%" y2="20%" />
                                        <line x1="50%" y1="50%" x2="80%" y2="20%" />
                                        <line x1="50%" y1="50%" x2="20%" y2="80%" />
                                        <line x1="50%" y1="50%" x2="80%" y2="80%" />
                                    </svg>
                                </div>
                                <div class="absolute top-0 left-[15%] w-10 h-10 rounded-full glass-panel flex items-center justify-center border-purple-500/30">
                                    <i data-lucide="users" class="w-5 h-5 text-purple-400"></i>
                                </div>
                                <div class="absolute bottom-0 right-[15%] w-10 h-10 rounded-full glass-panel flex items-center justify-center border-emerald-500/30">
                                    <i data-lucide="trending-up" class="w-5 h-5 text-emerald-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-32 relative">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-24 space-y-4">
                <h2 class="text-[10px] font-bold text-purple-500 uppercase tracking-[0.4em]">Core Ecosystem</h2>
                <h3 class="text-4xl font-black text-white">Engineered for Success</h3>
                <p class="text-gray-500 text-sm max-w-xl mx-auto">Everything you need to build, manage, and scale your network team smoothly.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="glass-panel p-10 rounded-3xl hover:border-purple-500/40 transition-all group">
                    <div class="w-14 h-14 rounded-2xl bg-purple-500/10 flex items-center justify-center mb-8 group-hover:scale-110 transition-transform">
                        <i data-lucide="shield-check" class="w-7 h-7 text-purple-400"></i>
                    </div>
                    <h4 class="text-lg font-bold text-white mb-4">Secured Vault</h4>
                    <p class="text-xs text-gray-500 leading-relaxed font-medium">Enterprise-grade security protecting your funds and personal data at every step.</p>
                </div>
                <div class="glass-panel p-10 rounded-3xl hover:border-purple-500/40 transition-all group">
                    <div class="w-14 h-14 rounded-2xl bg-blue-500/10 flex items-center justify-center mb-8 group-hover:scale-110 transition-transform">
                        <i data-lucide="activity" class="w-7 h-7 text-blue-400"></i>
                    </div>
                    <h4 class="text-lg font-bold text-white mb-4">Real-time ROI</h4>
                    <p class="text-xs text-gray-500 leading-relaxed font-medium">Watch your investments grow with automated weekly and monthly ROI distributions.</p>
                </div>
                <div class="glass-panel p-10 rounded-3xl hover:border-purple-500/40 transition-all group">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-500/10 flex items-center justify-center mb-8 group-hover:scale-110 transition-transform">
                        <i data-lucide="share-2" class="w-7 h-7 text-emerald-400"></i>
                    </div>
                    <h4 class="text-lg font-bold text-white mb-4">Level Rewards</h4>
                    <p class="text-xs text-gray-500 leading-relaxed font-medium">Earn deep commissions up to 5 levels down as your team expands globally.</p>
                </div>
                <div class="glass-panel p-10 rounded-3xl hover:border-purple-500/40 transition-all group">
                    <div class="w-14 h-14 rounded-2xl bg-amber-500/10 flex items-center justify-center mb-8 group-hover:scale-110 transition-transform">
                        <i data-lucide="award" class="w-7 h-7 text-amber-400"></i>
                    </div>
                    <h4 class="text-lg font-bold text-white mb-4">Club Milestones</h4>
                    <p class="text-xs text-gray-500 leading-relaxed font-medium">Unlock exclusive vouchers and luxury rewards as you achieve business targets.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How it Works -->
    <section id="how" class="py-32 bg-white/[0.01]">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
            <div class="space-y-12">
                <div class="space-y-4">
                    <h2 class="text-[10px] font-bold text-purple-500 uppercase tracking-[0.4em]">Simple Steps</h2>
                    <h3 class="text-4xl font-black text-white">Get Started in 3 minutes</h3>
                </div>
                <div class="space-y-8">
                    <div class="flex gap-6">
                        <div class="w-12 h-12 rounded-full glass-panel flex items-center justify-center font-black text-purple-400 shrink-0 border-purple-500/30">01</div>
                        <div>
                            <h4 class="text-white font-bold mb-1">Create Account</h4>
                            <p class="text-xs text-gray-500 font-medium leading-relaxed">Simply sign up and complete your profile to access your dashboard.</p>
                        </div>
                    </div>
                    <div class="flex gap-6">
                        <div class="w-12 h-12 rounded-full glass-panel flex items-center justify-center font-black text-purple-400 shrink-0 border-purple-500/30">02</div>
                        <div>
                            <h4 class="text-white font-bold mb-1">Fund & Invest</h4>
                            <p class="text-xs text-gray-500 font-medium leading-relaxed">Choose a starter, pro, or elite package and start earning weekly ROI.</p>
                        </div>
                    </div>
                    <div class="flex gap-6">
                        <div class="w-12 h-12 rounded-full glass-panel flex items-center justify-center font-black text-purple-400 shrink-0 border-purple-500/30">03</div>
                        <div>
                            <h4 class="text-white font-bold mb-1">Scale Your Network</h4>
                            <p class="text-xs text-gray-500 font-medium leading-relaxed">Share your unique link and earn level commissions from everyone you invite.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative">
                <div class="aspect-square glass-panel rounded-[4rem] p-12 border-indigo-500/20 relative group overflow-hidden">
                    <div class="absolute -inset-1 bg-gradient-to-tr from-indigo-500/20 to-purple-500/20 blur-3xl -z-10 group-hover:scale-110 transition-transform duration-1000"></div>
                    <div class="h-full flex flex-col justify-center gap-8">
                        <div class="p-6 rounded-3xl bg-black/40 border border-white/5 space-y-4">
                            <div class="flex justify-between text-xs text-gray-500 uppercase font-black tracking-widest">
                                <span>Total Commissions</span>
                                <span class="text-emerald-400">+{{ $settings['platform_currency_symbol'] ?? '$' }}45,200</span>
                            </div>
                            <div class="w-full h-3 rounded-full bg-white/5 overflow-hidden">
                                <div class="w-3/4 h-full bg-gradient-to-r from-purple-600 to-indigo-500 rounded-full"></div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-6">
                            <div class="p-6 rounded-3xl glass-panel text-center">
                                <i data-lucide="zap" class="w-6 h-6 text-amber-400 mx-auto mb-3"></i>
                                <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Active Pack</p>
                                <p class="text-white font-black mt-1">Elite V4</p>
                            </div>
                            <div class="p-6 rounded-3xl glass-panel text-center border-emerald-500/20">
                                <i data-lucide="check-circle" class="w-6 h-6 text-emerald-400 mx-auto mb-3"></i>
                                <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Status</p>
                                <p class="text-white font-black mt-1">Verified</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-32 relative overflow-hidden">
        <div class="max-w-5xl mx-auto px-6 glass-panel p-20 rounded-[4rem] border-purple-500/30 text-center relative">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-600/10 to-indigo-600/10 blur-[100px] -z-10"></div>
            <h2 class="text-4xl md:text-5xl font-black text-white mb-8 tracking-tighter">Ready to Start Your Journey?</h2>
            <p class="text-gray-400 text-lg mb-12 max-w-2xl mx-auto">Join thousands of investors who are already building their network and earning daily profit.</p>
            <div class="flex flex-col sm:flex-row items-center gap-6 justify-center">
                <a href="{{ route('register') }}" class="w-full sm:w-auto px-12 py-5 rounded-2xl bg-white text-black text-sm font-black uppercase tracking-widest hover:bg-purple-500 hover:text-white transition-all shadow-2xl shadow-white/10">Create Account Now</a>
                <a href="{{ route('login') }}" class="w-full sm:w-auto px-12 py-5 rounded-2xl border border-white/10 text-white text-sm font-black uppercase tracking-widest hover:bg-white/5 transition-all">Sign In to Dashboard</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-20 border-t border-white/5">
        <div class="max-w-7xl mx-auto px-6 text-center space-y-8">
            <div class="flex justify-center items-center gap-3">
                <div class="w-8 h-8 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-lg flex items-center justify-center">
                    <i data-lucide="zap" class="w-5 h-5 text-white"></i>
                </div>
                <span class="text-lg font-black text-white tracking-tighter italic">Nexa<span class="text-purple-500">Net</span></span>
            </div>
            <p class="text-[11px] text-gray-500 uppercase font-bold tracking-[0.3em]">Built for the Future of Network Economics</p>
            <div class="flex justify-center gap-8 py-4">
                <a href="#" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest hover:text-white transition-colors">Terms</a>
                <a href="#" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest hover:text-white transition-colors">Privacy</a>
                <a href="#" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest hover:text-white transition-colors">Support</a>
            </div>
            <p class="text-[10px] text-gray-600 font-medium tracking-widest uppercase">© 2026 NexaNet Platform. All Rights Reserved.</p>
        </div>
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
