<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - NexaNet</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #050505;
            --accent-purple: #8b5cf6;
        }
        body { background-color: var(--bg-dark); font-family: 'Inter', sans-serif; color: white; }
        .glass { background: rgba(15, 15, 15, 0.7); backdrop-filter: blur(12px); border: 1px solid #1f1f1f; }
        .btn-gradient { background: linear-gradient(135deg, #8b5cf6, #3b82f6); }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">
    
    <div class="w-full max-w-md space-y-8 relative">
        <!-- Glow Effect -->
        <div class="absolute -top-32 left-1/2 -translate-x-1/2 w-64 h-64 bg-purple-600/20 rounded-full blur-[100px]"></div>

        <div class="text-center relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-purple-600 to-blue-600 flex items-center justify-center mx-auto mb-6 shadow-2xl shadow-purple-900/40">
                <i data-lucide="shield-check" class="text-white w-8 h-8"></i>
            </div>
            <h1 class="text-3xl font-black tracking-tight">CoreAdmin</h1>
            <p class="text-slate-400 mt-2 font-medium">Enterprise Control Suite Access</p>
        </div>

        <div class="glass p-8 rounded-[2.5rem] relative z-10 shadow-2xl">
            <form class="space-y-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] ml-1">Administrator Email</label>
                    <div class="relative group">
                        <i data-lucide="mail" class="w-4 h-4 text-slate-500 absolute left-4 top-1/2 -translate-y-1/2 group-focus-within:text-purple-500 transition-colors"></i>
                        <input type="email" placeholder="admin@nexanet.com" class="w-full bg-[#0c0c0c] border border-[#1f1f1f] rounded-2xl pl-12 pr-4 py-3.5 text-sm focus:outline-none focus:border-purple-600 transition-all placeholder:text-slate-700">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] ml-1">Secure Password</label>
                    <div class="relative group">
                        <i data-lucide="lock" class="w-4 h-4 text-slate-500 absolute left-4 top-1/2 -translate-y-1/2 group-focus-within:text-purple-500 transition-colors"></i>
                        <input type="password" placeholder="••••••••" class="w-full bg-[#0c0c0c] border border-[#1f1f1f] rounded-2xl pl-12 pr-4 py-3.5 text-sm focus:outline-none focus:border-purple-600 transition-all placeholder:text-slate-700">
                    </div>
                </div>

                <div class="flex items-center justify-between px-1">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="checkbox" class="w-4 h-4 rounded border-[#1f1f1f] bg-[#0c0c0c] text-purple-600 focus:ring-purple-600 focus:ring-offset-0">
                        <span class="text-xs text-slate-400 group-hover:text-slate-300 transition-colors">Remember Session</span>
                    </label>
                </div>

                <button type="button" onclick="location.href='/admin/dashboard'" class="w-full btn-gradient py-4 rounded-2xl font-bold text-sm shadow-xl shadow-purple-600/10 hover:opacity-90 active:scale-[0.98] transition-all">
                    Authorize & Login
                </button>
            </form>
        </div>

        <p class="text-center text-xs text-slate-600">
            Authorized Personnel Only. All access is logged via IP <span class="font-mono">192.168.x.x</span>
        </p>
    </div>

    <script>lucide.createIcons();</script>
</body>
</html>
