@extends('layouts.template')

@section('head-title', 'Program Pendidikan')

@section('title', 'FHQ An-nashr')

@section('body')
<main class="mn-inner">
                <div class="row">
                    <div class="col s12">
                        <div class="page-title">Data Tables</div>
                    </div>
                    <div class="col s12 m12 l12">
                        <div class="card">
                            <div class="card-content">
                                <span class="card-title">Program Pendidikan</span>
                                <br>
                                <table id="example" class="display responsive-table datatable-example">
                                    <thead>
                                        <tr>
                                            <th>NAME</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>NAME</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    	@foreach ($program->data as $el)
                                        <tr>
                                            <td>{{ $el->name }}</td>
                                        </tr>
										@endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
@endsection