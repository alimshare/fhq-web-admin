@extends('layouts.materialized')

@section('header-script')
@endsection
@section('footer-script')
@endsection

@section('content')

    <!--breadcrumbs start-->
    <div id="breadcrumbs-wrapper">
      <div class="container">
        <div class="row">
          <div class="col s12 m12 l12">
            <h5 class="breadcrumbs-title">Program <small>Tambah</small></h5>
            <ol class="breadcrumbs">
                <li><a href="/" class="cyan-text">Dashboard</a></li>
                <li><a href="/program" class="cyan-text">Program</a></li>
                <li class="active">Tambah</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!--breadcrumbs end-->


    <!--start container-->
    <div class="container" style="margin-bottom: 25px; padding-top: 10px;">

        <form action="/program/store" method="POST">
            @csrf
            <div class="row">
                <div class="col s12 m6">
                    <label for="name">Nama Program</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="red-text">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6">
                    <label for="sequence">Urutan</label>
                    <input type="number" id="sequence" name="sequence" value="{{ old('sequence') }}">
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6">
                    <label for="description">Deskripsi</label>
                    <input type="text" id="description" name="description" value="{{ old('description') }}">
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6">
                    <label for="infaq">Infaq</label>
                    <input type="number" id="infaq" name="infaq" value="{{ old('infaq', 0) }}" min="0">
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6">
                    <label for="next_program_id">Program Selanjutnya</label>
                    <select name="next_program_id" id="next_program_id">
                        <option value="">- Tidak Ada -</option>
                        @foreach ($programs as $p)
                            <option value="{{ $p->id }}" {{ old('next_program_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row" style="margin-bottom: 10px; text-align: right;">
                <div class="col s12 m6">
                    <a href="/program" class="btn btn-small">Kembali</a>
                    <button type="submit" class="waves-effect waves-light btn btn-small green"><i class="mdi-content-save right"></i>Simpan</button>
                </div>
            </div>
        </form>

    </div>

@endsection
