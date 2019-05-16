@extends('layouts.template')

@section('head-title', 'Semester')

@section('title', 'FHQ An-nashr')

@section('body')
<main class="mn-inner">
    <form action="" method="post">
    @isset ($reference)
        @method('PUT')
    @else
        @method('POST')
    @endisset
    @csrf
    <div class="row">
        <div class="col s12">
            <div class="page-title">Semester Detail</div>
        </div>
        {{-- @dump($semester) --}}
        <div class="col s12 m12 l8">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Main</span><br>
                    <div class="row">
                        <div class="input-field col s12">
                            <input placeholder="Semester" id="semester" type="text" name="name" value="{{ $semester->data->name ?? '' }}" required="">
                            <label for="semester">Semester</label>
                        </div>
                        <div class="input-field col s12">
                            <select name="lembaga" id="lembaga">
                                {{-- <option value="" disabled selected>Choose your option</option> --}}
                                @foreach ($lembaga->data as $element)
                                <option value="{{ $element->reference }}" {{ $element->reference == ($semester->data->lembaga->reference ?? '') ? 'selected' : '' }}>{{ $element->name }}</option>
                                @endforeach
                            </select>
                            <label>Lembaga</label>
                        </div>
                        <div class="input-field col s12">
                            <input placeholder="Deskripsi" id="deskripsi" name="description" type="text" value="{{ $semester->data->description ?? ''}}" required="">
                            <label for="deskripsi">Deskripsi</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m12 l4">

            <div class="card">
                <div class="card-content">
                    <span class="card-title">Status</span><br>
                    <div class="row">
                        <div class="col s12">
                            <!-- Switch -->
                            <div class="switch m-b-md">
                                <label>
                                    <input type="checkbox"{!! ($semester->data->active ?? '') ? ' checked=""' : '' !!} name="active" >
                                    <span class="lever"></span>
                                    Active
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <button type="submit" class="waves-effect waves-light btn m-b-xs">{{ isset($reference) ? 'Update' : 'Save' }}</button>
                            {{-- <a href="" class="waves-effect waves-light btn m-b-xs">{{ $reference ? 'Update' : 'Save' }}</a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
</main>
@endsection