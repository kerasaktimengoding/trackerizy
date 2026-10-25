/**
 * Trackerizy Lifestyle & Settings Drawer Script
 * Handles Drawer, Moods, Stress Meter, Daily Quotes, Wallpaper, Dynamic Island, and About Modal.
 */

// 1. DRAWER TOGGLE
function openSettingsDrawer() {
    document.getElementById('settings-drawer').classList.add('open');
    document.getElementById('settings-backdrop').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeSettingsDrawer() {
    document.getElementById('settings-drawer').classList.remove('open');
    document.getElementById('settings-backdrop').classList.remove('open');
    document.body.style.overflow = '';
}

// 2. MOOD TRACKER
const MOOD_DATA = {
    happy: { emoji: '😄', label: 'Hebat & Bahagia', color: '#10b981' },
    calm: { emoji: '😌', label: 'Tenang & Damai', color: '#38bdf8' },
    neutral: { emoji: '😐', label: 'Biasa Saja', color: '#94a3b8' },
    sad: { emoji: '😔', label: 'Lelah / Murung', color: '#f59e0b' },
    stressed: { emoji: '😤', label: 'Stres / Tertekan', color: '#ef4444' }
};

function selectMood(key, emoji, label) {
    document.querySelectorAll('.mood-btn').forEach(btn => btn.classList.remove('active'));
    const btn = document.querySelector(`.mood-btn[data-mood="${key}"]`);
    if (btn) btn.classList.add('active');

    const feedback = document.getElementById('current-mood-text');
    if (feedback) {
        feedback.innerHTML = `${emoji} ${label}`;
    }

    // Save to localStorage
    const today = new Date().toISOString().split('T')[0];
    let moodHistory = JSON.parse(localStorage.getItem('trackerizy_mood_history') || '{}');
    moodHistory[today] = { key, emoji, label };
    localStorage.setItem('trackerizy_mood_history', JSON.stringify(moodHistory));

    showDynamicIsland(`${emoji} Mood dicatat: ${label}!`, emoji);
    renderMoodHistory();
}

function toggleMoodHistory() {
    const el = document.getElementById('mood-calendar-container');
    if (el) {
        el.style.display = el.style.display === 'none' ? 'block' : 'none';
        if (el.style.display === 'block') {
            renderMoodHistory();
        }
    }
}

function renderMoodHistory() {
    const container = document.getElementById('mood-history-row');
    if (!container) return;

    const moodHistory = JSON.parse(localStorage.getItem('trackerizy_mood_history') || '{}');
    container.innerHTML = '';

    for (let i = 6; i >= 0; i--) {
        const d = new Date();
        d.setDate(d.getDate() - i);
        const dateStr = d.toISOString().split('T')[0];
        const dayName = d.toLocaleDateString('id-ID', { weekday: 'short' });
        const record = moodHistory[dateStr];

        const chip = document.createElement('div');
        chip.className = 'mood-history-chip';
        chip.innerHTML = `
            <div style="font-size: 0.65rem; color: #94a3b8;">${dayName}</div>
            <div style="font-size: 1.15rem; margin-top: 2px;">${record ? record.emoji : '⚪'}</div>
        `;
        container.appendChild(chip);
    }
}

// 3. STRESS METER
const STRESS_DATA = {
    red: {
        badge: 'Merah: Tinggi',
        class: 'red',
        tip: '🔴 <strong>Tinggi:</strong> Tarik napas dalam 4 detik, hembuskan perlahan. Istirahatkan mata dari layar selama 15 menit.'
    },
    yellow: {
        badge: 'Kuning: Sedang',
        class: 'yellow',
        tip: '🟡 <strong>Sedang:</strong> Beban pikiran mulai terasa. Coba dengarkan instrumen santai atau jalan kaki ringan sejenak.'
    },
    lightblue: {
        badge: 'Biru Muda: Rendah',
        class: 'lightblue',
        tip: '🔷 <strong>Rendah:</strong> Fokusmu berada di ritme yang baik. Pertahankan momentum produktifmu!'
    },
    green: {
        badge: 'Hijau: Tenang',
        class: 'green',
        tip: '🟢 <strong>Sangat Tenang:</strong> Kondisi pikiran optimal. Sangat pas untuk menyelesaikan habit prioritasmu!'
    }
};

function setStressLevel(level, badgeText, tipText) {
    document.querySelectorAll('.stress-segment').forEach(seg => seg.classList.remove('active'));
    const activeSeg = document.querySelector(`.stress-segment[data-level="${level}"]`);
    if (activeSeg) activeSeg.classList.add('active');

    const badge = document.getElementById('stress-level-badge');
    if (badge) {
        badge.className = `stress-badge ${level}`;
        badge.textContent = badgeText;
    }

    const tipBox = document.getElementById('stress-tip-box');
    if (tipBox) {
        tipBox.innerHTML = tipText;
        tipBox.style.borderLeftColor = activeSeg ? getComputedStyle(activeSeg).backgroundColor : '#10b981';
    }

    localStorage.setItem('trackerizy_stress_level', level);
    showDynamicIsland(`Stress Meter diset: ${badgeText}`, '⚡');
}

// 4. DAILY QUOTES
const QUOTES_COLLECTION = [
    { text: "Kita adalah apa yang kita lakukan berulang kali. Keunggulan bukanlah sebuah tindakan, melainkan sebuah kebiasaan.", author: "Aristoteles" },
    { text: "Jangan biarkan apa yang tidak bisa kamu lakukan menghalangi apa yang bisa kamu lakukan.", author: "John Wooden" },
    { text: "Perubahan kecil hari ini menghasilkan lompatan raksasa di masa depan. 1% lebih baik setiap hari.", author: "James Clear (Atomic Habits)" },
    { text: "Disiplin adalah memilih antara apa yang kamu inginkan sekarang dan apa yang paling kamu inginkan nanti.", author: "Abraham Lincoln" },
    { text: "Rahasia masa depanmu tersembunyi di dalam rutinitas harianmu.", author: "Mike Murdock" }
];

function refreshDailyQuote() {
    const randomIndex = Math.floor(Math.random() * QUOTES_COLLECTION.length);
    const item = QUOTES_COLLECTION[randomIndex];
    document.getElementById('daily-quote-text').textContent = `"${item.text}"`;
    document.getElementById('daily-quote-author').textContent = `— ${item.author}`;
}

// 5. WALLPAPER SYSTEM
function openWallpaperModal() {
    document.getElementById('wallpaper-modal').classList.add('open');
}

function closeWallpaperModal(event) {
    if (event && event.target !== document.getElementById('wallpaper-modal')) return;
    document.getElementById('wallpaper-modal').classList.remove('open');
}

function applyWallpaperUrl(urlInput) {
    const url = urlInput || document.getElementById('wallpaper-url-input').value.trim();
    if (!url) return;
    setWallpaper(url);
    showDynamicIsland('Wallpaper berhasil diterapkan! ✨', '🖼️');
}

function applyPresetWallpaper(url) {
    setWallpaper(url);
    showDynamicIsland('Preset Wallpaper dipilih! ✨', '🖼️');
}

function handleWallpaperUpload(event) {
    const file = event.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function(e) {
        const base64Url = e.target.result;
        setWallpaper(base64Url);
        showDynamicIsland('Foto wallpaper berhasil diunggah! 📸', '🖼️');
    };
    reader.readAsDataURL(file);
}

function setWallpaper(url) {
    const bgNode = document.getElementById('custom-wallpaper-bg');
    if (bgNode) {
        bgNode.style.backgroundImage = `url('${url}')`;
        localStorage.setItem('trackerizy_wallpaper', url);
    }
}

function updateWallpaperDimmer(val) {
    const overlay = document.getElementById('custom-wallpaper-overlay');
    const lbl = document.getElementById('dimmer-val-lbl');
    const opacity = val / 100;
    if (overlay) {
        overlay.style.backgroundColor = `rgba(11, 15, 25, ${opacity})`;
    }
    if (lbl) {
        lbl.textContent = `${val}%`;
    }
    localStorage.setItem('trackerizy_dimmer', val);
}

function resetDefaultWallpaper() {
    const bgNode = document.getElementById('custom-wallpaper-bg');
    if (bgNode) {
        bgNode.style.backgroundImage = 'none';
        localStorage.removeItem('trackerizy_wallpaper');
    }
    updateWallpaperDimmer(60);
    document.getElementById('wallpaper-dimmer-slider').value = 60;
    showDynamicIsland('Tema default berhasil dikembalikan!', '🔄');
}

function initWallpaper() {
    const savedWallpaper = localStorage.getItem('trackerizy_wallpaper');
    const savedDimmer = localStorage.getItem('trackerizy_dimmer') || 60;

    if (savedWallpaper) {
        const bgNode = document.getElementById('custom-wallpaper-bg');
        if (bgNode) bgNode.style.backgroundImage = `url('${savedWallpaper}')`;
    }

    updateWallpaperDimmer(savedDimmer);
    const slider = document.getElementById('wallpaper-dimmer-slider');
    if (slider) slider.value = savedDimmer;
}

// 6. DYNAMIC ISLAND FLOATER
let diTimeout;
function showDynamicIsland(text, icon = '✨') {
    const isEnabled = document.getElementById('dynamic-island-toggle') ? document.getElementById('dynamic-island-toggle').checked : true;
    if (!isEnabled) return;

    const pill = document.getElementById('di-pill');
    const textEl = document.getElementById('di-text');
    const iconEl = document.getElementById('di-icon');

    if (pill && textEl && iconEl) {
        iconEl.textContent = icon;
        textEl.textContent = text;
        pill.style.transform = 'scale(1.1)';
        clearTimeout(diTimeout);
        diTimeout = setTimeout(() => {
            pill.style.transform = 'scale(1)';
        }, 1200);
    }
}

function toggleDynamicIsland(event) {
    const checked = event.target.checked;
    localStorage.setItem('trackerizy_dynamic_island', checked ? 'true' : 'false');
    const floater = document.getElementById('dynamic-island-floater');
    if (floater) floater.style.display = checked ? 'block' : 'none';
}

function expandDynamicIsland() {
    openSettingsDrawer();
}

// 7. PROFILE & AVATAR
function triggerAvatarUpload() {
    document.getElementById('avatar-file-input').click();
}

function handleAvatarChange(event) {
    const file = event.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function(e) {
        const url = e.target.result;
        document.getElementById('user-avatar-img').src = url;
        localStorage.setItem('trackerizy_user_avatar', url);
        showDynamicIsland('Foto profil diperbarui!', '👤');
    };
    reader.readAsDataURL(file);
}

function openEditProfileModal() {
    const currentName = document.getElementById('user-display-name').textContent;
    const newName = prompt('Masukkan nama profil baru:', currentName);
    if (newName && newName.trim()) {
        document.getElementById('user-display-name').textContent = newName.trim();
        localStorage.setItem('trackerizy_user_name', newName.trim());
        showDynamicIsland(`Profil diubah menjadi ${newName.trim()}!`, '👤');
    }
}

// 8. SETTINGS MODALS & ABOUT CONTENT
const ABOUT_CONTENTS = {
    tips: {
        title: "💡 Usage Tips (Membangun Habit)",
        body: `
            <p><strong>Metode 21/90 Hari:</strong> Dibutuhkan 21 hari untuk membangun kebiasaan baru, dan 90 hari untuk menjadikannya bagian tak terpisahkan dari gaya hidupmu.</p>
            <ul style="padding-left: 20px; margin-top: 10px; line-height: 1.6; color: #cbd5e1;">
                <li><strong>Start Small:</strong> Mulai dari hal kecil (contoh: membaca 5 lembar per hari).</li>
                <li><strong>Gunakan Trigger:</strong> Sambungkan habit baru dengan rutinitas lama (contoh: minum air putih tepat setelah bangun tidur).</li>
                <li><strong>Pantau Streak:</strong> Jangan putus rantai streak lebih dari 1 hari berturut-turut!</li>
            </ul>
        `
    },
    faqs: {
        title: "❓ Pertanyaan Umum (FAQs)",
        body: `
            <p><strong>Q: Apakah data tersimpan aman?</strong><br>A: Ya! Data habit Anda tersimpan di database lokal MySQL dan disinkronkan secara aman dengan panel Filament.</p>
            <br>
            <p><strong>Q: Bagaimana cara menambah habit baru?</strong><br>A: Anda bisa menekan tombol <strong>+ Tambah</strong> di tengah navigasi bawah atau melalui menu Habit Manager di panel admin.</p>
        `
    },
    contact: {
        title: "✉️ Hubungi Kami",
        body: `
            <p>Punya pertanyaan, ide fitur menarik, atau butuh bantuan integrasi?</p>
            <div style="margin-top: 14px; background: rgba(255,255,255,0.05); padding: 14px; border-radius: 12px;">
                <strong>📧 Email:</strong> support@lightbyte.id<br>
                <strong>📱 Instagram:</strong> @lightbyte_apps<br>
                <strong>🌐 Website:</strong> lightbyte.id
            </div>
        `
    },
    review: {
        title: "⭐ Review & Support",
        body: `
            <p>Suka dengan aplikasi Trackerizy? Dukung kami dengan memberikan rating bintang 5 dan ulasan terbaik Anda!</p>
            <div style="text-align: center; margin: 20px 0; font-size: 2rem;">
                ⭐⭐⭐⭐⭐
            </div>
            <p style="text-align: center; color: #38bdf8; font-weight: bold;">Terima kasih atas dukungan Anda untuk karya anak bangsa!</p>
        `
    }
};

function openAboutModal(key) {
    const data = ABOUT_CONTENTS[key];
    if (!data) return;

    document.getElementById('about-modal-title').textContent = data.title;
    document.getElementById('about-modal-content').innerHTML = data.body;
    document.getElementById('about-info-modal').classList.add('open');
}

function closeAboutModal(event) {
    if (event && event.target !== document.getElementById('about-info-modal')) return;
    document.getElementById('about-info-modal').classList.remove('open');
}

function shareTrackerApp() {
    if (navigator.share) {
        navigator.share({
            title: 'Trackerizy — Smart Habit Tracker',
            text: 'Ayo bangun kebiasaan produktif bersama Trackerizy!',
            url: window.location.href
        }).catch(() => {});
    } else {
        navigator.clipboard.writeText(window.location.href);
        alert('Tautan aplikasi Trackerizy berhasil disalin ke clipboard!');
    }
}

function simulateCloudSync() {
    const badge = document.getElementById('cloud-sync-badge');
    badge.textContent = 'Syncing...';
    badge.className = 'badge-pill';
    setTimeout(() => {
        badge.textContent = 'Connected';
        badge.className = 'badge-pill success';
        showDynamicIsland('iCloud Sync Berhasil diperbarui! ☁️', '☁️');
    }, 1000);
}

function openWidgetThemeModal() {
    openWallpaperModal();
}

function toggleDefaultPage() {
    alert('Halaman default telah diset ke: Dashboard Habit Hari Ini.');
}

// INITIALIZE ON LOAD
document.addEventListener('DOMContentLoaded', () => {
    initWallpaper();

    // Load saved avatar & name
    const savedName = localStorage.getItem('trackerizy_user_name');
    if (savedName) {
        const el = document.getElementById('user-display-name');
        if (el) el.textContent = savedName;
    }

    const savedAvatar = localStorage.getItem('trackerizy_user_avatar');
    if (savedAvatar) {
        const el = document.getElementById('user-avatar-img');
        if (el) el.src = savedAvatar;
    }

    // Load saved mood today
    const today = new Date().toISOString().split('T')[0];
    const moodHistory = JSON.parse(localStorage.getItem('trackerizy_mood_history') || '{}');
    if (moodHistory[today]) {
        const rec = moodHistory[today];
        selectMood(rec.key, rec.emoji, rec.label);
    }

    // Load saved stress level
    const savedStress = localStorage.getItem('trackerizy_stress_level');
    if (savedStress && STRESS_DATA[savedStress]) {
        const item = STRESS_DATA[savedStress];
        setStressLevel(savedStress, item.badge, item.tip);
    }
});
