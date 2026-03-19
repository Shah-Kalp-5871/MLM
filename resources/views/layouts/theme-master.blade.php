<style>
    :root {
        /* Default Branding Colors (Will be overridden by JS) */
        --primary: #9333ea;
        --primary-hover: #a855f7;
        --primary-rgb: 147, 51, 234;
        --secondary: #4f46e5;
        --secondary-rgb: 79, 70, 229;
        --accent: #10b981;
        --accent-rgb: 16, 185, 129;
        --danger: #f43f5e;
        
        /* Default Backgrounds mapped from setups */
        --bg-deep: #0a0b14;
        --bg-dark: #050505;
        --bg: #F4F7FB;
        --card-bg: #ffffff;
        
        /* Default Text */
        --text: #1A1A2E;
        --text-main: #94a3b8;
        
        /* Default Structural */
        --glass-bg: rgba(255, 255, 255, 0.03);
        --glass-border: rgba(255, 255, 255, 0.08);
    }

    /* Fallback Classes for CSS Only (JS takes primarily over :root) */
    .theme-midnight { background-color: var(--bg-deep) !important; color: var(--text-main) !important; }
    .theme-sunset { background-color: var(--bg-deep) !important; color: var(--text-main) !important; }
    .theme-protanopia { background-color: var(--bg-deep) !important; color: var(--text-main) !important; }
    .theme-tritanopia { background-color: var(--bg-deep) !important; color: var(--text-main) !important; }
    .theme-high-contrast { background-color: var(--bg-deep) !important; color: var(--text-main) !important; }

    /* Comprehensive Utility Overrides */
    .bg-purple-600, .bg-purple-500, .bg-indigo-600, .bg-indigo-500, .bg-vibrant { background-color: var(--primary) !important; }
    .hover\:bg-purple-500:hover, .hover\:bg-indigo-500:hover { background-color: var(--primary-hover) !important; }
    
    .text-purple-600, .text-purple-500, .text-indigo-600, .text-indigo-500, .text-vibrant, .text-brand-purple { color: var(--primary) !important; }
    
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
        
        if (body) {
            body.classList.remove('theme-protanopia', 'theme-tritanopia', 'theme-high-contrast', 'theme-midnight', 'theme-sunset');
            
            if (themeName !== 'default') {
                body.classList.add('theme-' + themeName);
            }
        } else {
             // Fallback to html tag if body is not yet parsed
             root.classList.remove('theme-protanopia', 'theme-tritanopia', 'theme-high-contrast', 'theme-midnight', 'theme-sunset');
             if (themeName !== 'default') {
                 root.classList.add('theme-' + themeName);
             }
        }
        
        const themes = {
            'default': {
                '--primary': '#9333ea', '--primary-hover': '#a855f7', '--primary-rgb': '147, 51, 234',
                '--secondary': '#4f46e5', '--accent': '#10b981', '--accent-rgb': '16, 185, 129',
                '--bg-deep': '#0a0b14', '--bg-dark': '#050505', '--bg': '#F4F7FB', '--card-bg': '#ffffff',
                '--text': '#1A1A2E', '--text-main': '#94a3b8',
                '--glass-bg': 'rgba(255, 255, 255, 0.03)', '--glass-border': 'rgba(255, 255, 255, 0.08)'
            },
            'midnight': {
                '--primary': '#8b5cf6', '--primary-hover': '#7c3aed', '--primary-rgb': '139, 92, 246',
                '--secondary': '#3b82f6', '--accent': '#2dd4bf', '--accent-rgb': '45, 212, 191',
                '--bg-deep': '#020617', '--bg-dark': '#0f172a', '--bg': '#0f172a', '--card-bg': '#1e293b',
                '--text': '#f8fafc', '--text-main': '#cbd5e1',
                '--glass-bg': 'rgba(30, 41, 59, 0.7)', '--glass-border': 'rgba(56, 189, 248, 0.2)'
            },
            'sunset': {
                '--primary': '#ea580c', '--primary-hover': '#c2410c', '--primary-rgb': '234, 88, 12',
                '--secondary': '#dc2626', '--accent': '#ca8a04', '--accent-rgb': '202, 138, 4',
                '--bg-deep': '#2a0a0a', '--bg-dark': '#1c0505', '--bg': '#fff7ed', '--card-bg': '#ffedd5',
                '--text': '#431407', '--text-main': '#fdba74',
                '--glass-bg': 'rgba(67, 20, 7, 0.8)', '--glass-border': 'rgba(234, 88, 12, 0.3)'
            },
            'protanopia': {
                '--primary': '#0072B2', '--primary-hover': '#005a8d', '--primary-rgb': '0, 114, 178',
                '--secondary': '#F0E442', '--accent': '#56B4E9', '--accent-rgb': '86, 180, 233',
                '--bg-deep': '#001a2e', '--bg-dark': '#001122', '--bg': '#e6f2ff', '--card-bg': '#ffffff',
                '--text': '#002244', '--text-main': '#e6f2ff',
                '--glass-bg': 'rgba(0, 114, 178, 0.15)', '--glass-border': 'rgba(0, 114, 178, 0.3)'
            },
            'tritanopia': {
                '--primary': '#E69F00', '--primary-hover': '#b87f00', '--primary-rgb': '230, 159, 0',
                '--secondary': '#56B4E9', '--accent': '#CC79A7', '--accent-rgb': '204, 121, 167',
                '--bg-deep': '#1a1100', '--bg-dark': '#0d0900', '--bg': '#fffaf0', '--card-bg': '#ffffff',
                '--text': '#332200', '--text-main': '#ffe6b3',
                '--glass-bg': 'rgba(230, 159, 0, 0.15)', '--glass-border': 'rgba(230, 159, 0, 0.3)'
            },
            'high-contrast': {
                '--primary': '#FFFF00', '--primary-hover': '#e6e600', '--primary-rgb': '255, 255, 0',
                '--secondary': '#00FFFF', '--accent': '#FFFFFF', '--accent-rgb': '255, 255, 255',
                '--bg-deep': '#000000', '--bg-dark': '#000000', '--bg': '#000000', '--card-bg': '#111111',
                '--text': '#ffffff', '--text-main': '#ffffff',
                '--glass-bg': 'rgba(0, 0, 0, 0.9)', '--glass-border': 'rgba(255, 255, 255, 0.5)'
            }
        };

        const theme = themes[themeName] || themes['default'];
        Object.keys(theme).forEach(key => {
            root.style.setProperty(key, theme[key]);
        });
        
        localStorage.setItem('global-preferred-theme', themeName);
        
        if (window.lucide) {
            lucide.createIcons();
        }
    }

    (function() {
        const savedTheme = localStorage.getItem('global-preferred-theme') || 'default';
        document.addEventListener('DOMContentLoaded', () => {
            setGlobalTheme(savedTheme);
        });
        const theme = savedTheme;
        if (theme !== 'default') {
             document.documentElement.classList.add('theme-' + theme);
        }
        
        // Block render flash by instantly applying styles
        function applyInitialCSS() {
            setGlobalTheme(theme);
        }
        applyInitialCSS();
    })();
</script>
