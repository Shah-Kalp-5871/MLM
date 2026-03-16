<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal | {{ env('APP_NAME') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #020617; }
        .glass { background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.05); }
        .neon-border { border: 1px solid rgba(139, 92, 246, 0.3); box-shadow: 0 0 20px rgba(139, 92, 246, 0.1); }
        .admin-gradient { background: linear-gradient(135deg, #1e1b4b 0%, #020617 100%); }
    </style>
</head>
<body class="admin-gradient min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-[420px] relative">
        <!-- Background Glow -->
        <div class="absolute -top-24 -left-24 w-64 h-64 bg-purple-600/10 rounded-full blur-[100px]"></div>
        <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-indigo-600/10 rounded-full blur-[100px]"></div>

        <div class="glass neon-border rounded-[2.5rem] p-10 relative overflow-hidden">
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-tr from-purple-600 to-indigo-500 mb-6 shadow-xl shadow-purple-500/20">
                    <i data-lucide="shield-check" class="text-white w-8 h-8"></i>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight mb-2">Admin Portal</h1>
                <p class="text-gray-500 text-xs font-bold uppercase tracking-[0.2em]">Authorized Access Only</p>
            </div>

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 ml-1">Admin Email</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-500 group-focus-within:text-purple-400">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                        </div>
                        <input type="email" name="email" required 
                               class="block w-full pl-11 pr-4 py-4 bg-white/5 border border-white/10 rounded-2xl text-white text-sm placeholder:text-gray-600 focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500/50 transition-all"
                               placeholder="admin@domain.com">
                    </div>
                    @error('email')
                        <p class="mt-2 text-[10px] text-red-500 font-bold uppercase tracking-wider">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 ml-1">Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-500 group-focus-within:text-purple-400">
                            <i data-lucide="lock" class="w-4 h-4"></i>
                        </div>
                        <input type="password" name="password" required 
                               class="block w-full pl-11 pr-4 py-4 bg-white/5 border border-white/10 rounded-2xl text-white text-sm placeholder:text-gray-600 focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500/50 transition-all"
                               placeholder="••••••••">
                    </div>
                </div>

                <button type="submit" 
                        class="w-full py-4 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white font-black text-xs uppercase tracking-widest rounded-2xl shadow-xl shadow-purple-900/20 transform transition-all active:scale-[0.98]">
                    Enter System
                </button>

                <div class="text-center pt-4">
                    <a href="{{ url('/') }}" class="text-[10px] font-black text-gray-600 uppercase tracking-widest hover:text-white transition-colors">
                        ← Exit to Public Site
                    </a>
                </div>
            </form>
        </div>
        
        <p class="text-center mt-8 text-[10px] text-gray-600 font-bold uppercase tracking-[0.3em]">Secure Environment 4.0.1</p>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
