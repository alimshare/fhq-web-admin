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
            "paging":true,
            "lengthChange": false,
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
                    <h5 class="breadcrumbs-title">Peserta Daftar Ulang</h5>
                    <ol class="breadcrumbs">
                        <li><a href="/" class="cyan-text">Home</a></li>
                        <li class="active">Peserta Daftar Ulang</li>
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
                    <option value="38">Semester 37</option>
                    <option value="37">Semester 36</option>
                    <option value="36">Semester 35</option>
                </select>
                <button type="submit">Pilih</button>
            </form>

            <div class="row">
                <div class="col s12">
                    <div class="card">                    

                        <div class="row">
                            @php $i = count($list); @endphp
                            @foreach ($list as $du)
                                <div class="col m3" style="margin-bottom:0.4em;display:flex;gap:0.5em;">
                                    <div style="width: 100%;">
                                        <span style="position: absolute; background-color:orange;padding:5px;">{{ $i-- }}</span>
                                        <a data-path="{{ '/storage/daftar-ulang/' . $du->upload_file }}" target="#" onclick="loadImage(this)">
                                            <img src="{{ '/storage/daftar-ulang/' . $du->upload_file }}" alt="" srcset="" style="width:100%; height:200px">
                                        </a>
                                        <div style="padding-left:10px; display:flex; justify-content:space-between;">
                                            <div style="overflow: hidden; width:80%;">
                                                <small>{{ $du->santri_name }} </small>
                                                @if($du->jenis_kbm=="CUTI" || $du->hari == "CUTI")
                                                    <span class="orange white-text" style="">&nbsp;CUTI&nbsp;</span>
                                                @endif
                                                <br> <small>{{ $du->created_at }}</small>
                                            </div>
                                                                                        
                                            @if (!empty($du->verified_at)) 
                                                <span class="chip green white-text">Verified</span> 
                                            @else
                                                <input type="checkbox" style="position:inherit;visibility:visible"
                                                    name="verified" id="verified" data-id="{{ $du->id }}"
                                                    @if (!empty($du->verified_at)) checked @endif onchange="verify(this)"
                                                    class="toggle-completed">                                                
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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
