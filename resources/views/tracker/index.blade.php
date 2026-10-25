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
            padding: 24px 16px;
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
    </style>
</head>
<body>

    <div class="container">
        <!-- Top Nav -->
        <header class="top-nav">
            <a href="/" class="brand-logo">
                <span class="brand-badge">✨</span>
                <span>Trackerizy</span>
            </a>

            <a href="/admin" class="admin-link">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Kelola di Filament</span>
            </a>
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

    <script>
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
                form.submit(); // fallback if error
            }
        }
    </script>
</body>
</html>
