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
                <li><a href="/halaqoh" class="cyan-text">Halaqoh</a></li>
                <li class="active">Detail</li>
            </ol>
			<p>
            	<div class="chip cyan white-text"> <i class="mdi-action-event"></i> <span id="modalSemester">{{ $halaqoh->semester_name }}</span> </div>
            	<div class="chip cyan white-text"> <i class="mdi-action-event"></i> <span id="modalDay">{{ $halaqoh->day }}</span> </div>
            	<div class="chip cyan white-text"> <i class="mdi-content-flag"></i> <span id="modalProgram">{{ $halaqoh->program_name }}</span> </div>
            	<div class="chip cyan white-text"> <i class="mdi-social-person-outline"></i> <span id="modalPengajar">{{ $halaqoh->pengajar_name }}</span> </div>
            </p>
          </div>
        </div>
      </div>
    </div>
    <!--breadcrumbs end-->


    <!--start container-->
    <div class="container" style="margin-bottom: 25px; padding-top: 10px;">
    		<div class="row" style="margin-bottom: 10px; text-align: right;">
    			<div class="col s12">
    				<a href="/halaqoh/{{ $halaqoh->halaqoh_reference }}/edit" class="waves-effect waves-light green btn btn-small"><i class="mdi-editor-border-color right"></i>Edit</a>
    			</div>
    		</div>
        	<div class="row"> 
        		<div class="col s12"> 
        			<div class="" style="overflow-x: scroll;"> 
        				<table class="dataTable" border="1px" width="100%"> 
        					<thead class="cyan white-text"> 
        						<tr> 
        							<th rowspan="2">NO</th>
        							<th rowspan="2">NIS</th>
        							<th rowspan="2">Nama Santri</th>
        							<th colspan="2">UTS</th>
        							<th colspan="2">UAS</th>
        							<th rowspan="2">Khatam</th>
        							<th rowspan="2">Kehadiran</th>
        							<th rowspan="2">Status</th>
        							<th rowspan="2">Catatan</th>        							
        						</tr>
        						<tr> 
        							<th>Teori</th>
        							<th>Praktek</th>
        							<th>Teori</th>
        							<th>Praktek</th>
        						</tr>
        					</thead>
        					<tbody> 
        						<?php  $no = 1; ?>
        						@foreach ($peserta as $santri)
        						<tr> 
        							<td>{{ $no++ }}</td>
        							<td>{{ $santri->nis }}</td>
        							<td>{{ $santri->santri_name }}</td>
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
        						</tr>
        						@endforeach
        					</tbody>
        				</table>
        			</div>
        		</div>
        	</div>

    </div>



@endsection