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
            <h5 class="breadcrumbs-title">Semester <small>{{ isset($semester) ? 'Edit' : 'Tambah' }}</small></h5>
            <ol class="breadcrumbs">
                <li><a href="/" class="cyan-text">Dashboard</a></li>
                <li><a href="/semester" class="cyan-text">Semester</a></li>
                <li class="active">{{ isset($semester) ? 'Edit' : 'Tambah' }}</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!--breadcrumbs end-->


    <!--start container-->
    <div class="container" style="margin-bottom: 25px; padding-top: 10px;">

        <form action="/semester/save" method="POST">
            @csrf
            @if(isset($semester))
                <input type="hidden" name="id" value="{{ $semester->id }}">
            @endif
            <div class="row">
                <div class="col s12 m6">
                    <label for="name">Nama Semester</label>
                    <input type="text" id="name" name="name" value="{{ isset($semester) ? $semester->name : '' }}" required>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6">
                    <label for="description">Deskripsi</label>
                    <input type="text" id="description" name="description" value="{{ isset($semester) ? $semester->description : '' }}">
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6">
                    <label for="start_period">Tanggal Mulai</label>
                    <input type="date" id="start_period" name="start_period" value="{{ isset($semester) ? $semester->start_period : '' }}">
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6">
                    <label for="end_period">Tanggal Selesai</label>
                    <input type="date" id="end_period" name="end_period" value="{{ isset($semester) ? $semester->end_period : '' }}">
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6">
                    <label for="next_semester_id">Semester Selanjutnya</label>
                    <select name="next_semester_id" id="next_semester_id">
                        <option value="">- Tidak Ada -</option>
                        @foreach ($semesters as $s)
                            <option value="{{ $s->id }}" {{ (isset($semester) && $semester->next_semester_id == $s->id) ? 'selected' : '' }}>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6" style="margin-top: 15px;">
                    <span>
                        <input type="checkbox" id="active" name="active" value="1" {{ (isset($semester) && $semester->active) ? 'checked' : '' }} />
                        <label for="active">Aktif</label>
                    </span>
                </div>
            </div>
            <div class="row" style="margin-bottom: 10px; text-align: right;">
                <div class="col s12 m6">
                    <a href="/semester" class="btn btn-small">Kembali</a>
                    <button type="submit" class="waves-effect waves-light btn btn-small green"><i class="mdi-content-save right"></i>Save</button>
                </div>
            </div>
        </form>

    </div>

@endsection
