@extends('layouts.materialized')

@section('content')

<!--breadcrumbs start-->
<div id="breadcrumbs-wrapper">
  <div class="container">
     <div class="row">
        <div class="col s12 m12 l12">
           <h5 class="breadcrumbs-title">Form Cuti</h5>
           <ol class="breadcrumbs">
              <li><a href="/" class="cyan-text">Beranda</a></li>
              <li class="active">Form Cuti</li>
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
              {{-- @include('layouts.materialized.components.alert') --}}
           </div>
        </div>
        <div class="row">
           <div class="col s12 m8 l6">
              <form class="" action="{{ route('halaqoh.peserta.cuti') }}" method="POST" id="cuti-form" autocomplete="off">
                 <div class="card-panel" id="profile-card">
                    @csrf

                    <div class="row mt-1">
                        <label for="peserta" class="col s12">Nama Peserta</label>
                        <div class="input-field col s12">
                           <select name="id" id="id" class="select2">
                              <option selected>-- Pilih Peserta --</option>
                              @foreach($peserta_active as $p)
                                 <option value="{{ $p->peserta_id }}">{{ $p->santri_name . " ($p->program_name, $p->pengajar_name, $p->day)"  }}</option>
                              @endforeach
                           </select>
                           <div id="peserta-error" class="error"></div>
                        </div>
                    </div>

                     <div class="card-footer text-right" style="margin-top: 2rem;">
                        <button class="btn waves-effect waves-light light-blue darken-4" type="button" id="btnCuti">
                           <span>Cuti</span>
                        </button>
                     </div>
                 </div>
              </form>
           </div>
        </div>

        <div class="row">
         <div class="col s12">
            <div class="card">
               <div class="card-panel">
                  <h5>Daftar Peserta Cuti</h5>
                  <table class="table">
                     <tr>
                        <th>Nama</th>
                        <th>Program</th>
                        <th>Pengajar Terakhir</th>
                        <th>Tanggal Cuti</th>
                        <th>Action</th>
                     </tr>

                     @foreach ($peserta_cuti as $p)
                         <tr>
                           <td>{{ $p->santri_name }}</td>
                           <td>{{ $p->pengajar_name }}</td>
                           <td>{{ $p->program_name }}</td>
                           <td>{{ $p->deleted_at }}</td>
                           <td>
                              <button type="button" class="btn btn-xs" onclick="confirmRestore(this)" data-id="{{ $p->peserta_id }}">Pulihkan</button>
                           </td>
                         </tr>
                     @endforeach
                  </table>
               </div>
            </div>
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

function confirmInputCuti(e) {
   var span = document.createElement("span");
   span.innerHTML = "Apakah anda yakin ingin merubah status peserta menjadi <b>CUTI</b> ?";

	swal({
		title: "Konfirmasi Cuti",
      content: span,
      // text: "Apakah anda yakin ingin merubah status peserta menjadi CUTI ?",
		icon: "warning",
		buttons: true,
	}).then((willCuti) => {
		if (willCuti) {
		  document.getElementById('cuti-form').submit();
		}
	});
}

function confirmRestore(e) {

   var span = document.createElement("span");
   span.innerHTML = "Apakah anda yakin ingin memulihkan status peserta menjadi <b>AKTIF</b> ?";

	swal({
		title: "Konfirmasi Pemulihan",
      content: span,
		icon: "warning",
		buttons: true,
	}).then((willCuti) => {
		if (willCuti) {
         document.location = "{{ route('halaqoh.peserta.cuti.restore') }}/"+ e.getAttribute("data-id");
		}
	});
}

document.getElementById("btnCuti").addEventListener("click", confirmInputCuti);
</script>
@endsection