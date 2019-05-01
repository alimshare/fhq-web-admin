@extends('layouts.template')

@section('head-title', 'Semester')

@section('title', 'FHQ An-nashr')

@section('body')
<main class="mn-inner">
    <div class="row">
        <div class="col s12">
            <div class="page-title">Semester Detail</div>
        </div>
        <div class="col s12 m12 l8">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Main</span><br>
                    <div class="row">
                        <form class="col s12">
                            <div class="row">
                                <div class="input-field col s12">
                                    <input placeholder="Lembaga" id="lembaga" type="text" class="validate" value="{{ $semester->data->lembaga->name }}">
                                    <label for="lembaga">Lembaga</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input placeholder="Deskripsi" id="deskripsi" type="text" class="validate" value="{{ $semester->data->description }}">
                                    <label for="deskripsi">Deskripsi</label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m12 l4">

            <div class="card">
                <div class="card-content">
                    <span class="card-title">Status</span><br>
                    <div class="row">
                        <div class="col s12">
                            <!-- Switch -->
                            <div class="switch m-b-md">
                                <label>
                                    <input type="checkbox"{!! $semester->data->active ? ' checked=""' : '' !!}>
                                    <span class="lever"></span>
                                    Active
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection