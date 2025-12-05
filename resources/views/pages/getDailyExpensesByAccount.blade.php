<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Working Days — Premium UI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg: #f8fafc;
            --card: #ffffff;
            --muted: #6b7280;
            --primary: #1C3FAA;
            --accent: #60A5FA;
            --success: #16a34a;
        }

        [data-theme='dark'] {
            --bg: #0b1220;
            --card: #071026;
            --muted: #94a3b8;
        }

        html,
        body {
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
            background: var(--bg);
        }

        .glass {
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.03), rgba(255, 255, 255, 0.01));
            backdrop-filter: blur(6px);
        }

        .hover-card {
            transition: transform .22s cubic-bezier(.2, .9, .3, 1), box-shadow .22s ease, background-color .15s ease
        }

        .hover-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(2, 6, 23, 0.12)
        }

        .modal-enter {
            animation: popIn .18s ease both
        }

        @keyframes popIn {
            from {
                opacity: 0;
                transform: translateY(8px) scale(.99)
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1)
            }
        }

        .day-active {
            border-color: rgba(28, 62, 170, 0.12);
            box-shadow: 0 10px 30px rgba(28, 62, 170, 0.06) !important
        }

        .toast-area {
            position: fixed;
            left: 50%;
            transform: translateX(-50%);
            bottom: 28px;
            z-index: 60
        }

        .toast {
            opacity: 0;
            transform: translateY(6px);
            transition: all .22s ease
        }

        .focus-ring:focus {
            outline: 3px solid rgba(28, 62, 170, 0.14);
            outline-offset: 3px
        }

        /* subtle scrollbar for days grid */
        #daysGrid {
            scrollbar-width: thin
        }
    </style>
</head>

<body data-theme="light" class="min-h-screen text-slate-800">

    <!-- HEADER -->
    <header class="glass sticky top-0 z-40 shadow-sm">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div
                    class="w-10 h-10 rounded-lg bg-gradient-to-br from-[var(--accent)] to-[var(--primary)] flex items-center justify-center text-white font-semibold">
                    WD</div>
                <div>
                    <div class="text-sm font-semibold">Working Days</div>
                    <div class="text-xs text-[var(--muted)]">Planner & budgeting</div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="hidden sm:flex items-center bg-[var(--card)] rounded-xl shadow-sm px-3 py-1 gap-2">
                    <input id="search" type="search" placeholder="Cari tanggal atau bank..."
                        class="outline-none text-sm bg-transparent" />
                    <button onclick="openFilter()" class="text-xs text-[var(--primary)] font-medium">Filter</button>
                </div>

                <button id="themeToggle" class="p-2 rounded-lg hover:bg-gray-100" title="Toggle theme">🌗</button>

                <button id="exportBtn"
                    class="hidden sm:inline-flex items-center gap-2 px-3 py-2 rounded-xl bg-[var(--card)] hover:scale-[.995] shadow-sm text-sm focus-ring"
                    title="Export CSV">Export</button>

                <div class="flex items-center gap-3">
                    <div class="text-right pr-2 hidden md:block text-sm">
                        <div class="text-xs text-[var(--muted)]">Saldo</div>
                        <div id="saldoTop" class="font-semibold">Rp 981.809</div>
                    </div>

                    <button
                        class="flex items-center gap-2 px-3 py-1 rounded-full bg-gradient-to-r from-[var(--primary)] to-blue-600 text-white text-sm shadow-md">
                        <span class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">RS</span>
                        <span class="hidden md:inline">Reza</span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- MAIN -->
    <main class="max-w-6xl mx-auto px-4 py-8">

        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="col-span-2 bg-[var(--card)] rounded-3xl p-6 border border-gray-100 hover-card">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1">
                        <h2 class="text-lg font-semibold">Ringkasan Keuangan</h2>
                        <p class="text-sm text-[var(--muted)] mt-1">Ringkasan & rekomendasi berdasarkan saldo dan
                            working days terpilih.</p>

                        <div class="mt-4 grid grid-cols-2 gap-3 text-sm text-[var(--muted)]">
                            <div class="p-3 rounded-xl bg-gray-50/40 border border-gray-100">
                                <div class="text-xs text-[var(--muted)]">Bank</div>
                                <div id="bankLabel" class="font-semibold text-slate-800">BCA</div>
                            </div>

                            <div class="p-3 rounded-xl bg-gray-50/40 border border-gray-100">
                                <div class="text-xs text-[var(--muted)]">Working Days</div>
                                <div id="workingDaysCount" class="font-semibold text-slate-800">18 hari</div>
                            </div>

                            <div class="p-3 rounded-xl bg-gray-50/40 border border-gray-100">
                                <div class="text-xs text-[var(--muted)]">Saldo</div>
                                <div id="saldoCard" class="font-semibold text-slate-800">Rp 981.809</div>
                            </div>

                            <div class="p-3 rounded-xl bg-green-50 border border-green-100">
                                <div class="text-xs text-green-700">Max Expense / Hari</div>
                                <div id="maxPerDay" class="font-bold text-green-800">Rp 54.544,94</div>
                            </div>
                        </div>

                        <div class="mt-4 w-full">
                            <label class="text-xs text-[var(--muted)]">Atur target pengeluaran (per bulan)</label>
                            <div class="mt-2 flex gap-2">
                                <input id="targetInput" type="number" min="0" step="1000"
                                    placeholder="Masukkan target (Rp)"
                                    class="w-full rounded-xl p-3 border border-gray-200 bg-gray-50 focus-ring" />
                                <button onclick="applyTarget()"
                                    class="px-4 py-2 rounded-xl bg-[var(--primary)] text-white">Hitung</button>
                            </div>
                        </div>
                    </div>

                    <div class="w-36 h-36 flex items-center justify-center">
                        <!-- small inline sparkline + circular progress -->
                        <svg viewBox="0 0 36 36" class="w-32 h-32">
                            <defs>
                                <linearGradient id="g1" x1="0" x2="1">
                                    <stop offset="0" stop-color="var(--accent)" />
                                    <stop offset="1" stop-color="var(--primary)" />
                                </linearGradient>
                            </defs>
                            <circle cx="18" cy="18" r="15" fill="#eef2ff" />
                            <circle cx="18" cy="18" r="12" fill="transparent" stroke="#E6E7F9"
                                stroke-width="6" />
                            <circle id="progressArc" cx="18" cy="18" r="12" fill="transparent"
                                stroke="url(#g1)" stroke-width="6" stroke-dasharray="0 100" stroke-linecap="round"
                                transform="rotate(-90 18 18)" />
                            <text id="progressLabel" x="18" y="19.8" font-size="5" text-anchor="middle"
                                fill="#0f172a" font-weight="600">0%</text>
                        </svg>
                    </div>
                </div>
            </div>

            <aside class="bg-[var(--card)] rounded-3xl p-5 border border-gray-100 hover-card">
                <h3 class="text-sm font-semibold text-slate-800">Aksi Cepat</h3>
                <div class="mt-4 flex flex-col gap-3">
                    <button
                        class="w-full text-left rounded-xl px-4 py-2 bg-[var(--primary)] text-white focus-ring">Tambah
                        Transaksi</button>
                    <button class="w-full text-left rounded-xl px-4 py-2 border border-gray-200 focus-ring"
                        onclick="autoGenerate()">Generate Working Days</button>
                    <button class="w-full text-left rounded-xl px-4 py-2 border border-gray-200"
                        id="downloadBtn">Unduh CSV</button>
                </div>

                <div class="mt-4 text-xs text-[var(--muted)]">Tip: gunakan "Generate Working Days" untuk otomatis
                    memilih hari kerja pada bulan terpilih.</div>
            </aside>

        </section>

        <section class="mt-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold">Tanggal Tersedia</h2>
                <div class="flex items-center gap-3">
                    <label class="text-sm text-[var(--muted)]">Bulan:</label>
                    <input id="monthPicker" type="month"
                        class="rounded-xl border border-gray-200 p-2 bg-[var(--card)]" />
                </div>
            </div>

            <div id="daysGrid"
                class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 p-1 overflow-auto max-h-[48vh]">
            </div>

            <div class="mt-6 text-sm text-[var(--muted)]">Klik tanggal untuk memilih / batalkan. Pilihan tersimpan
                secara lokal.</div>
        </section>

    </main>

    <!-- FILTER MODAL -->
    <div id="filterModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/40" onclick="closeFilter()" aria-hidden></div>

        <div class="relative max-w-md w-full modal-enter">
            <div class="bg-[var(--card)] rounded-3xl p-6 border border-gray-100 shadow-2xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold">Filter Data</h3>
                    <button onclick="closeFilter()" aria-label="Tutup">✕</button>
                </div>

                <form class="mt-4 space-y-4" onsubmit="applyFilter(event)">
                    <label class="block text-sm">
                        <span class="text-[var(--muted)]">Pilih Bank</span>
                        <select id="bankSelect"
                            class="mt-2 w-full rounded-xl border-gray-200 p-3 bg-gray-50 focus-ring">
                            <option>BCA</option>
                            <option>Mandiri</option>
                            <option>BRI</option>
                            <option>BNI</option>
                        </select>
                    </label>

                    <label class="block text-sm">
                        <span class="text-[var(--muted)]">Maksimal Tanggal</span>
                        <input id="maxDate" type="date" value="2025-12-27"
                            class="mt-2 w-full rounded-xl border-gray-200 p-3 bg-gray-50" />
                    </label>

                    <div class="flex items-center gap-3 justify-end">
                        <button type="button" onclick="closeFilter()"
                            class="px-4 py-2 rounded-xl border border-gray-200">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 rounded-xl bg-[var(--primary)] text-white">Terapkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- toast container -->
    <div id="toastArea" class="toast-area" aria-live="polite"></div>

    <script>
        // state
        const STORAGE_KEY = 'wd_ui_v3';
        const saved = JSON.parse(localStorage.getItem(STORAGE_KEY) || '{}');
        const state = {
            bank: saved.bank || 'BCA',
            saldo: saved.saldo || 981809,
            selected: new Set(saved.selected || []),
            month: saved.month || (new Date()).toISOString().slice(0, 7)
        };

        // helpers
        function currencyFormat(n) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0
            }).format(n);
        }

        document.getElementById('bankLabel').textContent = state.bank;
        document.getElementById('saldoCard').textContent = currencyFormat(state.saldo);
        document.getElementById('saldoTop').textContent = currencyFormat(state.saldo);
        document.getElementById('monthPicker').value = state.month;

        function saveState() {
            localStorage.setItem(STORAGE_KEY, JSON.stringify({
                bank: state.bank,
                saldo: state.saldo,
                selected: Array.from(state.selected),
                month: state.month
            }));
        }

        function getMonthDays(year, month) {
            const date = new Date(year, month - 1, 1);
            const days = [];
            while (date.getMonth() === month - 1) {
                days.push(new Date(date));
                date.setDate(date.getDate() + 1);
            }
            return days;
        }

        function isWeekend(d) {
            return d.getDay() === 0 || d.getDay() === 6;
        }

        const daysGrid = document.getElementById('daysGrid');

        function renderDays() {
            daysGrid.innerHTML = '';
            const [y, m] = (document.getElementById('monthPicker').value || state.month).split('-');
            const all = getMonthDays(Number(y), Number(m));

            all.forEach(d => {
                const iso = d.toISOString().slice(0, 10);
                const btn = document.createElement('button');
                btn.className =
                    'bg-[var(--card)] p-3 rounded-2xl border border-gray-100 text-left hover-card flex flex-col gap-1 focus-ring';
                btn.setAttribute('aria-pressed', state.selected.has(iso));

                const title = document.createElement('div');
                title.className = 'font-semibold text-sm';
                title.textContent = iso;
                const sub = document.createElement('div');
                sub.className = 'text-xs text-[var(--muted)]';
                sub.textContent = d.toLocaleDateString('id-ID', {
                    weekday: 'long'
                }) + (isWeekend(d) ? ' • Libur' : ' • Kerja');

                if (state.selected.has(iso)) btn.classList.add('day-active');
                if (isWeekend(d)) btn.style.opacity = '.72';

                btn.appendChild(title);
                btn.appendChild(sub);
                btn.onclick = () => {
                    if (isWeekend(d)) return showToast('Tidak bisa memilih hari libur.');
                    const toggled = state.selected.has(iso);
                    if (toggled) {
                        state.selected.delete(iso);
                        btn.classList.remove('day-active');
                        btn.setAttribute('aria-pressed', false);
                    } else {
                        state.selected.add(iso);
                        btn.classList.add('day-active');
                        btn.setAttribute('aria-pressed', true);
                    }
                    updateSummary();
                    saveState();
                    showToast(iso + (toggled ? ' dibatalkan' : ' dipilih'));
                };

                btn.onkeydown = (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        btn.click();
                    }
                };

                daysGrid.appendChild(btn);
            });
            updateSummary();
        }

        function updateSummary() {
            document.getElementById('workingDaysCount').textContent = state.selected.size + ' hari';
            const target = Number(document.getElementById('targetInput').value) || state.saldo;
            const perDay = state.selected.size > 0 ? Math.floor(target / state.selected.size) : 0;
            document.getElementById('maxPerDay').textContent = currencyFormat(perDay);
            const percent = Math.min(100, Math.round((state.saldo / Math.max(1, target)) * 100));
            document.getElementById('progressArc').setAttribute('stroke-dasharray', percent + ' ' + (100 - percent));
            document.getElementById('progressLabel').textContent = percent + '%';
        }

        function applyTarget() {
            const val = Number(document.getElementById('targetInput').value);
            if (!val) return showToast('Masukkan target valid.');
            showToast('Target diterapkan: ' + currencyFormat(val));
            updateSummary();
        }

        function openFilter() {
            document.getElementById('filterModal').classList.remove('hidden');
            document.getElementById('filterModal').classList.add('flex');
        }

        function closeFilter() {
            document.getElementById('filterModal').classList.add('hidden');
            document.getElementById('filterModal').classList.remove('flex');
        }

        function applyFilter(e) {
            e.preventDefault();
            state.bank = document.getElementById('bankSelect').value;
            state.maxDate = document.getElementById('maxDate').value;
            document.getElementById('bankLabel').textContent = state.bank;
            saveState();
            closeFilter();
            showToast('Filter diterapkan • ' + state.bank);
        }

        function showToast(msg) {
            const area = document.getElementById('toastArea');
            const t = document.createElement('div');
            t.className = 'toast bg-slate-900 text-white text-sm px-4 py-2 rounded-xl shadow-lg';
            t.textContent = msg;
            area.appendChild(t);
            requestAnimationFrame(() => {
                t.style.opacity = 1;
                t.style.transform = 'translateY(0)';
            });
            setTimeout(() => {
                t.style.opacity = 0;
                t.style.transform = 'translateY(6px)';
                setTimeout(() => t.remove(), 220);
            }, 2000);
        }

        function autoGenerate() {
            const [y, m] = (document.getElementById('monthPicker').value || state.month).split('-');
            const all = getMonthDays(Number(y), Number(m));
            state.selected = new Set();
            all.forEach(d => {
                if (!isWeekend(d)) state.selected.add(d.toISOString().slice(0, 10));
            });
            saveState();
            renderDays();
            showToast('Working days otomatis dipilih untuk ' + (document.getElementById('monthPicker').value));
        }

        function downloadCSV() {
            const rows = [
                ['date', 'status']
            ];
            Array.from(state.selected).sort().forEach(d => rows.push([d, 'selected']));
            const csv = rows.map(r => r.map(c => '"' + String(c).replace(/"/g, '""') + '"').join(',')).join('
                    '); const blob=new Blob([csv],{type:'
                    text / csv '}); const url=URL.createObjectURL(blob); const a=document.createElement('
                    a '); a.href=url; a.download='
                    working_days.csv '; a.click(); URL.revokeObjectURL(url); }

                    document.getElementById('downloadBtn').addEventListener('click', downloadCSV); document.getElementById(
                        'exportBtn').addEventListener('click', downloadCSV); document.getElementById('monthPicker')
                    .addEventListener('change', (e) => {
                        state.month = e.target.value;
                        saveState();
                        renderDays();
                    });

                    // theme toggle
                    document.getElementById('themeToggle').addEventListener('click', () => {
                        const root = document.documentElement;
                        const isDark = root.getAttribute('data-theme') === 'dark';
                        root.setAttribute('data-theme', isDark ? 'light' : 'dark');
                        document.body.classList.toggle('text-white', !isDark);
                    });

                    // init
                    renderDays(); updateSummary();
    </script>
</body>

</html>
