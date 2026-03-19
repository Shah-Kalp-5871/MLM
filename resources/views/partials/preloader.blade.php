<div id="global-preloader" class="fixed inset-0 z-[9999] flex items-center justify-center bg-[#0a0f1d] transition-opacity duration-700">
    <div class="relative flex flex-col items-center">
        <!-- Glowing Core -->
        <div class="absolute inset-0 bg-purple-600/20 blur-[50px] rounded-full w-32 h-32 mx-auto animate-pulse"></div>
        
        <!-- Animated Rings -->
        <div class="relative w-24 h-24 mb-6">
            <!-- Background Track -->
            <div class="absolute inset-0 border-4 border-white/5 rounded-full"></div>
            
            <!-- Outer Ring -->
            <div class="absolute inset-0 border-4 border-transparent border-t-purple-500 border-r-indigo-500 rounded-full animate-spin" style="animation-duration: 1.5s;"></div>
            
            <!-- Inner Ring -->
            <div class="absolute inset-2 border-4 border-transparent border-t-emerald-400 border-l-teal-400 rounded-full animate-spin" style="animation-duration: 2s; animation-direction: reverse;"></div>
            
            <!-- Center Icon Logo -->
            <div class="absolute inset-0 flex items-center justify-center text-white">
                <i data-lucide="layers" class="w-8 h-8 animate-pulse text-purple-300"></i>
            </div>
        </div>

        <!-- Text -->
        <div class="text-center relative">
            <h2 class="text-white text-xl font-black tracking-widest uppercase flex items-center justify-center">
                EliteMatrix<span class="text-purple-500">Pro</span>
            </h2>
            <div class="mt-2 flex items-center justify-center gap-1 opacity-70">
                <div class="w-1.5 h-1.5 bg-purple-500 rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                <div class="w-1.5 h-1.5 bg-indigo-500 rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                <div class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-bounce" style="animation-delay: 300ms"></div>
            </div>
        </div>
    </div>
</div>

<script>
    // Ensure the preloader fades out when the page is fully loaded
    window.addEventListener('load', function() {
        const preloader = document.getElementById('global-preloader');
        if (preloader) {
            preloader.style.opacity = '0';
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 700); // Wait for the transition-opacity to finish
        }
    });

    // Fallback: If 'load' event doesn't fire, remove it after 5 seconds to prevent hanging
    setTimeout(() => {
        const preloader = document.getElementById('global-preloader');
        if (preloader && preloader.style.display !== 'none') {
            preloader.style.opacity = '0';
            setTimeout(() => preloader.style.display = 'none', 700);
        }
    }, 5000);
</script>
