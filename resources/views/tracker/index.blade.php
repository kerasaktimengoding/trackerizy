<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Trackerizy — Smart Habit Tracker</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/settings_drawer.css">
    <style>
        :root {
            --bg-color: #0b0f19;
            --card-bg: rgba(22, 30, 49, 0.75);
            --card-border: rgba(255, 255, 255, 0.08);
            --primary: #6366f1;
            --primary-glow: rgba(99, 102, 241, 0.35);
            --success: #10b981;
            --success-glow: rgba(16, 185, 129, 0.3);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --accent: #ec4899;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            background-color: var(--bg-color);
            background-image: 
                radial-gradient(circle at 15% 15%, rgba(99, 102, 241, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 85% 85%, rgba(236, 72, 153, 0.12) 0%, transparent 40%),
                radial-gradient(circle at 50% 50%, rgba(16, 185, 129, 0.08) 0%, transparent 50%);
            background-attachment: fixed;
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            padding: 24px 16px 110px 16px;
        }

        .container {
            width: 100%;
            max-width: 680px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Top Bar */
        .top-nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 18px;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            backdrop-filter: blur(16px);
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
            font-size: 1.15rem;
            letter-spacing: -0.5px;
            color: #fff;
            text-decoration: none;
        }

        .brand-badge {
            background: linear-gradient(135deg, #6366f1, #ec4899);
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px var(--primary-glow);
            font-size: 1.1rem;
        }

        .admin-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #fff;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .admin-link:hover {
            background: rgba(99, 102, 241, 0.25);
            border-color: rgba(99, 102, 241, 0.4);
            transform: translateY(-1px);
        }

        /* Hero Progress Card */
        .progress-card {
            background: linear-gradient(145deg, rgba(30, 41, 69, 0.85), rgba(17, 24, 39, 0.95));
            border: 1px solid var(--card-border);
            border-radius: 24px;
            padding: 24px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(12px);
        }

        .progress-card::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 140px;
            height: 140px;
            background: radial-gradient(circle, var(--primary-glow), transparent 70%);
            pointer-events: none;
        }

        .date-title {
            font-size: 0.9rem;
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 6px;
        }

        .greeting {
            font-size: 1.65rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 18px;
        }

        .progress-stats-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 10px;
        }

        .stats-count {
            font-size: 0.95rem;
            color: var(--text-muted);
        }

        .stats-count strong {
            color: #fff;
            font-size: 1.2rem;
        }

        .stats-percent {
            font-size: 1.5rem;
            font-weight: 800;
            color: #38bdf8;
        }

        .progress-bar-bg {
            width: 100%;
            height: 12px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 999px;
            overflow: hidden;
            position: relative;
        }

        .progress-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, #38bdf8, #6366f1, #10b981);
            border-radius: 999px;
            transition: width 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 0 12px rgba(56, 189, 248, 0.5);
        }

        /* Calendar Week Strip */
        .calendar-strip {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            padding-bottom: 4px;
        }

        .calendar-strip::-webkit-scrollbar {
            display: none;
        }

        .day-chip {
            flex: 1;
            min-width: 58px;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            padding: 12px 6px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            text-decoration: none;
            color: var(--text-muted);
            transition: all 0.2s ease;
        }

        .day-chip:hover {
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .day-chip.active {
            background: linear-gradient(145deg, rgba(99, 102, 241, 0.35), rgba(99, 102, 241, 0.15));
            border-color: #6366f1;
            color: #fff;
            box-shadow: 0 4px 16px rgba(99, 102, 241, 0.25);
        }

        .day-chip .day-name {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .day-chip .day-number {
            font-size: 1.15rem;
            font-weight: 700;
            color: #fff;
        }

        .day-chip.today .day-number {
            color: #38bdf8;
        }

        /* Habit List */
        .habit-list-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 6px;
        }

        .habit-list-title {
            font-size: 1.15rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .habit-items {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .habit-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(12px);
            position: relative;
            overflow: hidden;
        }

        .habit-card:hover {
            border-color: rgba(255, 255, 255, 0.18);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -10px rgba(0, 0, 0, 0.4);
        }

        .habit-card.completed {
            background: rgba(16, 185, 129, 0.08);
            border-color: rgba(16, 185, 129, 0.35);
        }

        .habit-info-group {
            display: flex;
            align-items: center;
            gap: 16px;
            flex: 1;
        }

        .habit-icon-box {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.08);
            flex-shrink: 0;
            transition: transform 0.2s;
        }

        .habit-card.completed .habit-icon-box {
            transform: scale(1.05);
        }

        .habit-texts {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .habit-name {
            font-size: 1.05rem;
            font-weight: 700;
            color: #fff;
            transition: color 0.2s;
        }

        .habit-card.completed .habit-name {
            text-decoration: line-through;
            color: var(--text-muted);
        }

        .habit-desc {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .habit-meta-badges {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 4px;
        }

        .streak-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: rgba(245, 158, 11, 0.15);
            border: 1px solid rgba(245, 158, 11, 0.3);
            color: #fbbf24;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 8px;
        }

        /* Checkbox Action */
        .check-btn {
            background: transparent;
            border: 2px solid rgba(255, 255, 255, 0.2);
            width: 38px;
            height: 38px;
            border-radius: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.25s ease;
            color: transparent;
            flex-shrink: 0;
        }

        .check-btn:hover {
            border-color: var(--primary);
            transform: scale(1.08);
        }

        .habit-card.completed .check-btn {
            background: var(--success);
            border-color: var(--success);
            color: #fff;
            box-shadow: 0 0 16px var(--success-glow);
        }

        .check-btn svg {
            width: 20px;
            height: 20px;
            stroke-width: 3;
            transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .habit-card.completed .check-btn svg {
            transform: scale(1);
        }

        /* Empty State */
        .empty-state {
            background: var(--card-bg);
            border: 1px dashed var(--card-border);
            border-radius: 20px;
            padding: 40px 20px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
        }

        .empty-state-icon {
            font-size: 2.5rem;
        }

        .empty-state p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .btn-add-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: #fff;
            padding: 10px 20px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            box-shadow: 0 4px 15px var(--primary-glow);
            transition: all 0.2s ease;
            font-size: 0.9rem;
        }

        .btn-add-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px var(--primary-glow);
        }

        .btn-settings-trigger {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #fff;
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-settings-trigger:hover {
            background: rgba(99, 102, 241, 0.3);
            border-color: #6366f1;
            transform: scale(1.05);
        }

        /* ===== Responsive Bottom Navigation Bar ===== */
        .bottom-nav-wrapper {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 999;
            display: flex;
            justify-content: center;
            pointer-events: none; /* agar klik di samping tidak terhalang */
            padding: 0 16px;
        }

        .bottom-nav {
            pointer-events: auto;
            width: 100%;
            max-width: 520px;
            background: rgba(15, 23, 42, 0.88);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.12);
            display: flex;
            align-items: center;
            justify-content: space-around;
            padding: 8px 12px;
            box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.7), 0 0 20px rgba(99, 102, 241, 0.15);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Desktop & Tablet: Floating Pill */
        @media (min-width: 640px) {
            .bottom-nav-wrapper {
                bottom: 24px;
            }
            .bottom-nav {
                border-radius: 999px;
                padding: 8px 24px;
            }
        }

        /* Mobile Version: Full Width Bottom Dock */
        @media (max-width: 639px) {
            .bottom-nav-wrapper {
                padding: 0;
                bottom: 0;
            }
            .bottom-nav {
                max-width: 100%;
                border-radius: 24px 24px 0 0;
                border-bottom: none;
                padding: 10px 14px calc(10px + env(safe-area-inset-bottom, 8px)) 14px;
            }
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
            text-decoration: none;
            color: var(--text-muted);
            font-size: 0.72rem;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 14px;
            transition: all 0.2s ease;
            position: relative;
            cursor: pointer;
            border: none;
            background: transparent;
        }

        .nav-item svg {
            width: 22px;
            height: 22px;
            transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .nav-item:hover {
            color: #fff;
        }

        .nav-item:hover svg {
            transform: translateY(-2px);
        }

        .nav-item.active {
            color: #38bdf8;
        }

        .nav-item.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            width: 14px;
            height: 3px;
            background: #38bdf8;
            border-radius: 999px;
            box-shadow: 0 0 8px #38bdf8;
        }

        /* Center Floating Action Button (FAB) */
        .nav-fab-container {
            position: relative;
            top: -14px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .nav-fab {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1 0%, #ec4899 100%);
            border: 3px solid #0f172a;
            box-shadow: 0 6px 20px rgba(236, 72, 153, 0.45);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .nav-fab svg {
            width: 24px;
            height: 24px;
            stroke-width: 2.5;
            transition: transform 0.25s ease;
        }

        .nav-fab:hover {
            transform: scale(1.12) rotate(90deg);
            box-shadow: 0 8px 25px rgba(236, 72, 153, 0.65);
        }

        .nav-fab-label {
            font-size: 0.68rem;
            font-weight: 700;
            color: #fff;
            margin-top: 2px;
        }

        /* Stats Modal */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(8px);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-overlay.open {
            display: flex;
        }

        .modal-box {
            background: #131b2e;
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 24px;
            max-width: 440px;
            width: 100%;
            padding: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.8);
            animation: modalPop 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes modalPop {
            0% { transform: scale(0.92); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }

        .modal-title {
            font-size: 1.15rem;
            font-weight: 800;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .modal-close {
            background: rgba(255, 255, 255, 0.08);
            border: none;
            color: #fff;
            width: 32px;
            height: 32px;
            border-radius: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .stats-grid-modal {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 20px;
        }

        .stat-card-mini {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 16px;
            padding: 14px;
            text-align: center;
        }

        .stat-card-mini .val {
            font-size: 1.5rem;
            font-weight: 800;
            color: #38bdf8;
            margin-bottom: 4px;
        }

        .stat-card-mini .lbl {
            font-size: 0.78rem;
            color: var(--text-muted);
            font-weight: 600;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Top Nav -->
        <header class="top-nav">
            <div style="display: flex; align-items: center; gap: 12px;">
                <!-- Tombol Navigasi Kiri: Settings & Lifestyle Hub -->
                <button type="button" class="btn-settings-trigger" onclick="openSettingsDrawer()" title="Settings & Lifestyle Hub" aria-label="Buka Pengaturan">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </button>

                <a href="/" class="brand-logo">
                    <span class="brand-badge">✨</span>
                    <span>Trackerizy</span>
                </a>
            </div>

            <div style="display: flex; align-items: center; gap: 8px;">
                <button type="button" class="btn-outline-sm" onclick="openWallpaperModal()" title="Ubah Wallpaper" style="padding: 6px 12px; font-size: 0.8rem; border-radius: 12px;">
                    🖼️ Wallpaper
                </button>

                <a href="/admin" class="admin-link">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>Kelola</span>
                </a>
            </div>
        </header>

        <!-- Progress Card -->
        <section class="progress-card">
            <div class="date-title">
                {{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}
            </div>
            <h1 class="greeting">
                @if($progressPercent == 100 && $totalHabits > 0)
                    Luar Biasa! Semua Selesai 🎉
                @elseif($progressPercent >= 50)
                    Terus Semangat, Hampir Tuntas! ⚡
                @else
                    Mulai Kebiasaan Baikmu Hari Ini ✨
                @endif
            </h1>

            <div class="progress-stats-row">
                <div class="stats-count">
                    <strong id="completed-count">{{ $completedHabits }}</strong> dari {{ $totalHabits }} habit tercapai
                </div>
                <div class="stats-percent" id="progress-percent">
                    {{ $progressPercent }}%
                </div>
            </div>

            <div class="progress-bar-bg">
                <div class="progress-bar-fill" id="progress-bar-fill" style="width: {{ $progressPercent }}%;"></div>
            </div>
        </section>

        <!-- Calendar 7 Days -->
        <nav class="calendar-strip">
            @foreach($weekDays as $day)
                <a href="/?date={{ $day['date'] }}" class="day-chip {{ $day['is_selected'] ? 'active' : '' }} {{ $day['is_today'] ? 'today' : '' }}">
                    <span class="day-name">{{ $day['day_name'] }}</span>
                    <span class="day-number">{{ $day['day_num'] }}</span>
                </a>
            @endforeach
        </nav>

        <!-- Habit List -->
        <section class="habit-items">
            <div class="habit-list-header">
                <div class="habit-list-title">
                    <span>🎯</span>
                    <span>Target Hari Ini</span>
                </div>
                <a href="/admin/habits" class="admin-link" style="padding: 4px 10px; font-size: 0.8rem;">
                    + Tambah Habit
                </a>
            </div>

            @forelse($habits as $habit)
                <div class="habit-card {{ $habit->is_completed_on_date ? 'completed' : '' }}" id="habit-card-{{ $habit->id }}">
                    <div class="habit-info-group">
                        <div class="habit-icon-box" style="box-shadow: 0 4px 14px {{ $habit->color }}33;">
                            {{ $habit->icon }}
                        </div>
                        <div class="habit-texts">
                            <span class="habit-name">{{ $habit->name }}</span>
                            @if($habit->description)
                                <span class="habit-desc">{{ $habit->description }}</span>
                            @endif
                            <div class="habit-meta-badges">
                                <span class="streak-badge" id="streak-badge-{{ $habit->id }}">
                                    🔥 {{ $habit->current_streak }} hari beruntun
                                </span>
                            </div>
                        </div>
                    </div>

                    <form action="/habits/{{ $habit->id }}/toggle" method="POST" onsubmit="handleToggle(event, {{ $habit->id }})">
                        @csrf
                        <input type="hidden" name="date" value="{{ $date->toDateString() }}">
                        <button type="submit" class="check-btn" title="Tandai selesai">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </button>
                    </form>
                </div>
            @empty
                <div class="empty-state">
                    <span class="empty-state-icon">🌱</span>
                    <h3>Belum ada Habit Aktif</h3>
                    <p>Mulai bangun kebiasaan produktif Anda sekarang!</p>
                    <a href="/admin/habits" class="btn-add-primary">
                        Buat Habit Pertama di Filament
                    </a>
                </div>
            @endforelse
        </section>
    </div>

    <!-- ===== Bottom Navigation Bar (Responsive Mobile to Desktop) ===== -->
    <div class="bottom-nav-wrapper">
        <nav class="bottom-nav" aria-label="Navigasi Bawah">
            <!-- 1. Hari Ini -->
            <a href="/?date={{ now()->toDateString() }}" class="nav-item {{ request('date') == now()->toDateString() || !request('date') ? 'active' : '' }}" title="Hari Ini">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span>Hari Ini</span>
            </a>

            <!-- 2. Riwayat / Kalender -->
            <a href="/calendar" class="nav-item {{ request()->is('calendar*') ? 'active' : '' }}" title="Kalender & Analitik">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>Kalender</span>
            </a>

            <!-- 3. Floating Action Button (Tambah Cepat di Tengah) -->
            <div class="nav-fab-container">
                <a href="/admin/habits/create" class="nav-fab" title="Tambah Kebiasaan Baru">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                </a>
                <span class="nav-fab-label">Tambah</span>
            </div>

            <!-- 4. Statistik Ringkas -->
            <button type="button" class="nav-item" onclick="openStatsModal()" title="Statistik">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                <span>Statistik</span>
            </button>

            <!-- 5. Filament Admin Panel -->
            <a href="/admin" class="nav-item" title="Panel Admin Filament">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Kelola</span>
            </a>
        </nav>
    </div>

    <!-- Modal Ringkasan Statistik -->
    <div class="modal-overlay" id="stats-modal" onclick="closeStatsModal(event)">
        <div class="modal-box" onclick="event.stopPropagation()">
            <div class="modal-header">
                <div class="modal-title">
                    <span>📊</span>
                    <span>Ringkasan Performa</span>
                </div>
                <button type="button" class="modal-close" onclick="closeStatsModal()">✕</button>
            </div>

            <div class="stats-grid-modal">
                <div class="stat-card-mini">
                    <div class="val">{{ $totalHabits }}</div>
                    <div class="lbl">Total Kebiasaan Aktif</div>
                </div>
                <div class="stat-card-mini">
                    <div class="val">{{ $completedHabits }}/{{ $totalHabits }}</div>
                    <div class="lbl">Tuntas Hari Ini</div>
                </div>
                <div class="stat-card-mini">
                    <div class="val">{{ $progressPercent }}%</div>
                    <div class="lbl">Tingkat Keberhasilan</div>
                </div>
                <div class="stat-card-mini">
                    @php
                        $maxStreak = $habits->max('current_streak') ?? 0;
                    @endphp
                    <div class="val" style="color: #fbbf24;">🔥 {{ $maxStreak }}</div>
                    <div class="lbl">Streak Tertinggi</div>
                </div>
            </div>

            <a href="/admin/habits" class="btn-add-primary" style="width: 100%; justify-content: center;">
                Buka Detail Lengkap di Filament
            </a>
        </div>
    </div>

    <script>
        function openStatsModal() {
            document.getElementById('stats-modal').classList.add('open');
        }

        function closeStatsModal(event) {
            document.getElementById('stats-modal').classList.remove('open');
        }

        function scrollToCalendar() {
            const el = document.querySelector('.calendar-strip');
            if (el) {
                el.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }

        async function handleToggle(event, habitId) {
            event.preventDefault();
            const form = event.currentTarget;
            const card = document.getElementById(`habit-card-${habitId}`);
            const dateInput = form.querySelector('input[name="date"]').value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ date: dateInput })
                });

                if (response.ok) {
                    const data = await response.json();
                    
                    if (data.completed) {
                        card.classList.add('completed');
                    } else {
                        card.classList.remove('completed');
                    }

                    // Update streak badge
                    const streakBadge = document.getElementById(`streak-badge-${habitId}`);
                    if (streakBadge) {
                        streakBadge.innerHTML = `🔥 ${data.streak} hari beruntun`;
                    }

                    // Recalculate progress count and bar
                    const allCards = document.querySelectorAll('.habit-card');
                    const completedCards = document.querySelectorAll('.habit-card.completed');
                    const total = allCards.length;
                    const completed = completedCards.length;
                    const percent = total > 0 ? Math.round((completed / total) * 100) : 0;

                    document.getElementById('completed-count').textContent = completed;
                    document.getElementById('progress-percent').textContent = `${percent}%`;
                    document.getElementById('progress-bar-fill').style.width = `${percent}%`;
                }
            } catch (err) {
                console.error(err);
                form.submit();
            }
        }
    </script>

    @include('tracker.partials.settings_drawer')
    <script src="/js/settings_drawer.js"></script>
</body>
</html>
