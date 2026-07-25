@extends('layouts.materialized')

@section('header-script')
<style type="text/css">
    .kpi-card {
        border-radius: 8px;
        transition: transform 0.2s ease;
    }
    .kpi-card:hover {
        transform: translateY(-4px);
    }
    .kpi-card .card-content {
        padding: 20px 15px;
    }
    .kpi-value {
        font-size: 2.2rem;
        font-weight: 700;
        line-height: 1.2;
        margin-bottom: 4px;
    }
    .kpi-label {
        font-size: 0.85rem;
        opacity: 0.9;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .kpi-sub {
        font-size: 0.75rem;
        opacity: 0.75;
        margin-top: 6px;
    }
    .chart-card {
        border-radius: 8px;
    }
    .chart-card .card-content {
        padding: 20px;
    }
    .chart-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #37474f;
        margin-bottom: 15px;
    }
    .chart-container {
        position: relative;
        width: 100%;
    }
    .stat-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f5f5f5;
    }
    .stat-row:last-child {
        border-bottom: none;
    }
    .stat-row .label {
        font-size: 0.9rem;
        color: #616161;
    }
    .stat-row .value {
        font-size: 1rem;
        font-weight: 600;
        color: #37474f;
    }
    .progress-bar-wrapper {
        background: #e0e0e0;
        border-radius: 10px;
        height: 12px;
        overflow: hidden;
        margin: 8px 0;
    }
    .progress-bar-fill {
        height: 100%;
        border-radius: 10px;
        transition: width 1s ease;
    }
    .badge-stat {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        color: #fff;
    }
    .program-table {
        width: 100%;
        border-collapse: collapse;
    }
    .program-table th {
        text-align: left;
        padding: 10px 8px;
        font-size: 0.8rem;
        text-transform: uppercase;
        color: #9e9e9e;
        border-bottom: 2px solid #e0e0e0;
    }
    .program-table td {
        padding: 10px 8px;
        font-size: 0.9rem;
        border-bottom: 1px solid #f5f5f5;
    }
    .program-table tr:hover {
        background-color: #fafafa;
    }
    .program-bar {
        height: 8px;
        border-radius: 4px;
        background: #e0e0e0;
        overflow: hidden;
        min-width: 60px;
    }
    .program-bar-fill {
        height: 100%;
        border-radius: 4px;
    }
    .semester-badge {
        display: inline-block;
        padding: 6px 16px;
        border-radius: 20px;
        background: #e3f2fd;
        color: #1565c0;
        font-weight: 600;
        font-size: 0.9rem;
    }
    table tr td, table tr th {
        border: none !important;
    }
</style>
@endsection

@section('footer-script')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script type="text/javascript">
window.onload = function() {

    var trendData = @json($data->trend);

    // --- Trend Santri Chart ---
    if (document.getElementById('trendChart')) {
        var ctx = document.getElementById('trendChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: trendData.map(function(d) { return d.semester; }),
                datasets: [
                    {
                        label: 'Santri',
                        data: trendData.map(function(d) { return d.santri; }),
                        borderColor: '#1565c0',
                        backgroundColor: 'rgba(21, 101, 192, 0.1)',
                        borderWidth: 3,
                        pointRadius: 5,
                        pointBackgroundColor: '#1565c0',
                        fill: true,
                        tension: 0.3
                    },
                    {
                        label: 'Halaqoh',
                        data: trendData.map(function(d) { return d.halaqoh; }),
                        borderColor: '#00897b',
                        backgroundColor: 'rgba(0, 137, 123, 0.05)',
                        borderWidth: 2,
                        pointRadius: 4,
                        pointBackgroundColor: '#00897b',
                        fill: false,
                        tension: 0.3
                    },
                    {
                        label: 'Pengajar',
                        data: trendData.map(function(d) { return d.pengajar; }),
                        borderColor: '#f4511e',
                        backgroundColor: 'rgba(244, 81, 30, 0.05)',
                        borderWidth: 2,
                        pointRadius: 4,
                        pointBackgroundColor: '#f4511e',
                        fill: false,
                        tension: 0.3
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f5f5f5' } },
                    x: { grid: { display: false } }
                },
                plugins: {
                    legend: { position: 'bottom', labels: { padding: 20, usePointStyle: true } }
                }
            }
        });
    }

    // --- Gender Pie Chart ---
    var genderData = @json($data->gender_dist);
    if (document.getElementById('genderChart') && genderData.length > 0) {
        var genderColors = { 'Ikhwan': '#1565c0', 'Akhwat': '#e91e63', 'Belum Diisi': '#bdbdbd' };
        var ctx2 = document.getElementById('genderChart').getContext('2d');
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: genderData.map(function(d) { return d.label; }),
                datasets: [{
                    data: genderData.map(function(d) { return d.total; }),
                    backgroundColor: genderData.map(function(d) { return genderColors[d.label] || '#9e9e9e'; }),
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: { position: 'bottom', labels: { padding: 15, usePointStyle: true } }
                }
            }
        });
    }

    // --- Age Distribution Chart ---
    var ageData = @json($data->age_dist);
    if (document.getElementById('ageChart') && ageData.length > 0) {
        var ageColors = ['#4fc3f7','#29b6f6','#03a9f4','#039be5','#0288d1','#0277bd','#01579b','#bdbdbd'];
        var ctx4 = document.getElementById('ageChart').getContext('2d');
        new Chart(ctx4, {
            type: 'bar',
            data: {
                labels: ageData.map(function(d) { return d.age_range; }),
                datasets: [{
                    label: 'Jumlah Santri',
                    data: ageData.map(function(d) { return d.total; }),
                    backgroundColor: ageData.map(function(_, i) { return ageColors[i % ageColors.length]; }),
                    borderRadius: 4,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f5f5f5' } },
                    x: { grid: { display: false } }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });
    }

    // --- Program Bar Chart ---
    var programData = @json($data->program_dist);
    if (document.getElementById('programChart') && programData.length > 0) {
        var programColors = [
            '#1565c0','#00897b','#f4511e','#8e24aa','#fdd835',
            '#43a047','#e91e63','#5e35b1','#00acc1','#ff8f00',
            '#6d4c41','#546e7a','#d81b60','#1e88e5','#7cb342',
            '#f4511e','#3949ab','#00838f','#c62828','#ad1457'
        ];
        var ctx3 = document.getElementById('programChart').getContext('2d');
        new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: programData.map(function(d) { return d.program_name; }),
                datasets: [{
                    label: 'Jumlah Santri',
                    data: programData.map(function(d) { return d.total_santri; }),
                    backgroundColor: programData.map(function(_, i) { return programColors[i % programColors.length]; }),
                    borderRadius: 4,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                scales: {
                    x: { beginAtZero: true, grid: { color: '#f5f5f5' } },
                    y: { grid: { display: false }, ticks: { font: { size: 11 } } }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });
    }
};
</script>
@endsection

@section('content')

    <!--breadcrumbs start-->
    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                    <h5 class="breadcrumbs-title">Dashboard</h5>
                    <ol class="breadcrumbs">
                        <li><a href="/">Dashboard</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs end-->

    <!--start container-->
    <div class="container">
        <div class="section">

            {{-- Semester Filter --}}
            <div class="row" style="margin-bottom: 10px;">
                <div class="col s12" style="display: flex; align-items: center; flex-wrap: wrap; gap: 10px;">
                    <form method="GET" action="{{ route('dashboard') }}" style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <label for="semester_id" style="font-weight: 600; color: #37474f; white-space: nowrap;">Semester:</label>
                        <select name="semester_id" id="semester_id" onchange="this.form.submit()" class="browser-default" style="display: inline-block; width: auto; min-width: 180px; height: 36px; border: 1px solid #ccc; border-radius: 4px; padding: 0 10px; background: #fff;">
                            @foreach($data->semester_list as $sem)
                                <option value="{{ $sem->id }}" {{ $sem->id == $data->selected_semester_id ? 'selected' : '' }}>
                                    Semester {{ $sem->name }} {{ $sem->active ? '(Aktif)' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                    @if($data->semester_active->start_period && $data->semester_active->end_period)
                        <span style="color: #9e9e9e; font-size: 0.85rem;">
                            {{ \Carbon\Carbon::parse($data->semester_active->start_period)->format('d M Y') }}
                            &mdash;
                            {{ \Carbon\Carbon::parse($data->semester_active->end_period)->format('d M Y') }}
                        </span>
                    @endif
                </div>
            </div>

            {{-- KPI Cards --}}
            <div class="row">
                <div class="col s6 m6 l3">
                    <div class="card kpi-card" style="background: linear-gradient(135deg, #1565c0, #1976d2);">
                        <div class="card-content white-text center-align">
                            <p class="kpi-value">{{ number_format($data->count_santri) }}</p>
                            <p class="kpi-label">Total Santri</p>
                            <p class="kpi-sub">Aktif</p>
                        </div>
                    </div>
                </div>
                <div class="col s6 m6 l3">
                    <div class="card kpi-card" style="background: linear-gradient(135deg, #00897b, #00acc1);">
                        <div class="card-content white-text center-align">
                            <p class="kpi-value">{{ number_format($data->count_pengajar) }}</p>
                            <p class="kpi-label">Total Pengajar</p>
                            <p class="kpi-sub">Rasio 1 : {{ $data->rasio_santri_pengajar }}</p>
                        </div>
                    </div>
                </div>
                <div class="col s6 m6 l3">
                    <div class="card kpi-card" style="background: linear-gradient(135deg, #f4511e, #ff7043);">
                        <div class="card-content white-text center-align">
                            <p class="kpi-value">{{ number_format($data->count_halaqoh) }}</p>
                            <p class="kpi-label">Total Halaqoh</p>
                            <p class="kpi-sub">{{ $data->count_program }} Program</p>
                        </div>
                    </div>
                </div>
                <div class="col s6 m6 l3">
                    <div class="card kpi-card" style="background: linear-gradient(135deg, #6a1b9a, #8e24aa);">
                        <div class="card-content white-text center-align">
                            <p class="kpi-value">{{ number_format($data->kbm_total) }}</p>
                            <p class="kpi-label">Sesi KBM</p>
                            <p class="kpi-sub">{{ $data->kbm_coverage }}% Coverage</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Trend Chart + Gender --}}
            <div class="row">
                <div class="col s12 l8">
                    <div class="card chart-card">
                        <div class="card-content">
                            <p class="chart-title">Tren Pertumbuhan per Semester</p>
                            <div class="chart-container" style="height: 300px;">
                                <canvas id="trendChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12 l4">
                    <div class="card chart-card">
                        <div class="card-content">
                            <p class="chart-title">Distribusi Gender</p>
                            <div class="chart-container" style="height: 220px;">
                                <canvas id="genderChart"></canvas>
                            </div>
                            <div style="margin-top: 10px;">
                                @foreach($data->gender_dist as $g)
                                <div class="stat-row">
                                    <span class="label">{{ $g->label }}</span>
                                    <span class="value">{{ number_format($g->total) }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Age Distribution --}}
            <div class="row">
                <div class="col s12 l8">
                    <div class="card chart-card">
                        <div class="card-content">
                            <p class="chart-title">Distribusi Usia Santri</p>
                            <div class="chart-container" style="height: 280px;">
                                <canvas id="ageChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12 l4">
                    <div class="card chart-card">
                        <div class="card-content">
                            <p class="chart-title">Detail Usia</p>
                            @php $totalAge = $data->age_dist->sum('total'); @endphp
                            @foreach($data->age_dist as $age)
                            <div class="stat-row">
                                <span class="label">{{ $age->age_range }}</span>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div class="program-bar" style="width: 80px;">
                                        <div class="program-bar-fill" style="width: {{ $totalAge > 0 ? round(($age->total / $totalAge) * 100) : 0 }}%; background: #0288d1;"></div>
                                    </div>
                                    <span class="value">{{ $age->total }}</span>
                                    <span style="color: #9e9e9e; font-size: 0.75rem;">{{ $totalAge > 0 ? round(($age->total / $totalAge) * 100, 1) : 0 }}%</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Daftar Ulang + Day Distribution --}}
            <div class="row">
                <div class="col s12 m6 l4">
                    <div class="card chart-card">
                        <div class="card-content">
                            <p class="chart-title">Daftar Ulang</p>
                            <div style="text-align: center; margin: 15px 0;">
                                <span style="font-size: 2.5rem; font-weight: 700; color: #1565c0;">{{ $data->du_percent }}%</span>
                                <p style="color: #9e9e9e; font-size: 0.85rem;">Terverifikasi</p>
                            </div>
                            <div class="progress-bar-wrapper">
                                <div class="progress-bar-fill" style="width: {{ $data->du_percent }}%; background: linear-gradient(90deg, #1565c0, #42a5f5);"></div>
                            </div>
                            <div class="stat-row">
                                <span class="label">Terverifikasi</span>
                                <span class="badge-stat" style="background: #43a047;">{{ number_format($data->du_verified) }}</span>
                            </div>
                            <div class="stat-row">
                                <span class="label">Belum Verifikasi</span>
                                <span class="badge-stat" style="background: #ff8f00;">{{ number_format($data->du_pending) }}</span>
                            </div>
                            <div class="stat-row">
                                <span class="label">Total Pendaftar</span>
                                <span class="value">{{ number_format($data->du_total) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12 m6 l4">
                    <div class="card chart-card">
                        <div class="card-content">
                            <p class="chart-title">Aktivitas KBM</p>
                            <div style="text-align: center; margin: 15px 0;">
                                <span style="font-size: 2.5rem; font-weight: 700; color: #00897b;">{{ $data->kbm_coverage }}%</span>
                                <p style="color: #9e9e9e; font-size: 0.85rem;">Halaqoh Aktif KBM</p>
                            </div>
                            <div class="progress-bar-wrapper">
                                <div class="progress-bar-fill" style="width: {{ $data->kbm_coverage }}%; background: linear-gradient(90deg, #00897b, #4db6ac);"></div>
                            </div>
                            <div class="stat-row">
                                <span class="label">Total Sesi KBM</span>
                                <span class="value">{{ number_format($data->kbm_total) }}</span>
                            </div>
                            <div class="stat-row">
                                <span class="label">Halaqoh Melapor</span>
                                <span class="value">{{ $data->kbm_halaqoh_aktif }} / {{ $data->count_halaqoh }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12 m12 l4">
                    <div class="card chart-card">
                        <div class="card-content">
                            <p class="chart-title">Distribusi Hari</p>
                            @foreach($data->day_dist as $day)
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-weight: 600; color: #37474f;">{{ $day->day }}</span>
                                    <span style="color: #9e9e9e; font-size: 0.85rem;">{{ $day->total_halaqoh }} halaqoh &middot; {{ $day->total_santri }} santri</span>
                                </div>
                                @php
                                    $maxSantri = $data->day_dist->max('total_santri');
                                    $pct = $maxSantri > 0 ? round(($day->total_santri / $maxSantri) * 100) : 0;
                                @endphp
                                <div class="progress-bar-wrapper">
                                    <div class="progress-bar-fill" style="width: {{ $pct }}%; background: linear-gradient(90deg, #f4511e, #ff8a65);"></div>
                                </div>
                            </div>
                            @endforeach

                            <div style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #f0f0f0;">
                                <p class="chart-title" style="margin-bottom: 10px;">Rasio Pengajar</p>
                                <div class="stat-row">
                                    <span class="label">Santri / Pengajar</span>
                                    <span class="value">1 : {{ $data->rasio_santri_pengajar }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Program Distribution --}}
            <div class="row">
                <div class="col s12 l7">
                    <div class="card chart-card">
                        <div class="card-content">
                            <p class="chart-title">Distribusi Santri per Program</p>
                            <div class="chart-container" style="height: {{ max(300, count($data->program_dist) * 28) }}px;">
                                <canvas id="programChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12 l5">
                    <div class="card chart-card">
                        <div class="card-content">
                            <p class="chart-title">Detail Program</p>
                            <div style="max-height: 500px; overflow-y: auto;">
                                <table class="program-table">
                                    <thead>
                                        <tr>
                                            <th>Program</th>
                                            <th style="text-align: right;">Santri</th>
                                            <th style="text-align: right;">Halaqoh</th>
                                            <th style="text-align: right;">Rasio</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data->program_dist as $p)
                                        <tr>
                                            <td>{{ $p->program_name }}</td>
                                            <td style="text-align: right; font-weight: 600;">{{ $p->total_santri }}</td>
                                            <td style="text-align: right;">{{ $p->total_halaqoh }}</td>
                                            <td style="text-align: right; color: #9e9e9e;">
                                                {{ $p->total_halaqoh > 0 ? round($p->total_santri / $p->total_halaqoh, 1) : '-' }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr style="font-weight: 700; border-top: 2px solid #e0e0e0;">
                                            <td>Total</td>
                                            <td style="text-align: right;">{{ $data->count_santri }}</td>
                                            <td style="text-align: right;">{{ $data->count_halaqoh }}</td>
                                            <td style="text-align: right; color: #9e9e9e;">{{ $data->rasio_santri_pengajar }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Semester Comparison Table --}}
            <div class="row">
                <div class="col s12">
                    <div class="card chart-card">
                        <div class="card-content">
                            <p class="chart-title">Perbandingan antar Semester</p>
                            <div style="overflow-x: auto;">
                                <table class="program-table">
                                    <thead>
                                        <tr>
                                            <th>Semester</th>
                                            <th style="text-align: right;">Santri</th>
                                            <th style="text-align: right;">Pengajar</th>
                                            <th style="text-align: right;">Halaqoh</th>
                                            <th style="text-align: right;">Rasio S/P</th>
                                            <th style="text-align: center;">Pertumbuhan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data->trend as $i => $t)
                                        <tr @if($i == count($data->trend) - 1) style="background: #e8f5e9; font-weight: 600;" @endif>
                                            <td>{{ $t['semester'] }}</td>
                                            <td style="text-align: right;">{{ number_format($t['santri']) }}</td>
                                            <td style="text-align: right;">{{ number_format($t['pengajar']) }}</td>
                                            <td style="text-align: right;">{{ number_format($t['halaqoh']) }}</td>
                                            <td style="text-align: right;">
                                                {{ $t['pengajar'] > 0 ? round($t['santri'] / $t['pengajar'], 1) : '-' }}
                                            </td>
                                            <td style="text-align: center;">
                                                @if($i > 0 && $data->trend[$i-1]['santri'] > 0)
                                                    @php
                                                        $growth = round((($t['santri'] - $data->trend[$i-1]['santri']) / $data->trend[$i-1]['santri']) * 100, 1);
                                                    @endphp
                                                    @if($growth > 0)
                                                        <span class="badge-stat" style="background: #43a047;">+{{ $growth }}%</span>
                                                    @elseif($growth < 0)
                                                        <span class="badge-stat" style="background: #e53935;">{{ $growth }}%</span>
                                                    @else
                                                        <span class="badge-stat" style="background: #9e9e9e;">0%</span>
                                                    @endif
                                                @else
                                                    <span style="color: #bdbdbd;">&mdash;</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!--end container-->
@endsection
