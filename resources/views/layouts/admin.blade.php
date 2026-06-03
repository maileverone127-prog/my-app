<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Kushal.dev</title>

    {{-- Google Fonts: Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Vite Assets (CSS + JS with Alpine) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

{{-- Alpine `x-data` wraps the whole page so nested components can access $store.adm --}}
<body class="admin-wrap" x-data>

    {{-- ===============================================================
         MOBILE SIDEBAR OVERLAY
    ================================================================ --}}
    <div
        class="mobile-overlay animate-fade-in"
        x-show="$store.adm.mobileMenuOpen"
        x-transition:enter="transition-opacity duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="$store.adm.closeMobileMenu()"
        style="display:none"
    ></div>

    {{-- ===============================================================
         SIDEBAR
    ================================================================ --}}
    <aside
        class="admin-sidebar"
        :class="{
            'is-collapsed': $store.adm.sidebarCollapsed,
            'mobile-open':  $store.adm.mobileMenuOpen
        }"
        aria-label="Admin navigation"
    >
        {{-- ---- LOGO ---- --}}
        <a href="{{ route('admin.dashboard') }}" class="sb-logo" title="Go to Dashboard">
            <div class="sb-logo-icon">K</div>
            <div class="sb-logo-text">
                <div class="sb-logo-title">Kushal.dev</div>
                <div class="sb-logo-subtitle">Admin Panel</div>
            </div>
        </a>

        {{-- ---- NAVIGATION ---- --}}
        <nav class="sb-nav" aria-label="Sidebar navigation">

            <div class="sb-section-label">Main</div>

            {{-- Dashboard --}}
            <a href="{{ route('admin.dashboard') }}"
               class="sb-item {{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}"
               title="Dashboard">
                <svg class="sb-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span class="sb-item-text">Dashboard</span>
            </a>

            {{-- Projects --}}
            <a href="{{ route('admin.projects.index') }}"
               class="sb-item {{ request()->routeIs('admin.projects*') ? 'active' : '' }}"
               title="Projects">
                <svg class="sb-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                </svg>
                <span class="sb-item-text">Projects</span>
            </a>

            <div class="sb-section-label" style="margin-top:.875rem">Website</div>

            {{-- View Website --}}
            <a href="{{ route('home') }}" target="_blank"
               class="sb-item"
               title="View Live Website">
                <svg class="sb-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                <span class="sb-item-text">View Website</span>
            </a>

            {{-- Contact Messages --}}
            <a href="{{ route('admin.messages.index') }}"
               class="sb-item {{ request()->routeIs('admin.messages*') ? 'active' : '' }}"
               title="Contact Messages">
                @php $unread = \App\Models\Message::unread()->count(); @endphp
                <svg class="sb-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <span class="sb-item-text" style="display:flex;align-items:center;justify-content:space-between;width:100%">
                    Contact
                    @if($unread > 0)
                        <span style="background:#6366f1;color:#fff;font-size:.7rem;font-weight:700;padding:.15rem .45rem;border-radius:999px;min-width:18px;text-align:center">{{ $unread }}</span>
                    @endif
                </span>
            </a>

            {{-- Settings --}}
            <a href="{{ route('admin.settings.index') }}"
               class="sb-item {{ request()->routeIs('admin.settings*') ? 'active' : '' }}"
               title="Settings">
                <svg class="sb-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span class="sb-item-text">Settings</span>
            </a>

            {{-- Backup & Restore --}}
            <a href="{{ route('admin.backup.index') }}"
               class="sb-item {{ request()->routeIs('admin.backup*') ? 'active' : '' }}"
               title="Backup & Restore">
                <svg class="sb-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                <span class="sb-item-text">Backup</span>
            </a>

        </nav>

        {{-- ---- FOOTER (user + collapse) ---- --}}
        <div class="sb-footer">

            {{-- User info --}}
            <div class="sb-user">
                <div class="sb-avatar" aria-hidden="true">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="sb-user-info">
                    <div class="sb-user-name">{{ Auth::user()->name ?? 'Admin' }}</div>
                    <div class="sb-user-role">Administrator</div>
                </div>
            </div>

            {{-- Collapse toggle --}}
            <button
                class="sb-collapse-btn"
                @click="$store.adm.toggleSidebar()"
                :title="$store.adm.sidebarCollapsed ? 'Expand sidebar' : 'Collapse sidebar'"
                aria-label="Toggle sidebar"
            >
                {{-- Chevron icon rotates on collapse --}}
                <svg
                    :style="$store.adm.sidebarCollapsed ? 'transform:rotate(180deg)' : ''"
                    style="width:16px;height:16px;transition:transform .3s ease;flex-shrink:0"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
                </svg>
                <span class="sb-item-text" style="font-size:.8125rem">Collapse</span>
            </button>

        </div>
    </aside>

    {{-- ===============================================================
         MAIN AREA
    ================================================================ --}}
    <div
        class="admin-main"
        :class="{ 'sidebar-collapsed': $store.adm.sidebarCollapsed }"
    >

        {{-- ============================================================
             TOPBAR / HEADER
        ============================================================= --}}
        <header class="admin-header">

            {{-- LEFT: mobile menu toggle + page title --}}
            <div class="flex items-center gap-3 flex-1 min-w-0">

                {{-- Mobile hamburger --}}
                <button
                    class="header-btn lg:hidden"
                    @click="$store.adm.toggleMobileMenu()"
                    aria-label="Open sidebar"
                >
                    <svg style="width:20px;height:20px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                {{-- Desktop sidebar toggle --}}
                <button
                    class="header-btn hidden lg:flex"
                    @click="$store.adm.toggleSidebar()"
                    :title="$store.adm.sidebarCollapsed ? 'Expand sidebar' : 'Collapse sidebar'"
                    aria-label="Toggle sidebar"
                >
                    <svg style="width:18px;height:18px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                {{-- Page breadcrumb / title slot --}}
                <div class="min-w-0">
                    @yield('breadcrumb')
                </div>

            </div>

            {{-- RIGHT: action icons --}}
            <div class="flex items-center gap-1.5 flex-shrink-0">

                {{-- Dark mode toggle --}}
                <button
                    class="header-btn"
                    @click="
                        let next = $store.adm.dark === 'light' ? 'dark' : 'light';
                        $store.adm.setDark(next);
                    "
                    :title="$store.adm.dark === 'dark' ? 'Switch to light mode' : 'Switch to dark mode'"
                    aria-label="Toggle dark mode"
                >
                    {{-- Sun icon (shown in dark mode) --}}
                    <svg x-show="$store.adm.dark === 'dark'"
                         style="width:18px;height:18px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                    </svg>
                    {{-- Moon icon (shown in light mode) --}}
                    <svg x-show="$store.adm.dark !== 'dark'"
                         style="width:18px;height:18px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                </button>

                {{-- View website --}}
                <a href="{{ route('home') }}" target="_blank"
                   class="header-btn"
                   title="View live website"
                   aria-label="View website">
                    <svg style="width:18px;height:18px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>

                {{-- Theme customizer toggle --}}
                <button
                    class="header-btn"
                    @click="$store.adm.openCustomizer()"
                    title="Customize theme"
                    aria-label="Open theme customizer"
                >
                    <svg style="width:18px;height:18px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                    </svg>
                </button>

                {{-- Divider --}}
                <div style="width:1px;height:24px;background:var(--border);margin:0 .25rem"></div>

                {{-- User dropdown --}}
                <div class="relative" x-data="{ open: false }" @keydown.escape.window="open = false">

                    <button
                        @click="open = !open"
                        class="flex items-center gap-2 px-2 py-1.5 rounded-lg hover:bg-[var(--surface2)] transition-colors duration-200"
                        :aria-expanded="open"
                        aria-haspopup="true"
                    >
                        <div class="a-avatar" style="width:30px;height:30px;font-size:.8125rem">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <span class="hidden sm:block text-sm font-medium" style="color:var(--text);max-width:120px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                            {{ Auth::user()->name ?? 'Admin' }}
                        </span>
                        <svg style="width:14px;height:14px;color:var(--textM)" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    {{-- Dropdown menu --}}
                    <div
                        x-show="open"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        @click.outside="open = false"
                        class="a-dropdown"
                        style="display:none;min-width:200px"
                        role="menu"
                    >
                        {{-- User info header --}}
                        <div style="padding:.75rem 1rem .625rem;border-bottom:1px solid var(--border)">
                            <div style="font-size:.875rem;font-weight:600;color:var(--text)">
                                {{ Auth::user()->name ?? 'Admin' }}
                            </div>
                            <div style="font-size:.75rem;color:var(--textM);margin-top:.125rem">
                                {{ Auth::user()->email ?? '' }}
                            </div>
                        </div>

                        <a href="{{ route('profile.edit') }}" class="a-dropdown-item" role="menuitem">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Profile
                        </a>

                        <a href="{{ route('home') }}" target="_blank" class="a-dropdown-item" role="menuitem">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h.5A2.5 2.5 0 0022 5.5v-1.565M15 3.935V5.5A2.5 2.5 0 0012.5 8"/>
                            </svg>
                            View Website
                        </a>

                        <div class="a-dropdown-sep"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="a-dropdown-item" style="color:#e11d48" role="menuitem">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:#e11d48" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Sign Out
                            </button>
                        </form>

                    </div>
                </div>

            </div>
        </header>

        {{-- ============================================================
             PAGE CONTENT
        ============================================================= --}}
        <main class="admin-content" id="admin-content">
            @yield('content')
        </main>

        {{-- ============================================================
             FOOTER
        ============================================================= --}}
        <footer style="padding:.875rem 1.75rem;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap">
            <span style="font-size:.75rem;color:var(--textM)">
                &copy; {{ date('Y') }} Kushal.dev — Admin Panel
            </span>
            <span style="font-size:.75rem;color:var(--textL)">
                Laravel {{ app()->version() }}
            </span>
        </footer>

    </div>{{-- /admin-main --}}

    {{-- ===============================================================
         CUSTOMIZER BACKDROP
    ================================================================ --}}
    <div
        x-show="$store.adm.customizerOpen"
        @click="$store.adm.closeCustomizer()"
        style="position:fixed;inset:0;background:rgba(0,0,0,.25);z-index:54;backdrop-filter:blur(3px);display:none"
        x-transition:enter="transition-opacity duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    ></div>

    {{-- ===============================================================
         THEME CUSTOMIZER PANEL
    ================================================================ --}}
    <aside
        class="customizer-panel"
        :class="{ 'is-open': $store.adm.customizerOpen }"
        aria-label="Theme customizer"
        role="complementary"
    >
        {{-- Header --}}
        <div class="customizer-head">
            <div>
                <div class="customizer-title">Theme Customizer</div>
                <div style="font-size:.75rem;color:var(--textM);margin-top:.125rem">Personalize your panel</div>
            </div>
            <button
                @click="$store.adm.closeCustomizer()"
                class="header-btn"
                aria-label="Close customizer"
            >
                <svg style="width:18px;height:18px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="customizer-body">

            {{-- ---- ACCENT COLOR ---- --}}
            <div class="customizer-section">
                <span class="c-label">Accent Color</span>
                <div class="theme-dots">
                    <template x-for="t in $store.adm.themes" :key="t.id">
                        <div class="theme-dot-wrap" @click="$store.adm.setTheme(t.id)">
                            <div
                                class="theme-dot"
                                :class="{ 'is-active': $store.adm.theme === t.id }"
                                :style="'background:' + t.color"
                            ></div>
                            <span class="theme-dot-name" x-text="t.label"></span>
                        </div>
                    </template>
                </div>
            </div>

            {{-- ---- APPEARANCE ---- --}}
            <div class="customizer-section">
                <span class="c-label">Appearance</span>
                <div class="mode-options">
                    {{-- Light --}}
                    <div class="mode-opt" :class="{ 'is-active': $store.adm.dark === 'light' }" @click="$store.adm.setDark('light')">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                        </svg>
                        Light
                    </div>
                    {{-- Dark --}}
                    <div class="mode-opt" :class="{ 'is-active': $store.adm.dark === 'dark' }" @click="$store.adm.setDark('dark')">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                        Dark
                    </div>
                    {{-- System --}}
                    <div class="mode-opt" :class="{ 'is-active': $store.adm.dark === 'system' }" @click="$store.adm.setDark('system')">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        System
                    </div>
                </div>
            </div>

            {{-- ---- BORDER RADIUS ---- --}}
            <div class="customizer-section">
                <span class="c-label">Component Shape</span>
                <div class="c-opt-row">
                    <div class="c-opt" :class="{ 'is-active': $store.adm.radius === 'rounded' }" @click="$store.adm.setRadius('rounded')">
                        Rounded
                    </div>
                    <div class="c-opt" :class="{ 'is-active': $store.adm.radius === 'square' }" @click="$store.adm.setRadius('square')">
                        Square
                    </div>
                </div>
            </div>

            {{-- ---- DENSITY ---- --}}
            <div class="customizer-section">
                <span class="c-label">Layout Density</span>
                <div class="c-opt-row">
                    <div class="c-opt" :class="{ 'is-active': $store.adm.density === 'normal' }" @click="$store.adm.setDensity('normal')">
                        Normal
                    </div>
                    <div class="c-opt" :class="{ 'is-active': $store.adm.density === 'compact' }" @click="$store.adm.setDensity('compact')">
                        Compact
                    </div>
                </div>
            </div>

            {{-- ---- SIDEBAR ---- --}}
            <div class="customizer-section">
                <span class="c-label">Sidebar</span>
                <div class="c-opt-row">
                    <div class="c-opt hidden lg:flex" :class="{ 'is-active': !$store.adm.sidebarCollapsed }" @click="$store.adm.sidebarCollapsed && $store.adm.toggleSidebar()">
                        Expanded
                    </div>
                    <div class="c-opt hidden lg:flex" :class="{ 'is-active': $store.adm.sidebarCollapsed }" @click="!$store.adm.sidebarCollapsed && $store.adm.toggleSidebar()">
                        Collapsed
                    </div>
                    <div class="c-opt lg:hidden" style="pointer-events:none;opacity:.5">
                        Mobile view
                    </div>
                </div>
            </div>

            {{-- ---- ANIMATIONS ---- --}}
            <div class="customizer-section">
                <div class="c-toggle">
                    <div>
                        <div class="c-toggle-label">Animations</div>
                        <div class="c-toggle-hint">Transitions & micro-interactions</div>
                    </div>
                    <div
                        class="toggle-pill"
                        :class="{ 'on': $store.adm.anim }"
                        @click="$store.adm.toggleAnim()"
                        role="switch"
                        :aria-checked="$store.adm.anim"
                        tabindex="0"
                        @keydown.enter="$store.adm.toggleAnim()"
                        @keydown.space.prevent="$store.adm.toggleAnim()"
                    ></div>
                </div>
            </div>

            {{-- ---- CURRENT THEME INFO ---- --}}
            <div class="customizer-section">
                <span class="c-label">Active Settings</span>
                <div style="background:var(--surface2);border:1px solid var(--border);border-radius:var(--r-sm);padding:.75rem;font-size:.8125rem;color:var(--textM);line-height:1.7">
                    <div>Theme: <strong style="color:var(--text)" x-text="$store.adm.themes.find(t=>t.id===$store.adm.theme)?.label || $store.adm.theme"></strong></div>
                    <div>Mode: <strong style="color:var(--text)" x-text="$store.adm.dark.charAt(0).toUpperCase() + $store.adm.dark.slice(1)"></strong></div>
                    <div>Shape: <strong style="color:var(--text)" x-text="$store.adm.radius.charAt(0).toUpperCase() + $store.adm.radius.slice(1)"></strong></div>
                    <div>Density: <strong style="color:var(--text)" x-text="$store.adm.density.charAt(0).toUpperCase() + $store.adm.density.slice(1)"></strong></div>
                </div>
            </div>

        </div>{{-- /customizer-body --}}

        {{-- Footer: Reset --}}
        <div class="customizer-footer">
            <button
                @click="$store.adm.reset()"
                class="a-btn a-btn-ghost"
                style="width:100%;justify-content:center;gap:.5rem"
            >
                <svg style="width:16px;height:16px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Reset to Defaults
            </button>
        </div>

    </aside>{{-- /customizer-panel --}}

</body>
</html>
