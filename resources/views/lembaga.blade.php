@extends('layouts.template')
@section('head-title', 'Lembaga')
@section('title','FHQ An-nashr')
@section('body')
<main class="mn-inner">
    <div class="row">
        <div class="col s12">
            <div class="page-title">Data Tables</div>
        </div>
        <div class="col s12 m12 l12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Daftar Lembaga</span>
                    <br>
                    <table id="example" class="display responsive-table datatable-example">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Since</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Since</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                        	@foreach ($lembaga->data as $n)
                            <tr>
                                <td>{{ $n->name }}</td>
                                <td>{{ $n->since }}</td>
                                <td>
                                    <a href="{{ url("lembaga/detail/{$n->reference}") }}" class="btn btn-success blue" />Detail</a>
                                    <a href="{{ url("lembaga/{$n->reference}/semester")}}" class="btn btn-success green" />Semester</a>
                                    &nbsp; &bull; &nbsp;
                                    <a href="javascript:void(0)" class="btn btn-success red" onclick="return document.getElementById('form_delete_lembaga').submit();" />Delete</a>
                                </td>
                            </tr>   
							@endforeach
                        </tbody>
                    </table>
                    <form action="{{ url('lembaga/remove/'.$n->reference) }}" id="form_delete_lembaga" method="post" style="display: none;">
                        {{ method_field('DELETE') }}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

    <div class="fixed-action-btn horizontal click-to-toggle" style="bottom: 45px; right: 104px;">
        <a href="{{ url('lembaga/add') }}" class="btn-floating btn-large blue">
            <i class="material-icons">add</i>
        </a>
    </div>
    </div>
</main>

@endsection
