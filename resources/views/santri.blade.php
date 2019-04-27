@extends('header')
@section('head-title')
Santri
@endsection
@section('title')
FHQ An-nashr
@endsection
@section('body')
            <main class="mn-inner">
                <div class="row">
                    <div class="col s12">
                        <div class="page-title">Data Tables</div>
                    </div>
                    <div class="col s12 m12 l12">
                        <div class="card">
                            <div class="card-content">
                                <span class="card-title">Daftar Santri</span>
                                <br>
                                <table id="example" class="display responsive-table datatable-example">
                                    <thead>
                                        <tr>
                                            <th>NIS</th>
                                            <th>Name</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>NIS</th>
                                            <th>Name</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    	@foreach ($data as $n)
                                        <tr>
                                            <td>{{ $n['nis'] }}</td>
                                            <td>{{ $n['name'] }}</td>
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