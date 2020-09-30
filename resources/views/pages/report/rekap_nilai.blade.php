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
        padding: 5px;
    }
</style>
@endsection

@section('footer-script')
<script src="{{ asset('assets/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript">
    let table = $('#example').DataTable({
        "paging":false,
        "lengthChange": true,
        "order" : [1, 'asc'],
        "columnDefs": [
            {
                targets : [0,1,2,12,13], 
                orderable : false
            }
        ]
    });

    // Apply the search
    table.columns().every( function () {
        var that = this;
        $( 'input', this.header() ).on( 'keyup change clear', function () {
            if ( that.search() !== this.value ) {
                that.search( this.value ).draw();
            }
        }); 
        $( 'select', this.header() ).on( 'change', function () {
            let val = $.fn.dataTable.util.escapeRegex($(this).val());
            that.search( val ? '^'+val+'$' : '', true, false ).draw();
        });            
    });

    $("#orderBy").on('change', function(){
        let colIdx = $("#orderBy").val();
        let orderType = $("#orderType").val();
        order(colIdx, orderType);
    });

    $("#orderType").on('change', function(){
        let colIdx = $("#orderBy").val();
        let orderType = $("#orderType").val();
        order(colIdx, orderType); 
    });

    function order(columnIndex, type){
        table.order([columnIndex, type]).draw();
    }

        $("#btn_add").click(function(){
            $("form-daftar").show();
        });

</script>
@endsection

@section('content')

        <!--breadcrumbs start-->
        <div id="breadcrumbs-wrapper">
          <div class="container">
            <div class="row">
              <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">Rekap Nilai</h5>
                <ol class="breadcrumbs">
                    <li><a href="/" class="cyan-text">Beranda</a></li>
                    <li class="active">Monitor</li>
                    <li class="active">Rekap Nilai</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!--breadcrumbs end-->
        

        <!--start container-->
        <div class="container" style="margin-bottom: 25px">
            <div class="section text-right">
                @allow('rekap-nilai.download')
                <a href="{{ route('rekap.nilai.download') }}" class="btn cyan darken-2">Download</a>
                @endallow
                </div>
                <div class="row">
                    <div class="col s12">
                        <div style="overflow-x: scroll;">
                            <table id="example" class="cell-border" cellspacing="0" width="100%">
                                <thead>
                                    <tr class="cyan darken-3 white-text" class="row-header">
                                        <th>Hari</th>
                                        <th>Gender</th>
                                        <th>Program</th>
                                        <th>Pengajar</th>
                                        <th>NIS</th>
                                        <th>Santri</th>
                                        <th>UTS Praktek</th>
                                        <th>UTS Teori</th>
                                        <th>UAS Praktek</th>
                                        <th>UAS Teori</th>
                                        <th>Khatam</th>
                                        <th>Kehadiran</th>
                                        <th>Status</th>
                                        <th>Catatan</th>
                                    </tr>
                                    <tr class="row-filter">
                                        <th>
                                            <select id="paramHari">
                                                <option value=""></option>
                                                <option value="SABTU">SABTU</option>
                                                <option value="AHAD">AHAD</option>
                                            </select>
                                        </th>
                                        <th>
                                            <select id="paramGender">
                                                <option value=""></option>
                                                <option value="IKHWAN">IKHWAN</option>
                                                <option value="AKHWAT">AKHWAT</option>
                                            </select>
                                        </th>
                                        <th><input type="text" placeholder="Cari Program" id="paramProgram" class="input-text"></th>
                                        <th><input type="text" placeholder="Cari Pengajar" id="paramPengajar" class="input-text"></th>
                                        <th><input type="text" placeholder="Cari NIS" id="paramNIS" class="input-text"></th>
                                        <th><input type="text" placeholder="Cari Santri" id="paramSantri" class="input-text"></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>
                                            <select id="paramStatus">
                                                <option value=""></option>
                                                <option value="NAIK">NAIK</option>
                                                <option value="TETAP">TETAP</option>
                                            </select>
                                        </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list as $n)
                                        <tr>
                                            <td>{{ $n->day }}</td>
                                            <td>{{ ($n->gender=="FEMALE") ? "AKHWAT" : "IKHWAN" }}</td>
                                            <td>{{ $n->program_name }}</td>
                                            <td>{{ $n->pengajar_name }}</td>
                                            <td>{{ $n->nis }}</td>
                                            <td>{{ $n->santri_name }}</td>
                                            <td>{{ $n->nilai_uts_praktek }}</td>
                                            <td>{{ $n->nilai_uts_teori }}</td>
                                            <td>{{ $n->nilai_uas_praktek }}</td>
                                            <td>{{ $n->nilai_uas_teori }}</td>
                                            <td>{{ $n->khatam }}</td>
                                            <td>{{ $n->kehadiran }}</td>
                                            <td>{{ $n->status }}</td>
                                            <td>{{ $n->catatan }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>                            
                        </div>
						
                    </div>
                </div>
            </div>
        </div>
        <!--end container-->
@endsection

