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
                    @php
                        $data = isset($halaqoh->data) ? $halaqoh->data : null;
                    @endphp
                    <span class="card-title">{{ $data ? $data->semester->lembaga->name : '' }} - Semester {{ $data ? $data->semester->name : '' }}</span>
                    <a href="{{ url("halaqoh/add?semester={$semester_reference}") }}" class="waves-effect waves-light btn m-b-xs">Add</a>

                    <br>
                    <table id="example" class="display responsive-table datatable-example">
                        <thead>
                            <tr>
                                <th>Program</th>
                                <th>Pengajar</th>
                                <th>Waktu</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Program</th>
                                <th>Pengajar</th>
                                <th>Waktu</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse ($data->halaqoh as $el)
                            <tr>
                                <td>{{ $el->program->name }}</td>
                                <td>{{ $el->pengajar->name }}</td>
                                <td>{{ $el->day .' / '. $el->start_hour }}</td>
                                <td>
                                    <a href="{{ url("halaqoh/{$el->reference}") }}" class="waves-effect waves-light btn m-b-xs">Detail</a>
                                    {{-- <a href="{{ url("semester/{$el->reference}/halaqoh") }}" class="waves-effect waves-light btn indigo m-b-xs">Halaqoh</a> --}}
                                    &nbsp; &bull; &nbsp;
                                    <a href="javascript:void(0)" data-reference="{{ $el->reference }}" class="waves-effect waves-light btn red m-b-xs btn-del">Delete</a>
                                </td>
                            </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                    <form method="post" action="{{ url('halaqoh/remove') }}" id="form_delete_halaqoh" style="display: none;">
                        @csrf
                        @method('DELETE')

                        <input type="hidden" name="halaqoh_reference" value="">
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script type="text/javascript">
    $('.btn-del').click(function(e){
        e.preventDefault();

        var el = $(this);
        var form = $('#form_delete_halaqoh');

        $('input[name="halaqoh_reference"]').val(el.data('reference'));
        form.submit();
        
    })
</script>
@endpush