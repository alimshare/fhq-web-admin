@extends('layouts.materialized')

@section('header-script')
<link href="{{ asset('assets/plugins/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<style type="text/css">
    .dataTables_filter {
        display: none;
    }

    table.dataTable thead .row-filter .sorting_asc {
        background-image: none;
    }

    table.dataTable thead th {
        border: 1px solid #ddd;
    }

    table.dataTable thead tr.row-filter th {
        padding: 5px;
    }

    #input-select .input-field label {
        position: absolute;
        top: -14px;
        font-size: 0.8rem;
    }

    table.dataTable input[type=text],
    table .select-wrapper input.select-dropdown {
        height: 2rem;
        font-size: 12px;
        border: 1px solid #ddd;
        text-indent: 10px;
        margin: 0;
    }

    table.dataTable tbody th,
    table.dataTable tbody td {
        padding: 5px;
    }

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
    function loadPeserta(reference, day, program, kbm) {

        $("#modalDay").html(day);
        $("#modalProgram").html(program);
        $("#modalKbm").html(kbm);

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
</script>
<script>
function dragstartHandler(ev) {
    ev.dataTransfer.setData("node", ev.target);
}

function dragoverHandler(ev) {
  ev.preventDefault();
}

function dropHandler(ev) {
  ev.preventDefault();
  const data = ev.dataTransfer.getData("node");
  ev.target.appendChild(data);
}
</script>
@endsection

@section('content')
<!--breadcrumbs start-->
<div id="breadcrumbs-wrapper">
    <div class="container">
        <div class="row">
            <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">Manage Peserta</h5>
                <ol class="breadcrumbs">
                    <li><a href="/" class="cyan-text">Dashboard</a></li>
                    <li class="active">Manage Peserta</li>
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
                            @isset($halaqoh[$o->id])
                            @foreach($halaqoh[$o->id] as $h)
                                <div class="col s12 m6 l4 program-container {{ empty($halaqoh[$o->id]) ? 'd-none' : '' }}">
                                    
                                    <div class="cyan white-text program-container-header" style="width:100%; padding:15px;">
                                        <h6 class="mb-3" style="font-weight:300;">{{ $o->name }} - {{ $h->pengajar ?? "Belum Ditentukan" }}</h6>
                                        <small class="mb-3" style="font-weight:300;">{{ $h->peserta_count ?? 0 }} Peserta</small> 
                                        
                                        @allow('admin::manage::halaqoh')

                                            <a class="btn-floating activator btn-move-up waves-effect waves-light red accent-2 z-depth-4 right" href="/halaqoh/{{ $h->reference }}/edit-data">
                                                <i class="mdi-action-settings"></i>
                                            </a>

                                            <a class="btn-floating activator btn-move-up waves-effect waves-light red accent-2 z-depth-4 right" href="/halaqoh/add?hari={{ $day }}&program={{ $o->id }}&ref=/halaqoh/manage">
                                                <i class="mdi-social-person-add"></i>
                                            </a>
                                            <a class="btn-floating activator btn-move-up waves-effect waves-light red accent-2 z-depth-4 right" href="/halaqoh/{{ $h->reference }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28"><title>magnify</title><path fill="white" d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z" /></svg>
                                            </a>
                                                        {{-- <a href="/halaqoh/{{ $h->reference }}" class="secondary-content"> <span class="ultra-small">Lihat &nbsp;</span></a> --}}

                                            @if(strtoupper($h->jenis_kbm) == "ONLINE") <span class="badge new">Online</span> @endif
                                            
                                        @endallow
                                    </div>

                                    <ul class="collection program-container-body" style="width:100%;height:270px;overflow-y:scroll" ondrop="dropHandler(event)" ondragover="dragoverHandler(event)">
                                        @foreach($h->peserta as $peserta)
                                        <li class="collection-item" draggable="true" ondragstart="dragstartHandler(event)">
                                            <div class="row">
                                                <div class="col s8">                                                
                                                    <label>
                                                        {{ $peserta->santri_name }} 
                                                    </label>
                                                </div>
                                                @allow('admin::manage::halaqoh')
                                                <div class="col s4">
                                                    <div class="chip {{ $peserta->gender == 'FEMALE' ? 'pink accent-2' : 'cyan' }} white-text secondary-content"> <i class="mdi-social-person-outline"></i> <span id="modalPengajar"></span> {{ $peserta->umur }} Thn </div>
                                                </div>
                                                @endallow
                                            </div>
                                        </li>
                                        @endforeach

                                    </ul>
                                </div>                            
                            @endforeach
                            @endisset
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
                {{-- <div class="chip cyan white-text"> <i class="mdi-social-person-outline"></i> <span id="modalPengajar"></span> </div> --}}
            </p>
        </li>
        {{-- <li class="modal-collection-item"><div>Alvin<a href="#!" class="secondary-content"><i class="mdi-content-send"></i></a></div></li> --}}
        </ul>
    </div>
    <div class="modal-footer">
    <a href="#" class="waves-effect waves-green btn-flat modal-action modal-close">Cancel</a>
    </div>
</div>
<!--end container-->

@endsection