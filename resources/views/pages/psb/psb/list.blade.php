@extends('layouts.materialized')

@section('header-script')
    <style type="text/css">
        table.bordered td,
        table.bordered th {
            border: 1px solid rgba(0, 0, 0, .12) !important;
            padding: 15px !important;
        }
    </style>

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

        table.dataTable input[type=text],
        table .select-wrapper input.select-dropdown {
            height: 2rem;
            font-size: 12px;
            border: 1px solid #ddd;
            text-indent: 10px;
            margin: 0;
        }

        table.dataTable tbody th,
        table.dataTable tbody td {
            padding: 5px;
        }
        
        table.dataTable.no-footer {
            border-bottom: 1px solid #ddd;
        }

        .btn-outline {
            outline: 1px solid #aaa;
            padding: 8px 12px;
            margin: 0 5px;
        }

        .btn-outline:hover {
            background-color: #ddd;
        }

        .select-wrapper span.caret {
            color: darkgray;
            right: 4px;
            top: 9px;
        }
    </style>
@endsection

@section('footer-script')

    <script src="{{ asset('assets/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript">
        let table = $('#datatable').DataTable({
            "paging":false,
            "lengthChange": true,
            ordering: false,
            initComplete: function () {
                this.api().columns().every( function () {
                    var column = this;

                    // $( 'input', this.header() ).on( 'keyup change clear', function () {
                    //     if ( column.search() !== this.value ) {
                    //         column.search( this.value ).draw();
                    //     }
                    // } );

                    if ([6].includes(column.index())) {
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

        function loadImage(e) {
            const target = e.getAttribute("data-path");
            $("#preview").attr("src", `${target}`);
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
                    <h5 class="breadcrumbs-title">Pendaftaran Peserta Baru</h5>
                    <ol class="breadcrumbs">
                        <li><a href="/" class="cyan-text">Home</a></li>
                        <li class="active">Peserta Baru</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs end-->


    <!--start container-->
    <div class="container" style="margin-bottom: 25px">
        <section class="section users-view">

            <div class="row">
                <div class="col s12">
                    @include('layouts.materialized.components.alert')
                </div>
            </div>
            
            <form action="" method="get" style="display: inline-flex; align-items:center; gap:1.5rem;">
                <select name="semester_id" id="filter-semester" class="browser-default">
                    <option value="">- Pilih Semester -</option>
                    @foreach ($daftarSemester as $item)
                        <option value="{{ $item }}" {{ $item == $semester ? 'selected' : '' }}>Semester {{ $item }}</option>
                    @endforeach
                </select>
                <button type="submit">Pilih</button>
            </form>

            <div class="row">
                <div class="col s12">
                    <div class="card">

                        <div class="table-responsive" style="overflow-x:scroll">
                            <table id="datatable" class="display datatable bordered">
                                <thead>
                                    <tr class="cyan darken-3 white-text" class="row-header">
                                        <th scope="col">No</th>
                                        <th scope="col">Waktu</th>
                                        <th scope="col">Kode</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Jenis Kelamin</th>
                                        <th scope="col">Umur</th>
                                        <th scope="col">Jenis Program</th>
                                        <th scope="col">Penguji</th>
                                        <th scope="col">Hasil PT</th>
                                        <th scope="col">Hari</th>
                                        <th scope="col">KBM</th>
                                        <th scope="col">Nomor HP</th>
                                        <th scope="col"></th>
                                    </tr>
                                    <tr class="row-filter">
                                        <td></td>
                                        <th><input type="text" placeholder="Cari Waktu" id="paramWaktu" class="input-text"></th>
                                        <th><input type="text" placeholder="Nomor Pendaftaran" id="paramRegisterNumber" class="input-text"></th>
                                        <th><input type="text" placeholder="Cari Nama" id="paramNama" class="input-text"></th>
                                        <th><input type="text" placeholder="Cari Jenkel" id="paramJenkel" class="input-text"></th>
                                        <th><input type="text" placeholder="Cari Umur" id="paramAge" class="input-text"></th>
                                        <th><input type="text" placeholder="Cari Program" id="paramProgram" class="input-text"></th>
                                        <th><input type="text" placeholder="Penguji PT" id="paramPenguji" class="input-text"></th>                                        
                                        <th><input type="text" placeholder="Hasil PT" id="paramHasilPt" class="input-text"></th> 
                                        <th><input type="text" placeholder="Cari Hari" id="paramHari" class="input-text"></th> 
                                        <th><input type="text" placeholder="Cari KBM" id="paramKBM" class="input-text"></th> 
                                        <th><input type="text" placeholder="Cari Nomor HP" id="paramNoHp" class="input-text"></th> 
                                        <td data-dt-order="disable"></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach($calonSantri as $cs)
                                        <tr>
                                            <td>{{ $i++ }}.</td>
                                            <td>{{ $cs->created_at }}</td>
                                            <td>{{ $cs->registration_number }}</td>
                                            <td>{{ $cs->name }}</td>
                                            <td>
                                                @if ($cs->gender == 'MALE')
                                                    Laki-laki
                                                @elseif($cs->gender == 'FEMALE')
                                                    Perempuan
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ date('Y') - date('Y', strtotime($cs->birth_date)) }}</td>
                                            <td>{{ $cs->program }} @if($cs->is_child) (ANAK) @endif</td>
                                            <td>{{ $cs->penguji }}</td>
                                            <td>{{ $cs->program_pt }}</td>
                                            <td>{{ $cs->day }}</td>
                                            <td>{{ $cs->jenis_kbm }}</td>
                                            <td>{{ @$cs->phone }}</td>
                                            <td>
                                                <a class="btn cyan" style="margin-bottom: 0.25rem;" data-path="{{ env('WEB_DAFTAR_IMAGE_PATH', "https://daftar.fhqannashr.org/storage/upload/") . $cs->upload_file }}" target="#" onclick="loadImage(this)">Bukti</a> &nbsp;
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
    </div>

    </section>
    </div>


    <div id="modal" class="modal modal-fixed-footer" style="">
        <div class="modal-content" style="padding: 0">
            <ul class="collection with-header" style="margin-top: 0">
                <li class="collection-header">
                    <h5>Bukti Transfer</h5>
                </li>
                <li>
                    <img src="" alt="" id="preview" width="100%">
                </li>
            </ul>
        </div>
        <div class="modal-footer">
            <a href="#" class="waves-effect waves-green btn-flat modal-action modal-close">Cancel</a>
        </div>
    </div>
@endsection
