<style>
    :root {
        --bg-body: #0f172a;
        --bg-card: rgba(30, 41, 59, 0.8);
        --bg-input: rgba(15, 23, 42, 0.6);
        --bg-nav: rgba(15, 23, 42, 0.95);
        --bg-hover: rgba(148, 163, 184, 0.1);
        --bg-header: rgba(30, 41, 59, 0.8);
        --bg-table-head: rgba(15, 23, 42, 0.5);
        --bg-gradient-cover: linear-gradient(135deg, #1e293b, #334155);

        --text-primary: #f8fafc;
        --text-secondary: #e2e8f0;
        --text-muted: #cbd5e1;
        --text-dimmed: #94a3b8;

        --border-main: rgba(148, 163, 184, 0.1);
        --border-input: rgba(148, 163, 184, 0.15);

        --nav-active-bg: rgba(99, 102, 241, 0.2);
        --nav-active-text: #a5b4fc;

        --tag-indigo-bg: rgba(99, 102, 241, 0.15);
        --tag-indigo-text: #a5b4fc;
        --tag-violet-bg: rgba(139, 92, 246, 0.15);
        --tag-violet-text: #c4b5fd;
        --tag-green-bg: rgba(34, 197, 94, 0.15);
        --tag-green-text: #86efac;
        --tag-red-bg: rgba(239, 68, 68, 0.15);
        --tag-red-text: #fca5a5;
        --tag-yellow-bg: rgba(245, 158, 11, 0.15);
        --tag-yellow-text: #fcd34d;

        --alert-success-bg: rgba(34, 197, 94, 0.1);
        --alert-success-border: rgba(34, 197, 94, 0.2);
        --alert-success-text: #86efac;
        --alert-error-bg: rgba(239, 68, 68, 0.1);
        --alert-error-border: rgba(239, 68, 68, 0.2);
        --alert-error-text: #fca5a5;

        --btn-ghost-bg: rgba(148, 163, 184, 0.1);
        --btn-ghost-border: rgba(148, 163, 184, 0.1);
        --btn-ghost-text: #94a3b8;

        --placeholder-icon: rgba(148, 163, 184, 0.3);
        --empty-border: rgba(148, 163, 184, 0.2);

        --radial-1: rgba(99, 102, 241, 0.15);
        --radial-2: rgba(139, 92, 246, 0.15);

        --dropdown-bg: #1e293b;
        --dropdown-text: #cbd5e1;
        --dropdown-danger: #fca5a5;

        --shadow-sm: 0 1px 3px rgba(0,0,0,0.3), 0 1px 2px rgba(0,0,0,0.2);
        --shadow-md: 0 4px 6px rgba(0,0,0,0.3), 0 2px 4px rgba(0,0,0,0.2);
        --shadow-lg: 0 10px 25px rgba(0,0,0,0.4), 0 4px 10px rgba(0,0,0,0.2);
        --shadow-glow-indigo: 0 0 20px rgba(99,102,241,0.25);
        --shadow-glow-green: 0 0 20px rgba(16,185,129,0.25);
    }

    html.light-mode {
        --bg-body: #f1f5f9;
        --bg-card: rgba(255, 255, 255, 0.9);
        --bg-input: rgba(241, 245, 249, 0.9);
        --bg-nav: rgba(255, 255, 255, 0.95);
        --bg-hover: rgba(99, 102, 241, 0.05);
        --bg-header: rgba(255, 255, 255, 0.85);
        --bg-table-head: rgba(241, 245, 249, 0.8);
        --bg-gradient-cover: linear-gradient(135deg, #e2e8f0, #cbd5e1);

        --text-primary: #0f172a;
        --text-secondary: #334155;
        --text-muted: #64748b;
        --text-dimmed: #94a3b8;

        --border-main: rgba(148, 163, 184, 0.25);
        --border-input: rgba(148, 163, 184, 0.35);

        --nav-active-bg: rgba(99, 102, 241, 0.1);
        --nav-active-text: #4f46e5;

        --tag-indigo-bg: rgba(99, 102, 241, 0.1);
        --tag-indigo-text: #4f46e5;
        --tag-violet-bg: rgba(139, 92, 246, 0.1);
        --tag-violet-text: #7c3aed;
        --tag-green-bg: rgba(34, 197, 94, 0.1);
        --tag-green-text: #059669;
        --tag-red-bg: rgba(239, 68, 68, 0.1);
        --tag-red-text: #dc2626;
        --tag-yellow-bg: rgba(245, 158, 11, 0.1);
        --tag-yellow-text: #d97706;

        --alert-success-bg: rgba(34, 197, 94, 0.08);
        --alert-success-border: rgba(34, 197, 94, 0.2);
        --alert-success-text: #059669;
        --alert-error-bg: rgba(239, 68, 68, 0.08);
        --alert-error-border: rgba(239, 68, 68, 0.2);
        --alert-error-text: #dc2626;

        --btn-ghost-bg: rgba(148, 163, 184, 0.15);
        --btn-ghost-border: rgba(148, 163, 184, 0.2);
        --btn-ghost-text: #475569;

        --placeholder-icon: rgba(148, 163, 184, 0.4);
        --empty-border: rgba(148, 163, 184, 0.3);

        --radial-1: rgba(99, 102, 241, 0.08);
        --radial-2: rgba(139, 92, 246, 0.08);

        --dropdown-bg: #ffffff;
        --dropdown-text: #334155;
        --dropdown-danger: #dc2626;

        --shadow-sm: 0 1px 3px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.06);
        --shadow-md: 0 4px 6px rgba(0,0,0,0.07), 0 2px 4px rgba(0,0,0,0.05);
        --shadow-lg: 0 10px 25px rgba(0,0,0,0.1), 0 4px 10px rgba(0,0,0,0.06);
        --shadow-glow-indigo: 0 0 20px rgba(99,102,241,0.15);
        --shadow-glow-green: 0 0 20px rgba(16,185,129,0.15);
    }

    body {
        background: var(--bg-body) !important;
        font-family: 'Inter', sans-serif;
        transition: background 0.3s ease;
    }

    /* ===== ANIMATIONS ===== */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes pulseGlow {
        0%, 100% { box-shadow: 0 0 0 0 rgba(99,102,241,0.3); }
        50%       { box-shadow: 0 0 0 6px rgba(99,102,241,0); }
    }

    .animate-fade-in  { animation: fadeIn  0.4s ease both; }
    .animate-slide-up { animation: slideUp 0.5s ease both; }
    .stagger-1 { animation-delay: 0.05s; }
    .stagger-2 { animation-delay: 0.1s; }
    .stagger-3 { animation-delay: 0.15s; }
    .stagger-4 { animation-delay: 0.2s; }

    /* ===== SCROLLBAR ===== */
    ::-webkit-scrollbar { width: 6px; height: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: rgba(148,163,184,0.3); border-radius: 99px; }
    ::-webkit-scrollbar-thumb:hover { background: rgba(148,163,184,0.5); }

    /* ===== TABLE ROWS ===== */
    tbody tr { transition: background 0.15s ease; }
    tbody tr:hover { background: var(--bg-hover) !important; }

    /* ===== FORM INPUTS (global override) ===== */
    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="number"],
    input[type="date"],
    select,
    textarea {
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    input:focus, select:focus, textarea:focus {
        outline: none !important;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.2) !important;
        border-color: rgba(99,102,241,0.5) !important;
    }

    /* ===== BUTTONS ===== */
    button, a.btn { transition: all 0.2s ease; }

    /* ===== CARDS ===== */
    .card-hover {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .card-hover:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg) !important;
    }

    /* Theme toggle button */
    .theme-toggle {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: 1px solid var(--border-main);
        background: var(--bg-hover);
        color: var(--text-muted);
        transition: all 0.3s ease;
    }
    .theme-toggle:hover {
        background: var(--nav-active-bg);
        color: var(--nav-active-text);
    }
    .theme-toggle .icon-sun { display: none; }
    .theme-toggle .icon-moon { display: block; }
    html.light-mode .theme-toggle .icon-sun { display: block; }
    html.light-mode .theme-toggle .icon-moon { display: none; }
</style>

<script>
    // Apply theme immediately to prevent flash
    (function() {
        var theme = localStorage.getItem('perpus-theme');
        if (theme === 'light') {
            document.documentElement.classList.add('light-mode');
        }
    })();

    function toggleTheme() {
        var html = document.documentElement;
        html.classList.toggle('light-mode');
        var isLight = html.classList.contains('light-mode');
        localStorage.setItem('perpus-theme', isLight ? 'light' : 'dark');
    }
</script>
