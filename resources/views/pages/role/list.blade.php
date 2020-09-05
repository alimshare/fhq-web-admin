@extends('layouts.materialized')

@section('header-script')
    <style type="text/css">
        li.active a {
            color : white;
        }
    </style>
@endsection

@section('footer-script')
    <script>
        function toggle(source) {
            checkboxes = document.getElementsByClassName('permission-item');
            for(var i=0, n=checkboxes.length;i<n;i++) {
                checkboxes[i].checked = source.checked;
            }
        }
    </script>
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
                    <div class="collection with-header" style="margin-top: 0">
                        <div class="collection-header">
                            <h5>Daftar Role</h5>
                        </div>
                        @foreach($roles as $r)
                            @php
                                $isActive = (isset($role) && $role->id == $r->id) ? "active cyan" : "";
                            @endphp
                            <a href="{{ '/role/'.$r->id }}" class="collection-item {{$isActive}}">
                                {{$r->name}}
                                <span class="secondary-content"><i class="mdi-content-forward"></i></span>
                            </a>
                        @endforeach
                    </div>
                </div>

                @isset($role)
                <div class="col s12 m12 l5">
                    <div class="card">
                        <div class="card-content">
                            <form action="/role/save" method="post">
                                @csrf
                                <h5>Role : {{  optional($role)->name }}</h5>
                                <input type="hidden" name="id" value="{{$role->id}}">

                                <ul class="collection with-header" style="margin-top:15px">
                                    @isset($permissions)
                                        <li class="collection-header">
                                            &nbsp;
                                            <span class="secondary-content">
                                                <input type="checkbox" onclick="toggle(this)" 
                                                    style="position:inherit;visibility:visible">
                                            </span>                                            
                                        </li>
                                        @foreach($permissions as $permission)
                                            <li class="collection-item">
                                                <div>
                                                    {{$permission->name}}
                                                    <span class="secondary-content">
                                                        <input 
                                                            type="checkbox" 
                                                            name="permissions[{{$permission->id}}]"
                                                            id="{{$permission->slug}}" 
                                                            style="position:inherit;visibility:visible"
                                                            class="permission-item"
                                                            @if($permission->allowed) checked @endif
                                                            value="1"
                                                        >
                                                    </span>
                                                </div>
                                            </li>
                                        @endforeach
                                    @endisset
                                </ul>

                        </div>
                        <div class="card-action text-right">
                            <button type="submit" class="waves-effect waves-light green btn btn-small"><i class="mdi-content-create right"></i>Ubah</button>
                        </div>
                        </form>
                    </div>

                </div>
                @endisset

            </div>
        </div>
    </div>
    <!--end container-->

@endsection

