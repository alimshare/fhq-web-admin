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
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Since</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    	@foreach ($lembaga->data as $n)
                                        <tr>
                                            <td>{{ $n->name }}</td>
                                            <td>{{ $n->since }}</td>
                                        </tr>
										@endforeach
                                    </tbody>
                                </table>
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
        </div>

@endsection
