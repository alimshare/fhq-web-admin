@extends('layouts.materialized')

@section('content')

<!--breadcrumbs start-->
<div id="breadcrumbs-wrapper">
  <div class="container">
     <div class="row">
        <div class="col s12 m12 l12">
           <h5 class="breadcrumbs-title">Tambah Halaqoh</h5>
           <ol class="breadcrumbs">
              <li><a href="/" class="cyan-text">Beranda</a></li>
              <li class="active">Tambah Halaqoh</li>
           </ol>
        </div>
     </div>
  </div>
</div>
<!--breadcrumbs end-->
<div class="col s12">
  <div class="container">
     <div class="section users-view">
        <div class="row">
           <div class="col s12">
              @include('layouts.materialized.components.alert')
           </div>
        </div>
        <div class="row">
           <div class="col s12 m8 l4">
              <form class="" action="{{ route('halaqoh.addPost') }}" method="POST" id="formValidate" autocomplete="off">
                 <div class="card-panel" id="profile-card">
                    @csrf
                    <div class="row">
                       <div class="col s12" style="margin-bottom:1em">

                            <span>
                                <input class="with-gap" name="day" type="radio" checked value="AHAD" id="day-ahad"/>
                                <label for="day-ahad">AHAD</label>
                            </span>

                            <span>
                                <input class="with-gap" name="day" type="radio" value="SABTU" id="day-sabtu"/>
                                <label for="day-sabtu">SABTU</label>
                            </span>
                            <div id="day-error" class="error"></div>
                       </div>
                    </div>
                    <div class="row">
                       <div class="input-field col s12">
                          <select name="program" id="program" class="select2">
                           <option disabled selected>-- Pilih Program --</option>
                            @foreach($program as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                          </select>
                          <div id="program-error" class="error"></div>
                       </div>
                    </div>
                    <div class="row">
                       <div class="input-field col s12">
                          <select name="pengajar" id="pengajar" class="select2">
                           <option disabled selected>-- Pilih Pengajar --</option>
                            @foreach($pengajar as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                          </select>
                          <div id="pengajar-error" class="error"></div>
                       </div>
                    </div>

                    <div class="card-footer text-right" style="margin-top: 1rem;">                                           
                        <button class="btn waves-effect waves-light light-blue darken-4" type="submit" name="submit" id="submit">
                        <span>Tambah</span></button>                                         
                        <button class="btn waves-effect waves-light" type="reset" name="reset" id="reset">
                        <span>Batal</span></button>
                    </div>
                 </div>
              </form>
           </div>
        </div>
     </div>
  </div>
</div>
       
@endsection

@section('header-script')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('footer-script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
// Basic Select2 select
$(".select2").select2({
    dropdownAutoWidth: true,
    width: '100%'
});
</script>
@endsection