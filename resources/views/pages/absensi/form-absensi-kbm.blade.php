@extends('layouts.materialized')

@section('header-script')
<style type="text/css">
    table td, table th {
        border : 1px solid #ddd;
    }
    .error {
        color : red;
    }
    .textarea {
        min-height: 100px;
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
    }).on('select2:select', function (e) {
        var data = e.params.data;
        getPeserta(data.id);
    });

    const getPeserta = (id) => {

        $.get("/api/halaqoh/"+id+"/peserta", function(res){
            console.log('Get Peserta for Halaqoh '+id);
            $("#attendee").html('');
            res.forEach(function(obj){
                let elem = `
                    <tr>
                        <td>${obj.santri_name}</td>
                        <td>
                            <input type="radio" name="peserta[${obj.peserta_reference}][hadir]" id="hadir-true-${obj.peserta_reference}" value="1" checked=""><label for="hadir-true-${obj.peserta_reference}">Hadir</label>
                            &nbsp; | &nbsp;
                            <input type="radio" name="peserta[${obj.peserta_reference}][hadir]" id="hadir-false-${obj.peserta_reference}" value="0"><label for="hadir-false-${obj.peserta_reference}">Tidak Hadir</label>
                        </td>
                        <td>
                            <textarea class="" name="peserta[${obj.peserta_reference}][note]" id="peserta_note-${obj.peserta_reference}" rows="1"></textarea>
                        </td>
                    </tr>
                `;
                $("#attendee").append(elem);
            });
        });

    };

    @if (!empty($halaqohRef)) 
        $('#halaqoh').val({{ $halaqohRef }}).trigger('change');
        getPeserta({{ $halaqohRef }});
    @endif
   </script>
@endsection

@section('content')

<!--breadcrumbs start-->
<div id="breadcrumbs-wrapper">
  <div class="container">
     <div class="row">
        <div class="col s12 m12 l12">
           <h5 class="breadcrumbs-title">Form Absensi Kehadiran</h5>
           <ol class="breadcrumbs">
              <li><a href="/" class="cyan-text">Beranda</a></li>
              <li><a href="/absensi" class="cyan-text">Rekap Absensi</a></li>
              <li class="active">Form Absensi</li>
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
            <div class="card-panel" id="attendance-form-card">
                <div class="row">

                    <form class="" action="/absensi/save" method="POST" id="formValidate" autocomplete="off">
                        <div class="col s12 l4">
                            
                                @csrf

                                <div class="row">
                                    <label for="halaqoh" class="col s12">Halaqoh</label>    
                                    <div class="input-field col s12">
                                        <select name="halaqoh" id="halaqoh" class="select2">
                                        <option disabled selected>-- Pilih Halaqoh --</option>
                                            @foreach($halaqoh as $h)
                                                <option value="{{ $h->halaqoh_reference }}">{{ $h->pengajar_name. ' - ' . $h->program_name .' ('. $h->day . ')'   }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="input-field col s12">
                                        <input id="tgl" name="tgl" type="text" value="{{ date('Y-m-d') }}" maxlength="10">
                                        <label for="tgl">Tanggal Absensi</label>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input id="start_time" name="start_time" type="text" value="{{ date('H:i') }}" style="font-size:15pt" maxlength="5">
                                        <label for="start_time">Waktu Mulai</label>
                                    </div>
                                    <!-- <div class="input-field col s12 l6">
                                        <input id="end_time" name="end_time" type="text" value="{{ date('H:i') }}" style="font-size:15pt">
                                        <label for="end_time">Waktu Selesai</label>
                                    </div> -->
                                </div>

                                <div class="row">
                                    <label for="note" class="col s12">Catatan</label>   
                                    <div class="input-field col s12">
                                        <textarea class="textarea" name="note" id="note"># Teori:

# Talaqqi:</textarea>
                                    </div>
                                </div> 

                                <br>

                                <div class="row">
                                    <label for="management_note" class="col s12">Catatan Untuk Manajemen</label>   
                                    <div class="input-field col s12">
                                        <textarea class="textarea" name="management_note" id="management_note" placeholder=""></textarea>
                                    </div>
                                </div>

                                <br>

                        </div>

                        <div class="col s12 l8">

                            <table>
                                <thead>
                                    <tr class="green white-text lighten-2">
                                        <th>Peserta</th>
                                        <th>Status</th>
                                        <th>Catatan / Keterangan</th>
                                    </tr>
                                </thead>

                                <tbody id="attendee">
                                </tbody>

                            </table>


                            <div class="text-right" style="margin-top: 1rem;">
                                <button class="btn waves-effect waves-light light-blue darken-4 " type="submit" name="action" >
                                    <span>Simpan</span></button>
                                <a href='/absensi{{ !empty($halaqohRef) ? "?halaqohRef=$halaqohRef" : "" }}' class="btn">Batal</a>
                            </div>

                        </div>

                    </form>

                </div>
            </div>
        </div>
     </div>
  </div>
</div>
       
@endsection

