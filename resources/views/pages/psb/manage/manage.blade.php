@extends('layouts.materialized')

@section('header-script')
<style>
    table.table td {
        border: 1px solid #ddd;
        padding: 1rem;
    }
    table.first-th-cyan th td:first-child {
        background-color: cyan;
    }
</style>
@endsection

@section('footer-script')

@endsection

@section('content')

<!--breadcrumbs start-->
<div id="breadcrumbs-wrapper">
    <div class="container">
        <div class="row">
            <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">Atur Halaqoh</h5>
                <ol class="breadcrumbs">
                    <li><a href="/" class="cyan-text">Dashboard</a></li>
                    <li><a href="{{ route('du') }}" class="cyan-text">PSB</a></li>
                    <li class="active">Atur Halaqoh</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs end-->


<!--start container-->
<div class="container" style="margin-bottom: 25px">
    <div class="section">

        <div class="row">
            <div class="col s12">
                @include('layouts.materialized.components.alert')
            </div>
        </div>

        <div class="row">
            <div class="col">

                @if (Cache::has('du.manage.semester_id'))
                    <div class="card">
                        <div class="card-content no-padding">
                            <table class="table">
                                <tr>
                                    <td>Semester</td>
                                    <td>{{ Cache::get('du.manage.semester_id')->name }}</td>
                                </tr>
                                <tr>
                                    <td>Daftar Ulang</td>
                                    <td>{{ $totalPeserta ?? "-" }}</td>
                                </tr>
                                <tr>
                                    <td>Santri Baru</td>
                                    <td>{{ $santriNewCount ?? "-" }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                @else 
                <div class="card">
                    <div class="card-content">
                        <form action="{{ route('du.manage') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="semester_id" class="form-label">Pilih Semester</label>
                                <select name="semester_id" id="semester_id" class="form-control">
                                    <option value="">- Pilih Semester -</option>
                                    @foreach ($semesterList as $item)
                                    <option value="{{ $item->id }}">Semester {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="submit" name="submit_semester" class="btn cyan" value="Atur Halaqoh">
                        </form>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>
<!--end container-->

@endsection