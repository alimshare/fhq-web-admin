@extends('layouts.materialized')

@section('header-script')
<link href="{{ asset('assets/plugins/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<style type="text/css">
    table.dataTable thead th {
        border: 1px solid #ddd;
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
        "paging":false,
        "lengthChange": true,
        "columnDefs": [
            {
                targets : [4], 
                orderable : false
            }
        ]
    });
</script>
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
                    <li class="active">Permissions</li>
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
                        <div style="overflow-x: scroll;">
                            <table id="example" class="cell-border" cellspacing="0" width="100%">
                                <thead>
                                    <tr class="cyan darken-3 white-text" class="row-header">
                                        <th>Category</th>
                                        <th>Slug</th>
                                        <th>Description</th>
                                        <th>Sequance</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list as $n)
                                        <tr>
                                            <td>{{ $n->slug }}</td>
                                            <td>{{ $n->name }}</td>
                                            <td>{{ $n->category }}</td>
                                            <td>{{ $n->sequance }}</td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>                            
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 10px">
                    <div class="col s12 text-center">
                        <a href="/permissions/add" class="btn btn-large waves-effect waves-light green" ><span>Tambah Permission</span></a>
                    </div>
                </div>
            </div>

        </div>
        <!--end container-->

@endsection

