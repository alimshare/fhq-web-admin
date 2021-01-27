@extends('layouts.materialized')

@section('header-script')
<style type="text/css">
    table td, table th {
        border : 1px solid #ddd;
    }
    .error {
        color : red;
    }
</style>
@endsection

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
                       <div class="input-field col s12">
                          <select name="halaqoh" id="halaqoh">
                            @foreach($halaqoh as $h)
                                <option value="{{ $h->halaqoh_id }}">{{ $h->pengajar_name. ' - ' . $h->program_name .' ('. $h->day . ')'   }}</option>
                            @endforeach
                          </select>
                          <label for="halaqoh">Halaqoh Awal</label>
                          <div id="halaqoh-error" class="error"></div>
                       </div>
                    </div>
                    <div class="row">
                       <div class="input-field col s12">
                          <select name="santri" id="santri">
                            @foreach($peserta as $santri)
                                <option value="{{ $santri->id }}">{{ $santri->name . ' - ' .$santri->nis  }}</option>
                            @endforeach
                          </select>
                          <label for="santri">Peserta</label>
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
@endsection