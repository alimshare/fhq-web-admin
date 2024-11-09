@extends('layouts.materialized')

@section('header-script')
<style type="text/css">
    table.bordered td, table.bordered th {
        border: 1px solid rgba(0,0,0,.12) !important;
        padding: 15px !important;
    }
</style>
@endsection

@section('footer-script')
<script type="text/javascript">
</script>
@endsection

@section('content')

        <!--breadcrumbs start-->
        <div id="breadcrumbs-wrapper">
          <div class="container">
            <div class="row">
              <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">Semester</h5>
                <ol class="breadcrumbs">
                    <li><a href="/" class="cyan-text">Home</a></li>
                    <li class="active">Semester</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!--breadcrumbs end-->
        

        <!--start container-->
        <div class="container" style="margin-bottom: 25px">
            <section class="section users-view">
                <div class="row">
                    <div class="col s12">
                        <div class="card">
                            <table id="" class="display responsive-table datatable-example bordered">
                                <thead>
                                    <tr class="cyan darken-3 white-text" class="row-header">
                                        <th>Semester</th>
                                        <th>Deskripsi</th>
                                        <th>Start</th>
                                        <th>End</th>
                                        <th>Code</th>
                                        <th>Status</th>
                                        {{-- <th></th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list as $n)
                                        <tr>
                                            <td>{{ $n->name }}</td>
                                            <td>{{ $n->description }}</td>
                                            <td>{{ $n->start_period }}</td>
                                            <td>{{ $n->end_period }}</td>
                                            <td>{{ $n->reference }}</td>
                                            <td>{{ $n->active ? "Aktif" : "-" }}</td>
                                            {{-- <th>
                                                <a href="#" class="waves-effect waves-light tooltipped" data-position="bottom" data-tooltip="Detail">
                                                    <i class="mdi-action-search"></i>
                                                </a>
                                                <a href="#" class="waves-effect waves-light tooltipped" data-position="bottom" data-tooltip="Edit">
                                                    <i class="mdi-editor-border-color"></i>
                                                </a>
                                            </th> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>                             
                        </div>
                    </div>
                </div>
            </div>
                
        </section>
        </div>
        <!--end container-->

@endsection

