<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Core Admin - EliteMatrixPro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @include('layouts.theme-master')
    <style>
        body {
            background-color: var(--bg-dark, #050505);
            color: #ffffff;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        .glass {
            background: rgba(10, 10, 10, 0.6);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
        }

        .stats-card {
            background: linear-gradient(145deg, #121212, #080808);
            border: 1px solid rgba(255, 255, 255, 0.03);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .stats-card:hover {
            transform: translateY(-4px);
            border-color: var(--accent-purple);
            box-shadow: 0 10px 40px -10px rgba(139, 92, 246, 0.2);
        }

        .sidebar-link {
            transition: all 0.3s ease;
            color: var(--text-muted);
            border-left: 3px solid transparent;
        }

        .sidebar-link:hover {
            color: #ffffff;
            background: rgba(139, 92, 246, 0.08);
            border-left-color: rgba(139, 92, 246, 0.5);
        }

        .sidebar-link.active {
            color: #ffffff;
            background: rgba(139, 92, 246, 0.12);
            border-left-color: var(--accent-purple);
            font-weight: 600;
        }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: var(--bg-dark); }
        ::-webkit-scrollbar-thumb { background: #1f1f1f; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #333; }

        .btn-gradient {
            background: linear-gradient(135deg, var(--accent-purple), var(--accent-blue));
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-gradient:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 25px -5px rgba(139, 92, 246, 0.4);
        }

        .badge-pending { background: rgba(245, 158, 11, 0.1); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.2); }
        .badge-active { background: rgba(16, 185, 129, 0.1); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2); }
        .badge-danger { background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); }
    </style>
</head>
<body class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="fixed left-0 top-0 bottom-0 w-64 glass border-r border-[#1f1f1f] z-50 hidden lg:block overflow-y-auto">
        <div class="p-6">
            <a href="{{ route('welcome') }}" class="flex items-center gap-3 group mb-10 no-underline">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-purple-500/20 group-hover:scale-110 transition-transform">
                    <i data-lucide="zap" class="w-6 h-6 text-white"></i>
                </div>
                <span class="text-xl font-black text-white tracking-tighter italic">EliteMatrix<span class="text-purple-500">Pro</span></span>
            </a>

            <nav class="space-y-1">
                <div class="text-[10px] uppercase tracking-widest text-[#444] font-bold mb-4 ml-3">Main Control</div>
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    <span class="text-sm font-medium">Dashboard</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i data-lucide="users" class="w-5 h-5"></i>
                    <span class="text-sm font-medium">Users Management</span>
                </a>
                
                <div class="pt-6 text-[10px] uppercase tracking-widest text-[#444] font-bold mb-4 ml-3">Financial Operations</div>
                <a href="{{ route('admin.deposits.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.deposits.*') ? 'active' : '' }}">
                    <i data-lucide="arrow-down-to-line" class="w-5 h-5"></i>
                    <span class="text-sm font-medium">Pending Deposits</span>
                </a>
                <a href="{{ route('admin.withdrawals.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.withdrawals.*') ? 'active' : '' }}">
                    <i data-lucide="arrow-up-from-line" class="w-5 h-5"></i>
                    <span class="text-sm font-medium">Withdrawal Requests</span>
                </a>
                <a href="{{ route('admin.payment-methods.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.payment-methods.*') ? 'active' : '' }}">
                    <i data-lucide="qr-code" class="w-5 h-5"></i>
                    <span class="text-sm font-medium">Payment Gateways</span>
                </a>
                <a href="{{ route('admin.investments.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.investments.*') ? 'active' : '' }}">
                    <i data-lucide="gem" class="w-5 h-5"></i>
                    <span class="text-sm font-medium">Investments List</span>
                </a>
                <a href="{{ route('admin.roi.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.roi.*') ? 'active' : '' }}">
                    <i data-lucide="zap" class="w-5 h-5"></i>
                    <span class="text-sm font-medium">ROI Engine</span>
                </a>
                <a href="{{ route('admin.reports.vouchers') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.reports.vouchers') ? 'active' : '' }}">
                    <i data-lucide="ticket" class="w-5 h-5"></i>
                    <span class="text-sm font-medium">Voucher Report</span>
                </a>

                <div class="pt-6 text-[10px] uppercase tracking-widest text-[#444] font-bold mb-4 ml-3">Network & Growth</div>
                <a href="{{ route('admin.network.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.network.*') ? 'active' : '' }}">
                    <i data-lucide="network" class="w-5 h-5"></i>
                    <span class="text-sm font-medium">Network Tree</span>
                </a>
                <!-- <a href="{{ route('admin.commissions.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.commissions.*') ? 'active' : '' }}">
                    <i data-lucide="layers" class="w-5 h-5"></i>
                    <span class="text-sm font-medium">Commission History</span>
                </a>
                <a href="{{ route('admin.level-settings.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.level-settings.*') ? 'active' : '' }}">
                    <i data-lucide="settings" class="w-5 h-5"></i>
                    <span class="text-sm font-medium">Commission Settings</span>
                </a> -->

                <div class="pt-6 text-[10px] uppercase tracking-widest text-[#444] font-bold mb-4 ml-3">System Control</div>
                <a href="{{ route('admin.reports.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.reports.index') ? 'active' : '' }}">
                    <i data-lucide="bar-chart-3" class="w-5 h-5"></i>
                    <span class="text-sm font-medium">Business Reports</span>
                </a>
                <a href="{{ route('admin.settings') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                    <i data-lucide="settings-2" class="w-5 h-5"></i>
                    <span class="text-sm font-medium">Profile Settings</span>
                </a>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="lg:ml-64 flex-1 flex flex-col min-h-screen">
        
        <!-- Header -->
        <header class="h-20 glass sticky top-0 z-40 border-b border-[#1f1f1f] px-4 lg:px-8 flex items-center justify-between">
            <div class="flex items-center gap-4 lg:hidden">
                <i data-lucide="menu" class="w-6 h-6 text-muted cursor-pointer"></i>
                <a href="{{ route('welcome') }}" class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-lg flex items-center justify-center">
                        <i data-lucide="zap" class="w-4 h-4 text-white"></i>
                    </div>
                    <span class="text-xs font-black text-white tracking-tighter italic">EMP<span class="text-purple-500">Admin</span></span>
                </a>
            </div>

            <div class="hidden lg:flex items-center gap-6">
                <div class="relative group">
                    <i data-lucide="search" class="w-4 h-4 text-muted absolute left-3 top-1/2 -translate-y-1/2"></i>
                    <input type="text" placeholder="Search orders, users..." class="bg-[#121212] border border-[#1f1f1f] rounded-full pl-10 pr-4 py-2 text-sm w-80 focus:outline-none focus:border-purple-600 transition-all text-muted">
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="hidden sm:flex flex-col items-end">
                    <span class="text-sm font-semibold">Super Admin</span>
                    <span class="text-[10px] text-green-500 font-bold uppercase tracking-wider flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                        Live Control
                    </span>
                </div>
                <div class="relative group">
                    <div class="w-10 h-10 rounded-xl glass flex items-center justify-center cursor-pointer border border-[#2d2d2d] group-hover:border-blue-500 transition-all">
                        <i data-lucide="eye" class="w-5 h-5 text-muted group-hover:text-blue-500"></i>
                    </div>
                    <div class="admin-dropdown p-2">
                        <div class="px-3 py-2 text-[9px] font-black text-gray-500 uppercase tracking-widest border-b border-[#1f1f1f] mb-2 text-left">Accessibility</div>
                        <button onclick="setGlobalTheme('default')" class="w-full flex items-center gap-3 px-3 py-2 text-xs font-semibold text-gray-400 hover:text-white hover:bg-[#1a1a1a] rounded-lg transition-all text-left">
                            <span class="w-2 h-2 rounded-full bg-purple-600"></span> Default
                        </button>
                        <button onclick="setGlobalTheme('protanopia')" class="w-full flex items-center gap-3 px-3 py-2 text-xs font-semibold text-gray-400 hover:text-white hover:bg-[#1a1a1a] rounded-lg transition-all text-left">
                            <span class="w-2 h-2 rounded-full bg-[#0072B2]"></span> Protanopia
                        </button>
                        <button onclick="setGlobalTheme('tritanopia')" class="w-full flex items-center gap-3 px-3 py-2 text-xs font-semibold text-gray-400 hover:text-white hover:bg-[#1a1a1a] rounded-lg transition-all text-left">
                            <span class="w-2 h-2 rounded-full bg-[#E69F00]"></span> Tritanopia
                        </button>
                        <button onclick="setGlobalTheme('high-contrast')" class="w-full flex items-center gap-3 px-3 py-2 text-xs font-semibold text-gray-400 hover:text-white hover:bg-[#1a1a1a] rounded-lg transition-all text-left">
                            <span class="w-2 h-2 rounded-full bg-[#FFFF00]"></span> High Contrast
                        </button>
                    </div>
                </div>

                <div class="w-10 h-10 rounded-xl glass flex items-center justify-center cursor-pointer border border-[#2d2d2d] group hover:border-purple-500 transition-all">
                    <i data-lucide="bell" class="w-5 h-5 text-muted group-hover:text-white"></i>
                </div>
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center cursor-pointer shadow-lg shadow-purple-900/20 text-white">
                    <span class="font-bold text-sm">SA</span>
                </div>

                <!-- Admin Logout -->
                <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
                <button type="button" onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();" 
                        class="w-10 h-10 rounded-xl glass flex items-center justify-center cursor-pointer border border-[#2d2d2d] group hover:border-rose-500 transition-all"
                        title="Logout Admin">
                    <i data-lucide="log-out" class="w-5 h-5 text-muted group-hover:text-rose-500"></i>
                </button>
            </div>
        </header>

        <!-- Dynamic Content -->
        <div class="p-4 lg:p-8">
            @yield('content')
        </div>

        <!-- Footer -->
        <footer class="mt-auto p-4 lg:p-8 border-t border-[#1f1f1f] text-center">
            <p class="text-xs text-muted">© 2026 CoreAdmin v2.1.0 — EliteMatrixPro Enterprise Suite. System Latency: 12ms.</p>
        </footer>
    </main>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
