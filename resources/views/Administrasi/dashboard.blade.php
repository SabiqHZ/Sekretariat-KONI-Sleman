<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>KONI Sleman — Dashboard Administrasi</title>
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />

        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            brand: {
                                yellow: "#f59e0b",
                                light: "#fef3c7",
                                pale: "#fff7ed",
                                ink: "#334155",
                            },
                        },
                        fontFamily: {
                            sans: [
                                "Inter",
                                "ui-sans-serif",
                                "system-ui",
                                "Segoe UI",
                                "Roboto",
                                "Ubuntu",
                                "Helvetica",
                                "Arial",
                            ],
                        },
                        boxShadow: {
                            soft: "0 14px 38px rgba(15,23,42,.08)",
                        },
                    },
                },
            };
        </script>
        <style>
            body {
                font-family: "Inter", "Segoe UI", system-ui, -apple-system, sans-serif;
            }
            .container {
                max-width: 1220px;
            }
            .scroll-slim {
                scrollbar-width: thin;
                scrollbar-color: #e2e8f0 transparent;
            }
            .scroll-slim::-webkit-scrollbar {
                height: 8px;
                width: 8px;
            }
            .scroll-slim::-webkit-scrollbar-thumb {
                background: #e2e8f0;
                border-radius: 999px;
            }
            .card-grad {
                background: linear-gradient(135deg, #fff, #fff4 40%),
                    linear-gradient(135deg, #fef3c7, #fff7ed);
            }
            .ring-brand {
                box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.15);
            }
            .glass {
                backdrop-filter: blur(10px);
            }
            .tag {
                box-shadow: inset 0 0 0 1px rgba(253, 224, 71, 0.6);
            }
        </style>
    </head>
    <body class="bg-white text-brand-ink">
        <div class="min-h-screen grid" style="grid-template-columns: 260px 1fr">
            <aside class="bg-white border-r border-slate-100 p-4 flex flex-col gap-3">
                <a href="{{ route('administrasi.dashboard') }}" class="flex items-center gap-3">
                    <span
                        class="h-10 w-10 rounded-xl flex items-center justify-center bg-gradient-to-br from-yellow-400 to-amber-500 text-white shadow-soft"
                        >🏅</span
                    >
                    <div class="leading-tight">
                        <div class="font-extrabold text-slate-900">KONI Sleman</div>
                        <div class="text-[11px] text-slate-500 tracking-wide">
                            Dashboard Administrasi
                        </div>
                    </div>
                </a>

                <nav class="mt-2 text-[15px] flex-1">
                    <a
                        class="flex items-center gap-3 px-3 py-2 rounded-lg bg-amber-50 text-amber-700 ring-brand"
                        href="{{ route('administrasi.dashboard') }}"
                    >
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 3 1.5 9l10.5 6 10.5-6L12 3Zm-7.5 9V21l7.5 3 7.5-3v-9" />
                        </svg>
                        Dasbor
                    </a>
                    <a
                        class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-50"
                        href="{{ route('administrasi.surat.index') }}"
                    >
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M21 6.75V19.5a.75.75 0 0 1-1.125.65L12 16.221l-7.875 3.93A.75.75 0 0 1 3 19.5V6.75l9-4.5 9 4.5Z"
                            />
                        </svg>
                        Arsip Surat
                    </a>
                    <a
                        class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-50"
                        href="{{ route('administrasi.surat.create') }}"
                    >
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 5.25a.75.75 0 0 1 .75.75v5.25h5.25a.75.75 0 0 1 0 1.5H12.75V18a.75.75 0 0 1-1.5 0v-5.25H6a.75.75 0 0 1 0-1.5h5.25V6a.75.75 0 0 1 .75-.75Z" />
                        </svg>
                        Unggah Surat
                    </a>
                    <a
                        class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-50"
                        href="{{ route('administrasi.jenis-surat.index') }}"
                    >
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M6 3.75h12l1.5 6H4.5L6 3.75Zm-1.5 7.5h15v9H4.5v-9Z"
                            />
                        </svg>
                        Jenis Surat
                    </a>
                </nav>

                <div class="mt-auto p-3 rounded-xl bg-amber-50 border border-amber-100">
                    <div class="text-xs text-amber-700">Sleman Tetap Ju4ra</div>
                    <div class="text-[11px] text-amber-700/80">Sembada Luar Biasa</div>
                </div>
            </aside>

            <main class="bg-white">
                <header class="sticky top-0 z-40 bg-white/85 glass border-b border-slate-100">
                    <div class="container mx-auto px-5 py-3 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <h1 class="text-lg font-extrabold text-slate-900">Dasbor Surat</h1>
                            <span class="text-xs px-2 py-1 rounded-full bg-amber-100 text-amber-700 tag">Real-time</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="hidden sm:block text-right">
                                <div class="text-sm font-semibold text-slate-900">{{ auth()->user()->name }}</div>
                                <div class="text-[12px] text-slate-500 uppercase tracking-wide">
                                    {{ auth()->user()->role ?? 'Pengguna' }}
                                </div>
                            </div>
                            <div class="relative">
                                <img
                                    src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=f59e0b&color=fff"
                                    class="h-9 w-9 rounded-full border border-amber-200"
                                    alt="profil"
                                />
                            </div>
                        </div>
                    </div>
                </header>

                <section class="container mx-auto px-5 py-6 space-y-8">
                    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
                        <article class="card-grad rounded-2xl p-5 border border-amber-100 shadow-soft">
                            <div class="flex items-center justify-between">
                                <h3 class="text-slate-900 font-semibold">Total Surat</h3>
                                <span class="text-amber-600">📄</span>
                            </div>
                            <div class="mt-3 text-3xl font-black text-slate-900">{{ number_format($totalSurat) }}</div>
                            <div class="text-xs text-slate-500">{{ $guestRate }}% berasal dari tamu</div>
                        </article>
                        <article class="card-grad rounded-2xl p-5 border border-amber-100 shadow-soft">
                            <div class="flex items-center justify-between">
                                <h3 class="text-slate-900 font-semibold">Surat Tergarap</h3>
                                <span class="text-amber-600">✅</span>
                            </div>
                            <div class="mt-3 text-3xl font-black text-slate-900">{{ number_format($suratSelesai) }}</div>
                            <div class="text-xs text-slate-500">{{ $completionRate }}% dari total surat</div>
                        </article>
                        <article class="card-grad rounded-2xl p-5 border border-amber-100 shadow-soft">
                            <div class="flex items-center justify-between">
                                <h3 class="text-slate-900 font-semibold">Menunggu Proses</h3>
                                <span class="text-amber-600">🗂️</span>
                            </div>
                            <div class="mt-3 text-3xl font-black text-slate-900">{{ number_format($suratBelum) }}</div>
                            <div class="text-xs text-slate-500">Perlu tindak lanjut</div>
                        </article>
                        <article class="card-grad rounded-2xl p-5 border border-amber-100 shadow-soft">
                            <div class="flex items-center justify-between">
                                <h3 class="text-slate-900 font-semibold">Surat Tamu</h3>
                                <span class="text-amber-600">👥</span>
                            </div>
                            <div class="mt-3 text-3xl font-black text-slate-900">{{ number_format($suratFromGuest) }}</div>
                            <div class="text-xs text-slate-500">Terhubung dengan layanan publik</div>
                        </article>
                    </div>

                    <div class="grid lg:grid-cols-5 gap-5">
                        <div class="lg:col-span-3 rounded-2xl border border-slate-200 p-5">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="font-semibold text-slate-900">Surat Masuk per Bulan</h3>
                                <button
                                    id="refreshLine"
                                    class="px-3 py-1.5 text-xs rounded-lg border border-slate-200 hover:bg-slate-50"
                                >
                                    Refresh
                                </button>
                            </div>
                            <canvas id="lineChart" height="120"></canvas>
                        </div>
                        <div class="lg:col-span-2 rounded-2xl border border-slate-200 p-5">
                            <h3 class="font-semibold text-slate-900 mb-3">Distribusi Surat per Jenis</h3>
                            <canvas id="barChart" height="120"></canvas>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 overflow-hidden">
                        <div class="p-4 flex flex-col md:flex-row md:items-center justify-between gap-3 bg-white">
                            <div class="flex items-center gap-2">
                                <div class="relative">
                                    <input
                                        id="filterSearch"
                                        class="w-[240px] rounded-lg bg-white border border-slate-200 pl-9 pr-3 py-2 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-amber-300"
                                        placeholder="Cari surat…"
                                        type="search"
                                    />
                                    <svg
                                        class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"
                                        viewBox="0 0 24 24"
                                        fill="currentColor"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M10.5 3.75a6.75 6.75 0 104.237 12.006l4.003 4.004a.75.75 0 101.06-1.06l-4.004-4.004A6.75 6.75 0 0010.5 3.75z"
                                        />
                                    </svg>
                                </div>
                                <select
                                    id="filterStatus"
                                    class="rounded-lg border border-slate-200 px-3 py-2 text-sm"
                                >
                                    <option value="">Semua Status</option>
                                    <option value="completed">Tergarap</option>
                                    <option value="pending">Belum Tergarap</option>
                                    <option value="guest">Surat Tamu</option>
                                </select>
                                <select
                                    id="filterJenis"
                                    class="rounded-lg border border-slate-200 px-3 py-2 text-sm"
                                >
                                    <option value="">Semua Jenis</option>
                                    @foreach ($jenisOptions as $jenis)
                                        <option value="{{ $jenis->jenis_surat }}">{{ $jenis->jenis_surat }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-center gap-2">
                                <a
                                    href="{{ route('administrasi.surat.create') }}"
                                    class="px-4 py-2 rounded-lg bg-amber-500 text-white hover:opacity-90 shadow-soft"
                                >
                                    + Tambah Surat
                                </a>
                            </div>
                        </div>

                        <div class="overflow-x-auto scroll-slim bg-white">
                            <table class="min-w-full text-sm">
                                <thead class="bg-amber-50/60 text-slate-700">
                                    <tr>
                                        <th class="text-left px-4 py-3 w-12">Selesai</th>
                                        <th class="text-left px-4 py-3">Nomor Surat</th>
                                        <th class="text-left px-4 py-3">Jenis</th>
                                        <th class="text-left px-4 py-3">Pengirim</th>
                                        <th class="text-left px-4 py-3">Tanggal Masuk</th>
                                        <th class="text-left px-4 py-3">Status</th>
                                        <th class="text-right px-4 py-3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody" class="divide-y divide-slate-100">
                                    <tr>
                                        <td colspan="7" class="px-4 py-6 text-center text-slate-500">Memuat data…</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </main>
        </div>

        <div id="toast" class="fixed bottom-4 right-4 z-50 hidden">
            <div class="bg-white border border-slate-200 rounded-xl px-4 py-3 shadow-soft flex items-center gap-2">
                <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                <span id="toastText" class="text-sm">Tersimpan.</span>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const SURAT_DATA = @json($tableData);
            const MONTH_LABELS = @json($monthlyLabels);
            const MONTH_COUNTS = @json($monthlyCounts);
            const JENIS_LABELS = @json($jenisLabels);
            const JENIS_SELESAI = @json($jenisSelesai);
            const JENIS_BELUM = @json($jenisBelum);
            const JENIS_GUEST = @json($jenisGuest);
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const baseSuratUrl = @json(url('administrasi/dashboard/surat'));

            const tbody = document.getElementById('tbody');
            const filterSearch = document.getElementById('filterSearch');
            const filterStatus = document.getElementById('filterStatus');
            const filterJenis = document.getElementById('filterJenis');

            function statusBadge(item) {
                if (item.is_completed) {
                    return '<span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-700">Tergarap</span>';
                }
                if (item.is_from_guest) {
                    return '<span class="px-2 py-1 rounded-full text-xs bg-amber-100 text-amber-700">Surat Tamu</span>';
                }
                return '<span class="px-2 py-1 rounded-full text-xs bg-slate-100 text-slate-700">Menunggu</span>';
            }

            function rowTemplate(item) {
                const editUrl = `${baseSuratUrl}/${item.id}/edit`;
                const pdfUrl = `${baseSuratUrl}/${item.id}/pdf`;
                const toggleAction = `${baseSuratUrl}/${item.id}/toggle`;
                const checked = item.is_completed ? 'checked' : '';
                const guestClass = item.is_from_guest ? 'bg-amber-50/60' : '';
                return `
                <tr class="hover:bg-amber-50/30 ${guestClass}" data-id="${item.id}">
                    <td class="px-4 py-3 align-top">
                        <label class="inline-flex items-center">
                            <input type="checkbox" data-toggle="${toggleAction}" class="h-4 w-4 rounded border-slate-300 text-amber-500 focus:ring-amber-300" ${checked} />
                        </label>
                    </td>
                    <td class="px-4 py-3">
                        <div class="font-semibold text-slate-900">${item.nomor_surat}</div>
                        <div class="text-xs text-slate-500">${item.tanggal_surat || '-'}</div>
                    </td>
                    <td class="px-4 py-3">${item.jenis}</td>
                    <td class="px-4 py-3">
                        <div class="text-slate-900">${item.pengirim}</div>
                        ${item.is_from_guest ? '<div class="text-xs text-amber-600">Pengunjung</div>' : ''}
                    </td>
                    <td class="px-4 py-3">${item.tanggal_masuk || '-'}</td>
                    <td class="px-4 py-3">${statusBadge(item)}</td>
                    <td class="px-4 py-3 text-right space-x-2">
                        <a href="${editUrl}" class="px-3 py-1.5 rounded-lg border border-slate-200 hover:bg-slate-50">Edit</a>
                        <a href="${pdfUrl}" class="px-3 py-1.5 rounded-lg border border-slate-200 hover:bg-slate-50">PDF</a>
                    </td>
                </tr>`;
            }

            function renderTable() {
                const term = (filterSearch.value || '').toLowerCase();
                const status = filterStatus.value;
                const jenis = filterJenis.value;

                const rows = SURAT_DATA.filter((item) => {
                    const matchesTerm = !term || `${item.nomor_surat} ${item.pengirim} ${item.jenis}`.toLowerCase().includes(term);
                    const matchesStatus =
                        !status ||
                        (status === 'completed' && item.is_completed) ||
                        (status === 'pending' && !item.is_completed) ||
                        (status === 'guest' && item.is_from_guest);
                    const matchesJenis = !jenis || item.jenis === jenis;
                    return matchesTerm && matchesStatus && matchesJenis;
                })
                    .map((item) => rowTemplate(item))
                    .join('');

                tbody.innerHTML = rows || '<tr><td colspan="7" class="px-4 py-6 text-center text-slate-500">Tidak ada data…</td></tr>';
                bindCheckboxEvents();
            }

            function bindCheckboxEvents() {
                tbody.querySelectorAll('input[type="checkbox"]').forEach((checkbox) => {
                    checkbox.addEventListener('change', async (event) => {
                        const url = checkbox.getAttribute('data-toggle');
                        const row = checkbox.closest('tr');
                        const suratId = Number(row?.dataset.id);
                        const payload = { is_completed: checkbox.checked };
                        try {
                            const response = await fetch(url, {
                                method: 'PATCH',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json',
                                },
                                body: JSON.stringify(payload),
                            });
                            if (!response.ok) {
                                throw new Error('Gagal memperbarui status');
                            }
                            const target = SURAT_DATA.find((item) => item.id === suratId);
                            if (target) {
                                target.is_completed = checkbox.checked;
                            }
                            toast('Status surat diperbarui');
                            renderTable();
                        } catch (error) {
                            checkbox.checked = !checkbox.checked;
                            toast('Terjadi kesalahan, coba lagi');
                            console.error(error);
                        }
                    });
                });
            }

            function toast(text) {
                const toastEl = document.getElementById('toast');
                document.getElementById('toastText').textContent = text;
                toastEl.classList.remove('hidden');
                clearTimeout(toastEl.dataset.timeout);
                toastEl.dataset.timeout = setTimeout(() => toastEl.classList.add('hidden'), 1800);
            }

            filterSearch.addEventListener('input', renderTable);
            filterStatus.addEventListener('change', renderTable);
            filterJenis.addEventListener('change', renderTable);

            renderTable();

            const lineCtx = document.getElementById('lineChart');
            const barCtx = document.getElementById('barChart');
            const brandYellow = '#f59e0b';
            const brandLight = '#fde68a';
            const brandLine = '#eab308';

            let lineChart = new Chart(lineCtx, {
                type: 'line',
                data: {
                    labels: MONTH_LABELS,
                    datasets: [
                        {
                            label: 'Surat Masuk',
                            data: MONTH_COUNTS,
                            borderColor: brandYellow,
                            backgroundColor: brandLight,
                            fill: true,
                            tension: 0.35,
                            pointRadius: 3,
                            pointBackgroundColor: brandLine,
                        },
                    ],
                },
                options: {
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false } },
                        y: { grid: { color: 'rgba(0,0,0,.05)' }, ticks: { precision: 0 } },
                    },
                },
            });

            let barChart = new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: JENIS_LABELS,
                    datasets: [
                        {
                            label: 'Tergarap',
                            backgroundColor: '#34d399',
                            data: JENIS_SELESAI,
                        },
                        {
                            label: 'Belum',
                            backgroundColor: '#fbbf24',
                            data: JENIS_BELUM,
                        },
                        {
                            label: 'Surat Tamu',
                            backgroundColor: '#fef3c7',
                            data: JENIS_GUEST,
                        },
                    ],
                },
                options: {
                    plugins: { legend: { position: 'bottom' } },
                    scales: {
                        x: { stacked: true },
                        y: { stacked: true, grid: { color: 'rgba(0,0,0,.05)' }, ticks: { precision: 0 } },
                    },
                },
            });

            document.getElementById('refreshLine').addEventListener('click', () => {
                const newData = lineChart.data.datasets[0].data.map((value) => {
                    const randomFactor = 0.9 + Math.random() * 0.2;
                    return Math.max(0, Math.round(value * randomFactor));
                });
                lineChart.data.datasets[0].data = newData;
                lineChart.update();
                toast('Data grafik diperbarui');
            });
        </script>
    </body>
</html>
