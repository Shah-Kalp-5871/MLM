<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication | MLM Platform</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: var(--bg-deep); color: var(--text-main); }
        .glass-panel { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.08); }
        .auth-input { background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.1); color: white; transition: all 0.3s; }
        .auth-input:focus { border-color: #9333ea; box-shadow: 0 0 15px rgba(147, 51, 234, 0.15); outline: none; background: rgba(255, 255, 255, 0.04); }
    </style>
</head>
<body class="selection:bg-purple-500 selection:text-white min-h-screen flex items-center justify-center p-6 md:p-12 relative">

    <!-- Background Elements -->
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute top-[-10%] left-[-10%] w-[600px] h-[600px] bg-purple-900/10 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[700px] h-[700px] bg-indigo-900/10 rounded-full blur-[150px]"></div>
    </div>

    <!-- Content Area -->
    <div class="relative z-10 w-full flex justify-center">
        @yield('content')
    </div>

    <script>
        lucide.createIcons();

        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.querySelector(`#${iconId}`);
            if (input.type === 'password') {
                input.type = 'text';
                icon.setAttribute('data-lucide', 'eye-off');
            } else {
                input.type = 'password';
                icon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        }
    </script>
</body>
</html>