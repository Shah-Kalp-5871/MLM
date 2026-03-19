<style>
    :root {
        /* Default Branding Colors */
        --primary: #9333ea;
        --primary-hover: #a855f7;
        --primary-rgb: 147, 51, 234;
        --secondary: #4f46e5;
        --secondary-rgb: 79, 70, 229;
        --accent: #10b981;
        --accent-rgb: 16, 185, 129;
        --danger: #f43f5e;
        --bg-deep: #0a0b14;
        --text-main: #94a3b8;
    }

    /* Theme Overrides */
    .theme-protanopia {
        --primary: #0072B2;
        --primary-hover: #005a8d;
        --primary-rgb: 0, 114, 178;
        --secondary: #F0E442;
        --secondary-rgb: 240, 228, 66;
        --accent: #56B4E9;
        --accent-rgb: 86, 180, 233;
        --danger: #D55E00;
    }

    .theme-tritanopia {
        --primary: #E69F00;
        --primary-hover: #b87f00;
        --primary-rgb: 230, 159, 0;
        --secondary: #56B4E9;
        --secondary-rgb: 86, 180, 233;
        --accent: #CC79A7;
        --accent-rgb: 204, 121, 167;
        --danger: #009E73;
    }

    .theme-high-contrast {
        --primary: #FFFF00;
        --primary-hover: #e6e600;
        --primary-rgb: 255, 255, 0;
        --secondary: #00FFFF;
        --secondary-rgb: 0, 255, 255;
        --accent: #FFFFFF;
        --accent-rgb: 255, 255, 255;
        --danger: #FF00FF;
        --bg-deep: #000000;
        --text-main: #ffffff;
    }

    /* Comprehensive Utility Overrides */
    .bg-purple-600, .bg-purple-500, .bg-indigo-600, .bg-indigo-500, .bg-vibrant { background-color: var(--primary) !important; }
    .hover\:bg-purple-500:hover, .hover\:bg-indigo-500:hover { background-color: var(--primary-hover) !important; }
    
    .text-purple-600, .text-purple-500, .text-indigo-600, .text-indigo-500, .text-vibrant { color: var(--primary) !important; }
    
    .from-purple-600, .from-indigo-600 { --tw-gradient-from: var(--primary) !important; --tw-gradient-to: var(--secondary) !important; --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to) !important; }
    .to-purple-600, .to-indigo-600 { --tw-gradient-to: var(--secondary) !important; }
    
    .border-purple-600, .border-purple-500, .border-indigo-600, .border-indigo-500 { border-color: var(--primary) !important; }
    .border-purple-500\/30, .border-white\/10 { border-color: rgba(var(--primary-rgb), 0.2) !important; }
    
    .shadow-purple-900\/40, .shadow-purple-500\/20, .shadow-indigo-500\/20 { --tw-shadow-color: rgba(var(--primary-rgb), 0.4) !important; }

    /* Special Classes */
    .badge-active { background: rgba(var(--accent-rgb), 0.1) !important; color: var(--accent) !important; border: 1px solid rgba(var(--accent-rgb), 0.2) !important; }
    .text-purple-400 { color: var(--primary) !important; opacity: 0.8; }
</style>

<script>
    function setGlobalTheme(themeName) {
        const root = document.documentElement;
        const body = document.body;
        
        // Remove existing theme classes
        body.classList.remove('theme-protanopia', 'theme-tritanopia', 'theme-high-contrast');
        
        // Add new theme class
        if (themeName !== 'default') {
            body.classList.add('theme-' + themeName);
        }
        
        // Also update variables directly for non-class browsers/elements
        const themes = {
            'default': {
                '--primary': '#9333ea',
                '--primary-hover': '#a855f7',
                '--primary-rgb': '147, 51, 234',
                '--secondary': '#4f46e5',
                '--accent': '#10b981',
                '--accent-rgb': '16, 185, 129',
                '--bg-deep': '#0a0b14',
                '--text-main': '#94a3b8'
            },
            'protanopia': {
                '--primary': '#0072B2',
                '--primary-hover': '#005a8d',
                '--primary-rgb': '0, 114, 178',
                '--secondary': '#F0E442',
                '--accent': '#56B4E9',
                '--accent-rgb': '86, 180, 233',
                '--bg-deep': '#0a0b14',
                '--text-main': '#94a3b8'
            },
            'tritanopia': {
                '--primary': '#E69F00',
                '--primary-hover': '#b87f00',
                '--primary-rgb': '230, 159, 0',
                '--secondary': '#56B4E9',
                '--accent': '#CC79A7',
                '--accent-rgb': '204, 121, 167',
                '--bg-deep': '#0a0b14',
                '--text-main': '#94a3b8'
            },
            'high-contrast': {
                '--primary': '#FFFF00',
                '--primary-hover': '#e6e600',
                '--primary-rgb': '255, 255, 0',
                '--secondary': '#00FFFF',
                '--accent': '#FFFFFF',
                '--accent-rgb': '255, 255, 255',
                '--bg-deep': '#000000',
                '--text-main': '#ffffff'
            }
        };

        const theme = themes[themeName] || themes['default'];
        Object.keys(theme).forEach(key => {
            root.style.setProperty(key, theme[key]);
        });
        
        localStorage.setItem('global-preferred-theme', themeName);
        
        // Re-render Lucide icons just in case
        if (window.lucide) {
            lucide.createIcons();
        }
    }

    // Apply theme immediately
    (function() {
        const savedTheme = localStorage.getItem('global-preferred-theme') || 'default';
        document.addEventListener('DOMContentLoaded', () => {
            setGlobalTheme(savedTheme);
        });
        // Also apply to HTML tag immediately to prevent flash
        const theme = savedTheme;
        if (theme !== 'default') {
             // We can't use classList on body yet, but we can on root
             document.documentElement.classList.add('theme-' + theme);
        }
    })();
</script>
