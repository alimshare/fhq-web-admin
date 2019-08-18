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
                    <li><a href="/" class="cyan-text">Dashboard</a></li>
                    <li class="active">Change Password</li>
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
                    <form class="col s12 l6" action="/change-password" method="POST" id="formValidate"  autocomplete="off">
                      @csrf
                      <div class="row">
                        <div class="input-field col s12">
                          <input id="email" type="email" class="validate" disabled="" value="{{ Auth::user()->email }}">
                          <label for="email">Email</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s12">
                          <input id="old_password" type="password" class="validate" name="old_password" required="">
                          <label for="password">Old Password</label>
                          <div id="old-password-error" class="error"></div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s12">
                          <input id="new_password" type="password" class="validate" name="new_password" required="">
                          <label for="password">New Password</label>
                          <div id="new-password-error" class="error"></div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s12">
                          <input id="confirm_password" type="password" class="validate" name="confirm_password" required="">
                          <label for="password">Confirm New Password</label>
                          <div id="confirm-password-error" class="error"></div>
                        </div>
                      </div>
                      <div class="row" style="margin-top: 25px">
                        <div class="col s12 text-right">
                          <button class="btn waves-effect waves-light light-blue darken-4 " type="submit" name="action" >
                            <i class="mdi-communication-vpn-key"></i> <span>Change Password</span></button>
                        </div>
                      </div>
                    </form>
                </div>
            </div>
        </div>
        <!--end container-->

@endsection

