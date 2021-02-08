@extends('layouts.materialized')

@section('header-script')
@endsection
@section('footer-script')
@endsection

@section('content')

    <!--breadcrumbs start-->
    <div id="breadcrumbs-wrapper">
      <div class="container">
        <div class="row">
          <div class="col s12 m12 l12">
            <h5 class="breadcrumbs-title">Santri <small>Edit</small></h5>
            <ol class="breadcrumbs">
                <li><a href="/" class="cyan-text">Dashboard</a></li>
                <li><a href="/santri" class="cyan-text">Santri</a></li>
                <li class="active">Edit</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!--breadcrumbs end-->


    <!--start container-->
    <div class="container" style="margin-bottom: 25px; padding-top: 10px;">
            <form action="/santri/save" method="POST">
            <div class="row"> 
                <div class="col s12 m6"> 
                    <label for="nis">NIS</label>
                    <input type="text" id="nis" name="nis" value="{{ $santri->nis }}">
                </div>
            </div>
            <div class="row"> 
                <div class="col s12 m6"> 
                    <label for="name">Nama</label>
                    <input type="text" name="name" value="{{ $santri->name }}">
                </div>
            </div>
            <div class="row"> 
                <div class="col s12 m6"> 
                    <label for="name">Nomor Handphone</label>
                    <input type="text" name="phone" value="{{ $santri->phone }}">
                </div>
            </div>
            <div class="row">
                <label class="col s12">Jenis Kelamin</label>
                <div class="col s12" style="margin-bottom:1em; text-align:left; margin-top:15px">
                    <span>
                        <input class="with-gap" name="gender" type="radio" value="MALE" id="gender-male" {{ ($santri->gender == 'MALE') ? 'checked' : '' }} />
                        <label for="gender-male">IKHWAN</label>
                    </span>

                    <span>
                        <input class="with-gap" name="gender" type="radio" value="FEMALE" id="gender-female"  {{ ($santri->gender == 'FEMALE') ? 'checked' : '' }} />
                        <label for="gender-female">AKHWAT</label>
                    </span>
                    <div id="day-error" class="error"></div>
                </div>
            </div>
            <div class="row" style="margin-bottom: 10px; text-align: right;">
                <div class="col s12 m6">
                    @csrf
                    <input type="hidden" name="id" value={{ $santri->id }}>
                    <button type="submit" class="waves-effect waves-light btn btn-small"><i class="mdi-content-save right"></i>Save</button>
                </div>
            </div>
            </form>

    </div>



@endsection