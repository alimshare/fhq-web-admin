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
@endsection

@section('footer-script')
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

                    <form class="" action="/absensi/update" method="POST" id="formValidate" autocomplete="off">
                        <div class="col s12 l4">
                            
                                @csrf
                                <input type="hidden" name="id" value="{{ $activity->id }}">

                                <div class="row">
                                    <label for="halaqoh" class="col s12">Halaqoh</label>    
                                    <div class="input-field col s12">
                                        {{ $activity->halaqoh->pengajar_name. ' - ' . $activity->halaqoh->program_name .' ('. $activity->halaqoh->day . ')'   }}
                                    </div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="input-field col s12">
                                        <input id="tgl" name="tgl" type="text" value="{{ $activity->tgl }}" maxlength="10">
                                        <label for="tgl">Tanggal Absensi</label>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input id="start_time" name="start_time" type="text" value="{{ date('H:i', strtotime($activity->start_time)) }}" style="font-size:15pt" maxlength="5">
                                        <label for="start_time">Waktu Mulai</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="note" class="col s12">Catatan</label>   
                                    <div class="input-field col s12">
                                        <textarea class="textarea" name="note" id="note">{{ $activity->description }}</textarea>
                                    </div>
                                </div> 

                                <br>

                                <div class="row">
                                    <label for="management_note" class="col s12">Catatan Untuk Manajemen</label>   
                                    <div class="input-field col s12">
                                        <textarea class="textarea" name="management_note" id="management_note" placeholder="">{{ $activity->management_note }}</textarea>
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
                                    @foreach($activity->attendances as $a)
                                        <tr>
                                            <td>{{ $a->peserta->santri_name }}</td>
                                            <td>
                                                <input type="radio" name="attendances[{{ $a->id }}][hadir]" id="hadir-true-{{ $a->id }}" value="1" {{ $a->status == "1" ? "checked" : "" }}><label for="hadir-true-{{ $a->id }}">Hadir</label>
                                                &nbsp; | &nbsp;
                                                <input type="radio" name="attendances[{{ $a->id }}][hadir]" id="hadir-false-{{ $a->id }}" value="0" {{ $a->status == "0" ? "checked" : "" }}><label for="hadir-false-{{ $a->id }}">Tidak Hadir</label>
                                            </td>
                                            <td>
                                                <textarea class="" name="attendances[{{ $a->id }}][note]" id="peserta_note-{{ $a->id }}" rows="1">{{ $a->note }}</textarea>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>


                            <div class="text-right" style="margin-top: 1rem;">
                                <button class="btn waves-effect waves-light light-blue darken-4 " type="submit" name="action" >
                                    <span>Ubah</span></button>
                                <a href='/absensi{{ !empty($activity->halaqoh_id) ? "?halaqohRef=".$activity->halaqoh_id : "" }}' class="btn">Batal</a>
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

