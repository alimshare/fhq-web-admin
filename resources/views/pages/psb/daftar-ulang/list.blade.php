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

        function verify(e) {
            const id = $(e).data('id');
            const completed = $(this).is(':checked');
            $.ajax({
                url: `/daftar-ulang/${id}/verify`,
                method: 'PATCH',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    console.log(res)
                    alert("success");
                }
            });
        }

        function loadImage(e) {
            const target = e.getAttribute("data-path");
            $("#preview").attr("src", `${target}`);
            $('#modal').openModal();
        }

        function confirmDelete(elem) {

            // Generate a random math question
            const num1 = Math.floor(Math.random() * 10) + 1; // Random number between 1 and 10
            const num2 = Math.floor(Math.random() * 10) + 1; // Random number between 1 and 10
            const correctAnswer = num1 + num2; // Calculate the correct answer


            var span = document.createElement("span");
            span.innerHTML = `Konfirmasi Hapus: ${num1} + ${num2}`;

            swal({
                title: `Konfirmasi Hapus: ${num1} + ${num2}`,
                text: "Data DU yang dihapus akan hilang, silahkan hubungi admin untuk pemulihan data, tetapi gambar tidak bisa dipulihkan !", // Caption before the input
                content: "input",
                icon: "warning",
                buttons: true,
            }).then((answer) => {

            if (answer === null) {
                return; // If the user cancels, do nothing
            }

            if (parseInt(answer) === correctAnswer) {
                var data = elem.getAttribute("data-target");
                // document.location = data;

                var form = document.createElement("form");
                form.method = "POST";
                form.action = data;   

                var token = document.createElement("input");
                token.name = "_token";
                token.value = "{{ csrf_token() }}";
                
                form.appendChild(token);
                document.body.appendChild(form);
                form.submit();


            } else {
                swal(`Jawaban tidak tepat, proses hapus dibatalkan`);
            }

            return;
                
            });
        }

        @if (!empty(Request::get('semester_id'))) 
            $('#filter-semester').val({{ Request::get('semester_id') }}).trigger('change');
        @endif
    </script>
@endsection

@section('content')
    <!--breadcrumbs start-->
    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                    <h5 class="breadcrumbs-title">Daftar Ulang</h5>
                    <ol class="breadcrumbs">
                        <li><a href="/" class="cyan-text">Home</a></li>
                        <li class="active">Daftar Ulang</li>
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
                    <option value="37">Semester 36</option>
                    <option value="36">Semester 35</option>
                </select>
                <button type="submit">Pilih</button>
            </form>

            <div class="row">
                <div class="col s12">
                    <div class="card">
                        {{-- <a class="btn green" style="margin-bottom: 0.25rem;" href="{{ route('du.export') }}">Export</a> --}}                        

                        <div class="table-responsive" style="overflow-x:scroll">
                            <table id="datatable" class="display datatable bordered">
                                <thead>
                                    <tr class="cyan darken-3 white-text" class="row-header">
                                        <th>No</th>
                                        <th>Verifikasi</th>
                                        <th>Waktu</th>
                                        <th>NIS</th>
                                        <th>Santri</th>
                                        <th>Umur</th>
                                        <th>Semester</th>
                                        <th>Program</th>
                                        <th>Pengajar</th>
                                        <th>Status</th>
                                        <th>Pilihan Hari</th>
                                        <th>Pilihan KBM</th>
                                        <th>Action</th>
                                    </tr>
                                    <tr class="row-filter">
                                        <td></td>
                                        <td></td>
                                        <th><input type="text" placeholder="Cari Waktu" id="paramWaktu" class="input-text"></th>
                                        <th><input type="text" placeholder="Cari NIS" id="paramNIS" class="input-text"></th>
                                        <th><input type="text" placeholder="Cari Santri" id="paramSantri" class="input-text"></th>
                                        <th><input type="text" placeholder="Cari Umur" id="paramAge" class="input-text"></th>
                                        <th><input type="text" placeholder="Cari Semester" id="paramSemester" class="input-text"></th>
                                        <th><input type="text" placeholder="Cari Program" id="paramProgram" class="input-text"></th>
                                        <th><input type="text" placeholder="Cari Pengajar" id="paramPengajar" class="input-text"></th>                                        
                                        <th><input type="text" placeholder="Cari Status" id="paramStatus" class="input-text"></th> 
                                        <th><input type="text" placeholder="Cari Hari" id="paramHari" class="input-text"></th> 
                                        <th><input type="text" placeholder="Cari KBM" id="paramKBM" class="input-text"></th> 
                                        <td data-dt-order="disable"></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach ($list as $du)
                                        <tr>
                                            <td>{{ $i++ }}.</td>
                                            <td class="text-center">
                                                <input type="checkbox" style="position:inherit;visibility:visible"
                                                    name="verified" id="verified" data-id="{{ $du->id }}"
                                                    @if (!empty($du->verified_at)) checked @endif onchange="verify(this)"
                                                    class="toggle-completed">
                                            </td>
                                            <td>{{ $du->created_at }}</td>
                                            <td>{{ $du->nis }}</td>
                                            <td>{{ $du->santri_name }}</td>
                                            <td>{{ date('Y') - date('Y', strtotime($du->tgl_lahir)) }}</td>
                                            <td>{{ $du->semester_name }}</td>
                                            <td>{{ $du->program_name }}</td>
                                            <td>{{ $du->pengajar_name }}</td>
                                            <td>{{ $du->status }}</td>
                                            <td>{{ $du->hari }}</td>
                                            <td>{{ $du->jenis_kbm }}</td>
                                            <td>
                                                <a class="btn cyan" style="margin-bottom: 0.25rem;" data-path="{{ '/storage/daftar-ulang/' . $du->upload_file }}" target="#" onclick="loadImage(this)">Bukti</a> &nbsp;
                                                <a class="btn green" style="margin-bottom: 0.25rem;" href="{{ route('du.edit', ['id' => $du->id]) }}">Edit</a>
                                                <a class="btn red" style="margin-bottom: 0.25rem;" data-target="{{ route('du.remove', ['id' => $du->id]) }}" onclick="confirmDelete(this)">Hapus</a>
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
