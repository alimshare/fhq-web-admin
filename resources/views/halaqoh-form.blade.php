@extends('layouts.template')

@section('head-title', 'Halaqoh')

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
            <div class="page-title">Halaqoh Detail</div>
        </div>
        {{-- @dump($halaqoh) --}}
        <div class="col s12 m12 l8">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Main</span><br>
                    <div class="row">
                        <div class="input-field col s12">
                            <select name="program" id="program" required="">
                                @foreach ($program->data as $element)
                                <option value="{{ $element->reference }}" >{{ $element->name }}</option>
                                @endforeach
                            </select>
                            <label>Program</label>
                        </div>
                        <div class="input-field col s12">
                            <select name="nip" id="nip" required="">
                                @foreach ($pengajar->data as $element)
                                <option value="{{ $element->nip }}" >{{ $element->name }}</option>
                                @endforeach
                            </select>
                            <label>Pengajar</label>
                        </div>
                        <div class="input-field col s12">
                            <select name="day" id="day" required="">
                                <option value="SABTU" >SABTU</option>
                                <option value="AHAD" >AHAD</option>
                            </select>
                            <label>Hari</label>
                        </div>
                        <div class="input-field col s12">
                            <input placeholder="07:00" id="start_hour" class="masked" name="start_hour" type="text" value="" required="">
                            <label for="start_hour">Jam Mulai KBM</label>
                        </div>
                        {{-- <div class="input-field col s12">
                             <input placeholder="" id="mask3" class="masked" type="text" data-inputmask="'mask': 'h:s'">
                             <label for="mask3" class="active">Time</label>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m12 l4">

            <div class="card">
                <div class="card-content">
                    <span class="card-title">Status</span><br>
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

@push('scripts')
<script src="{{ asset('assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js') }}"></script>
@endpush