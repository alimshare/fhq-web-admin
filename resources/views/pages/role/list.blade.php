@extends('layouts.materialized')

@section('header-script')
    <style type="text/css">
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
                    <h5 class="breadcrumbs-title">Role & Permission</h5>
                    <ol class="breadcrumbs">
                        <li><a href="/" class="cyan-text">Dashboard</a></li>
                        <li class="active">Role & Permission</li>
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
                <div class="col s12 m12 l4">
                    <ul class="collection with-header" style="margin-top: 0">
                        <li class="collection-header">
                            <h5>Daftar Role</h5>
                        </li>
                        @foreach($roles as $role)
                            @php
                                $isActive = (isset($object) && $role->id == $role->id) ? "active" : "";
                            @endphp
                            <li class="collection-item {{$isActive}}">
                                <a href="{{ '/role/'.$role->id }}">
                                    {{$role->name}}
                                    <span class="secondary-content"><i class="mdi-content-forward"></i></span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                @isset($role)
                <div class="col s12 m12 l8">
                    <div class="card">
                        <div class="card-content">
                            <form action="" method="post">
                                <h5>Role : {{  $role->name }}</h5>
                                <input type="hidden" name="id" value="{{$role->id}}">

                                <ul class="collection with-header" style="margin-top: 0">
                                    @foreach($permissions as $permission)
                                        <li class="collection-item">
                                            <div>
                                                {{$permission->name}}
                                                <div class="secondary-content">
                                                    @if ($permission->allowed)
                                                        <label class="cyan-text">YES</label>
                                                    @else
                                                        <label class="red-text">NO</label>
                                                    @endif
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>

                            </form>
                        </div>
                        <div class="card-action text-right">
                            <a href="/role/save" class="waves-effect waves-light green btn btn-small"><i class="mdi-content-create right"></i>Ubah</a>
                        </div>
                    </div>

                </div>
                @endisset

            </div>
        </div>
    </div>
    <!--end container-->

@endsection

