@extends('layouts.template')

@section('head-title', 'Semester')

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
                    <span class="card-title">Daftar Semester</span>
                    <br>
                    <table id="example" class="display responsive-table datatable-example">
                        <thead>
                            <tr>
                                <th>Lembaga</th>
                                <th>Semester</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Lembaga</th>
                                <th>Semester</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                        	@foreach ($semester->data as $el)
                            <tr>
                                <td>{{ $el->lembaga }}</td>
                                <td>{{ $el->semester }}</td>
                                <td>
                                    <a href="{{ url('semester/'.$el->semester_reference) }}" class="waves-effect waves-light btn m-b-xs">Detail</a>
                                    {{-- <a href="" class="waves-effect waves-light btn orange m-b-xs">Edit</a> --}}
                                </td>
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