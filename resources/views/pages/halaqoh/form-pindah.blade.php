@extends('layouts.materialized')

@section('content')

<!--breadcrumbs start-->
<div id="breadcrumbs-wrapper">
  <div class="container">
     <div class="row">
        <div class="col s12 m12 l12">
           <h5 class="breadcrumbs-title">Pindah Halaqoh</h5>
           <ol class="breadcrumbs">
              <li><a href="/" class="cyan-text">Beranda</a></li>
              <li class="active">Pindah Halaqoh</li>
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
              <form class="" action="{{ route('halaqoh.pindahPost') }}" method="POST" id="formValidate" autocomplete="off">
                 <div class="card-panel" id="profile-card">
                    @csrf
                    <div class="row">
                        <label for="old_halaqoh" class="col s12">Halaqoh Awal</label>
                        <div class="input-field col s12">
                           <select name="old_halaqoh" id="old_halaqoh" onchange="cek()" class="select2">
                              <option disabled selected>-- Pilih Halaqoh Awal --</option>
                              @foreach($halaqoh as $h)
                                 @if($currentHalaqoh == $h->halaqoh_id) 
                                       <option value="{{ $h->halaqoh_id }}" selected="selected">{{ $h->pengajar_name. ' - ' . $h->program_name .' ('. $h->day . ')'   }}</option>
                                 @else
                                       <option value="{{ $h->halaqoh_id }}">{{ $h->pengajar_name. ' - ' . $h->program_name .' ('. $h->day . ')'   }}</option>
                                 @endif
                              @endforeach
                           </select>
                           <div id="old-halaqoh-error" class="error"></div>
                        </div>
                    </div>
                    @isset($peserta)
                    <div class="row mt-1">
                          <label for="peserta" class="col s12">Peserta</label>
                       <div class="input-field col s12">
                          <select name="peserta" id="peserta" class="select2">
                           <option disabled selected>-- Pilih Peserta --</option>
                            @foreach($peserta as $p)
                                <option value="{{ $p->peserta_id }}">{{ $p->nis . ' - ' .$p->santri_name  }}</option>
                            @endforeach
                          </select>
                          <div id="peserta-error" class="error"></div>
                       </div>
                    </div>
                    <div class="row mt-1 mb-1">
                        <label for="new_halaqoh" class="col s12">Halaqoh Tujuan</label>
                       <div class="input-field col s12">
                          <select name="new_halaqoh" id="new_halaqoh" class="select2">
                           <option disabled selected>-- Pilih Halaqoh Tujuan --</option>
                            @foreach($halaqoh as $h)
                                @if ($h->halaqoh_id != $currentHalaqoh)
                                    <option value="{{ $h->halaqoh_id }}">{{ $h->pengajar_name. ' - ' . $h->program_name .' ('. $h->day . ')'   }}</option>
                                @endif
                            @endforeach
                          </select>
                          <div id="new_halaqoh-error" class="error"></div>
                       </div>
                    </div>
                    @endisset

                    <div class="card-footer text-right" style="margin-top: 2rem;">
                       
                        @isset($peserta)
                            <button class="btn waves-effect waves-light light-blue darken-4" type="submit" name="submit" id="submit">
                            <span>Submit</span></button>
                            <a href="/halaqoh/pindah" class="btn waves-effect waves-light" name="batal" id="batal">
                            <span>Batal</span></a>
                        @else
                            <button class="btn waves-effect waves-light light-blue darken-4" type="button" name="cek" id="cek">
                            <span>Cek</span></button>
                        @endisset
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
    .mt-1 {
       margin-top: 1em;
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection


@section('footer-script')
    <script>
        document.getElementById("cek").addEventListener("click", cek);

        function cek()
        {
            let halaqohId = document.getElementById('old_halaqoh').value;
            let elemPeserta = document.getElementById('peserta');

            if (elemPeserta == null) {
                document.location = '/halaqoh/pindah/'+halaqohId;
            } else {
                let pesertaId = elemPeserta.value;
                document.location = '/halaqoh/pindah/'+halaqohId+'/'+pesertaId;

            }
        }
    </script>
   <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
   <script>
      // Basic Select2 select
      $(".select2").select2({
         dropdownAutoWidth: true,
         width: '100%'
      });
   </script>
@endsection