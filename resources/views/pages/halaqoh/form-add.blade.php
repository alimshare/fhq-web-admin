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
                    <input type="hidden" name="redirectTo" value="{{ $redirectTo }}">
                    <div class="row">
                       <div class="col s12">
                            <select name="day" id="day" class="select2">
                              <option disabled selected>-- Pilih Hari --</option>
                               @foreach ($days as $day)
                                 <option value="{{ trim($day) }}" {{ strtolower($hari) == strtolower($day) ? 'selected' : '' }}>{{ $day }}</option>
                               @endforeach
                           </select>
                            <div id="day-error" class="error"></div>
                       </div>
                    </div>
                    <div class="row">
                       <div class="input-field col s12">
                          <select name="program" id="program" class="select2">
                           <option disabled selected>-- Pilih Program --</option>
                            @foreach($program as $p)
                                 @if(!empty($program_id) && $program_id == $p->id)
                                    <option value="{{ $p->id }}" selected>{{ $p->name }}</option>
                                 @else 
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                 @endif
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

                    <div class="row" style="margin-top:1rem;">
                        <label for="old_halaqoh" class="col s12">Jenis KBM</label>
                        <div class="input-field col s12">
                           <input type="text" name="jenis_kbm" id="jenis_kbm" style="height: 1.8rem">
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