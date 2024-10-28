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
            <h5 class="breadcrumbs-title">User <small>Add</small></h5>
            <ol class="breadcrumbs">
                <li><a href="/" class="cyan-text">Dashboard</a></li>
                <li><a href="/users" class="cyan-text">User</a></li>
                <li class="active">Add</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!--breadcrumbs end-->


    <!--start container-->
    <div class="container" style="margin-bottom: 25px; padding-top: 10px;">

      <div class="row">
         <div class="col s12">
            @include('layouts.materialized.components.alert')
         </div>
      </div>
        
        <form action="{{ route('users.add') }}" method="POST">

            <div class="row"> 
                <div class="col s12 m6"> 
                    <label for="gender">Pengajar</label>
                    <select name="profile_id" id="profile_id" required class="select2">
                        <option disabled selected>- Pilih Nama Pengajar -</option>
                        @foreach ($profiles as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row"> 
                <div class="col s12 m6"> 
                    <label for="username">Username</label>
                    <input type="text" name="username" value="" required>
                </div>
            </div>

            <div class="row"> 
                <div class="col s12 m6"> 
                    <label for="password">Password</label>
                    <input type="password" name="password" value="" required>
                </div>
            </div>
            <div class="row"> 
                <div class="col s12 m6"> 
                    <label for="confirm_password">Konfirmasi Password</label>
                    <input type="password" name="confirm_password" value="" required>
                </div>
            </div>

            <div class="row" style="margin-bottom: 10px; text-align: right;">
                <div class="col s12 m6">
                    @csrf
                    <a href="{{ route('users') }}" class="btn btn-small">Kembali</a>
                    <button type="submit" class="waves-effect waves-light btn btn-small"><i class="mdi-content-save right"></i>Save</button>
                </div>
            </div>
        </form>

    </div>



@endsection