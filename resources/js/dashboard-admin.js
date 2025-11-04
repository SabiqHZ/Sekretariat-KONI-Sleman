const $ = (selector, scope = document) => scope.querySelector(selector);
const $$ = (selector, scope = document) => Array.from(scope.querySelectorAll(selector));

const palette = {
    primary: '#eb5120',
    secondary: '#f2d52c',
    ink: '#1e3a8a',
};

window.scrollToSection = (id) => {
    const section = document.getElementById(id);
    if (!section) return;
    section.scrollIntoView({ behavior: 'smooth', block: 'start' });
};

const activateNavOnScroll = () => {
    const sections = $$('section[id]');
    const navButtons = $$('.nav-pill');

    const highlight = () => {
        const scrollY = window.scrollY + 120;
        let activeId = sections[0]?.id;
        sections.forEach((section) => {
            if (scrollY >= section.offsetTop) {
                activeId = section.id;
            }
        });
        navButtons.forEach((btn) => {
            btn.classList.toggle('active', btn.getAttribute('onclick')?.includes(activeId));
        });
    };

    highlight();
    window.addEventListener('scroll', highlight, { passive: true });
};

const setupProfileDropdown = () => {
    const trigger = $('#profileButton');
    const menu = $('#dropdownMenu');
    if (!trigger || !menu) return;

    trigger.addEventListener('click', (event) => {
        event.stopPropagation();
        menu.classList.toggle('show');
    });

    document.addEventListener('click', (event) => {
        if (!menu.contains(event.target) && !trigger.contains(event.target)) {
            menu.classList.remove('show');
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            menu.classList.remove('show');
        }
    });
};

const withFallback = (value, fallback = 0) => (Number.isFinite(value) ? value : fallback);

const buildTrendChart = (canvas, dataset) => {
    if (!canvas || !window.Chart) return null;
    const ctx = canvas.getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, canvas.height);
    gradient.addColorStop(0, 'rgba(235, 81, 32, 0.25)');
    gradient.addColorStop(1, 'rgba(235, 81, 32, 0.02)');

    const labels = dataset.map((item) => item.label);
    const values = dataset.map((item) => withFallback(item.total));

    return new window.Chart(canvas, {
        type: 'line',
        data: {
            labels,
            datasets: [
                {
                    label: 'Total surat',
                    data: values,
                    borderColor: palette.primary,
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.35,
                    pointRadius: 4,
                    pointBackgroundColor: palette.secondary,
                    pointBorderWidth: 0,
                },
            ],
        },
        options: {
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label(context) {
                            return `${context.parsed.y} surat`;
                        },
                    },
                },
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: 'rgba(30,58,138,0.6)' },
                },
                y: {
                    grid: { color: 'rgba(30,58,138,0.1)' },
                    ticks: {
                        precision: 0,
                        color: 'rgba(30,58,138,0.6)',
                        callback(value) {
                            return `${value}`;
                        },
                    },
                },
            },
        },
    });
};

const buildOriginChart = (canvas, dataset) => {
    if (!canvas || !window.Chart) return null;
    const values = Object.values(dataset || {});
    const labels = Object.keys(dataset || {}).map((key) => key.charAt(0).toUpperCase() + key.slice(1));

    return new window.Chart(canvas, {
        type: 'doughnut',
        data: {
            labels,
            datasets: [
                {
                    data: values,
                    backgroundColor: [palette.primary, palette.secondary],
                    borderWidth: 0,
                },
            ],
        },
        options: {
            cutout: '62%',
            plugins: {
                legend: { position: 'bottom', labels: { color: 'rgba(30,58,138,0.7)' } },
            },
        },
    });
};

const buildJenisChart = (canvas, dataset) => {
    if (!canvas || !window.Chart) return null;
    const labels = dataset.map((item) => item.jenis);
    const values = dataset.map((item) => withFallback(item.total));

    return new window.Chart(canvas, {
        type: 'bar',
        data: {
            labels,
            datasets: [
                {
                    data: values,
                    backgroundColor: palette.primary,
                    borderRadius: 12,
                },
            ],
        },
        options: {
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label(context) {
                            return `${context.parsed.y} surat`;
                        },
                    },
                },
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: 'rgba(30,58,138,0.7)' },
                },
                y: {
                    grid: { color: 'rgba(30,58,138,0.08)' },
                    ticks: {
                        precision: 0,
                        color: 'rgba(30,58,138,0.6)',
                    },
                },
            },
        },
    });
};

const setupCharts = () => {
    const data = window.dashboardData || {};
    const trendCanvas = document.getElementById('suratTrendChart');
    const jenisCanvas = document.getElementById('jenisChart');
    const originCanvas = document.getElementById('originChart');
    const emptyState = document.querySelector('[data-chart-empty]');
    let trendChart = null;

    const buildAll = () => {
        const monthly = Array.isArray(data.monthlyCounts) ? data.monthlyCounts : [];
        const jenis = Array.isArray(data.suratByJenis) ? data.suratByJenis : [];
        const origin = data.originDataset || {};

        if (trendChart) {
            trendChart.destroy();
        }
        if (trendCanvas) {
            if (monthly.length) {
                trendChart = buildTrendChart(trendCanvas, monthly);
                if (emptyState) emptyState.hidden = true;
            } else if (emptyState) {
                emptyState.hidden = false;
            }
        }

        if (jenisCanvas) {
            if (jenisCanvas.chart) jenisCanvas.chart.destroy();
            jenisCanvas.chart = buildJenisChart(jenisCanvas, jenis);
        }

        if (originCanvas) {
            if (originCanvas.chart) originCanvas.chart.destroy();
            originCanvas.chart = buildOriginChart(originCanvas, origin);
        }
    };

    buildAll();

    const refreshButton = document.getElementById('refreshTrend');
    if (refreshButton) {
        refreshButton.addEventListener('click', () => {
            if (!Array.isArray(data.monthlyCounts)) return;
            data.monthlyCounts = data.monthlyCounts.map((item) => ({
                ...item,
                total: Math.max(0, Math.round(item.total * (0.9 + Math.random() * 0.25))),
            }));
            buildAll();
        });
    }
};

const setupLetterFilter = () => {
    const buttons = $$('[data-letter-filter]');
    const rows = $$('[data-letter-item]');
    if (!buttons.length || !rows.length) return;

    const applyFilter = (filter) => {
        rows.forEach((row) => {
            const origin = row.dataset.origin;
            const visible = filter === 'all' || origin === filter;
            row.style.display = visible ? '' : 'none';
        });
    };

    buttons.forEach((button) => {
        button.addEventListener('click', () => {
            buttons.forEach((btn) => btn.classList.remove('active'));
            button.classList.add('active');
            applyFilter(button.dataset.letterFilter || 'all');
        });
    });
};

document.addEventListener('DOMContentLoaded', () => {
    activateNavOnScroll();
    setupProfileDropdown();
    setupCharts();
    setupLetterFilter();
});

window.addEventListener('load', () => {
    document.body.classList.add('loaded');
});
