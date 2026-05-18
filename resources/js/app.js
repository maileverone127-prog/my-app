import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

/* =====================================================================
   ANTI-FOUC: Apply stored theme/dark settings BEFORE Alpine starts
   so the page never flashes with the wrong colors.
   ===================================================================== */
(function applyStoredTheme() {
    const theme = localStorage.getItem('adm_theme') || 'blue';
    const dark  = localStorage.getItem('adm_dark')  || 'light';
    const radius  = localStorage.getItem('adm_radius');
    const density = localStorage.getItem('adm_density');
    const anim    = localStorage.getItem('adm_anim');
    const html    = document.documentElement;

    html.setAttribute('data-theme', theme);

    if (dark === 'dark') {
        html.classList.add('dark');
    } else if (dark === 'system') {
        if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
            html.classList.add('dark');
        }
    }

    if (radius  === 'square')  html.setAttribute('data-radius',  'square');
    if (density === 'compact') html.setAttribute('data-density', 'compact');
    if (anim    === 'off')     html.setAttribute('data-animations', 'off');
})();

/* =====================================================================
   ALPINE STORE — admin theme & layout state
   ===================================================================== */
Alpine.store('adm', {

    /* ---- persisted state ---- */
    theme:     localStorage.getItem('adm_theme')   || 'blue',
    dark:      localStorage.getItem('adm_dark')    || 'light',
    radius:    localStorage.getItem('adm_radius')  || 'rounded',
    density:   localStorage.getItem('adm_density') || 'normal',
    anim:      localStorage.getItem('adm_anim')    !== 'off',

    /* ---- session-only UI state ---- */
    sidebarCollapsed: localStorage.getItem('adm_sb_col') === 'true',
    customizerOpen:   false,
    mobileMenuOpen:   false,
    userDdOpen:       false,

    /* --- available themes metadata --- */
    themes: [
        { id: 'blue',   label: 'Blue',    color: '#6366f1' },
        { id: 'green',  label: 'Green',   color: '#10b981' },
        { id: 'red',    label: 'Red',     color: '#f43f5e' },
        { id: 'purple', label: 'Purple',  color: '#a855f7' },
        { id: 'dark',   label: 'Dark',    color: '#8b5cf6' },
        { id: 'orange', label: 'Orange',  color: '#f97316' },
        { id: 'glass',  label: 'Glass',   color: '#06b6d4' },
        { id: 'white',  label: 'Minimal', color: '#475569' },
    ],

    /* ----------------------------------------------------------------
       INIT — runs once when store is used
    ---------------------------------------------------------------- */
    init() {
        /* Watch system preference changes */
        window.matchMedia('(prefers-color-scheme: dark)')
            .addEventListener('change', (e) => {
                if (this.dark === 'system') {
                    this._toggleDark(e.matches);
                }
            });
    },

    /* ----------------------------------------------------------------
       THEME COLOR
    ---------------------------------------------------------------- */
    setTheme(id) {
        this.theme = id;
        localStorage.setItem('adm_theme', id);
        this._animate(() => {
            document.documentElement.setAttribute('data-theme', id);
        });
    },

    /* ----------------------------------------------------------------
       DARK / LIGHT / SYSTEM
    ---------------------------------------------------------------- */
    setDark(mode) {
        this.dark = mode;
        localStorage.setItem('adm_dark', mode);
        this._animate(() => {
            if (mode === 'dark') {
                this._toggleDark(true);
            } else if (mode === 'light') {
                this._toggleDark(false);
            } else {
                const sys = window.matchMedia('(prefers-color-scheme: dark)').matches;
                this._toggleDark(sys);
            }
        });
    },

    _toggleDark(on) {
        document.documentElement.classList.toggle('dark', on);
    },

    /* ----------------------------------------------------------------
       SIDEBAR
    ---------------------------------------------------------------- */
    toggleSidebar() {
        this.sidebarCollapsed = !this.sidebarCollapsed;
        localStorage.setItem('adm_sb_col', this.sidebarCollapsed);
    },

    toggleMobileMenu() {
        this.mobileMenuOpen = !this.mobileMenuOpen;
    },

    closeMobileMenu() {
        this.mobileMenuOpen = false;
    },

    /* ----------------------------------------------------------------
       BORDER RADIUS
    ---------------------------------------------------------------- */
    setRadius(r) {
        this.radius = r;
        localStorage.setItem('adm_radius', r);
        document.documentElement.setAttribute('data-radius', r === 'square' ? 'square' : 'rounded');
    },

    /* ----------------------------------------------------------------
       DENSITY
    ---------------------------------------------------------------- */
    setDensity(d) {
        this.density = d;
        localStorage.setItem('adm_density', d);
        document.documentElement.setAttribute('data-density', d === 'compact' ? 'compact' : 'normal');
    },

    /* ----------------------------------------------------------------
       ANIMATIONS
    ---------------------------------------------------------------- */
    toggleAnim() {
        this.anim = !this.anim;
        const val = this.anim ? 'on' : 'off';
        localStorage.setItem('adm_anim', val);
        document.documentElement.setAttribute('data-animations', val);
    },

    /* ----------------------------------------------------------------
       CUSTOMIZER PANEL
    ---------------------------------------------------------------- */
    openCustomizer() {
        this.customizerOpen = true;
    },

    closeCustomizer() {
        this.customizerOpen = false;
    },

    /* ----------------------------------------------------------------
       RESET TO DEFAULTS
    ---------------------------------------------------------------- */
    reset() {
        this.theme   = 'blue';
        this.dark    = 'light';
        this.radius  = 'rounded';
        this.density = 'normal';
        this.anim    = true;
        this.sidebarCollapsed = false;

        const keys = ['adm_theme','adm_dark','adm_radius','adm_density','adm_anim','adm_sb_col'];
        keys.forEach(k => localStorage.removeItem(k));

        this._animate(() => {
            const html = document.documentElement;
            html.setAttribute('data-theme', 'blue');
            html.classList.remove('dark');
            html.setAttribute('data-radius', 'rounded');
            html.setAttribute('data-density', 'normal');
            html.setAttribute('data-animations', 'on');
        });
    },

    /* ----------------------------------------------------------------
       HELPER — smooth theme-change transition
    ---------------------------------------------------------------- */
    _animate(fn) {
        const html = document.documentElement;
        html.classList.add('theme-transition');
        fn();
        setTimeout(() => html.classList.remove('theme-transition'), 350);
    },

});

Alpine.start();
