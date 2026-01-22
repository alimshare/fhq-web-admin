@extends('layouts.materialized')

@section('content')

<!--breadcrumbs start-->
<div id="breadcrumbs-wrapper">
  <div class="container">
     <div class="row">
        <div class="col s12 m12 l12">
           <h5 class="breadcrumbs-title">Edit Halaqoh</h5>
           <ol class="breadcrumbs">
              <li><a href="/" class="cyan-text">Beranda</a></li>
              <li class="active">Edit Halaqoh</li>
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
              <form class="" action="{{ route('halaqoh.editPost', ['halaqohReference'=>$halaqoh->halaqoh_reference]) }}" method="POST" id="formValidate" autocomplete="off">
                 <div class="card-panel" id="profile-card">
                    @csrf
                    <input type="hidden" name="redirectTo" value="{{ $redirectTo }}">
                    <input type="hidden" name="id" value="{{ $halaqoh->halaqoh_id }}">
                    <div class="row">
                       <div class="col s12">
                            <select name="day" id="day" class="select2">
                              <option disabled selected>-- Pilih Hari --</option>
                               @foreach ($days as $day)
                                 <option value="{{ trim($day) }}" {{ strtolower($halaqoh->day) == strtolower($day) ? 'selected' : '' }}>{{ $day }}</option>
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
                                 @if(!empty($halaqoh->program_id) && $halaqoh->program_id == $p->id)
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
                              @if(!empty($halaqoh->pengajar_id) && $halaqoh->pengajar_id == $p->id)
                                 <option value="{{ $p->id }}" selected>{{ $p->name }}</option>
                              @else 
                                 <option value="{{ $p->id }}">{{ $p->name }}</option>
                              @endif
                            @endforeach
                          </select>
                          <div id="pengajar-error" class="error"></div>
                       </div>
                    </div>
                    <div class="row">
                       <div class="input-field col s12">
                          <select name="gender" id="gender" class="select2">
                              <option disabled selected>-- Pilih Gender --</option>
                              <option value="MALE" {{ $halaqoh->halaqoh_gender == 'MALE' ? 'selected' : '' }}>IKHWAN</option>
                              <option value="FEMALE" {{ $halaqoh->halaqoh_gender == 'FEMALE' ? 'selected' : '' }}>AKHWAT</option>
                          </select>
                          <div id="gender-error" class="error"></div>
                       </div>
                    </div>
                    <div class="row">
                       <div class="input-field col s12">
                          <select name="jenis_kbm" id="jenis_kbm" class="select2">
                              <option disabled selected>-- Pilih Jenis KBM --</option>
                              <option value="OFFLINE" {{ strtoupper($halaqoh->jenis_kbm) == 'OFFLINE' ? 'selected' : '' }}>OFFLINE</option>
                              <option value="ONLINE" {{ strtoupper($halaqoh->jenis_kbm) == 'ONLINE' ? 'selected' : '' }}>ONLINE</option>
                          </select>
                          <div id="jenis_kbm-error" class="error"></div>
                       </div>
                    </div>

                    <div class="card-footer text-right" style="margin-top: 1rem;">                                           
                        <button class="btn waves-effect waves-light light-blue darken-4" type="submit" name="submit" id="submit">
                        <span>Ubah</span></button>                                         
                        <button class="btn waves-effect waves-light" type="reset" name="reset" id="reset" onclick="window.history.back()">
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