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
            <h5 class="breadcrumbs-title">Santri <small>Add</small></h5>
            <ol class="breadcrumbs">
                <li><a href="/" class="cyan-text">Dashboard</a></li>
                <li><a href="/santri" class="cyan-text">Santri</a></li>
                <li class="active">Add</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!--breadcrumbs end-->


    <!--start container-->
    <div class="container" style="margin-bottom: 25px; padding-top: 10px;">
        
        <form action="/santri/save" method="POST">
            <div class="row"> 
                <div class="col s12 m6"> 
                    <label for="nis">NIS</label>
                    <input type="text" id="nis" name="nis" value="">
                </div>
            </div>
            <div class="row"> 
                <div class="col s12 m6"> 
                    <label for="name">Nama</label>
                    <input type="text" name="name" value="">
                </div>
            </div>
            <div class="row"> 
                <div class="col s12 m6"> 
                    <label for="gender">Jenis Kelamin</label>
                    <select name="gender" id="gender">
                        <option disabled selected>-</option>
                        <option value="MALE">Laki-laki</option>
                        <option value="FEMALE">Perempuan</option>
                    </select>
                </div>
            </div>
            <div class="row"> 
                <div class="col s12 m6"> 
                    <label for="phone">Nomor Telpon</label>
                    <input type="text" name="phone" value="">
                </div>
            </div>
            <div class="row" style="margin-bottom: 10px; text-align: right;">
                <div class="col s12 m6">
                    @csrf
                    <a href="{{ "/santri" }}" class="btn btn-small">Kembali</a>
                    <button type="submit" class="waves-effect waves-light btn btn-small"><i class="mdi-content-save right"></i>Save</button>
                </div>
            </div>
        </form>

    </div>



@endsection