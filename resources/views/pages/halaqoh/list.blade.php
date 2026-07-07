@extends('layouts.materialized')

@section('header-script')
<link href="{{ asset('assets/plugins/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<style type="text/css">
    .dataTables_filter {
        display: none;
    }
    table.dataTable thead th {
        border: 1px solid #ddd;
    }
    table.dataTable thead tr.row-filter th {
        padding: 5px;
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
    .chip {
        margin-bottom: 0.5rem;
    }
    .tabs .tab a {
        color: #fff !important;
    }
    .tabs .tab a.active {
        background-color: rgba(0,0,0,0.2);
    }
    .tabs .indicator {
        background-color: #fff;
    }
    /* Disable sorting indicators on all headers */
    table.dataTable thead th.sorting,
    table.dataTable thead th.sorting_asc,
    table.dataTable thead th.sorting_desc {
        background-image: none !important;
        cursor: default;
    }
    .sort-controls label {
        position: absolute;
        top: -14px;
        font-size: 0.8rem;
    }
</style>
@endsection

@section('footer-script')
<script src="{{ asset('assets/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript">

    var dtLang = {
        processing: "Memuat data...",
        emptyTable: "Tidak ada data",
        info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
        infoEmpty: "Menampilkan 0 data",
        infoFiltered: "(difilter dari _MAX_ total data)",
        lengthMenu: "Tampilkan _MENU_ data",
        search: "Cari:",
        paginate: { first: "Pertama", last: "Terakhir", next: "&raquo;", previous: "&laquo;" }
    };

    // Bind column filter inputs/selects for a given table
    function bindColumnFilters(tableId, dtInstance) {
        $('#' + tableId + ' thead .row-filter').on('keyup change', 'input', function() {
            var col = $(this).data('col');
            var val = this.value;
            if (dtInstance.column(col).search() !== val) {
                dtInstance.column(col).search(val).draw();
            }
        });
        $('#' + tableId + ' thead .row-filter').on('change', 'select', function() {
            var col = $(this).data('col');
            var val = $(this).val();
            if (dtInstance.column(col).search() !== val) {
                dtInstance.column(col).search(val).draw();
            }
        });
    }

    // Bind sort combo boxes above a table
    function bindSortControls(prefix, dtInstance) {
        function applySort() {
            var col = $('#' + prefix + 'SortBy').val();
            var dir = $('#' + prefix + 'SortDir').val();
            if (col !== '') {
                dtInstance.order([parseInt(col), dir]).draw();
            }
        }
        $('#' + prefix + 'SortBy').on('change', applySort);
        $('#' + prefix + 'SortDir').on('change', applySort);
    }

    // --- Tab 1: Halaqoh table (server-side) ---
    var tblHalaqoh = $('#tblHalaqoh').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/api/datatable/halaqoh',
        columns: [
            { data: 'semester_name', orderable: false },
            { data: 'day', orderable: false },
            { data: 'gender', orderable: false },
            { data: 'program_name', orderable: false },
            { data: 'pengajar_name', orderable: false },
            {
                data: 'halaqoh_reference',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return '<a href="/halaqoh/'+ data +'" class="btn-floating waves-effect waves-light primary tooltipped" data-position="bottom" data-tooltip="Detail"><i class="mdi-action-search"></i></a> ' +
                           '<a onclick="loadPeserta(\''+ row.day +'\',\''+ row.gender +'\',\''+ row.program_name +'\',\''+ row.pengajar_name +'\',\''+ data +'\',\''+ row.semester_name +'\')" class="btn-floating waves-effect waves-light green tooltipped modal-triggers" data-position="bottom" data-tooltip="Daftar Peserta"><i class="mdi-social-people"></i></a>';
                }
            }
        ],
        orderCellsTop: true,
        pageLength: 25,
        order: [[0, 'asc']],
        language: dtLang
    });

    bindColumnFilters('tblHalaqoh', tblHalaqoh);
    bindSortControls('halaqoh', tblHalaqoh);

    // --- Tab 2: Peserta table (server-side, lazy-loaded) ---
    var tblPeserta = null;

    function initPesertaTable() {
        if (tblPeserta !== null) return;
        tblPeserta = $('#tblPeserta').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/api/datatable/peserta',
            columns: [
                { data: 'semester_name', orderable: false },
                { data: 'day', orderable: false },
                { data: 'gender', orderable: false },
                { data: 'program_name', orderable: false },
                {
                    data: 'pengajar_name',
                    orderable: false,
                    render: function(data, type, row) {
                        return '<div style="display:flex;justify-content:space-between;align-items:center;">' +
                               '<span>'+ data +'</span>' +
                               '<a href="/halaqoh/'+ row.halaqoh_reference +'"><i class="mdi-action-search"></i></a>' +
                               '</div>';
                    }
                },
                { data: 'nis', orderable: false },
                {
                    data: 'santri_name',
                    orderable: false,
                    render: function(data, type, row) {
                        return '<div style="display:flex;justify-content:space-between;align-items:center;">' +
                               '<span>'+ data +'</span>' +
                               '<a href="/peserta/'+ row.peserta_reference +'"><i class="mdi-action-search"></i></a>' +
                               '</div>';
                    }
                }
            ],
            orderCellsTop: true,
            pageLength: 25,
            order: [[0, 'asc']],
            language: dtLang
        });
        bindColumnFilters('tblPeserta', tblPeserta);
        bindSortControls('peserta', tblPeserta);
    }

    // Lazy-load peserta table when tab is clicked
    $('ul.tabs').on('click', 'a[href="#tab-peserta"]', function() {
        initPesertaTable();
    });

    // --- Modal: Daftar Peserta per Halaqoh ---
    function loadPeserta(day, gender, program, pengajar, reference, semester) {

        $("#modalSemester").html(semester);
        $("#modalDay").html(day);
        $("#modalProgram").html(program);
        $("#modalPengajar").html(pengajar);

        if (gender == "AKHWAT" || gender == "FEMALE") {
            $(".chip").removeClass('cyan');
            $(".chip").addClass('pink accent-2');
        } else {
            $(".chip").removeClass('pink accent-2');
            $(".chip").addClass('cyan');
        }

        $.get("/api/halaqoh/"+reference+"/peserta", function(res){
            $('.collection-item').remove();
            res.forEach(function(obj){
                var elem = '<div class="collection-item"><div>'+ obj.santri_name +'<a href="/peserta/'+ obj.peserta_reference +'?referer=/halaqoh/'+ reference +'" class="secondary-content"><i class="mdi-content-send"></i></a></div></div>';
                $(".collection").append(elem);
            });
        });

        $('#modal').openModal();
    }

</script>
@endsection

@section('content')

        <!--breadcrumbs start-->
        <div id="breadcrumbs-wrapper">
          <div class="container">
            <div class="row">
              <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">Halaqoh</h5>
                <ol class="breadcrumbs">
                    <li><a href="/" class="cyan-text">Dashboard</a></li>
                    <li class="active">Halaqoh</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!--breadcrumbs end-->

        <!--start container-->
        <div class="container" style="margin-bottom: 25px">
            <div class="section">

                <!-- Modal -->
                <div class="row">
                    <div class="col s12">
                        <div id="modal" class="modal modal-fixed-footer" >
                          <div class="modal-content" style="padding: 0">
                              <ul class="collection with-header" style="margin-top: 0">
                                <li class="collection-header">
                                  <h5>Daftar Peserta Halaqoh</h5>
                                  <p>
                                    <div class="chip cyan white-text"> <i class="mdi-action-event"></i> <span id="modalSemester"></span> </div>
                                    <div class="chip cyan white-text"> <i class="mdi-action-event"></i> <span id="modalDay"></span> </div>
                                    <div class="chip cyan white-text"> <i class="mdi-content-flag"></i> <span id="modalProgram"></span> </div>
                                    <div class="chip cyan white-text"> <i class="mdi-social-person-outline"></i> <span id="modalPengajar"></span> </div>
                                  </p>
                                </li>
                              </ul>
                          </div>
                          <div class="modal-footer">
                            <a href="#" class="waves-effect waves-green btn-flat modal-action modal-close">Cancel</a>
                          </div>
                        </div>
                    </div>
                </div>

                <!-- Tabs -->
                <div class="row">
                    <div class="col s12">
                        <ul class="tabs tab-demo-active z-depth-1 cyan" style="width: 100%;">
                            <li class="tab col s6"><a class="white-text waves-effect waves-light active" href="#tab-halaqoh">Daftar Halaqoh</a></li>
                            <li class="tab col s6"><a class="white-text waves-effect waves-light" href="#tab-peserta">Daftar Peserta</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Tab 1: Halaqoh -->
                <div id="tab-halaqoh" class="col s12">
                    <div class="row sort-controls" style="margin-top: 10px">
                        <div class="col s6 l3">
                            <label>Urutkan</label>
                            <select id="halaqohSortBy">
                                <option value="0" selected>Semester</option>
                                <option value="1">Hari</option>
                                <option value="2">Gender</option>
                                <option value="3">Program</option>
                                <option value="4">Pengajar</option>
                            </select>
                        </div>
                        <div class="col s6 l2">
                            <label>&nbsp;</label>
                            <select id="halaqohSortDir">
                                <option value="asc" selected>A-Z</option>
                                <option value="desc">Z-A</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <div style="overflow-x: scroll;">
                                <table id="tblHalaqoh" class="cell-border" cellspacing="0" width="100%">
                                    <thead>
                                        <tr class="cyan darken-3 white-text">
                                            <th>Semester</th>
                                            <th>Hari</th>
                                            <th>Gender</th>
                                            <th>Program</th>
                                            <th>Pengajar</th>
                                            <th>Action</th>
                                        </tr>
                                        <tr class="row-filter">
                                            <th><input type="text" placeholder="Cari Semester" data-col="0"></th>
                                            <th><input type="text" placeholder="Cari Hari" data-col="1"></th>
                                            <th>
                                                <select data-col="2">
                                                    <option value="">Semua</option>
                                                    <option value="IKHWAN">IKHWAN</option>
                                                    <option value="AKHWAT">AKHWAT</option>
                                                </select>
                                            </th>
                                            <th><input type="text" placeholder="Cari Program" data-col="3"></th>
                                            <th><input type="text" placeholder="Cari Pengajar" data-col="4"></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab 2: Peserta -->
                <div id="tab-peserta" class="col s12">
                    <div class="row sort-controls" style="margin-top: 10px">
                        <div class="col s6 l3">
                            <label>Urutkan</label>
                            <select id="pesertaSortBy">
                                <option value="0" selected>Semester</option>
                                <option value="1">Hari</option>
                                <option value="2">Gender</option>
                                <option value="3">Program</option>
                                <option value="4">Pengajar</option>
                                <option value="5">NIS</option>
                                <option value="6">Santri</option>
                            </select>
                        </div>
                        <div class="col s6 l2">
                            <label>&nbsp;</label>
                            <select id="pesertaSortDir">
                                <option value="asc" selected>A-Z</option>
                                <option value="desc">Z-A</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <div style="overflow-x: scroll;">
                                <table id="tblPeserta" class="cell-border" cellspacing="0" width="100%">
                                    <thead>
                                        <tr class="cyan darken-3 white-text">
                                            <th>Semester</th>
                                            <th>Hari</th>
                                            <th>Gender</th>
                                            <th>Program</th>
                                            <th>Pengajar</th>
                                            <th>NIS</th>
                                            <th>Santri</th>
                                        </tr>
                                        <tr class="row-filter">
                                            <th><input type="text" placeholder="Cari Semester" data-col="0"></th>
                                            <th><input type="text" placeholder="Cari Hari" data-col="1"></th>
                                            <th>
                                                <select data-col="2">
                                                    <option value="">Semua</option>
                                                    <option value="IKHWAN">IKHWAN</option>
                                                    <option value="AKHWAT">AKHWAT</option>
                                                </select>
                                            </th>
                                            <th><input type="text" placeholder="Cari Program" data-col="3"></th>
                                            <th><input type="text" placeholder="Cari Pengajar" data-col="4"></th>
                                            <th><input type="text" placeholder="Cari NIS" data-col="5"></th>
                                            <th><input type="text" placeholder="Cari Santri" data-col="6"></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!--end container-->

@endsection
