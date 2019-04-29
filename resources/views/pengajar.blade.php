@extends('layouts.template')

@section('head-title', 'Pengajar')

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
                                <span class="card-title">Daftar Pengajar</span>
                                <br>
                                <table id="example" class="display responsive-table datatable-example">
                                    <thead>
                                        <tr>
                                            <th>NIP</th>
                                            <th>Name</th>
                                            <th>Gender</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>NIP</th>
                                            <th>Name</th>
                                            <th>Gender</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    	@foreach ($pengajar->data as $el)
                                        <tr>
                                            <td>{{ $el->nip }}</td>
                                            <td>{{ $el->name }}</td>
                                            <td>{{ $el->gender }}</td>
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