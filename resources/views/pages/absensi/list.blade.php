@extends('layouts.materialized')

@section('header-script')
<style type="text/css">
    table thead th, table tbody td {
      border: 1px solid #ddd;
      text-align : center;
    }
    table thead th {
    }

   .mobile .collection {
      display: none;
   }

    @media(max-width: 430px) {
        .desktop .table {
           display: none;
        }
        .mobile .collection {
           display: block;
        }
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
           <h5 class="breadcrumbs-title">Daftar Absensi</h5>
           <ol class="breadcrumbs">
              <li><a href="/" class="cyan-text">Beranda</a></li>
              <li class="active">Daftar Absensi</li>
           </ol>
        </div>
     </div>
  </div>
</div>
<!--breadcrumbs end-->
<div class="col s12">
  <div class="container">
      <div class="section text-center" style="margin-top:35px">
         <a href='/absensi/add{{ !empty($halaqohId) ? "?halaqohRef=$halaqohId" : "" }}' class="btn btn-large cyan darken-2">Isi Absensi</a>
      </div>
     <div class="section">
        <div class="row">
           <div class="col s12">
              @include('layouts.materialized.components.alert')
           </div>
        </div>
        <div class="row">
           <div class="col s12 desktop">
              <table class="table" cellpadding="5px" width="100%">
                  <thead>
                     <tr class="cyan darken-3 white-text">
                        <th>Tanggal Absensi</th>
                        <th>Hari</th>
                        <th>Program</th>
                        <th>Pengajar</th>
                        <th>Waktu Mulai</th>
                        <th>Jumlah Peserta</th>
                        <th>Jumlah Peserta Hadir</th>
                        <th>Catatan</th>
                        <th></th>
                     </tr>
                  </thead>

                  <tbody>
                     @foreach($kbm as $k)
                        <tr>
                           <td>{{ $k->tgl }}</td>
                           <td>{{ $k->halaqoh->day }}</td>
                           <td>{{ $k->halaqoh->program_name }}</td>
                           <td>{{ $k->halaqoh->pengajar_name }}</td>
                           <td>{{ date('H:i', strtotime($k->start_time)) }}</td>
                           <td>{{ $k->attendances_count }}</td>
                           <td>{{ $k->hadir_count }}</td>
                           <td class="text-left">{!! nl2br($k->description) !!}</td>
                           <td>
                              <a href='/absensi/edit/{{ $k->id }}{{ !empty($halaqohId) ? "?halaqohRef=$halaqohId" : "" }}'>Edit</a>
                           </td>
                        </tr>
                     @endforeach
                  </tbody>
              </table>
           </div>
           <div class="col s12 mobile no-padding">
               <div class="collection">
                  @foreach($kbm as $k)
                     <div class="row collection-item" style="">
                        <div class="col s3 teal white-text" style="padding: 8px 12px;">
                           {{ date('M',strtotime($k->tgl)) }} <br>
                           {{ date('d',strtotime($k->tgl)) }} <br>
                           {{ date('Y',strtotime($k->tgl)) }} <br>
                        </div>
                        <div class="col s3">{{ $k->halaqoh->program_name }}</div>
                        <div class="col s3 text-center" style="display: flex; ">{{ count($k->hadir) }} / {{ $k->attendances_count }}</div>
                        <div class="col s3 no-padding text-right">
                           <a href="/absensi/edit/{{ $k->id }}{{ !empty($halaqohId) ? "?halaqohRef=$halaqohId" : "" }}" class="btn-floating waves-effect waves-light primary" data-position="bottom" data-tooltip="Detail"><i class="mdi-action-search"></i></a>
                           <a class="btn-floating green waves-effect waves-light primary" data-position="bottom" data-tooltip="Catatan"><i class="mdi-communication-comment"></i></a>
                        </div>
                     </div>
                  @endforeach
               </div>
           </div>
        </div>
     </div>

     @isset($kehadiran)
     @php $i = 1; @endphp
     <div class="section">
      <div class="row">
         <div class="col s12 l6">

            <h5>Rekap Kehadiran Peserta</h5>
            <table class="table" cellpadding="1px" width="100%">
                <thead>
                   <tr class="cyan darken-3 white-text">
                      <th>No.</th>
                      <th>Nama Santri</th>
                      <th>Total Kehadiran</th>
                   </tr>
                </thead>

                <tbody>
                   @foreach($kehadiran as $k)
                      <tr>
                         <td>{{ $i++ }}</td>
                         <td class="text-left">{{ $k->peserta->santri_name }} </td>
                         <td>{{ $k->count_kehadiran }}</td>
                      </tr>
                   @endforeach
                </tbody>
            </table>
         </div>
      </div>
      @endisset

     </div>
  </div>
</div>
       
@endsection

