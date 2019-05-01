@extends('layouts.template')

@section('head-title', 'Detail Pengajar')

@section('title', 'FHQ An-nashr')

@section('body')
<main class="mn-inner">
    <div class="row">
        <div class="col s12">
            <div class="page-title">Detil Pengajar</div>
        </div>
        <div class="col s12 m12 l8">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Main</span><br>
                    <div class="row">
                        <form class="col s12">
                            <div class="row">
                                <div class="input-field col s12">
                                    <input placeholder="Nama" id="nama" type="text" class="validate" value="{{ $pengajar->data->name }}">
                                    <label for="nama">Nama</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input placeholder="Alamat" id="alamat" type="text" class="validate" value="{{ $pengajar->data->address }}">
                                    <label for="alamat">Alamat</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input placeholder="Email" id="email" type="text" class="validate" value="{{ $pengajar->data->email }}">
                                    <label for="email">Email</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input placeholder="Phone" id="phone" type="text" class="validate" value="{{ $pengajar->data->phone }}">
                                    <label for="phone">Phone</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input placeholder="Pendidikan Terakhir" id="pendidikan_terakhit" type="text" class="validate" value="{{ $pengajar->data->educational_background }}">
                                    <label for="pendidikan_terakhir">Pendidikan Terakhir</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input placeholder="Bidang Pendidikan" id="bidang_pendidikan" type="text" class="validate" value="{{ $pengajar->data->phone }}">
                                    <label for="bidang_pendidikan">Bidang Pendidikan</label>
                                </div>
                            </div>
                            <div class="row right">
                            	<a href=""><button class="btn btn-default">Kembali</button></a>
                            	<a href=""><button class="btn btn-default">Ubah</button></a>
                            	<a href=""><button class="btn btn-default">Hapus</button></a>
                            </div>	
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection