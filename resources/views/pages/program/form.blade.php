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
            <h5 class="breadcrumbs-title">Program <small>Edit</small></h5>
            <ol class="breadcrumbs">
                <li><a href="/" class="cyan-text">Dashboard</a></li>
                <li><a href="/program" class="cyan-text">Program</a></li>
                <li class="active">Edit</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!--breadcrumbs end-->


    <!--start container-->
    <div class="container" style="margin-bottom: 25px; padding-top: 10px;">

        <form action="/program/save" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $program->id }}">
            <div class="row">
                <div class="col s12 m6">
                    <label for="name">Nama Program</label>
                    <input type="text" id="name" value="{{ $program->name }}" disabled>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6">
                    <label for="next_program_id">Program Selanjutnya</label>
                    <select name="next_program_id" id="next_program_id">
                        <option value="">- Tidak Ada -</option>
                        @foreach ($programs as $p)
                            <option value="{{ $p->id }}" {{ $program->next_program_id == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row" style="margin-bottom: 10px; text-align: right;">
                <div class="col s12 m6">
                    <a href="/program" class="btn btn-small">Kembali</a>
                    <button type="submit" class="waves-effect waves-light btn btn-small green"><i class="mdi-content-save right"></i>Save</button>
                </div>
            </div>
        </form>

    </div>

@endsection
