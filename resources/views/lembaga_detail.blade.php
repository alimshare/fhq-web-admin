@extends('layouts.template')
@section('head-title', 'Lembaga')
@section('title','FHQ An-nashr')
@section('body')
<main class="mn-inner">
                <div class="row">
                    <div class="col s12 m12 l6">
                        <div class="card">
                            <div class="card-content">
                                <span class="card-title">Input Lembaga</span><br>
                                <div class="row">
                                    <form class="col s12" action="{{ url('lembaga/postadd') }}" method="POST">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <input id="nama" name="nama" type="text" class="validate" value="{{ $lembaga->data->name }}">
                                                <label for="nama">Nama</label>
                                            </div>
                                            <div class="input-field col s6">
                                                <input id="telp" name="telp" type="text" class="validate" value="{{ $lembaga->data->phone }}">
                                                <label for="telp">Telp</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="alamat" name="alamat" type="text" class="validate" value="{{ $lembaga->data->address }}">
                                                <label for="alamat">Alamat</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <input id="email" type="email" class="validate" value="{{ $lembaga->data->email }}">
                                                <label for="email">Email</label>
                                            </div>
                                            <div class="input-field col s6">
                                                <input id="berdiri" name="berdiri" type="text" class="validate" value="{{ $lembaga->data->since }}">
                                                <label for="berdiri">Tahun Berdiri</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <input id="longitude" name="longitude" type="text" value="{{ $lembaga->data->longitude }}">
                                                <label for="longitude">Longitude</label>
                                            </div>
                                            <div class="input-field col s6">
                                                <input id="latitude" name="latitude" type="text" value="{{ $lembaga->data->latitude }}">
                                                <label for="latitude">Latitude</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <input id="negara" name="negara" type="text" value="{{ $lembaga->data->region }}">
                                                <label for="negara">Negara</label>
                                            </div>
                                            <div class="input-field col s6">
                                                <input id="propinsi" name="propinsi" type="text" value="{{ $lembaga->data->province }}">
                                                <label for="propinsi">Propinsi</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="status" name="status" type="text" value="{{ $lembaga->data->status }}">
                                                <label for="status">Status Lembaga</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12" align="right">
                                                <button class="waves-effect waves-light btn blue m-b-xs" name="btn_ubah" id="btn_ubah">Ubah</button>
                                                <button class="waves-effect waves-light btn pink m-b-xs" name="btn_batal" id="btn_batal">Batal</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
@endsection