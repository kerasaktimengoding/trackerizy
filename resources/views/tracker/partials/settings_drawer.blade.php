<!-- ===== Left Sidebar / Settings & Lifestyle Drawer ===== -->
<div id="settings-backdrop" class="drawer-backdrop" onclick="closeSettingsDrawer()"></div>

<aside id="settings-drawer" class="settings-drawer" aria-label="Menu Pengaturan & Lifestyle">
    <!-- Drawer Header -->
    <div class="drawer-header">
        <div class="drawer-title">
            <span class="pulse-dot"></span>
            <span>Lifestyle & Settings</span>
        </div>
        <button type="button" class="btn-drawer-close" onclick="closeSettingsDrawer()" aria-label="Tutup Menu">
            ✕
        </button>
    </div>

    <div class="drawer-scroll-body">
        <!-- 1. PROFILE SECTION -->
        <section class="drawer-card profile-card">
            <div class="profile-info-row">
                <div class="profile-avatar-wrapper">
                    <img id="user-avatar-img" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80" alt="Avatar User" class="profile-avatar">
                    <button type="button" class="avatar-edit-badge" onclick="triggerAvatarUpload()" title="Ubah Foto">
                        📷
                    </button>
                    <input type="file" id="avatar-file-input" accept="image/*" style="display: none;" onchange="handleAvatarChange(event)">
                </div>
                <div class="profile-details">
                    <div class="profile-name-row">
                        <h4 id="user-display-name">Kera Sakti</h4>
                        <span class="pro-badge">PRO</span>
                    </div>
                    <p class="profile-email" id="user-display-email">admin@gmail.com</p>
                    <div class="streak-mini-chip">🔥 Level 4: Habit Master</div>
                </div>
            </div>

            <div class="profile-actions-row">
                <button type="button" class="btn-outline-sm" onclick="openEditProfileModal()">
                    ✏️ Edit Profil
                </button>
                <button type="button" class="btn-outline-sm" onclick="openWallpaperModal()">
                    🖼️ Wallpaper
                </button>
            </div>
        </section>

        <!-- 2. MOODS TRACKER & CALENDAR VIEW -->
        <section class="drawer-card">
            <div class="section-title-row">
                <div class="section-heading">
                    <span>✨</span>
                    <span>Mood Hari Ini</span>
                </div>
                <button type="button" class="link-action-text" onclick="toggleMoodHistory()">
                    View Mood Calendar 📅
                </button>
            </div>
            <p class="section-subtext">Bagaimana perasaan dan energimu saat ini?</p>

            <div class="mood-selector-grid">
                <button type="button" class="mood-btn" data-mood="happy" onclick="selectMood('happy', '😄', 'Bahagia & Bersemangat')">
                    <span class="emoji">😄</span>
                    <span class="label">Hebat</span>
                </button>
                <button type="button" class="mood-btn" data-mood="calm" onclick="selectMood('calm', '😌', 'Tenang & Damai')">
                    <span class="emoji">😌</span>
                    <span class="label">Tenang</span>
                </button>
                <button type="button" class="mood-btn" data-mood="neutral" onclick="selectMood('neutral', '😐', 'Biasa Saja')">
                    <span class="emoji">😐</span>
                    <span class="label">Biasa</span>
                </button>
                <button type="button" class="mood-btn" data-mood="sad" onclick="selectMood('sad', '😔', 'Sedih / Lelah')">
                    <span class="emoji">😔</span>
                    <span class="label">Lelah</span>
                </button>
                <button type="button" class="mood-btn" data-mood="stressed" onclick="selectMood('stressed', '😤', 'Stres / Frustrasi')">
                    <span class="emoji">😤</span>
                    <span class="label">Stres</span>
                </button>
            </div>

            <div id="mood-selected-feedback" class="mood-feedback-box">
                Mood hari ini: <strong id="current-mood-text">Belum dipilih</strong>
            </div>

            <!-- Mood Calendar Popup Collapse -->
            <div id="mood-calendar-container" class="mood-calendar-collapse" style="display: none;">
                <div class="mini-calendar-header">Riwayat Emosi 7 Hari Terakhir:</div>
                <div class="mood-history-row" id="mood-history-row">
                    <!-- Dinamis via JS -->
                </div>
            </div>
        </section>

        <!-- 3. STRESS METER (Merah, Kuning, Biru Muda, Hijau) -->
        <section class="drawer-card stress-meter-card">
            <div class="section-title-row">
                <div class="section-heading">
                    <span>⚡</span>
                    <span>Stress Meter</span>
                </div>
                <span id="stress-level-badge" class="stress-badge green">Hijau: Tenang</span>
            </div>
            <p class="section-subtext">Deteksi beban pikiran untuk menjaga kesehatan mental:</p>

            <div class="stress-bar-selector">
                <button type="button" class="stress-segment red" data-level="red" onclick="setStressLevel('red', '🔴 Merah (Tinggi / Butuh Istirahat!)', 'Tarik napas dalam 4 detik, tahan 4 detik, buang 4 detik. Luangkan 15 menit tanpa layar.')" title="Merah: Tinggi"></button>
                <button type="button" class="stress-segment yellow" data-level="yellow" onclick="setStressLevel('yellow', '🟡 Kuning (Sedang / Cukup Tertekan)', 'Beban pikiran cukup terasa. Coba dengarkan musik santai atau minum teh hangat.')" title="Kuning: Sedang"></button>
                <button type="button" class="stress-segment lightblue" data-level="lightblue" onclick="setStressLevel('lightblue', '🔷 Biru Muda (Rendah / Terkendali)', 'Fokusmu sangat baik hari ini, pertahankan ritme kerjamu!')" title="Biru Muda: Rendah"></button>
                <button type="button" class="stress-segment green active" data-level="green" onclick="setStressLevel('green', '🟢 Hijau (Sangat Rileks & Tenang)', 'Kondisi mental optimal. Waktu yang luar biasa untuk produktif dan menyelesaikan habit!')" title="Hijau: Sangat Tenang"></button>
            </div>

            <div class="stress-legend-row">
                <span style="color: #ef4444;">Tinggi</span>
                <span style="color: #f59e0b;">Sedang</span>
                <span style="color: #38bdf8;">Rendah</span>
                <span style="color: #10b981;">Tenang</span>
            </div>

            <div class="stress-tip-box" id="stress-tip-box">
                🟢 <strong>Sangat Tenang:</strong> Kondisi mental optimal untuk produktif dan konsisten mencapai target!
            </div>
        </section>

        <!-- 4. DAILY QUOTE -->
        <section class="drawer-card quote-card">
            <div class="section-title-row">
                <div class="section-heading">
                    <span>💡</span>
                    <span>Daily Quote</span>
                </div>
                <button type="button" class="btn-refresh-quote" onclick="refreshDailyQuote()" title="Ganti Kutipan">
                    🔄
                </button>
            </div>
            <blockquote id="daily-quote-text" class="quote-text">
                "Kita adalah apa yang kita lakukan berulang kali. Keunggulan bukanlah sebuah tindakan, melainkan sebuah kebiasaan."
            </blockquote>
            <div id="daily-quote-author" class="quote-author">— Aristoteles</div>
        </section>

        <!-- 5. SETTINGS MENU -->
        <section class="drawer-card">
            <div class="section-heading" style="margin-bottom: 12px;">
                <span>⚙️</span>
                <span>Pengaturan Sistem</span>
            </div>

            <div class="menu-list-items">
                <!-- Habit Manager -->
                <a href="/admin/habits" class="menu-item-row">
                    <div class="menu-item-left">
                        <span class="menu-item-icon">🎯</span>
                        <div class="menu-item-text">
                            <strong>Habit Manager</strong>
                            <small>Kelola target, warna, & ikon kebiasaan</small>
                        </div>
                    </div>
                    <span class="menu-item-arrow">›</span>
                </a>

                <!-- Widget Theme -->
                <div class="menu-item-row" onclick="openWidgetThemeModal()">
                    <div class="menu-item-left">
                        <span class="menu-item-icon">🎨</span>
                        <div class="menu-item-text">
                            <strong>Widget Theme</strong>
                            <small id="current-widget-theme-lbl">Glassmorphism Cyber</small>
                        </div>
                    </div>
                    <span class="menu-item-arrow">›</span>
                </div>

                <!-- Theme / Wallpaper -->
                <div class="menu-item-row" onclick="openWallpaperModal()">
                    <div class="menu-item-left">
                        <span class="menu-item-icon">🖼️</span>
                        <div class="menu-item-text">
                            <strong>Theme & Wallpaper</strong>
                            <small>Kustomisasi latar belakang gambar / warna</small>
                        </div>
                    </div>
                    <span class="menu-item-arrow">›</span>
                </div>

                <!-- Page & Function -->
                <div class="menu-item-row" onclick="toggleDefaultPage()">
                    <div class="menu-item-left">
                        <span class="menu-item-icon">📑</span>
                        <div class="menu-item-text">
                            <strong>Page & Function</strong>
                            <small id="default-page-lbl">Default: Dashboard Hari Ini</small>
                        </div>
                    </div>
                    <span class="badge-pill">Aktif</span>
                </div>

                <!-- iCloud Sync -->
                <div class="menu-item-row" onclick="simulateCloudSync()">
                    <div class="menu-item-left">
                        <span class="menu-item-icon">☁️</span>
                        <div class="menu-item-text">
                            <strong>iCloud / Cloud Sync</strong>
                            <small id="cloud-sync-status">Tersinkronisasi Otomatis</small>
                        </div>
                    </div>
                    <span id="cloud-sync-badge" class="badge-pill success">Connected</span>
                </div>

                <!-- Dynamic Island -->
                <div class="menu-item-row">
                    <div class="menu-item-left">
                        <span class="menu-item-icon">🏝️</span>
                        <div class="menu-item-text">
                            <strong>Dynamic Island</strong>
                            <small>Notifikasi interaktif melayang di atas layar</small>
                        </div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" id="dynamic-island-toggle" checked onchange="toggleDynamicIsland(event)">
                        <span class="toggle-slider"></span>
                    </label>
                </div>
            </div>
        </section>

        <!-- 6. ABOUT SECTION -->
        <section class="drawer-card about-card">
            <div class="section-heading" style="margin-bottom: 12px;">
                <span>ℹ️</span>
                <span>Tentang Aplikasi</span>
            </div>

            <div class="menu-list-items">
                <!-- Usage Tips -->
                <div class="menu-item-row" onclick="openAboutModal('tips')">
                    <div class="menu-item-left">
                        <span class="menu-item-icon">💡</span>
                        <div class="menu-item-text">
                            <strong>Usage Tips</strong>
                            <small>Metode 21/90 hari membangun kebiasaan</small>
                        </div>
                    </div>
                    <span class="menu-item-arrow">›</span>
                </div>

                <!-- FAQs -->
                <div class="menu-item-row" onclick="openAboutModal('faqs')">
                    <div class="menu-item-left">
                        <span class="menu-item-icon">❓</span>
                        <div class="menu-item-text">
                            <strong>FAQs</strong>
                            <small>Pertanyaan & jawaban seputar fitur</small>
                        </div>
                    </div>
                    <span class="menu-item-arrow">›</span>
                </div>

                <!-- Contact Us -->
                <div class="menu-item-row" onclick="openAboutModal('contact')">
                    <div class="menu-item-left">
                        <span class="menu-item-icon">✉️</span>
                        <div class="menu-item-text">
                            <strong>Contact Us</strong>
                            <small>Hubungi bantuan & konsultasi developer</small>
                        </div>
                    </div>
                    <span class="menu-item-arrow">›</span>
                </div>

                <!-- Instagram -->
                <a href="https://instagram.com/lightbyte_apps" target="_blank" rel="noopener" class="menu-item-row">
                    <div class="menu-item-left">
                        <span class="menu-item-icon">📷</span>
                        <div class="menu-item-text">
                            <strong>Instagram</strong>
                            <small style="color: #ec4899; font-weight: 600;">@lightbyte_apps</small>
                        </div>
                    </div>
                    <span class="menu-item-arrow">↗</span>
                </a>

                <!-- Share App -->
                <div class="menu-item-row" onclick="shareTrackerApp()">
                    <div class="menu-item-left">
                        <span class="menu-item-icon">🔗</span>
                        <div class="menu-item-text">
                            <strong>Share App</strong>
                            <small>Bagikan Trackerizy ke teman atau sosmed</small>
                        </div>
                    </div>
                    <span class="menu-item-arrow">↗</span>
                </div>

                <!-- Review and Support -->
                <div class="menu-item-row" onclick="openAboutModal('review')">
                    <div class="menu-item-left">
                        <span class="menu-item-icon">⭐</span>
                        <div class="menu-item-text">
                            <strong>Review and Support</strong>
                            <small>Beri rating bintang 5 & dukung project</small>
                        </div>
                    </div>
                    <span class="menu-item-arrow">★</span>
                </div>
            </div>

            <div class="app-version-footer">
                <span>Trackerizy v2.4.0 by Lightbyte Apps</span>
                <small>Made with ❤️ for peak productivity</small>
            </div>
        </section>
    </div>
</aside>

<!-- ============================================================== -->
<!-- POPUP MODAL 1: WALLPAPER CUSTOMIZER -->
<!-- ============================================================== -->
<div id="wallpaper-modal" class="custom-modal-backdrop" onclick="closeWallpaperModal(event)">
    <div class="custom-modal-card" onclick="event.stopPropagation()">
        <div class="modal-card-header">
            <h3>🖼️ Pengaturan Wallpaper Tampilan</h3>
            <button type="button" class="btn-drawer-close" onclick="closeWallpaperModal()">✕</button>
        </div>

        <div class="modal-card-body">
            <!-- Upload File -->
            <div class="input-group-row">
                <label>📁 Upload Foto dari Perangkat (Laptop/HP):</label>
                <input type="file" id="wallpaper-file-input" accept="image/*" class="custom-file-input" onchange="handleWallpaperUpload(event)">
            </div>

            <!-- Paste URL -->
            <div class="input-group-row">
                <label>🔗 Atau Masukkan URL Gambar Langsung:</label>
                <div style="display: flex; gap: 8px;">
                    <input type="url" id="wallpaper-url-input" placeholder="https://images.unsplash.com/..." class="custom-text-input">
                    <button type="button" class="btn-primary-sm" onclick="applyWallpaperUrl()">Terapkan</button>
                </div>
            </div>

            <!-- Preset Wallpapers -->
            <div class="input-group-row">
                <label>🌌 Pilihan Koleksi Preset Estetik:</label>
                <div class="preset-wallpapers-grid">
                    <button type="button" class="preset-thumb" onclick="applyPresetWallpaper('https://images.unsplash.com/photo-1518709268805-4e9042af9f23?w=1600&auto=format&fit=crop&q=80')" title="Cyberpunk City">
                        <img src="https://images.unsplash.com/photo-1518709268805-4e9042af9f23?w=300&auto=format&fit=crop&q=80" alt="Cyberpunk">
                        <span>Cyberpunk</span>
                    </button>
                    <button type="button" class="preset-thumb" onclick="applyPresetWallpaper('https://images.unsplash.com/photo-1506744038136-46273834b3fb?w=1600&auto=format&fit=crop&q=80')" title="Nature Forest">
                        <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?w=300&auto=format&fit=crop&q=80" alt="Nature">
                        <span>Lembah Alam</span>
                    </button>
                    <button type="button" class="preset-thumb" onclick="applyPresetWallpaper('https://images.unsplash.com/photo-1534447677768-be436bb09401?w=1600&auto=format&fit=crop&q=80')" title="Deep Space">
                        <img src="https://images.unsplash.com/photo-1534447677768-be436bb09401?w=300&auto=format&fit=crop&q=80" alt="Deep Space">
                        <span>Galaksi Aurora</span>
                    </button>
                    <button type="button" class="preset-thumb" onclick="applyPresetWallpaper('https://images.unsplash.com/photo-1519681393784-d120267933ba?w=1600&auto=format&fit=crop&q=80')" title="Starry Mountain">
                        <img src="https://images.unsplash.com/photo-1519681393784-d120267933ba?w=300&auto=format&fit=crop&q=80" alt="Mountain">
                        <span>Bintang Malam</span>
                    </button>
                </div>
            </div>

            <!-- Dimmer / Darkness Slider -->
            <div class="input-group-row">
                <div style="display: flex; justify-content: space-between;">
                    <label>🎚️ Kecerahan / Lapisan Gelap (Overlay Dimmer):</label>
                    <strong id="dimmer-val-lbl">60%</strong>
                </div>
                <input type="range" id="wallpaper-dimmer-slider" min="10" max="95" value="60" oninput="updateWallpaperDimmer(this.value)">
                <small style="color: var(--text-muted);">Membantu teks dan kartu habit tetap mudah terbaca.</small>
            </div>

            <!-- Reset -->
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 10px;">
                <button type="button" class="btn-outline-sm" onclick="resetDefaultWallpaper()">
                    🔄 Reset Tema Bawaan
                </button>
                <button type="button" class="btn-primary-sm" onclick="closeWallpaperModal()">
                    Selesai
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- POPUP MODAL 2: ABOUT / TIPS / FAQS MODAL -->
<!-- ============================================================== -->
<div id="about-info-modal" class="custom-modal-backdrop" onclick="closeAboutModal(event)">
    <div class="custom-modal-card" onclick="event.stopPropagation()">
        <div class="modal-card-header">
            <h3 id="about-modal-title">Usage Tips</h3>
            <button type="button" class="btn-drawer-close" onclick="closeAboutModal()">✕</button>
        </div>
        <div class="modal-card-body" id="about-modal-content">
            <!-- Diisi lewat JS -->
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- DYNAMIC ISLAND NOTIFICATION FLOATER -->
<!-- ============================================================== -->
<div id="dynamic-island-floater" class="dynamic-island">
    <div class="di-pill" id="di-pill" onclick="expandDynamicIsland()">
        <span class="di-icon" id="di-icon">🔥</span>
        <span class="di-text" id="di-text">Streak Hari Ini: Aktif & Terjaga!</span>
    </div>
</div>

<!-- Background Wallpaper Dom Nodes -->
<div id="custom-wallpaper-bg" class="custom-wallpaper-bg"></div>
<div id="custom-wallpaper-overlay" class="custom-wallpaper-overlay"></div>
