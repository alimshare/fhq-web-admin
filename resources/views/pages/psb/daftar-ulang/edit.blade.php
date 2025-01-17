@extends('layouts.materialized')

@section('title', 'Edit Daftar Ulang')

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
<script>
    const loadFile = (event, elem) => {
        var target = elem.getAttribute("data-target");
        var output = document.getElementById(target);

        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src) 
        }
    };
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
                        <li><a href="{{ route('du') }}" class="cyan-text">Daftar Ulang</a></li>
                        <li class="active">Edit</li>
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
                    <div class="container">
                        <div class="section">

                            <div class="row">
                                <div class="col s12">
                                    @include('layouts.materialized.components.alert')
                                </div>
                            </div>

                            <div class="row">
                                <div class="col s12 m8 l4">
                                    <form class="" action="{{ route('du.edit', ['id' => $du->id]) }}" method="POST" id="formValidate" autocomplete="off">
                                        <div class="card-panel" id="">
                                            @csrf
                                            
                                            <div class="">
                                                <h5 class="card-title">Informasi Daftar Ulang</h5>
                                            </div>

                                            <div class="row">
                                                <label for="" class="col s12">
                                                    NIS
                                                </label>
                                                <div class="input-field col s12">
                                                    <input type="text" name="nis" readonly value="{{ $du->peserta->santri->nis }}">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <label for="" class="col s12">
                                                    Nama
                                                </label>
                                                <div class="input-field col s12">
                                                    <input type="text" name="name" id="" value="{{ $du->peserta->santri->name }}">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <label for="" class="col s12">
                                                    Tanggal Lahir
                                                </label>
                                                <div class="input-field col s12">
                                                    <input type="date" name="tgl_lahir" id="tgl_lahir" value="{{ $du->tgl_lahir }}">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <label for="" class="col s12">
                                                    Pilihan Hari
                                                </label>
                                                <div class="input-field col s12">
                                                    @php
                                                        $days = ['SABTU','AHAD','CUTI'];
                                                    @endphp
                                                    <select name="hari" id="hari">
                                                        <option value="">-- Pilihan Hari --</option>
                                                        @foreach ($days as $item)
                                                            <option value="{{ $item }}" @if($du->hari == $item) selected @endif>{{ $item }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <label for="" class="col s12">
                                                    Pilihan Jenis KBM
                                                </label>
                                                <div class="input-field col s12">
                                                    @php
                                                        $kbms = ['OFFLINE','ONLINE','CUTI'];
                                                    @endphp
                                                    <select name="jenis_kbm" id="jenis_kbm">
                                                        <option value="">-- Pilihan Jenis KBM --</option>
                                                        @foreach ($kbms as $item)
                                                            <option value="{{ $item }}" @if($du->jenis_kbm == $item) selected @endif >{{ $item }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <label for="" class="col s12">
                                                    Nomor Handphone
                                                </label>
                                                <div class="input-field col s12">
                                                    <input type="text" name="phone" id="" class="disable" value="{{ $du->peserta->santri->phone }}" readonly>
                                                </div>
                                            </div>

                                            <div class="card-footer text-right" style="margin-top: 1rem;">
                                                <button class="btn waves-effect waves-light light-blue darken-4"
                                                    type="submit" name="submit" id="submit">
                                                    <span>Submit</span></button>

                                                <a href="{{ route('du') }}" class="btn waves-effect waves-light"
                                                    name="batal" id="batal">
                                                    <span>Kembali</span></a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col s12 l4">
                                    <div class="card-panel">
                                        
                                        <h5 class="">Informasi Halaqoh</h5>

                                        <table class="table bordered">
                                            <tr>
                                                <td>Semester</td>
                                                <td>{{ $du->peserta->halaqoh->getSemester()->id }}</td>
                                            </tr>
                                            <tr>
                                                <td>Hari</td>
                                                <td>{{ $du->peserta->halaqoh->day }}</td>
                                            </tr>
                                            <tr>
                                                <td>Jenis KBM</td>
                                                <td>{{ $du->peserta->halaqoh->jenis_kbm }}</td>
                                            </tr>
                                            <tr>
                                                <td>Program</td>
                                                <td>{{ $du->peserta->halaqoh->getProgram()->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Pengajar</td>
                                                <td>{{ $du->peserta->halaqoh->getPengajar()->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Status</td>
                                                <td>{{ $du->peserta->status }}</td>
                                            </tr>
                                        </table>
                                        
                                    </div>
                                </div>
                                <div class="col s12 m4 l4">
                                    <div class="card-panel">
                                        <form action="" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <label for="upload_file" class="col s12">Bukti Daftar Ulang</label>
                                                <div class="col s12">
                                                    <input type="file" name="upload_file" id="upload_file" style="margin: 1rem auto;" onchange="loadFile(event, this)" accept="image/*" data-target="preview" >
                                                    <img id="preview" src="{{ '/storage/daftar-ulang/' . $du->upload_file }}" style="width:100%">
                                                </div>
                                            </div>
                                            <div class="card-footer text-right" style="margin-top: 1rem;">
                                                <button class="btn waves-effect waves-light light-blue darken-4" name="simpan_gambar">Simpan Gambar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>

@endsection
