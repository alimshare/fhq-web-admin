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
            <h5 class="breadcrumbs-title">Pengajar <small>Edit</small></h5>
            <ol class="breadcrumbs">
                <li><a href="/" class="cyan-text">Dashboard</a></li>
                <li><a href="/pengajar" class="cyan-text">Pengajar</a></li>
                <li class="active">Edit</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!--breadcrumbs end-->


    <!--start container-->
    <div class="container" style="margin-bottom: 25px; padding-top: 10px;">
            <form action="/pengajar/save" method="POST">
            <div class="row"> 
                <div class="col s12 m6"> 
                    <label for="nip">NIP</label>
                    <input type="text" id="nip" name="nip" value="{{ $pengajar->nip }}">
                </div>
            </div>
            <div class="row"> 
                <div class="col s12 m6"> 
                    <label for="name">Nama</label>
                    <input type="text" name="name" value="{{ $pengajar->name }}">
                </div>
            </div>
            <div class="row" style="margin-bottom: 10px; text-align: right;">
                <div class="col s12 m6">
                    @csrf
                    <input type="hidden" name="id" value={{ $pengajar->id }}>
                    <button type="button" class="waves-effect waves-light btn btn-small" onclick="history.back();">Kembali</button>
                    <button type="submit" class="waves-effect waves-light btn btn-small"><i class="mdi-content-save right"></i>Simpan</button>
                </div>
            </div>
            </form>

    </div>



@endsection