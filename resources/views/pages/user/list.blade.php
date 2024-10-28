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
</style>
@endsection

@section('footer-script')
<script src="{{ asset('assets/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript">
    let table = $('#example').DataTable({
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
    });
</script>
@endsection

@section('content')

        <!--breadcrumbs start-->
        <div id="breadcrumbs-wrapper">
          <div class="container">
            <div class="row">
              <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">User</h5>
                <ol class="breadcrumbs">
                    <li><a href="/" class="cyan-text">Dashboard</a></li>
                    <li class="active">User</li>
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
                <div class="row mb-3" style="margin-bottom: 1em">
                    <div class="col s12 text-right">
                        <a href="{{ route('users.add') }}" class="btn cyan">Tambah User</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <div style="overflow-x: scroll;">
                            <table id="example" class="cell-border" cellspacing="0" width="100%">
                                <thead>
                                    <tr class="cyan darken-3 white-text" class="row-header">
                                        <th>Username</th>
                                        <th>Name</th>
                                        <th></th>
                                    </tr>
                                    <tr class="row-filter">
                                        <th><input type="text" placeholder="Cari Username" id="paramUsername" class="input-text"></th>
                                        <th><input type="text" placeholder="Cari Name" id="paramName" class="input-text"></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list as $n)
                                        <tr>
                                            <td>{{ $n->username }}</td>
                                            <td>{{ $n->profile->name ?? '' }}</td>
                                            <td>
                                                @if($n->id != Auth::user()->id)
                                                    @allow('users.reset-password')
                                                        <a href="{{ route('users.reset-password', ['userId'=>$n->id]) }}" class="btn red darker-3" onclick="return confirm('Apakah anda yakin untuk melakukan Reset Password pada Akun ini ?')">Reset Password</a>
                                                    @endallow
                                                @endif
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
            </div>
        </div>
        <!--end container-->

@endsection

