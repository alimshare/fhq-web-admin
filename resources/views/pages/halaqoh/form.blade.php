@extends('layouts.materialized')
@section('header-script')
<style type="text/css">
    table.dataTable thead .row-filter .sorting_asc {
        background-image: none;
    }
    table.dataTable thead th {
        border: 1px solid #ddd;
        text-align: center;
    }
    table.dataTable thead tr.row-filter th {
        padding: 5px;
    }
    table.dataTable td {
    	padding: 8px;
        border: 1px solid #ddd;    	
    }
    table.dataTable input[type=text], table .select-wrapper input.select-dropdown {
        height: 2rem;
        font-size: 12px;
        border: 1px solid #ddd;
        text-indent: 10px;
        margin: 0;
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
            <h5 class="breadcrumbs-title">Halaqoh <small>Detail</small></h5>
            <ol class="breadcrumbs">
                <li><a href="/" class="cyan-text">Dashboard</a></li>
				<li><a href="{{ Request::get('referer') ? "#" : "/halaqoh" }}" class="cyan-text">Halaqoh</a></li>
                <li class="active">Detail</li>
            </ol>
			<p>
            	<div class="chip cyan white-text"> <i class="mdi-action-event"></i> <span id="modalSemester">Semester {{ $halaqoh->semester_name }}</span> </div>
            	<div class="chip cyan white-text"> <i class="mdi-action-event"></i> <span id="modalDay">{{ $halaqoh->day }}</span> </div>
            	<div class="chip cyan white-text"> <i class="mdi-content-flag"></i> <span id="modalProgram">{{ $halaqoh->program_name }}</span> </div>
            	{{-- <div class="chip cyan white-text"> <i class="mdi-social-person-outline"></i> <span id="modalPengajar">{{ $halaqoh->pengajar_name }}</span> </div> --}}
            </p>
          </div>
        </div>
      </div>
    </div>
    <!--breadcrumbs end-->


    <!--start container-->
    <div class="container" style="margin-bottom: 25px; padding-top: 10px;">
			<div class="section">
				<div class="row" style="margin-bottom: 10px; text-align: right;">
					<div class="col s12">
						@if (Auth::user()->isPengajar())
							<a href="{{ route('profile') }}" class="waves-effect waves-light btn btn-small">Profile</a>
						@endif

						@allow('input-nilai')
							<a href="/halaqoh/{{ $halaqoh->halaqoh_reference }}/edit" class="waves-effect waves-light green btn btn-small"><i class="mdi-editor-border-color right"></i>Edit</a>
						@endallow
					</div>
				</div>
				<div class="row"> 
					<div class="col s12"> 
						<div class="" style="overflow-x: scroll;"> 
							<table class="dataTable" border="1px" width="100%"> 
								<thead class="cyan white-text"> 
									<tr> 
										<th rowspan="2">Rapot</th>
										<th rowspan="2">NIS</th>
										<th rowspan="2">Nama Santri</th>
										<th colspan="2">UTS</th>
										<th colspan="2">UAS</th>
										<th rowspan="2">Khatam</th>
										<th rowspan="2">Kehadiran</th>
										<th rowspan="2">Status</th>
										<th rowspan="2">Catatan</th>
										<th rowspan="2">Catatan Manajemen</th>
									</tr>
									@if($halaqoh->program_id == "11" || $halaqoh->program_name == "TAKHASSUS")
									<tr> 
										<th>Tadribat</th>
										<th>Tahfidz</th>
										<th>Tadribat</th>
										<th>Tahfidz</th>
									</tr>
									@else
									<tr> 
										<th>Teori</th>
										<th>Praktek</th>
										<th>Teori</th>
										<th>Praktek</th>
									</tr>
									@endif
								</thead>
								<tbody> 
									@foreach ($peserta as $santri)
									<tr> 
										<td class="text-center">
											<a href="{{ route('peserta.raport.print', ['peserta_id'=>$santri->peserta_id]) }}" target="_blank" class="btn-floating waves-effect waves-light purple darken-2 tooltipped" data-position="bottom" data-tooltip="Cetak Raport"><i class="mdi-file-file-download small"></i></a>
										</td>
										<td>{{ $santri->nis }}</td>
										<td>
											@allow('detail-santri')
											<a href="{{ route('santri.profile', ['santriId'=>$santri->santri_id]) }}?referer=/halaqoh/{{ $halaqoh->halaqoh_reference }}">{{ $santri->santri_name }}</a>
											@else
											{{ $santri->santri_name }}
											@endallow
										</td>
										<td class="text-right">{{ $santri->nilai_uts_teori }}</td>
										<td class="text-right">{{ $santri->nilai_uts_praktek }}</td>
										<td class="text-right">{{ $santri->nilai_uas_teori }}</td>
										<td class="text-right">{{ $santri->nilai_uas_praktek }}</td>
										<td class="text-right">{{ $santri->khatam }}</td>
										<td class="text-right">{{ $santri->kehadiran }}</td>
										<td class="text-center">{{ $santri->status }}</td>
										<td class="text-center">
											@if ($santri->catatan != null)
											<a class="btn-floating waves-effect waves-light primary tooltipped" data-position="bottom" data-tooltip="{{ $santri->catatan }}"><i class="mdi-communication-comment"></i></a>
											@endif
										</td>
										<td class="text-center">
											@if ($santri->catatan_manajemen != null)
											<a class="btn-floating waves-effect waves-light primary tooltipped" data-position="bottom" data-tooltip="{{ $santri->catatan_manajemen }}"><i class="mdi-communication-comment"></i></a>
											@endif
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>


			<div class="section">
				<div class="row">
				   <div class="col s12">
					  <h5>Kehadiran Peserta</h5>
				   </div>
				</div>
				<div class="row">
				   <div class="col s12">
					  <div class="table-responsive">
		  
						 <table class="table table-bordered dataTable" border="1px" width="100%">
							<thead>
							   <tr class="cyan darken-3 white-text">
								  <th>No.</th>
								  <th>Nama Santri</th>
								  @foreach ($halaqoh->kbm as $kbm)
									<td class="text-center">
										@php $time = strtotime($kbm->tgl); @endphp
										{{ date("Y", $time) }} <br> {{ date("d", $time) }}/{{ date("m", $time) }}
									</td>
								  @endforeach
							   </tr>
							</thead>
			 
							<tbody>
			 
							   @php $i = 1; @endphp
							   @foreach($peserta as $santri)
								  <tr>
									 <td>{{ $i++ }}</td>
									 <td class="text-left">{{ $santri->santri_name }} </td>
									 @foreach ($halaqoh->kbm as $kbm)
									 	@php $pesertaHadir = $kbm->attendances->pluck('status','peserta_id'); @endphp
										<td class="text-center">
											@if($pesertaHadir[$santri->peserta_id] && $pesertaHadir[$santri->peserta_id] == 1)
												<span class="mdi-action-check-circle green-text"></span>
											@else
												<span class="mdi-navigation-close red-text"></span>
											@endif
										</td>
									 @endforeach
								  </tr>
							   @endforeach
			 
							</tbody>
						 </table>
		  
					  </div>
				   </div>
				</div>
			   </div>
    </div>



@endsection