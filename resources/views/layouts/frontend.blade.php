<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kushal Portfolio</title>

    {{-- =====================================================
         ANTI-FOUC: apply stored dark mode BEFORE any paint
         ===================================================== --}}
    <script>
    (function(){
        try {
            var d = localStorage.getItem('adm_dark');
            var html = document.documentElement;
            if (d === 'dark') {
                html.classList.add('dark');
            } else if (d === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                html.classList.add('dark');
            }
        } catch(e) {}
    })();
    </script>

    {{-- External CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/devicon.min.css">

    {{-- app.js includes Alpine.js (npm) — no CDN Alpine needed --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white dark:bg-gray-950 text-gray-800 dark:text-gray-100 transition-colors duration-300 antialiased">

{{-- ===============================================================
     NAVBAR
================================================================ --}}
<nav x-data="{
        open: false,
        dark: document.documentElement.classList.contains('dark'),
        toggleDark() {
            this.dark = !this.dark;
            var html = document.documentElement;
            html.classList.add('theme-transition');
            html.classList.toggle('dark', this.dark);
            localStorage.setItem('adm_dark', this.dark ? 'dark' : 'light');
            setTimeout(function(){ html.classList.remove('theme-transition'); }, 350);
        }
     }"
     class="fixed top-0 left-0 w-full z-50
            backdrop-blur-lg
            bg-white/80 dark:bg-gray-900/80
            border-b border-gray-200/60 dark:border-gray-700/60
            shadow-sm">

    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

        {{-- LOGO --}}
        <a href="{{ url('/') }}" class="text-xl font-bold text-indigo-600 dark:text-indigo-400">
            Kushal.dev
        </a>

        {{-- DESKTOP MENU --}}
        <div class="hidden md:flex items-center gap-7 text-sm font-medium">

            <a href="{{ url('/') }}"
               class="{{ request()->is('/') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400' }} transition-colors duration-200">
                Home
            </a>

            <a href="{{ url('/#projects') }}"
               class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-200">
                Projects
            </a>

            <a href="{{ url('/contact') }}"
               class="{{ request()->is('contact') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400' }} transition-colors duration-200">
                Contact
            </a>

            @auth
                <a href="{{ url('/admin') }}"
                   class="{{ request()->is('admin*') ? 'text-indigo-600 font-semibold dark:text-indigo-400' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400' }} transition-colors duration-200">
                    Dashboard
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-red-500 hover:text-red-600 dark:hover:text-red-400 transition">
                        Logout
                    </button>
                </form>
            @endauth

            {{-- ===== DARK MODE TOGGLE (desktop) ===== --}}
            <button
                @click="toggleDark()"
                :title="dark ? 'Switch to Light Mode' : 'Switch to Dark Mode'"
                :aria-label="dark ? 'Switch to Light Mode' : 'Switch to Dark Mode'"
                class="w-9 h-9 flex items-center justify-center rounded-lg
                       text-gray-600 dark:text-gray-300
                       hover:text-indigo-600 dark:hover:text-indigo-400
                       hover:bg-gray-100 dark:hover:bg-gray-800
                       border border-transparent hover:border-gray-200 dark:hover:border-gray-700
                       transition-all duration-200"
            >
                {{-- Sun: visible when dark mode is ON --}}
                <svg x-show="dark" x-cloak style="width:17px;height:17px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                </svg>
                {{-- Moon: visible when light mode is ON --}}
                <svg x-show="!dark" x-cloak style="width:17px;height:17px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
            </button>

        </div>

        {{-- MOBILE: dark toggle + hamburger --}}
        <div class="md:hidden flex items-center gap-1">

            {{-- Dark toggle (mobile) --}}
            <button
                @click="toggleDark()"
                :title="dark ? 'Light Mode' : 'Dark Mode'"
                class="w-9 h-9 flex items-center justify-center rounded-lg
                       text-gray-600 dark:text-gray-300
                       hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-200"
            >
                <svg x-show="dark" x-cloak style="width:18px;height:18px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                </svg>
                <svg x-show="!dark" x-cloak style="width:18px;height:18px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
            </button>

            {{-- Hamburger --}}
            <button @click="open = !open"
                    class="w-9 h-9 flex items-center justify-center text-gray-700 dark:text-gray-300 focus:outline-none">
                <svg x-show="!open" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="open" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

        </div>

    </div>

    {{-- MOBILE MENU --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         x-cloak
         class="md:hidden bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 shadow-md">

        <div class="px-6 py-5 space-y-3 text-sm font-medium">

            <a href="{{ url('/') }}" @click="open=false"
               class="flex items-center gap-2 py-2 text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                Home
            </a>

            <a href="{{ url('/#projects') }}" @click="open=false"
               class="flex items-center gap-2 py-2 text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                Projects
            </a>

            <a href="{{ url('/contact') }}" @click="open=false"
               class="flex items-center gap-2 py-2 text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                Contact
            </a>

            @auth
                <div class="pt-1 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ url('/admin') }}" @click="open=false"
                       class="flex items-center gap-2 py-2 text-indigo-600 dark:text-indigo-400 font-semibold">
                        Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="flex items-center gap-2 py-2 text-red-500 hover:text-red-600 dark:hover:text-red-400 transition">
                            Logout
                        </button>
                    </form>
                </div>
            @endauth

        </div>
    </div>

</nav>

{{-- ===============================================================
     PAGE CONTENT
================================================================ --}}
<main class="pt-24">
    @yield('content')
</main>

{{-- AOS animation --}}
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({ once: true, duration: 800, offset: 100 });
</script>

{{-- Flash message auto-fade --}}
<script>
    setTimeout(function() {
        document.querySelectorAll('[data-alert]').forEach(function(el) {
            el.style.transition = 'opacity 0.5s';
            el.style.opacity = 0;
        });
    }, 3000);
</script>

{{-- ===============================================================
     FRONTEND THEME CUSTOMIZER (floating)
================================================================ --}}
<div x-data="{ open: false }" style="position:fixed;bottom:1.5rem;right:1.5rem;z-index:9999">

    {{-- Backdrop --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         x-cloak
         @click="open = false"
         style="position:fixed;inset:0;background:rgba(0,0,0,.25);z-index:9998;backdrop-filter:blur(2px)">
    </div>

    {{-- Panel --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-250"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 scale-95"
         x-cloak
         style="position:absolute;bottom:3.75rem;right:0;width:240px;background:white;border-radius:1rem;box-shadow:0 20px 60px rgba(0,0,0,.18);z-index:9999;overflow:hidden;border:1px solid #e5e7eb"
         class="dark:!bg-gray-900 dark:!border-gray-700">

        {{-- Header --}}
        <div style="padding:1rem 1.25rem .75rem;border-bottom:1px solid #f3f4f6;display:flex;align-items:center;justify-content:space-between"
             class="dark:!border-gray-800">
            <div>
                <div style="font-size:.9375rem;font-weight:700;color:#111827" class="dark:!text-white">Theme</div>
                <div style="font-size:.75rem;color:#9ca3af;margin-top:.1rem">Personalize your view</div>
            </div>
            <button @click="open = false"
                    style="width:28px;height:28px;border-radius:50%;border:none;background:#f3f4f6;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#6b7280"
                    class="dark:!bg-gray-800 dark:!text-gray-400">
                <svg style="width:14px;height:14px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div style="padding:1rem 1.25rem 1.25rem">

            {{-- Appearance --}}
            <div style="font-size:.6875rem;font-weight:600;color:#9ca3af;letter-spacing:.07em;text-transform:uppercase;margin-bottom:.75rem">
                Appearance
            </div>
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:.5rem;margin-bottom:1.125rem">
                @foreach([['light','☀️','Light'],['dark','🌙','Dark'],['system','🖥️','System']] as [$mode,$icon,$label])
                <button
                    @click="$store.adm.setDark('{{ $mode }}')"
                    :style="$store.adm.dark==='{{ $mode }}'
                        ? 'background:#eef2ff;border:1.5px solid #6366f1;color:#6366f1'
                        : 'background:#f9fafb;border:1.5px solid #e5e7eb;color:#6b7280'"
                    style="border-radius:.625rem;padding:.6rem .25rem;font-size:.8rem;font-weight:600;cursor:pointer;display:flex;flex-direction:column;align-items:center;gap:.3rem;transition:all .15s"
                    class="dark:!bg-gray-800 dark:!border-gray-700 dark:!text-gray-300"
                >
                    <span style="font-size:1.25rem">{{ $icon }}</span>
                    <span>{{ $label }}</span>
                </button>
                @endforeach
            </div>

            {{-- Reset --}}
            <button @click="$store.adm.setDark('light')"
                    style="width:100%;padding:.5rem;border-radius:.5rem;border:1px solid #e5e7eb;background:transparent;color:#9ca3af;font-size:.8125rem;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:.375rem;transition:all .15s"
                    class="dark:!border-gray-700 dark:!text-gray-500"
                    onmouseover="this.style.borderColor='#6366f1';this.style.color='#6366f1'"
                    onmouseout="this.style.borderColor='';this.style.color=''">
                <svg style="width:13px;height:13px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Reset to Light Mode
            </button>

        </div>
    </div>

    {{-- Floating Toggle Button --}}
    <button @click="open = !open"
            :class="open ? 'rotate-90' : ''"
            style="width:48px;height:48px;border-radius:50%;border:none;cursor:pointer;
                   background:var(--p,#6366f1);color:white;
                   box-shadow:0 4px 20px rgba(99,102,241,.45);
                   display:flex;align-items:center;justify-content:center;
                   transition:transform .3s,box-shadow .2s;position:relative;z-index:9999"
            onmouseover="this.style.boxShadow='0 6px 28px rgba(99,102,241,.6)'"
            onmouseout="this.style.boxShadow='0 4px 20px rgba(99,102,241,.45)'"
            title="Customize Theme"
            aria-label="Open Theme Customizer">
        <svg style="width:20px;height:20px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
        </svg>
    </button>

</div>

</body>
</html>
