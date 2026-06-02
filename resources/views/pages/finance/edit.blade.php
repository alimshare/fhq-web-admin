@extends('layouts.materialized')

@section('content')

        <!--breadcrumbs start-->
        <div id="breadcrumbs-wrapper">
          <div class="container">
            <div class="row">
              <div class="col s12">
                <h5 class="breadcrumbs-title">Edit Transaksi</h5>
                <ol class="breadcrumbs">
                    <li><a href="/" class="cyan-text">Dashboard</a></li>
                    <li><a href="{{ route('keuangan.index') }}">Keuangan</a></li>
                    <li class="active">Edit</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!--breadcrumbs end-->


        <!--start container-->
        <div class="container" style="margin-bottom: 25px">
            <div class="section">
                <div class="row">
                    <div class="col s12 m8">
                        <div class="card">
                            <div class="card-content">
                                <span class="card-title">Edit Transaksi Kas</span>

                                @if($errors->any())
                                <div class="card-panel red lighten-4 red-text text-darken-4">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif

                                <form action="{{ route('keuangan.update', $transaction->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="input-field">
                                        <input id="tanggal" type="date" name="tanggal" value="{{ old('tanggal', $transaction->tanggal->format('Y-m-d')) }}" required>
                                        <label class="active" for="tanggal">Tanggal</label>
                                    </div>
                                    <div class="input-field">
                                        <select name="jenis" required>
                                            <option value="masuk" {{ old('jenis', $transaction->jenis) === 'masuk' ? 'selected' : '' }}>Kas Masuk</option>
                                            <option value="keluar" {{ old('jenis', $transaction->jenis) === 'keluar' ? 'selected' : '' }}>Kas Keluar</option>
                                        </select>
                                        <label>Jenis</label>
                                    </div>
                                    <div class="input-field">
                                        <input id="kategori" type="text" name="kategori" value="{{ old('kategori', $transaction->kategori) }}">
                                        <label class="active" for="kategori">Kategori (opsional)</label>
                                    </div>
                                    <div class="input-field">
                                        <input id="jumlah" type="number" step="0.01" min="0" name="jumlah" value="{{ old('jumlah', $transaction->jumlah) }}" required>
                                        <label class="active" for="jumlah">Jumlah (Rp)</label>
                                    </div>
                                    <div class="input-field">
                                        <textarea id="keterangan" name="keterangan" class="materialize-textarea">{{ old('keterangan', $transaction->keterangan) }}</textarea>
                                        <label class="active" for="keterangan">Keterangan (opsional)</label>
                                    </div>
                                    @if($transaction->attachment)
                                    <p>Lampiran saat ini: <a href="{{ $transaction->attachment_url }}" target="_blank">Lihat file</a></p>
                                    @endif
                                    <div class="file-field input-field">
                                        <div class="btn">
                                            <span>{{ $transaction->attachment ? 'Ganti Lampiran' : 'Lampiran' }}</span>
                                            <input type="file" name="attachment" accept=".jpg,.jpeg,.png,.pdf">
                                        </div>
                                        <div class="file-path-wrapper">
                                            <input class="file-path validate" type="text" placeholder="Bukti transaksi (jpg/png/pdf, maks 4MB) - opsional">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn waves-effect waves-light">Perbarui</button>
                                    <a href="{{ route('keuangan.index') }}" class="btn waves-effect waves-light grey">Batal</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
