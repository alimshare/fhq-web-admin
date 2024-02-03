@extends('layouts.materialized')

@section('header-script')
<link href="{{ asset('assets/plugins/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<style type="text/css">
    .dataTables_filter {
        display: none;
    }
    table.dataTable thead .row-filter .sorting_asc {
        background-image: none;
    }
    table.dataTable thead th {
        border: 1px solid #ddd;
    }
    table.dataTable thead tr.row-filter th {
        padding: 5px;
    }
    #input-select .input-field label {
        position: absolute;
        top: -14px;
        font-size: 0.8rem;
    }
    table.dataTable input[type=text], table .select-wrapper input.select-dropdown {
        height: 2rem;
        font-size: 12px;
        border: 1px solid #ddd;
        text-indent: 10px;
        margin: 0;
    }
    table.dataTable tbody th, table.dataTable tbody td {
        padding: 8px;
    }
</style>
@endsection


@section('footer-script')
<script src="{{ asset('assets/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript">
    let table = $('#table-kbm').DataTable({
        "paging":true,
        "lengthChange": false,
        "pageLength": 25,
        "ordering": false,
        initComplete: function () {
            this.api().columns().every( function () {
                var column = this;

                if ([1,2,3].includes(column.index())) {
                    var select = $('<select><option value=""></option></select>')
                        .appendTo( $(column.header()).empty() )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
    
                            column.search( val ? '^'+val+'$' : '', true, false).draw();
                        });
    
                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    });

                } else {
                    $( 'input', this.header() ).on( 'keyup change clear', function () {
                        if ( column.search() !== this.value ) {
                            column.search( this.value ).draw();
                        }
                    } );
                }

            } );
        }
    });
</script>
@endsection


@section('content')

<!--breadcrumbs start-->
<div id="breadcrumbs-wrapper">
    <div class="container">
        <div class="row">
        <div class="col s12 m12 l12">
            <h5 class="breadcrumbs-title">Rekap KBM</h5>
            <ol class="breadcrumbs">
                <li><a href="/" class="cyan-text">Beranda</a></li>
                <li class="active">Monitor</li>
                <li class="active">Rekap KBM</li>
            </ol>
        </div>
        </div>
    </div>
</div>
<!--breadcrumbs end-->


<!--start container-->
<div class="col s12">
    <div class="container">
       <div class="section">
          <div class="row">
             <div class="col s12">
                @include('layouts.materialized.components.alert')
             </div>
          </div>

          <div class="row text-right">
              <div class="col s12">
                @allow('rekap-kbm.download')
                <a href="{{ route('rekap.kbm.download') }}" class="btn cyan darken-2">Download</a>
                @endallow
              </div>
          </div>

          <div class="row">
             <div class="col s12">
                <div class="card-panel no-padding">
                    <table id="table-kbm" class="table" cellpadding="5px" width="100%">
                        <thead>
                            <tr class="cyan darken-3 white-text">
                                <th class="sorting_desc" tabindex="0" aria-controls="table-kbm" rowspan="1" colspan="1" aria-label=": activate to sort column ascending" style="width: 148px;" aria-sort="descending">Tanggal Absensi</th>
                                <th>Hari</th>
                                <th>Program</th>
                                <th>Pengajar</th>
                                <th>Waktu Mulai</th>
                                <th>Waktu Selesai</th>
                                <th>Jumlah Peserta</th>
                                <th>Jumlah Peserta Hadir</th>
                            </tr>
                            <tr class="row-filter">
                                <th><input type="text" placeholder="yyyy-mm-dd" class="input-text" id="paramTanggal"></th>
                                <th><input type="text" placeholder="Hari Belajar" class="input-text" id="paramHari"></th>
                                <th><input type="text" placeholder="program" class="input-text" id="paramProgram"></th>
                                <th><input type="text" placeholder="pengajar" class="input-text" id="paramPengajar"></th>
                                <th></th>
                                <th></th>
                                <th></th>
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
                                <td>{{ empty($k->end_time) ? '' : date('H:i', strtotime($k->end_time)) }}</td>
                                <td>{{ $k->attendances_count }}</td>
                                <td>{{ $k->hadir_count }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
             </div>
          </div>

          <div class="row">
                <div class="col s12 l4">
                    <div class="card-panel">
                        <h5>Download berdasarkan tanggal</h5>
                        <form action="{{ route('rekap.kbm.download') }}" method="GET">

                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="tgl" name="start_date" type="text" value="{{ date('Y-m-d') }}" maxlength="10">
                                    <label for="tgl">Tanggal Awal</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="tgl" name="end_date" type="text" value="{{ date('Y-m-d') }}" maxlength="10">
                                    <label for="tgl">Tanggal Akhir</label>
                                </div>
                            </div>

                            <button type="submit" class="btn cyan darken-2">Download</button>

                        </form>
                    </div>
                </div>
          </div>

       </div>
    </div>
</div>
<!--end container-->

@endsection