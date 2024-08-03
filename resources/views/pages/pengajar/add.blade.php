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
            <h5 class="breadcrumbs-title">Pengajar <small>Add</small></h5>
            <ol class="breadcrumbs">
                <li><a href="/" class="cyan-text">Dashboard</a></li>
                <li><a href="/pengajar" class="cyan-text">Pengajar</a></li>
                <li class="active">Add</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!--breadcrumbs end-->


    <!--start container-->
    <div class="container" style="margin-bottom: 25px; padding-top: 10px;">

      <div class="row">
         <div class="col s12">
            @include('layouts.materialized.components.alert')
         </div>
      </div>
        
        <form action="{{ route('pengajar.add') }}" method="POST">
            
            <div class="row"> 
                <div class="col s12 m6"> 
                    <label for="name">Nama</label>
                    <input type="text" name="name" value="" required>
                </div>
            </div>

            <div class="row"> 
                <div class="col s12 m6"> 
                    <label for="gender">Jenis Kelamin</label>
                    <select name="gender" id="gender" required>
                        <option disabled selected>-</option>
                        <option value="MALE">Laki-laki</option>
                        <option value="FEMALE">Perempuan</option>
                    </select>
                </div>
            </div>

            <div class="row"> 
                <div class="col s12 m6"> 
                    <label for="phone">Nomor Telpon</label>
                    <input type="text" name="phone" value="" required>
                </div>
            </div>

            <div class="row"> 
                <div class="col s12 m6"> 
                    <label for="address">Alamat</label>
                    <textarea name="address" id="address" class="materialize-textarea"></textarea>
                </div>
            </div>

            <div class="row" style="margin-bottom: 10px; text-align: right;">
                <div class="col s12 m6">
                    @csrf
                    <a href="{{ route('pengajar') }}" class="btn btn-small">Kembali</a>
                    <button type="submit" class="waves-effect waves-light btn btn-small"><i class="mdi-content-save right"></i>Save</button>
                </div>
            </div>
        </form>

    </div>



@endsection