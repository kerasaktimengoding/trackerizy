<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender & Analisis Habit — Trackerizy</title>
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
                radial-gradient(circle at 10% 20%, rgba(99, 102, 241, 0.14) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(236, 72, 153, 0.12) 0%, transparent 40%),
                radial-gradient(circle at 50% 50%, rgba(16, 185, 129, 0.08) 0%, transparent 50%);
            background-attachment: fixed;
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            padding: 24px 16px 120px 16px;
        }

        .container {
            width: 100%;
            max-width: 760px;
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

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #fff;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 700;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: #38bdf8;
        }

        .page-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 999px;
            background: rgba(99, 102, 241, 0.15);
            border: 1px solid rgba(99, 102, 241, 0.3);
            color: #a5b4fc;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Statistics KPI Grid (4 Metrics) */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
        }

        @media (max-width: 639px) {
            .kpi-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .kpi-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            padding: 16px 14px;
            display: flex;
            flex-direction: column;
            gap: 6px;
            backdrop-filter: blur(12px);
            transition: transform 0.2s;
            position: relative;
            overflow: hidden;
        }

        .kpi-card:hover {
            transform: translateY(-2px);
            border-color: rgba(255, 255, 255, 0.18);
        }

        .kpi-icon {
            font-size: 1.25rem;
        }

        .kpi-val {
            font-size: 1.45rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.1;
        }

        .kpi-label {
            font-size: 0.74rem;
            color: var(--text-muted);
            font-weight: 600;
        }

        /* Period Switcher (Mingguan, Bulanan, Tahunan) */
        .period-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .period-tabs {
            display: flex;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid var(--card-border);
            border-radius: 14px;
            padding: 4px;
            gap: 4px;
        }

        .period-tab {
            padding: 8px 18px;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-muted);
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .period-tab:hover {
            color: #fff;
        }

        .period-tab.active {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: #fff;
            box-shadow: 0 4px 12px var(--primary-glow);
        }

        .month-selector {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .month-nav-btn {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            color: #fff;
            width: 32px;
            height: 32px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.2s;
        }

        .month-nav-btn:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .current-month-label {
            font-size: 0.95rem;
            font-weight: 700;
            color: #fff;
            min-width: 140px;
            text-align: center;
        }

        /* ============================================================ */
        /* VIEW 1: BULANAN (Kalender Masing-Masing Habit dalam Sebulan) */
        /* ============================================================ */
        .monthly-habit-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 22px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            backdrop-filter: blur(12px);
            margin-bottom: 16px;
        }

        .habit-header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .habit-title-box {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .habit-badge-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .habit-heading {
            font-size: 1.05rem;
            font-weight: 700;
            color: #fff;
        }

        .habit-progress-pill {
            font-size: 0.8rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: #38bdf8;
        }

        /* Calendar Matrix Grid */
        .calendar-weekdays {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 6px;
            text-align: center;
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
        }

        .calendar-days-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 6px;
        }

        .calendar-day-cell {
            aspect-ratio: 1;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--text-muted);
            position: relative;
            transition: all 0.2s;
        }

        .calendar-day-cell.empty {
            background: transparent;
            border-color: transparent;
        }

        .calendar-day-cell.completed {
            color: #fff;
            font-weight: 800;
            border-color: transparent;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .calendar-day-cell.today-marker {
            box-shadow: inset 0 0 0 1.5px #38bdf8;
        }

        /* ============================================================ */
        /* VIEW 2: TAHUNAN (GitHub-Style Contribution Heatmap) */
        /* ============================================================ */
        .github-heatmap-container {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 24px;
            padding: 24px;
            backdrop-filter: blur(12px);
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .heatmap-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .heatmap-title {
            font-size: 1.1rem;
            font-weight: 800;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .heatmap-sub {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .heatmap-scroll-wrapper {
            overflow-x: auto;
            padding-bottom: 8px;
        }

        .heatmap-grid {
            display: grid;
            grid-template-rows: repeat(7, 13px);
            grid-auto-flow: column;
            grid-auto-columns: 13px;
            gap: 4px;
            width: max-content;
        }

        .heatmap-cell {
            width: 13px;
            height: 13px;
            border-radius: 3px;
            background: rgba(255, 255, 255, 0.05);
            transition: transform 0.15s, outline 0.15s;
            cursor: pointer;
            position: relative;
        }

        .heatmap-cell:hover {
            transform: scale(1.3);
            z-index: 10;
            outline: 1px solid #fff;
        }

        /* GitHub Contribution Intensity Colors */
        .heatmap-cell[data-level="0"] { background: rgba(255, 255, 255, 0.05); }
        .heatmap-cell[data-level="1"] { background: #0e4429; }
        .heatmap-cell[data-level="2"] { background: #006d32; }
        .heatmap-cell[data-level="3"] { background: #26a641; }
        .heatmap-cell[data-level="4"] { background: #39d353; box-shadow: 0 0 6px rgba(57, 211, 83, 0.6); }

        .heatmap-legend {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 6px;
            font-size: 0.72rem;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .legend-box {
            width: 11px;
            height: 11px;
            border-radius: 2px;
        }

        /* ============================================================ */
        /* VIEW 3: MINGGUAN (Weekly View) */
        /* ============================================================ */
        .weekly-container {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .weekly-day-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 18px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            backdrop-filter: blur(12px);
        }

        .weekly-day-card.today {
            border-color: rgba(56, 189, 248, 0.4);
            background: rgba(56, 189, 248, 0.05);
        }

        .weekly-day-info {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .weekly-date-badge {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.05);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-weight: 800;
        }

        .weekly-date-badge .day-name {
            font-size: 0.65rem;
            color: var(--text-muted);
            text-transform: uppercase;
        }

        .weekly-date-badge .day-num {
            font-size: 1.1rem;
            color: #fff;
            line-height: 1;
        }

        .weekly-habits-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .pill-habit {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.06);
            color: var(--text-muted);
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .pill-habit.done {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.3);
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
            pointer-events: none;
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
        }

        @media (min-width: 640px) {
            .bottom-nav-wrapper { bottom: 24px; }
            .bottom-nav { border-radius: 999px; padding: 8px 24px; }
        }

        @media (max-width: 639px) {
            .bottom-nav-wrapper { padding: 0; bottom: 0; }
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
        }

        .nav-item svg { width: 22px; height: 22px; }
        .nav-item:hover { color: #fff; }
        .nav-item.active { color: #38bdf8; }
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

        .nav-fab svg { width: 24px; height: 24px; stroke-width: 2.5; }
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
    </style>
</head>
<body>

    <div class="container">
        <!-- Top Nav -->
        <header class="top-nav">
            <div style="display: flex; align-items: center; gap: 10px;">
                <button type="button" class="btn-settings-trigger" onclick="openSettingsDrawer()" title="Settings & Lifestyle Hub" aria-label="Buka Pengaturan" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.12); color: #fff; width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </button>

                <a href="/" class="back-link">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span>Tracker Hari Ini</span>
                </a>
            </div>

            <div style="display: flex; align-items: center; gap: 8px;">
                <button type="button" class="btn-outline-sm" onclick="openWallpaperModal()" title="Ubah Wallpaper" style="padding: 5px 10px; font-size: 0.78rem; border-radius: 10px;">
                    🖼️ Wallpaper
                </button>
                <span class="page-badge">Analisis & Kalender</span>
            </div>
        </header>

        <!-- 4 KPI Metrics Card -->
        <section class="kpi-grid">
            <!-- 1. Persen Sukses -->
            <div class="kpi-card">
                <span class="kpi-icon">📈</span>
                <div class="kpi-val">{{ $percentSuccess }}%</div>
                <div class="kpi-label">Rasio Sukses</div>
            </div>

            <!-- 2. Best Day -->
            <div class="kpi-card">
                <span class="kpi-icon">🏆</span>
                <div class="kpi-val" style="font-size: 1.15rem; color: #38bdf8;">{{ $bestDay }}</div>
                <div class="kpi-label">Hari Paling Produktif</div>
            </div>

            <!-- 3. Total Done -->
            <div class="kpi-card">
                <span class="kpi-icon">✅</span>
                <div class="kpi-val" style="color: #34d399;">{{ $totalDone }}</div>
                <div class="kpi-label">Total Habit Tuntas</div>
            </div>

            <!-- 4. Best Streak -->
            <div class="kpi-card">
                <span class="kpi-icon">🔥</span>
                <div class="kpi-val" style="color: #fbbf24;">{{ $bestStreak }} Hari</div>
                <div class="kpi-label">Rekor Streak Tertinggi</div>
            </div>
        </section>

        <!-- Period Tab Switcher -->
        <div class="period-header">
            <div class="period-tabs">
                <a href="/calendar?view=weekly" class="period-tab {{ $viewType === 'weekly' ? 'active' : '' }}">
                    Mingguan
                </a>
                <a href="/calendar?view=monthly&month={{ $month }}" class="period-tab {{ $viewType === 'monthly' ? 'active' : '' }}">
                    Bulanan
                </a>
                <a href="/calendar?view=yearly" class="period-tab {{ $viewType === 'yearly' ? 'active' : '' }}">
                    Tahunan (GitHub)
                </a>
            </div>

            @if($viewType === 'monthly')
                @php
                    $prevMonth = $currentMonth->copy()->subMonth()->format('Y-m');
                    $nextMonth = $currentMonth->copy()->addMonth()->format('Y-m');
                @endphp
                <div class="month-selector">
                    <a href="/calendar?view=monthly&month={{ $prevMonth }}" class="month-nav-btn" title="Bulan Sebelumnya">‹</a>
                    <span class="current-month-label">{{ $currentMonth->translatedFormat('F Y') }}</span>
                    <a href="/calendar?view=monthly&month={{ $nextMonth }}" class="month-nav-btn" title="Bulan Selanjutnya">›</a>
                </div>
            @endif
        </div>

        <!-- ========================================== -->
        <!-- CONTENT 1: BULANAN (Kalender Masing-Masing Habit) -->
        <!-- ========================================== -->
        @if($viewType === 'monthly')
            <section class="monthly-container">
                @foreach($monthlyHabits as $habit)
                    <div class="monthly-habit-card">
                        <div class="habit-header-row">
                            <div class="habit-title-box">
                                <div class="habit-badge-icon" style="box-shadow: 0 4px 12px {{ $habit->color }}33;">
                                    {{ $habit->icon }}
                                </div>
                                <div>
                                    <h3 class="habit-heading">{{ $habit->name }}</h3>
                                    <span style="font-size: 0.78rem; color: var(--text-muted);">
                                        Target: {{ $habit->target_per_day }}x / hari
                                    </span>
                                </div>
                            </div>

                            <span class="habit-progress-pill">
                                {{ $habit->month_done_count }}/{{ $daysInMonth }} Hari ({{ $habit->month_percent }}%)
                            </span>
                        </div>

                        <!-- Header Hari (Sen, Sel, Rab, Kam, Jum, Sab, Min) -->
                        <div class="calendar-weekdays">
                            <div>Sen</div>
                            <div>Sel</div>
                            <div>Rab</div>
                            <div>Kam</div>
                            <div>Jum</div>
                            <div>Sab</div>
                            <div>Min</div>
                        </div>

                        <!-- Days Grid -->
                        <div class="calendar-days-grid">
                            {{-- Kosongkan slot hari sebelum tanggal 1 --}}
                            @for($s = 1; $s < $startDayOfWeek; $s++)
                                <div class="calendar-day-cell empty"></div>
                            @endfor

                            {{-- Render Tanggal 1 s/d daysInMonth --}}
                            @for($d = 1; $d <= $daysInMonth; $d++)
                                @php
                                    $isDone = isset($habit->completed_days[$d]);
                                    $isToday = $currentMonth->copy()->day($d)->isToday();
                                @endphp
                                <div class="calendar-day-cell {{ $isDone ? 'completed' : '' }} {{ $isToday ? 'today-marker' : '' }}"
                                     style="{{ $isDone ? 'background: ' . $habit->color . '; color: #fff;' : '' }}"
                                     title="Tanggal {{ $d }} {{ $currentMonth->translatedFormat('F Y') }} - {{ $isDone ? 'Selesai' : 'Belum' }}">
                                    @if($isDone)
                                        ✓
                                    @else
                                        {{ $d }}
                                    @endif
                                </div>
                            @endfor
                        </div>
                    </div>
                @endforeach
            </section>

        <!-- ========================================== -->
        <!-- CONTENT 2: TAHUNAN (GitHub-Style Contribution Heatmap) -->
        <!-- ========================================== -->
        @elseif($viewType === 'yearly')
            <section class="github-heatmap-container">
                <div class="heatmap-header">
                    <div>
                        <div class="heatmap-title">
                            <span>🟩</span>
                            <span>Aktivitas Habit Setahun Terakhir</span>
                        </div>
                        <p class="heatmap-sub">Pola konsistensi dan produktivitas harian Anda seperti grafik kontribusi GitHub.</p>
                    </div>
                </div>

                <div class="heatmap-scroll-wrapper">
                    <div class="heatmap-grid" id="heatmap-grid">
                        @foreach($yearlyContributions as $cell)
                            <div class="heatmap-cell" 
                                 data-level="{{ $cell['level'] }}" 
                                 title="{{ $cell['date'] }}: {{ $cell['count'] }} dari {{ $totalHabits }} habit selesai">
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="heatmap-legend">
                    <span>Kurang</span>
                    <div class="legend-box" style="background: rgba(255, 255, 255, 0.05);"></div>
                    <div class="legend-box" style="background: #0e4429;"></div>
                    <div class="legend-box" style="background: #006d32;"></div>
                    <div class="legend-box" style="background: #26a641;"></div>
                    <div class="legend-box" style="background: #39d353;"></div>
                    <span>Sangat Konsisten</span>
                </div>
            </section>

        <!-- ========================================== -->
        <!-- CONTENT 3: MINGGUAN (Weekly Breakdown) -->
        <!-- ========================================== -->
        @elseif($viewType === 'weekly')
            <section class="weekly-container">
                @foreach($weeklyDays as $wDay)
                    <div class="weekly-day-card {{ $wDay['is_today'] ? 'today' : '' }}">
                        <div class="weekly-day-info">
                            <div class="weekly-date-badge">
                                <span class="day-name">{{ $wDay['day_name'] }}</span>
                                <span class="day-num">{{ $wDay['day_number'] }}</span>
                            </div>
                            <div class="weekly-habits-pills">
                                @foreach($habits as $h)
                                    @php
                                        $doneOnThisDay = $h->logs()->where('date', $wDay['date'])->where('completed', true)->exists();
                                    @endphp
                                    <span class="pill-habit {{ $doneOnThisDay ? 'done' : '' }}">
                                        {{ $h->icon }} {{ $h->name }} {{ $doneOnThisDay ? '✓' : '' }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <a href="/?date={{ $wDay['date'] }}" class="month-nav-btn" title="Buka di Tracker">
                            →
                        </a>
                    </div>
                @endforeach
            </section>
        @endif

    </div>

    <!-- ===== Bottom Navigation Bar ===== -->
    <div class="bottom-nav-wrapper">
        <nav class="bottom-nav" aria-label="Navigasi Bawah">
            <!-- 1. Hari Ini -->
            <a href="/" class="nav-item" title="Hari Ini">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span>Hari Ini</span>
            </a>

            <!-- 2. Kalender (Active) -->
            <a href="/calendar" class="nav-item active" title="Kalender & Analitik">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>Kalender</span>
            </a>

            <!-- 3. FAB Tambah -->
            <div class="nav-fab-container">
                <a href="/admin/habits/create" class="nav-fab" title="Tambah Kebiasaan Baru">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                </a>
                <span class="nav-fab-label">Tambah</span>
            </div>

            <!-- 4. Ringkasan / Top -->
            <a href="#top" class="nav-item" onclick="window.scrollTo({top: 0, behavior: 'smooth'}); return false;" title="Ke Atas">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                <span>Statistik</span>
            </a>

            <!-- 5. Admin -->
            <a href="/admin" class="nav-item" title="Panel Admin Filament">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Kelola</span>
            </a>
        </nav>
    </div>

    @include('tracker.partials.settings_drawer')
    <script src="/js/settings_drawer.js"></script>
</body>
</html>
