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
    table.dataTable input[type=text], table.dataTable input[type=number], table .select-wrapper input.select-dropdown {
        height: 2rem;
        font-size: 12px;
        border: 1px solid #ddd;
        text-indent: 10px;
        margin: 0;
    }
</style>
@endsection
@section('footer-script')
<script>
    /**
     * solution from https://stackoverflow.com/questions/13952686/how-to-make-html-input-tag-only-accept-numerical-values/13952761
    */
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode != 46 &&(charCode < 48 || charCode > 57)))
            return false;
        return true;
    }

    function saveDU(pesertaId, halaqohReference) {
        var hari = document.getElementById('du_hari_' + pesertaId).value;
        var kbm = document.getElementById('du_kbm_' + pesertaId).value;
        if (!hari || !kbm) {
            alert('Pilih Hari dan KBM terlebih dahulu');
            return;
        }
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("halaqoh.du.save") }}';
        form.innerHTML = '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
            '<input type="hidden" name="peserta_id" value="' + pesertaId + '">' +
            '<input type="hidden" name="halaqoh_reference" value="' + halaqohReference + '">' +
            '<input type="hidden" name="hari" value="' + hari + '">' +
            '<input type="hidden" name="jenis_kbm" value="' + kbm + '">';
        document.body.appendChild(form);
        form.submit();
    }

    function removeDU(url) {
        if (!confirm('Hapus Daftar Ulang?')) return;
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = url;
        form.innerHTML = '<input type="hidden" name="_token" value="{{ csrf_token() }}">';
        document.body.appendChild(form);
        form.submit();
    }
</script>
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
            	<div class="chip cyan white-text"> <i class="mdi-action-event"></i> <span id="modalDay">{{ $halaqoh->day }}</span> </div>
            	<div class="chip cyan white-text"> <i class="mdi-content-flag"></i> <span id="modalProgram">{{ $halaqoh->program_name }}</span> </div>
            	<div class="chip cyan white-text"> <i class="mdi-social-person-outline"></i> <span id="modalPengajar">{{ $halaqoh->pengajar_name }}</span> </div>
            </p>
          </div>
        </div>
      </div>
    </div>
    <!--breadcrumbs end-->


    <div class="row">
        <div class="col s12">
           @include('layouts.materialized.components.alert')
        </div>
     </div>

    <!--start container-->
    <div class="container" style="margin-bottom: 25px; padding-top: 10px;">
            <form action="/halaqoh-detail/save" method="POST" name="form-input-nilai">
            <div class="row"> 
                <div class="col s12"> 
        			<div class="" style="overflow-x: scroll;"> 
        				<table class="dataTable" width="100%"> 
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
        							<th rowspan="2">Catatan Manajemen</th>
										@if(env('ENABLE_PENGAJAR_DU'))
        							<th rowspan="2">Daftar Ulang</th>
										@endif
        						</tr>
                        
                                @if(in_array($halaqoh->program_id, explode(",", env('TAKHOSSUS_IDS', ''))))
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
        						<?php  $no = 1; ?>
        						@foreach ($peserta as $santri)
        						<tr> 
        							<td>{{ $no++ }}</td>
        							<td>{{ $santri->nis }}</td>
        							<td>{{ $santri->santri_name }}</td>
                                    <td class="text-right"><input type="number" step="0.1" name="data[{{$santri->peserta_id}}][nilai_uts_teori]" value="{{ $santri->nilai_uts_teori }}" onkeypress="return isNumberKey(event)"></td>
                                    <td class="text-right"><input type="number" step="0.1" name="data[{{$santri->peserta_id}}][nilai_uts_praktek]" value="{{ $santri->nilai_uts_praktek }}" onkeypress="return isNumberKey(event)"></td>
                                    <td class="text-right"><input type="number" step="0.1" name="data[{{$santri->peserta_id}}][nilai_uas_teori]" value="{{ $santri->nilai_uas_teori }}" onkeypress="return isNumberKey(event)"></td>
                                    <td class="text-right"><input type="number" step="0.1" name="data[{{$santri->peserta_id}}][nilai_uas_praktek]"  value="{{ $santri->nilai_uas_praktek }}" onkeypress="return isNumberKey(event)"></td>
                                    <td class="text-right"><input type="number" step="0.1" name="data[{{$santri->peserta_id}}][khatam]" value="{{ $santri->khatam }}" onkeypress="return isNumberKey(event)"></td>
                                    <td class="text-right"><input type="number" step="0.1" name="data[{{$santri->peserta_id}}][kehadiran]" value="{{ $santri->kehadiran }}" onkeypress="return isNumberKey(event)"></td>
        							<td class="text-right">
                                        <select name="data[{{$santri->peserta_id}}][status]">
                                            <option value=""></option>    
                                            <option value="TETAP" {{ ($santri->status == 'TETAP') ? 'selected' : '' }}>TETAP</option>    
                                            <option value="NAIK" {{ ($santri->status == 'NAIK') ? 'selected' : '' }}>NAIK</option>    
                                        </select>
                                    </td>
        							<td class="text-center">
        								<textarea name="data[{{$santri->peserta_id}}][note]">{{ $santri->catatan }}</textarea>
        							</td>
        							<td class="text-center">
        								<textarea name="data[{{$santri->peserta_id}}][management_note]">{{ $santri->catatan_manajemen }}</textarea>
        							</td>
									@if(env('ENABLE_PENGAJAR_DU'))
        							<td class="text-center" style="min-width: 160px;">
										@if (!empty($santri->daftarUlang))
											@if(@$santri->daftarUlang->jenis_kbm == "CUTI" || @$santri->daftarUlang->hari == "CUTI")
												@if($santri->daftarUlang->isCreatedByPengajar())
													<div class="chip black white-text"><span>CUTI</span> <small>(Pengajar)</small></div>
												@else
													<div class="chip black white-text"><span>CUTI</span></div>
												@endif
											@elseif($santri->daftarUlang->isCreatedByPengajar())
												<div class="chip blue white-text">DU <small>(Pengajar)</small></div>
											@else
												<div class="chip green white-text">DU</div>
											@endif
											@if($santri->daftarUlang->created_by == auth()->id())
												<button type="button" onclick="removeDU('{{ route('halaqoh.du.remove', ['id' => $santri->daftarUlang->id]) }}')" class="btn-floating btn-small waves-effect waves-light red"><i class="mdi-content-clear"></i></button>
											@endif
										@else
											<div style="display:inline-flex; gap:4px; align-items:center; flex-wrap:wrap;">
												<select id="du_hari_{{ $santri->peserta_id }}" class="browser-default" style="height:2rem; font-size:11px; width:auto; padding:0 4px;">
													<option value="">Hari</option>
													@foreach($days as $day)
														<option value="{{ $day }}">{{ $day }}</option>
													@endforeach
													<option value="CUTI">CUTI</option>
												</select>
												<select id="du_kbm_{{ $santri->peserta_id }}" class="browser-default" style="height:2rem; font-size:11px; width:auto; padding:0 4px;">
													<option value="">KBM</option>
													<option value="OFFLINE">OFFLINE</option>
													<option value="ONLINE">ONLINE</option>
													<option value="CUTI">CUTI</option>
												</select>
												<button type="button" onclick="saveDU('{{ $santri->peserta_id }}', '{{ $halaqoh->halaqoh_reference }}')" class="btn-floating btn-small waves-effect waves-light green"><i class="mdi-content-add"></i></button>
											</div>
										@endif
        							</td>
									@endif
        						</tr>
        						@endforeach
        					</tbody>
        				</table>
        			</div>
                </div>
            </div>
            <div class="row" style="margin-bottom: 10px; text-align: right;">
                <div class="col s12">
                    @csrf
                    <input type="hidden" name="halaqohReference" value="{{ $halaqoh->halaqoh_reference }}">
                    <button type="submit" class="waves-effect waves-light btn btn-small"><i class="mdi-content-save right"></i>Simpan</button>
                </div>
            </div>
            </form>

    </div>



@endsection