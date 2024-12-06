@extends('layouts.materialized')

@section('header-script')
    <style type="text/css">
        table.bordered td,
        table.bordered th {
            border: 1px solid rgba(0, 0, 0, .12) !important;
            padding: 15px !important;
        }
    </style>
@endsection

@section('footer-script')
    <script type="text/javascript"></script>
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
                    <div class="card">
                        <table id="" class="display responsive-table datatable-example bordered">
                            <thead>
                                <tr class="cyan darken-3 white-text" class="row-header">
                                    <th></th>
                                    <th>Created At</th>
                                    <th>Nama Santri</th>
                                    <th>Nama Pengajar</th>
                                    <th>Program</th>
                                    <th>Pilihan Hari</th>
                                    <th>Pilihan Jenis KBM</th>
                                    <th>Umur</th>
                                    <th>Bukti Transfer</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list as $du)
                                    <tr>
                                        <td>
                                            <input type="checkbox" style="position:inherit;visibility:visible"
                                                name="verified" id="verified"
                                                @if (!empty($du->verified_at)) checked @endif>
                                        </td>
                                        <td>{{ $du->created_at }}</td>
                                        <td>{{ $du->santri_name }}</td>
                                        <td>{{ $du->pengajar_name }}</td>
                                        <td>{{ $du->program_name }}</td>
                                        <td>{{ $du->hari }}</td>
                                        <td>{{ $du->jenis_kbm }}</td>
                                        <td>{{ $du->tgl_lahir }}</td>
                                        <td>
                                            <a class="" data-path="{{ "/storage/daftar-ulang/".$du->upload_file }}" target="#" onclick="loadImage(this)">Lihat</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>

    </section>
    </div>


    <div id="modal" class="modal modal-fixed-footer">
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

    <script>
        function loadImage(e) {
            const target = e.getAttribute("data-path");
            $("#preview").attr("src", `${target}`);
            $('#modal').openModal();
        }
    </script>
    <!--end container-->
@endsection
