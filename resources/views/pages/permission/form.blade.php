
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
                <h5 class="breadcrumbs-title">Permissions</h5>
                <ol class="breadcrumbs">
                    <li><a href="/" class="cyan-text">Dashboard</a></li>
                    <li><a href="/permissions" class="cyan-text">Permission</a></li>
                    <li class="active">Form</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!--breadcrumbs end-->
        

        <!--start container-->
        <div class="container" style="margin-bottom: 25px">
            <div class="section">
                <div class="row">
                <div class="col s12">
                    @include('layouts.materialized.components.alert')
                </div>
                </div>
                <div class="row">
                    <div class="col s12 m6">
                        <form class="" action="/permissions/save" method="POST" id="formValidate" autocomplete="off">
                            <div class="card-panel" id="profile-card">
                                <div class="card-title">
                                    <h5>Tambah Permission</h5>
                                </div>
                                @csrf
                                <input type="hidden" name="id">
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input id="name" type="text" name="name">
                                        <label for="name">Description</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input id="slug" type="text" name="slug">
                                        <label for="slug">Slug</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input id="category" type="text" name="category">
                                        <label for="category">Category</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input id="sequance" type="text" name="sequance">
                                        <label for="sequance">Sequance</label>
                                    </div>
                                </div>
                                <div class="card-footer text-right" style="margin-top: 1rem;">
                                    <a href="/permissions" class="btn waves-effect waves-light" >
                                    <span>Cancel</span></a>
                                    <button class="btn waves-effect waves-light light-blue darken-4 " type="submit" name="action" >
                                    <span>Save</span></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--end container-->

@endsection

