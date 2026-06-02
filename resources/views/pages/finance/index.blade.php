@extends('layouts.materialized')

@section('header-script')
<style type="text/css">
    table td, table th {
        border: 1px solid #ddd;
    }
    .summary-card .card-content { padding: 16px; }
    .summary-card .amount { font-size: 1.6rem; font-weight: 600; }
    .text-right { text-align: right; }
</style>
@endsection

@section('content')

        <!--breadcrumbs start-->
        <div id="breadcrumbs-wrapper">
          <div class="container">
            <div class="row">
              <div class="col s12">
                <h5 class="breadcrumbs-title">Keuangan</h5>
                <ol class="breadcrumbs">
                    <li><a href="/" class="cyan-text">Dashboard</a></li>
                    <li class="active">Kas Masuk &amp; Keluar</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!--breadcrumbs end-->


        <!--start container-->
        <div class="container" style="margin-bottom: 25px">
            <div class="section">

                @if(session('success'))
                <div class="card-panel green lighten-4 green-text text-darken-4">{{ session('success') }}</div>
                @endif

                <!-- Ringkasan saldo -->
                <div class="row">
                    <div class="col s12 m4">
                        <div class="card summary-card green lighten-5">
                            <div class="card-content">
                                <span class="card-title">Kas Masuk</span>
                                <div class="amount green-text text-darken-2">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m4">
                        <div class="card summary-card red lighten-5">
                            <div class="card-content">
                                <span class="card-title">Kas Keluar</span>
                                <div class="amount red-text text-darken-2">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m4">
                        <div class="card summary-card cyan lighten-5">
                            <div class="card-content">
                                <span class="card-title">Saldo</span>
                                <div class="amount cyan-text text-darken-2">Rp {{ number_format($saldo, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12">
                        <div class="card">
                            <div class="card-content">
                                <span class="card-title">Daftar Transaksi</span>
                                <a href="{{ route('keuangan.export', request()->only(['jenis', 'start_date', 'end_date'])) }}" class="btn waves-effect waves-light green right" style="margin-left: 8px;"><i class="mdi-file-file-download left"></i> Download Excel</a>
                                @allow('add-keuangan')
                                <a href="{{ route('keuangan.create') }}" class="btn waves-effect waves-light right">Tambah Transaksi</a>
                                @endallow

                                <!-- Filter -->
                                <form action="{{ route('keuangan.index') }}" method="GET">
                                    <div class="row">
                                        <div class="input-field col s12 m3">
                                            <select name="jenis">
                                                <option value="" {{ request('jenis') === null || request('jenis') === '' ? 'selected' : '' }}>Semua Jenis</option>
                                                <option value="masuk" {{ request('jenis') === 'masuk' ? 'selected' : '' }}>Kas Masuk</option>
                                                <option value="keluar" {{ request('jenis') === 'keluar' ? 'selected' : '' }}>Kas Keluar</option>
                                            </select>
                                            <label>Jenis</label>
                                        </div>
                                        <div class="input-field col s12 m3">
                                            <input type="date" name="start_date" value="{{ request('start_date') }}">
                                            <label class="active">Dari Tanggal</label>
                                        </div>
                                        <div class="input-field col s12 m3">
                                            <input type="date" name="end_date" value="{{ request('end_date') }}">
                                            <label class="active">Sampai Tanggal</label>
                                        </div>
                                        <div class="input-field col s12 m3">
                                            <button type="submit" class="btn waves-effect waves-light">Filter</button>
                                            <a href="{{ route('keuangan.index') }}" class="btn waves-effect waves-light grey">Reset</a>
                                        </div>
                                    </div>
                                </form>

                                <table class="striped">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Jenis</th>
                                            <th>Kategori</th>
                                            <th>Keterangan</th>
                                            <th class="text-right">Jumlah</th>
                                            <th>Lampiran</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($transactions as $trx)
                                        <tr>
                                            <td>{{ $trx->tanggal->format('d/m/Y') }}</td>
                                            <td>
                                                @if($trx->isMasuk())
                                                    <span class="green-text text-darken-2">Masuk</span>
                                                @else
                                                    <span class="red-text text-darken-2">Keluar</span>
                                                @endif
                                            </td>
                                            <td>{{ $trx->kategori ?: '-' }}</td>
                                            <td>{{ $trx->keterangan ?: '-' }}</td>
                                            <td class="text-right">Rp {{ number_format($trx->jumlah, 0, ',', '.') }}</td>
                                            <td>
                                                @if($trx->attachment)
                                                    <a href="{{ $trx->attachment_url }}" target="_blank">Lihat</a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @allow('edit-keuangan')
                                                <a href="{{ route('keuangan.edit', $trx->id) }}" class="btn-small">Edit</a>
                                                @endallow
                                                @allow('delete-keuangan')
                                                <form action="{{ route('keuangan.destroy', $trx->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-small red" onclick="return confirm('Hapus transaksi ini?')">Hapus</button>
                                                </form>
                                                @endallow
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="center-align">Belum ada transaksi.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
