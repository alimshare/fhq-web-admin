@extends('layouts.materialized')

@section('header-script')
<style type="text/css">
    table td, table th {
        border : 1px solid #ddd;
    }
    .error {
        color : red;
    }
</style>
@endsection

@section('footer-script')

@endsection

@section('content')

<!--breadcrumbs start-->
<div id="breadcrumbs-wrapper">
  <div class="container">
     <div class="row">
        <div class="col s12 m12 l12">
           <h5 class="breadcrumbs-title">Change Password</h5>
           <ol class="breadcrumbs">
              <li><a href="/" class="cyan-text">Home</a></li>
              <li class="active">Change Password</li>
           </ol>
        </div>
     </div>
  </div>
</div>
<!--breadcrumbs end-->
<div class="col s12">
  <div class="container">
     <div class="section users-view">
        <div class="row">
           <div class="col s12">
              @include('layouts.materialized.components.alert')
           </div>
        </div>
        <div class="row">
           <div class="col s12 m8 l4">
              <form class="" action="/change-password" method="POST" id="formValidate" autocomplete="off">
                 <div class="card-panel" id="profile-card">
                    @csrf
                    <div class="row">
                       <div class="input-field col s12">
                          <input id="email" type="email" class="validate" disabled="" value="{{ Auth::user()->username }}">
                          <label for="email">Username</label>
                       </div>
                    </div>
                    <div class="row">
                       <div class="input-field col s12">
                          <input id="old_password" type="password" class="validate" name="old_password" required="">
                          <label for="password">Password Lama</label>
                          <div id="old-password-error" class="error"></div>
                       </div>
                    </div>
                    <div class="row">
                       <div class="input-field col s12">
                          <input id="new_password" type="password" class="validate" name="new_password" required="">
                          <label for="password">Password Baru</label>
                          <div id="new-password-error" class="error"></div>
                       </div>
                    </div>
                    <div class="row">
                       <div class="input-field col s12">
                          <input id="confirm_password" type="password" class="validate" name="confirm_password" required="">
                          <label for="password">Ulangi Password Baru</label>
                          <div id="confirm-password-error" class="error"></div>
                       </div>
                    </div>
                    <div class="card-footer text-right" style="margin-top: 1rem;">
                       <button class="btn waves-effect waves-light light-blue darken-4 " type="submit" name="action" >
                       <span>Ubah Password</span></button>
                    </div>
                 </div>
              </form>
           </div>
        </div>
     </div>
  </div>
</div>
       
@endsection

