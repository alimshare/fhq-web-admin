@extends('layouts.materialized')

@section('header-script')
    <link href="{{ asset('assets/plugins/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <style type="text/css">
        .dataTables_filter {
            display: none;
        }
        table.dataTable thead .row-filter .sorting_asc {
            background-image: none;
        }
        table.dataTable thead th {
            border: 1px solid #ddd;
        }
        table.dataTable thead tr.row-filter th {
            padding: 5px;
        }
        #input-select .input-field label {
            position: absolute;
            top: -14px;
            font-size: 0.8rem;
        }
        table.dataTable input[type=text], table .select-wrapper input.select-dropdown {
            height: 2rem;
            font-size: 12px;
            border: 1px solid #ddd;
            text-indent: 10px;
            margin: 0;
        }
        table.dataTable tbody th, table.dataTable tbody td {
            padding: 5px;
        }
        li.active a {
            color : white;
        }
        table.bordered td, table.bordered th {
            border: 1px solid rgba(0,0,0,.12) !important;
            padding: 15px !important;
        }
    </style>
@endsection

@section('footer-script')
    <script src="{{ asset('assets/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript">
        let table = $('#user-role-table').DataTable({
            "lengthChange": false,
            "order" : [1, 'asc'],
            "columnDefs": [
                {
                    targets : [0,1,2], 
                    orderable : false
                }
            ]
        });

        // Apply the search
        table.columns().every( function () {
            var that = this;
            $( 'input', this.header() ).on( 'keyup change clear', function () {
                if ( that.search() !== this.value ) {
                    that.search( this.value ).draw();
                }
            }); 
            $( 'select', this.header() ).on( 'change', function () {
                let val = $.fn.dataTable.util.escapeRegex($(this).val());
                that.search( val ? '^'+val+'$' : '', true, false ).draw();
            });            
        });

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
               <div class="col s12">
                  @include('layouts.materialized.components.alert')
               </div>
            </div>

            <div class="row">
            <div class="col s12">
              <ul class="tabs tab-demo-active z-depth-1 cyan" style="width: 100%;">
                <li class="tab col s3"><a class="white-text waves-effect waves-light" href="#role-permission-container">Role & Permission</a>
                </li>
                <li class="tab col s3"><a class="white-text waves-effect waves-light" href="#user-role-container">User & Role</a>
                </li>
              <div class="indicator" style="right: 0px; left: 588px;"></div><div class="indicator" style="right: 0px; left: 588px;"></div></ul>
            </div>
            <div class="col s12" style="padding: 10px">
              <div id="role-permission-container" class="col s12" style="display: block;">

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
                                <div class="row">
                                    <div class="col s6">
                                        <h5>Role : {{  optional($role)->name }}</h5>
                                    </div>
                                    <div class="col s6 text-right">
                                    <a class="btn-floating waves-effect waves-light" href="{{ route('role') }}"><i class="mdi-content-clear"></i></a>
                                    </div>
                                </div>
                                
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

                @endisset

                </div>
              </div>
              <div id="user-role-container" class="col s12" style="display: none;">
                <div class="col s12 m12 l6">
                    <div class="card-panel">
                        <div class="row">
                            <div class="col">
                                <h5>Daftar Role Pengguna</h5>
                            </div>
                        </div>
                        {{-- <div class="row text-right" style="margin:1em auto">
                            <a class="btn waves-effect waves-light cyan darken-2">Tambah</a>
                        </div> --}}
                        <div class="row">
                            <table id="user-role-table" class="cell-border bordered" width="100%">
                                <thead>
                                    <tr class="cyan darken-3 white-text" class="row-header">
                                        <th>User</th>
                                        <th>Role</th>
                                        <th></th>
                                    </tr>
                                    <tr class="row-filter">
                                        <th><input type="text" placeholder="Cari User" id="paramUser" class="input-text"></th>
                                        <th><input type="text" placeholder="Cari Role" id="paramRole" class="input-text"></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($userRoles as $ur)
                                        <tr>
                                            <td>{{ $ur->user->name }}</td>
                                            <td>{{ $ur->role->name }}</td>
                                            <td class="text-center">
                                            <a href="{{ route('user-role.remove', ['userId' => $ur->user_id, 'roleId'=>$ur->role_id]) }}" class="red-text" onclick="return confirm('Yakin ingin menghapus role ini ?')" href="#"><i class="mdi-action-delete small"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>                            
                        </div>
                    </div>
                </div>
                <div class="col s12 l6">
                    {{-- <div class="card-panel">
                        <div class="row">
                            <div class="col">
                                <h5>Tambah Role Pengguna</h5>
                            </div>
                        </div>
                    </div> --}}
                    <form class="" action="{{ route('user-role.save') }}" method="POST" id="formValidate" autocomplete="off">
                        <div class="card-panel" id="profile-card">
                            <h5>Tambah Role Pengguna</h5>
                           @csrf
                           <div class="row">
                              <div class="input-field col s12">
                                 <select name="user_id" id="" class="browser-default">
                                     <option value="" class="disabled" disabled selected>-- Pilih User ---</option>
                                     @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->username }} : {{ $user->profile->name }}</option>
                                     @endforeach
                                 </select>
                                 {{-- <label for="email">Username</label> --}}
                              </div>
                           </div>
                           <div class="row">
                              <div class="input-field col s12">
                                <select name="role_id" id="" class="browser-default">
                                    <option value="" class="disabled" disabled selected>-- Pilih Role ---</option>
                                    @foreach($roles as $role)
                                       <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                 {{-- <label for="password">Role</label> --}}
                              </div>
                           </div>
                           <div class="card-footer text-right" style="margin-top: 1rem;">
                              <button class="btn waves-effect waves-light light-blue darken-4 " type="submit" name="action" >
                              <span>Tambah Role</span></button>
                           </div>
                        </div>
                     </form>
                </div>
              </div> 
            </div>
          </div>
        </div>
    </div>
    <!--end container-->

@endsection

