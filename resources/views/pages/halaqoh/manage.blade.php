@extends('layouts.materialized')

@section('header-script')
<style type="text/css">
    li.active a {
        color: white;
    }

    table.bordered td,
    table.bordered th {
        border: 1px solid rgba(0, 0, 0, .12) !important;
        padding: 15px !important;
    }

    .d-none {
        display: none;
    }

    .d-block {

    }
    span.badge {
        position: inherit;
    }
    span.badge.new:after {
        content: "";
    }
</style>
@endsection

@section('footer-script')
<script>
    function loadPeserta(reference, day, program, kbm, pengajar) {

        // $("#modalSemester").html(semester);
        $("#modalDay").html(day);
        $("#modalProgram").html(program);
        $("#modalKbm").html(kbm);
        $("#modalPengajar").html(pengajar);

        $.get("/api/halaqoh/"+reference+"/peserta", function(res){
            console.log(res);
            $('.modal-collection-item').remove();
            res.forEach(function(obj){
                let color = "cyan";
                if (obj.gender == 'FEMALE') color = 'pink accent-2';

                let chip = `<div class="chip ${color} white-text class="secondary-content""> <i class="mdi-social-person-outline"></i> <span id="modalPengajar"></span> ${obj.umur} Thn </div>`;

                let elem = `<div class='modal-collection-item collection-item'>
                    <div> ${obj.santri_name} `+
                        `<a class="secondary-content">
                            ${chip}
                        </a>                    
                    </diV>
                </div>`;

                $("#modal-collection").append(elem);
            });
        });

        $('#modal').openModal();

    }
    
    @if (!empty(Request::get('semester_id'))) 
        $('#filter-semester').val({{ Request::get('semester_id') }}).trigger('change');
    @endif
</script>
@endsection

@section('content')
<!--breadcrumbs start-->
<div id="breadcrumbs-wrapper">
    <div class="container">
        <div class="row">
            <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">Manage Halaqoh</h5>
                <ol class="breadcrumbs">
                    <li><a href="/" class="cyan-text">Dashboard</a></li>
                    <li class="active">Manage Halaqoh</li>
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
            <div class="col s12" style="margin-bottom:1rem">

                <form action="" method="get" style="display: inline-flex; align-items:center; gap:1.5rem;">
                    <select name="semester_id" id="filter-semester" class="browser-default">
                        <option value="">- Pilih Semester -</option>
                        @foreach ($semesterList as $item)
                            <option value="{{ $item->id }}">Semester {{ $item->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit">Pilih</button>
                </form>

            </div>
        </div>

        <div class="row">

            <div class="col s12">
                <ul class="tabs tab-demo-active z-depth-1 cyan" style="width: 100%;">
                    @foreach ($days as $d)
                        <li class="tab col s3"><a class="white-text waves-effect waves-light" href="#{{ $d }}-container">{{ $d }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="col s12" style="padding: 10px">

                @php $i = 0 @endphp
                @foreach ($data as $day => $halaqoh)
                    <div id="{{ $day }}-container" class="col s12 tab-container" style="display: {{ (++$i == 1) ? 'block' : 'none' }}">

                        @foreach($program as $o)
                            <div class="col s12 m6 l4 program-container {{ empty($halaqoh[$o->id]) ? 'd-none' : '' }}">

                                <div class="{{ @$halaqoh->halaqoh_gender == 'FEMALE' ? 'pink' : 'cyan' }} white-text program-container-header" style="width:100%; padding:15px;">
                                    <h6 class="mb-3" style="font-weight:300;">{{ $o->name }}</h6>
                                    <small class="mb-3" style="font-weight:300;">@if(!empty($halaqoh[$o->id])) {{ count($halaqoh[$o->id]) }} @else 0 @endif Halaqoh</small>
                                    @allow('add-halaqoh')
                                    <a class="btn-floating activator btn-move-up waves-effect waves-light red accent-2 z-depth-4 right" href="/halaqoh/add?hari={{ $day }}&program={{ $o->id }}&ref=/halaqoh/manage">
                                        <i class="mdi-social-person-add"></i>
                                    </a>
                                    @endallow
                                </div>

                                <ul class="collection program-container-body" style="width:100%;height:270px;overflow-y:scroll">

                                    @isset($halaqoh[$o->id])
                                    @foreach($halaqoh[$o->id] as $h)
                                    <li class="collection-item">
                                        <div class="row">
                                            <div class="col s8">                                                
                                                <label>
                                                    {{ $h->pengajar ?? "Belum Ditentukan" }} 
                                                </label>
                                                @if(strtoupper($h->jenis_kbm) == "ONLINE") <span class="badge new">Online</span> @endif
                                            </div>
                                            @allow('admin::manage::halaqoh')
                                            <div class="col s4">
                                                <a href="/halaqoh/{{ $h->reference }}" class="secondary-content"> <span class="ultra-small">Lihat &nbsp;</span></a>
                                                <a href="/halaqoh/{{ $h->reference }}/edit-data" class="secondary-content"> <span class="ultra-small">Edit  &nbsp;</span></a>
                                                <a onclick="loadPeserta(`{{ $h->reference }}`,`{{ $h->day }}`,`{{ $h->program }}`,`{{ $h->kbm }}`,`{{ $h->pengajar }}`)"  class="secondary-content">
                                                    <span class="ultra-small blue-text text-darken-2 badge" style="">{{ $h->peserta_count ?? "" }} &nbsp;</span>
                                                </a>
                                            </div>
                                            @endallow
                                        </div>
                                    </li>
                                    @endforeach
                                    @endisset

                                </ul>
                            </div>
                        @endforeach

                    </div>                    
                @endforeach
            </div>
        </div>
    </div>
</div>


<div id="modal" class="modal modal-fixed-footer" >
    <div class="modal-content" style="padding: 0">
        <ul class="collection with-header" style="margin-top: 0" id="modal-collection">
            <li class="collection-header">
                <h5>Daftar Peserta Halaqoh</h5>
                <p>
                    <div class="chip cyan white-text"> <i class="mdi-action-event"></i> <span id="modalKbm"></span> </div>
                    <div class="chip cyan white-text"> <i class="mdi-action-event"></i> <span id="modalDay"></span> </div>
                    <div class="chip cyan white-text"> <i class="mdi-content-flag"></i> <span id="modalProgram"></span> </div>
                    <div class="chip cyan white-text"> <i class="mdi-social-person-outline"></i> <span id="modalPengajar"></span> </div>
                </p>
            </li>
        </ul>
    </div>
    <div class="modal-footer">
    <a href="#" class="waves-effect waves-green btn-flat modal-action modal-close">Cancel</a>
    </div>
</div>
<!--end container-->

@endsection