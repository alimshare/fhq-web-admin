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
                                            <td><table width="5" border="0">
                                                <tr>
                                                    <td><form action="{{ url('lembaga/edit')}}/{{ $n->reference }}" method="post" style="margin-right:-90px;margin-top:-30px;margin-bottom:-30px;">
                                                        {{ method_field('EDIT') }}
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input class="btn btn-success blue" type="submit" value=" Ubah  " />
                                                    </form>
                                                    </td>
                                                    <td>
                                                    <form action="{{ url('lembaga/remove')}}/{{ $n->reference }}" method="post" style="margin-left:-100px;margin-top:-30px;margin-bottom:-30px;">
                                                        {{ method_field('DELETE') }}
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input class="btn btn-success pink" type="submit" value="Hapus" />
                                                    </form>
                                                    </td>
                                                </tr>
                                                </table>
                                            </td>
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
