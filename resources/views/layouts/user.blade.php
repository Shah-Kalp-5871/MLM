<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Portal | MLM Dashboard</title>
    <!-- Tailwind CSS (CDN for static prototyping) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        /* Dropdown Styles */
        .dropdown-menu { 
            display: none; 
            position: absolute; 
            top: 100%; 
            left: 50%; 
            transform: translateX(-50%) translateY(10px); 
            min-width: 200px; 
            background: rgba(15, 17, 26, 0.95); 
            backdrop-filter: blur(20px); 
            border: 1px solid rgba(255, 255, 255, 0.08); 
            border-radius: 16px; 
            padding: 8px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.5); 
            z-index: 60; 
            opacity: 0; 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .group:hover .dropdown-menu { 
            display: block; 
            opacity: 1; 
            transform: translateX(-50%) translateY(5px); 
        }
        .dropdown-item { 
            display: flex; 
            align-items: center; 
            gap: 12px; 
            padding: 10px 16px; 
            font-size: 11px; 
            font-weight: 700; 
            color: #94a3b8; 
            text-transform: uppercase; 
            letter-spacing: 0.05em; 
            border-radius: 10px; 
            transition: all 0.2s; 
        }
        .dropdown-item:hover { 
            background: rgba(255, 255, 255, 0.05); 
            color: white; 
        }
        .dropdown-item.active { 
            color: #a855f7; 
            background: rgba(168, 85, 247, 0.05); 
        }
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

                    <!-- Investments Dropdown -->
                    <div class="relative group">
                        <button class="nav-link text-xs font-bold uppercase tracking-wider flex items-center gap-2 {{ request()->routeIs(['invest.create', 'investments.index', 'earnings.index']) ? 'text-white' : 'text-gray-400' }}">
                            <i data-lucide="zap" class="w-4 h-4"></i> Investments <i data-lucide="chevron-down" class="w-3 h-3 opacity-50"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a href="{{ route('invest.create') }}" class="dropdown-item {{ request()->routeIs('invest.create') ? 'active' : '' }}"><i data-lucide="plus-circle" class="w-4 h-4"></i> Start Investing</a>
                            <a href="{{ route('investments.index') }}" class="dropdown-item {{ request()->routeIs('investments.index') ? 'active' : '' }}"><i data-lucide="history" class="w-4 h-4"></i> Investment Hub</a>
                            <a href="{{ route('roi.index') }}" class="dropdown-item {{ request()->routeIs('roi.index') ? 'active' : '' }}"><i data-lucide="zap" class="w-4 h-4"></i> ROI History</a>
                            <a href="{{ route('earnings.index') }}" class="dropdown-item {{ request()->routeIs('earnings.index') ? 'active' : '' }}"><i data-lucide="trending-up" class="w-4 h-4"></i> Overall Earnings</a>
                        </div>
                    </div>

                    <!-- Network Dropdown -->
                    <div class="relative group">
                        <button class="nav-link text-xs font-bold uppercase tracking-wider flex items-center gap-2 {{ request()->routeIs(['network.index', 'referrals.index', 'club.index']) ? 'text-white' : 'text-gray-400' }}">
                            <i data-lucide="network" class="w-4 h-4"></i> Network <i data-lucide="chevron-down" class="w-3 h-3 opacity-50"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a href="{{ route('network.index') }}" class="dropdown-item {{ request()->routeIs('network.index') ? 'active' : '' }}"><i data-lucide="share-2" class="w-4 h-4"></i> Team Tree</a>
                            <a href="{{ route('referrals.index') }}" class="dropdown-item {{ request()->routeIs('referrals.index') ? 'active' : '' }}"><i data-lucide="users" class="w-4 h-4"></i> Referral List</a>
                            <a href="{{ route('level-income.index') }}" class="dropdown-item {{ request()->routeIs('level-income.index') ? 'active' : '' }}"><i data-lucide="layers" class="w-4 h-4"></i> Level Income</a>
                            <a href="{{ route('club.index') }}" class="dropdown-item {{ request()->routeIs('club.index') ? 'active' : '' }}"><i data-lucide="award" class="w-4 h-4"></i> Club Rewards</a>
                        </div>
                    </div>

                    <!-- Finance Dropdown -->
                    <div class="relative group">
                        <button class="nav-link text-xs font-bold uppercase tracking-wider flex items-center gap-2 {{ request()->routeIs(['wallet.index', 'withdraw.create', 'vouchers.index']) ? 'text-white' : 'text-gray-400' }}">
                            <i data-lucide="wallet" class="w-4 h-4"></i> Finance <i data-lucide="chevron-down" class="w-3 h-3 opacity-50"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a href="{{ route('wallet.index') }}" class="dropdown-item {{ request()->routeIs('wallet.index') ? 'active' : '' }}"><i data-lucide="piggy-bank" class="w-4 h-4"></i> Wallet</a>
                            <a href="{{ route('deposits.index') }}" class="dropdown-item {{ request()->routeIs('deposits.index') ? 'active' : '' }}"><i data-lucide="arrow-down-to-line" class="w-4 h-4"></i> Deposit History</a>
                            <a href="{{ route('withdraw.create') }}" class="dropdown-item {{ request()->routeIs('withdraw.create') ? 'active' : '' }}"><i data-lucide="arrow-up-right" class="w-4 h-4"></i> Withdraw</a>
                            <a href="{{ route('withdrawals.index') }}" class="dropdown-item {{ request()->routeIs('withdrawals.index') ? 'active' : '' }}"><i data-lucide="history" class="w-4 h-4"></i> Withdrawal History</a>
                            <a href="{{ route('vouchers.index') }}" class="dropdown-item {{ request()->routeIs('vouchers.index') ? 'active' : '' }}"><i data-lucide="ticket" class="w-4 h-4"></i> Vouchers</a>
                        </div>
                    </div>

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
        <div id="mobile-menu" class="hidden absolute top-[80px] left-4 right-4 glass-panel rounded-2xl p-4 shadow-2xl lg:hidden flex-col gap-2 max-h-[80vh] overflow-y-auto">
            <a href="{{ route('dashboard') }}" class="p-3 text-sm text-white font-bold uppercase rounded-xl hover:bg-white/5 flex items-center gap-3 {{ request()->routeIs('dashboard') ? 'bg-white/5' : '' }}"><i data-lucide="home" class="w-4 h-4 text-purple-400"></i> Home</a>

            <div class="px-3 pt-4 pb-2 text-[10px] font-black text-gray-500 uppercase tracking-widest border-t border-white/5 mt-2">Investments</div>
            <a href="{{ route('invest.create') }}" class="p-3 text-sm text-white font-bold uppercase rounded-xl hover:bg-white/5 flex items-center gap-3 {{ request()->routeIs('invest.create') ? 'bg-white/5 text-purple-400' : '' }}"><i data-lucide="zap" class="w-4 h-4 text-purple-400"></i> Start Investing</a>
            <a href="{{ route('investments.index') }}" class="p-3 text-sm text-white font-bold uppercase rounded-xl hover:bg-white/5 flex items-center gap-3 {{ request()->routeIs('investments.index') ? 'bg-white/5 text-purple-400' : '' }}"><i data-lucide="history" class="w-4 h-4 text-purple-400"></i> Investment Hub</a>
            <a href="{{ route('roi.index') }}" class="p-3 text-sm text-white font-bold uppercase rounded-xl hover:bg-white/5 flex items-center gap-3 {{ request()->routeIs('roi.index') ? 'bg-white/5 text-purple-400' : '' }}"><i data-lucide="zap" class="w-4 h-4 text-purple-400"></i> ROI History</a>
            <a href="{{ route('earnings.index') }}" class="p-3 text-sm text-white font-bold uppercase rounded-xl hover:bg-white/5 flex items-center gap-3 {{ request()->routeIs('earnings.index') ? 'bg-white/5 text-purple-400' : '' }}"><i data-lucide="trending-up" class="w-4 h-4 text-purple-400"></i> Overall Earnings</a>

            <div class="px-3 pt-4 pb-2 text-[10px] font-black text-gray-500 uppercase tracking-widest border-t border-white/5 mt-2">Network</div>
            <a href="{{ route('network.index') }}" class="p-3 text-sm text-white font-bold uppercase rounded-xl hover:bg-white/5 flex items-center gap-3 {{ request()->routeIs('network.index') ? 'bg-white/5 text-purple-400' : '' }}"><i data-lucide="share-2" class="w-4 h-4 text-purple-400"></i> Team Tree</a>
            <a href="{{ route('referrals.index') }}" class="p-3 text-sm text-white font-bold uppercase rounded-xl hover:bg-white/5 flex items-center gap-3 {{ request()->routeIs('referrals.index') ? 'bg-white/5 text-purple-400' : '' }}"><i data-lucide="users" class="w-4 h-4 text-purple-400"></i> Referrals</a>
            <a href="{{ route('level-income.index') }}" class="p-3 text-sm text-white font-bold uppercase rounded-xl hover:bg-white/5 flex items-center gap-3 {{ request()->routeIs('level-income.index') ? 'bg-white/5 text-purple-400' : '' }}"><i data-lucide="layers" class="w-4 h-4 text-purple-400"></i> Level Income</a>
            <a href="{{ route('club.index') }}" class="p-3 text-sm text-white font-bold uppercase rounded-xl hover:bg-white/5 flex items-center gap-3 {{ request()->routeIs('club.index') ? 'bg-white/5 text-purple-400' : '' }}"><i data-lucide="award" class="w-4 h-4 text-purple-400"></i> Club Rewards</a>

            <div class="px-3 pt-4 pb-2 text-[10px] font-black text-gray-500 uppercase tracking-widest border-t border-white/5 mt-2">Finance</div>
            <a href="{{ route('wallet.index') }}" class="p-3 text-sm text-white font-bold uppercase rounded-xl hover:bg-white/5 flex items-center gap-3 {{ request()->routeIs('wallet.index') ? 'bg-white/5 text-purple-400' : '' }}"><i data-lucide="piggy-bank" class="w-4 h-4 text-purple-400"></i> Wallet</a>
            <a href="{{ route('deposits.index') }}" class="p-3 text-sm text-white font-bold uppercase rounded-xl hover:bg-white/5 flex items-center gap-3 {{ request()->routeIs('deposits.index') ? 'bg-white/5 text-purple-400' : '' }}"><i data-lucide="arrow-down-to-line" class="w-4 h-4 text-purple-400"></i> Deposits</a>
            <a href="{{ route('withdraw.create') }}" class="p-3 text-sm text-white font-bold uppercase rounded-xl hover:bg-white/5 flex items-center gap-3 {{ request()->routeIs('withdraw.create') ? 'bg-white/5 text-purple-400' : '' }}"><i data-lucide="arrow-up-right" class="w-4 h-4 text-purple-400"></i> Withdraw</a>
            <a href="{{ route('withdrawals.index') }}" class="p-3 text-sm text-white font-bold uppercase rounded-xl hover:bg-white/5 flex items-center gap-3 {{ request()->routeIs('withdrawals.index') ? 'bg-white/5 text-purple-400' : '' }}"><i data-lucide="history" class="w-4 h-4 text-purple-400"></i> Withdrawal History</a>
            <a href="{{ route('vouchers.index') }}" class="p-3 text-sm text-white font-bold uppercase rounded-xl hover:bg-white/5 flex items-center gap-3 {{ request()->routeIs('vouchers.index') ? 'bg-white/5 text-purple-400' : '' }}"><i data-lucide="ticket" class="w-4 h-4 text-purple-400"></i> Vouchers</a>

            <div class="mt-4 pt-4 border-t border-white/5">
                <a href="{{ route('profile.index') }}" class="p-3 text-sm text-white font-bold uppercase rounded-xl hover:bg-white/5 flex items-center gap-3 {{ request()->routeIs('profile.index') ? 'bg-white/5' : '' }}"><i data-lucide="user" class="w-4 h-4 text-purple-400"></i> Profile</a>
            </div>
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