@extends('layouts.materialized')

@section('header-script')
<style type="text/css">
    table td, table th {
        border : 1px solid #ddd;
    }
</style>
@endsection

@section('content')

        <!--breadcrumbs start-->
        <div id="breadcrumbs-wrapper">
          <div class="container">
            <div class="row">
              <div class="col s12">
                <h5 class="breadcrumbs-title">Program</h5>
                <ol class="breadcrumbs">
                    <li><a href="/" class="cyan-text">Dashboard</a></li>
                    <li class="active">Program</li>
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
                    <div class="col s12">
                        @include('layouts.materialized.components.alert')
                    </div>
                </div>
                <div class="row">
                    @foreach($list as $o)
                    <div class="col s12 l4">
                      <div class="card white-text" style="background-color: {{ $o->color }}">
                        <div class="card-content white-text center-align">
                          <p class="card-title">{{ $o->program_name }}</p>
                          <p>{{ $o->halaqoh }} Halaqoh</p>
                          <p>{{ $o->peserta }} Peserta</p>
                        </div>
                      </div>
                    </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col s12">
                        <div class="card-panel">
                            <h5>Daftar Program</h5>
                            <table class="bordered">
                                <thead>
                                    <tr class="cyan darken-3 white-text">
                                        <th>Nama Program</th>
                                        <th>Urutan</th>
                                        <th>Program Selanjutnya</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($programs as $p)
                                        <tr>
                                            <td>{{ $p->name }}</td>
                                            <td>{{ $p->sequence }}</td>
                                            <td>{{ $p->next_program ?? '-' }}</td>
                                            <td>
                                                <a href="/program/edit/{{ $p->id }}" class="btn btn-small orange" title="Edit Program">
                                                    <i class="mdi-editor-mode-edit"></i>
                                                </a>
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
        <!--end container-->

@endsection

