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
<script src="{{ asset('assets/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript">
    let table = $('#user-role-table').DataTable({
        "lengthChange": false,
        "order": [1, 'asc'],
        "columnDefs": [{
            targets: [0, 1, 2],
            orderable: false
        }]
    });

    // Apply the search
    table.columns().every(function() {
        var that = this;
        $('input', this.header()).on('keyup change clear', function() {
            if (that.search() !== this.value) {
                that.search(this.value).draw();
            }
        });
        $('select', this.header()).on('change', function() {
            let val = $.fn.dataTable.util.escapeRegex($(this).val());
            that.search(val ? '^' + val + '$' : '', true, false).draw();
        });
    });

    function toggle(source) {
        checkboxes = document.getElementsByClassName('permission-item');
        for (var i = 0, n = checkboxes.length; i < n; i++) {
            checkboxes[i].checked = source.checked;
        }
    }

    // var checkShowAll = document.getElementById("showAll");
    // checkShowAll.addEventListener("click", ()=>{
    //     // if (checkShowAll.checked) {

    //     // }
    // });
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

        {{-- <div class="row">
            <div class="col" style="float: right">
                <input type="checkbox" id="showAll">                     
                <label for="showAll">
                    <span>Tampilkan Semua</span>
                </label>
            </div>
        </div> --}}

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

                                <div class="cyan white-text program-container-header" style="width:100%; padding:15px;">
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
                                                <label>{{ $h->pengajar }} </label>
                                                @if(strtoupper($h->jenis_kbm) == "ONLINE") <span class="badge new">Online</span> @endif
                                            </div>
                                            @allow('admin::manage::halaqoh')
                                            <div class="col s4">
                                                <a href="/halaqoh/{{ $h->reference }}" class="secondary-content"> <span class="ultra-small">Lihat &nbsp;</span></a>
                                                <a href="/halaqoh/{{ $h->reference }}/edit-data" class="secondary-content"> <span class="ultra-small">Edit  &nbsp;</span></a>
                                                <a class="secondary-content"><span class="ultra-small blue-text text-darken-2" style="">{{ $h->peserta_count ?? "" }} &nbsp;</span></a>
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
<!--end container-->

@endsection