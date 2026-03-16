<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Portal | MLM Dashboard</title>
    <!-- Tailwind CSS (CDN for static prototyping) -->
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
                        cardBg: 'rgba(255, 255, 255, 0.03)',
                        glassBorder: 'rgba(255, 255, 255, 0.08)',
                        vibrant: '#9333ea',
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #0a0b14; color: #94a3b8; overflow-x: hidden; }
        .glass-panel { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.08); }
        .table-wrapper { width: 100%; overflow-x: auto; scrollbar-width: none; }
        .table-wrapper::-webkit-scrollbar { display: none; }
        .nav-link { transition: all 0.3s ease; }
        .nav-link:hover, .nav-link.active { color: white; text-shadow: 0 0 10px rgba(147,51,234,0.5); }
        table { width: 100%; white-space: nowrap; border-collapse: separate; border-spacing: 0; }
        th { background: rgba(255,255,255,0.05); padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 700; color: #fff; text-transform: uppercase; border-bottom: 1px solid rgba(255,255,255,0.1); }
        td { padding: 16px; font-size: 13px; border-bottom: 1px solid rgba(255,255,255,0.05); color: #cbd5e1; }
        .pagination { display: inline-flex; gap: 4px; padding: 16px 0; }
        .pagination a, .pagination span { padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #ccc; transition: all 0.2s; }
        .pagination .active { background: linear-gradient(135deg, #7c3aed, #4f46e5); color: white; border-color: rgba(255,255,255,0.2); }
    </style>
</head>
<body class="selection:bg-purple-500 selection:text-white">

    <!-- Top Navigation -->
    <nav class="fixed top-0 left-0 w-full z-50 px-4 py-3" id="main-nav">
        <div class="max-w-7xl mx-auto">
            <div class="glass-panel px-6 py-3 rounded-2xl flex justify-between items-center">
                
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-purple-500/20">
                        <i data-lucide="zap" class="w-5 h-5 text-white"></i>
                    </div>
                    <div class="flex flex-col leading-none">
                        <span class="text-xs font-bold text-white tracking-widest uppercase opacity-90">Company</span>
                        <span class="text-lg font-bold text-purple-500 tracking-tight mt-0.5">PLATFORM</span>
                    </div>
                </a>

                <!-- Desktop Links -->
                <div class="hidden lg:flex items-center gap-6">
                    <a href="{{ route('dashboard') }}" class="nav-link text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center gap-2 {{ request()->routeIs('dashboard') ? 'active' : '' }}"><i data-lucide="home" class="w-4 h-4"></i> Home</a>
                    <a href="{{ route('packages.index') }}" class="nav-link text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center gap-2 {{ request()->routeIs('packages.index') ? 'active' : '' }}"><i data-lucide="briefcase" class="w-4 h-4"></i> Invest</a>
                    <a href="{{ route('earnings.index') }}" class="nav-link text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center gap-2 {{ request()->routeIs('earnings.index') ? 'active' : '' }}"><i data-lucide="trending-up" class="w-4 h-4"></i> Earnings</a>
                    <a href="{{ route('team.index') }}" class="nav-link text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center gap-2 {{ request()->routeIs('team.index') ? 'active' : '' }}"><i data-lucide="network" class="w-4 h-4"></i> Network</a>
                    <a href="{{ route('referrals.index') }}" class="nav-link text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center gap-2 {{ request()->routeIs('referrals.index') ? 'active' : '' }}"><i data-lucide="users" class="w-4 h-4"></i> Referrals</a>
                    <a href="{{ route('club-rewards.index') }}" class="nav-link text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center gap-2 {{ request()->routeIs('club-rewards.index') ? 'active' : '' }}"><i data-lucide="award" class="w-4 h-4"></i> Club</a>
                    <a href="{{ route('wallet.index') }}" class="nav-link text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center gap-2 {{ request()->routeIs('wallet.index') ? 'active' : '' }}"><i data-lucide="wallet" class="w-4 h-4"></i> Wallet</a>
                    <a href="{{ route('withdraw.create') }}" class="nav-link text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center gap-2 {{ request()->routeIs('withdraw.create') ? 'active' : '' }}"><i data-lucide="credit-card" class="w-4 h-4"></i> Withdraw</a>
                    <a href="{{ route('profile.index') }}" class="nav-link text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center gap-2 {{ request()->routeIs('profile.index') ? 'active' : '' }}"><i data-lucide="user" class="w-4 h-4"></i> Profile</a>
                </div>

                <!-- Right Actions -->
                <div class="flex items-center gap-4">
                    <form action="{{ route('login') }}" method="GET">
                        <button type="submit" class="w-10 h-10 rounded-xl bg-rose-500/10 border border-rose-500/20 flex items-center justify-center text-rose-500 hover:bg-rose-500/20 transition-all">
                            <i data-lucide="power" class="w-4 h-4"></i>
                        </button>
                    </form>
                    <button class="lg:hidden w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-gray-300" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                        <i data-lucide="menu" class="w-5 h-5"></i>
                    </button>
                </div>

            </div>
        </div>
        
        <!-- Mobile Menu (Hidden by default) -->
        <div id="mobile-menu" class="hidden absolute top-[80px] left-4 right-4 glass-panel rounded-2xl p-4 shadow-2xl lg:hidden flex-col gap-2">
            <a href="{{ route('dashboard') }}" class="p-3 text-sm text-white font-bold uppercase rounded-xl hover:bg-white/5 flex items-center gap-3"><i data-lucide="home" class="w-4 h-4 text-purple-400"></i> Home</a>
            <a href="{{ route('packages.index') }}" class="p-3 text-sm text-white font-bold uppercase rounded-xl hover:bg-white/5 flex items-center gap-3"><i data-lucide="briefcase" class="w-4 h-4 text-purple-400"></i> Invest</a>
            <a href="{{ route('earnings.index') }}" class="p-3 text-sm text-white font-bold uppercase rounded-xl hover:bg-white/5 flex items-center gap-3"><i data-lucide="trending-up" class="w-4 h-4 text-purple-400"></i> Earnings</a>
            <a href="{{ route('team.index') }}" class="p-3 text-sm text-white font-bold uppercase rounded-xl hover:bg-white/5 flex items-center gap-3"><i data-lucide="network" class="w-4 h-4 text-purple-400"></i> Network</a>
            <a href="{{ route('referrals.index') }}" class="p-3 text-sm text-white font-bold uppercase rounded-xl hover:bg-white/5 flex items-center gap-3"><i data-lucide="users" class="w-4 h-4 text-purple-400"></i> Referrals</a>
            <a href="{{ route('club-rewards.index') }}" class="p-3 text-sm text-white font-bold uppercase rounded-xl hover:bg-white/5 flex items-center gap-3"><i data-lucide="award" class="w-4 h-4 text-purple-400"></i> Club Rewards</a>
            <a href="{{ route('wallet.index') }}" class="p-3 text-sm text-white font-bold uppercase rounded-xl hover:bg-white/5 flex items-center gap-3"><i data-lucide="wallet" class="w-4 h-4 text-purple-400"></i> Wallet</a>
            <a href="{{ route('withdraw.create') }}" class="p-3 text-sm text-white font-bold uppercase rounded-xl hover:bg-white/5 flex items-center gap-3"><i data-lucide="credit-card" class="w-4 h-4 text-purple-400"></i> Withdraw</a>
            <a href="{{ route('profile.index') }}" class="p-3 text-sm text-white font-bold uppercase rounded-xl hover:bg-white/5 flex items-center gap-3"><i data-lucide="user" class="w-4 h-4 text-purple-400"></i> Profile</a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-[110px] pb-20 px-4 min-h-screen relative z-10 w-full">
        <div class="max-w-7xl mx-auto">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-white/5 py-8 mt-auto z-10 relative">
        <div class="max-w-7xl mx-auto px-6 text-center text-xs text-gray-500 font-medium">
            &copy; {{ date('Y') }} Platform Name. All rights reserved.<br>
            <a href="#" class="hover:text-white transition-colors">Support</a> | <a href="#" class="hover:text-white transition-colors">Terms</a>
        </div>
    </footer>

    <!-- Background Elements -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute top-[10%] left-[-10%] w-[500px] h-[500px] bg-purple-900/10 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[600px] h-[600px] bg-indigo-900/10 rounded-full blur-[120px]"></div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>