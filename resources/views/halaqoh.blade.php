@extends('layouts.template')

@section('head-title', 'Semester')

@section('title', 'FHQ An-nashr')

@section('body')
<main class="mn-inner">
    <div class="row">
        <div class="col s12">
            <div class="page-title">Daftar Halaqoh</div>
        </div>
        <div class="col s12 m12 l12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">{{ $halaqoh->semester->lembaga->name ?? '' }} - Semester {{ $halaqoh->semester->name }}</span>
                    <a href="{{ url("halaqoh/add?semester={$halaqoh->semester->reference}") }}" class="waves-effect waves-light btn m-b-xs">Add</a>

                    <br>
                    <table id="example" class="display responsive-table datatable-example">
                        <thead>
                            <tr>
                                <th>Semester</th>
                                <th>Keterangan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Semester</th>
                                <th>Keterangan</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                        	@foreach ($halaqoh->halaqoh as $el)
                            {{-- <tr>
                                <td>{{ $el->name }}</td>
                                <td>{{ $el->description }}</td>
                                <td>
                                    <a href="{{ url("semester/{$el->reference}") }}" class="waves-effect waves-light btn m-b-xs">Detail</a>
                                    <a href="{{ url("semester/{$el->reference}/halaqoh") }}" class="waves-effect waves-light btn indigo m-b-xs">Halaqoh</a>
                                    &nbsp; &bull; &nbsp;
                                    <a href="{{ url('semester/remove/'.$el->reference) }}" class="waves-effect waves-light btn red m-b-xs">Delete</a>
                                </td>
                            </tr> --}}
							@endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection