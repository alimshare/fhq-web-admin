@extends('layouts.materialized')

@section('content')

<!--breadcrumbs start-->
<div id="breadcrumbs-wrapper">
  <div class="container">
     <div class="row">
        <div class="col s12 m12 l12">
           <h5 class="breadcrumbs-title">Tambah Peserta Halaqoh</h5>
           <ol class="breadcrumbs">
              <li><a href="/" class="cyan-text">Beranda</a></li>
              <li class="active">Tambah Peserta Halaqoh</li>
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
              <form class="" action="{{ route('halaqoh.peserta.addPost') }}" method="POST" id="formValidate" autocomplete="off">
                 <div class="card-panel" id="profile-card">
                    @csrf

                    <div class="row">
                        <label for="halaqoh" class="col s12">Halaqoh</label>    
                        <div class="input-field col s12">
                           <select name="halaqoh" id="halaqoh" class="select2">
                              @foreach($halaqoh as $h)
                                 <option value="{{ $h->halaqoh_id }}">{{ $h->pengajar_name. ' - ' . $h->program_name .' ('. $h->day . ')'   }}</option>
                              @endforeach
                           </select>
                           <div id="halaqoh-error" class="error"></div>
                        </div>
                    </div>

                    <div class="row" style="margin-bottom:2em; margin-top:1em">
                        <label for="santri" class="col s12">Peserta</label>    
                        <div class="input-field col s12">
                           <select name="santri" id="santri" class="select2">
                              @foreach($peserta as $santri)
                                 <option value="{{ $santri->id }}">{{ $santri->name . ' - ' .$santri->nis  }}</option>
                              @endforeach
                           </select>
                           <div id="santri-error" class="error"></div>
                        </div>
                    </div>

                    <div class="card-footer text-right" style="margin-top: 1rem;">                                           
                        <button class="btn waves-effect waves-light light-blue darken-4" type="submit" name="submit" id="submit">
                        <span>Submit</span></button>
                        <a href="/halaqoh/peserta/add" class="btn waves-effect waves-light" name="batal" id="batal">
                        <span>Batal</span></a>
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
<style type="text/css">
    table td, table th {
        border : 1px solid #ddd;
    }
    .error {
        color : red;
    }
</style>
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

      @if (!empty($selectedHalaqoh)) 
         $('#halaqoh').val({{ $selectedHalaqoh->halaqoh_id }}).trigger('change');
      @endif
   </script>
@endsection