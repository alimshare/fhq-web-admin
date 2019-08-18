@extends('layouts.template')

@section('head-title', 'Semester')
@section('title','FHQ')

@section('body')
<main class="mn-inner" style="background-color: #f3f3f3">

    <div class="row" style="margin-bottom: 0">
        <div class="col s12"> 
            <ul class="breadcrumbs">
              <li><a href="/home">Home</a></li>
              <li class="active">Semester</li>
            </ul>
            <h5 class="breadcrumbs-title">Manajemen Semester</h5>
        </div>
    </div>

    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card">
                <div class="card-content">
                    <table id="example" class="display responsive-table datatable-example bordered">
                        <thead>
                            <tr>
                                <th>Lembaga</th>
                                <th>Name</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach ($list as $n)
                                <tr>
                                    <td>{{ $n->lembaga->name }}</td>
                                    <td>{{ $n->name }}</td>
                                </tr>
							@endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
