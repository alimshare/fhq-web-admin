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
    .hide-mobile {
        display: table-cell;
    }
    @media(max-width: 430px) {
        .table-responsive {
            overflow-x: scroll;
            scroll-behavior: smooth;
        }
        .hide-mobile {
            display:none;
        }
    }
</style>
@endsection


@section('footer-script')
<script src="{{ asset('assets/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript">
    let table = $('#table-kehadiran').DataTable({
        "paging":true,
        "lengthChange": false,
        "pageLength": 100,
        "ordering": false,
        initComplete: function () {
            this.api().columns().every( function () {
                var column = this;

                if ([0,1,2].includes(column.index())) {
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
            <h5 class="breadcrumbs-title">Rekap Kehadiran Peserta</h5>
            <ol class="breadcrumbs">
                <li><a href="/" class="cyan-text">Beranda</a></li>
                <li class="active">Monitor</li>
                <li class="active">Rekap Kehadiran</li>
            </ol>
        </div>
        </div>
    </div>
</div>
<!--breadcrumbs end-->


<div class="col s12">
    <div class="container">
  
        <div class="section">
            <div class="card-panel l6 no-padding" style="padding-bottom: 15px !important">
                <div class="row">
                    <div class="col s12 table-responsive">
                        <table id="table-kehadiran" class="table" cellpadding="1px" width="100%">
                            <thead>
                                <tr class="cyan darken-3 white-text">
                                    <th class="hide-mobile">Hari</th>
                                    <th class="hide-mobile">Program</th>
                                    <th class="hide-mobile">Nama Pengajar</th>
                                    <th>Nama Santri</th>
                                    <th>Total Kehadiran</th>
                                </tr>
                                <tr class="row-filter">
                                    <th class="hide-mobile"></th>
                                    <th class="hide-mobile"></th>
                                    <th class="hide-mobile"></th>
                                    <th><input type="text" placeholder="nama santri" class="input-text"></th>
                                    <th></th>
                                </tr>
                            </thead>
            
                            <tbody>
                                @foreach($kehadiran as $k)
                                    <tr>
                                        <td class="text-left hide-mobile">{{ @$k->peserta->day}} </td>
                                        <td class="text-left hide-mobile">{{ @$k->peserta->program_name }} </td>
                                        <td class="text-left hide-mobile">{{ @$k->peserta->pengajar_name }} </td>
                                        <td class="text-left">{{ @$k->peserta->santri_name }} </td>
                                        <td>{{ @$k->count_kehadiran }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
    
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection