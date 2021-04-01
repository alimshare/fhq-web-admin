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
        table.dataTable input[type=text], table .select-wrapper input.select-dropdown {
            height: 2rem;
            font-size: 12px;
            border: 1px solid #ddd;
            text-indent: 10px;
            margin: 0;
        }
        table.dataTable tbody th, table.dataTable tbody td {
            padding: 5px;
        }
        li.active a {
            color : white;
        }
        table.bordered td, table.bordered th {
            border: 1px solid rgba(0,0,0,.12) !important;
            padding: 15px !important;
        }
    </style>
@endsection

@section('footer-script')
    <script src="{{ asset('assets/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript">
        let table = $('#user-role-table').DataTable({
            "lengthChange": false,
            "order" : [1, 'asc'],
            "columnDefs": [
                {
                    targets : [0,1,2], 
                    orderable : false
                }
            ]
        });

        // Apply the search
        table.columns().every( function () {
            var that = this;
            $( 'input', this.header() ).on( 'keyup change clear', function () {
                if ( that.search() !== this.value ) {
                    that.search( this.value ).draw();
                }
            }); 
            $( 'select', this.header() ).on( 'change', function () {
                let val = $.fn.dataTable.util.escapeRegex($(this).val());
                that.search( val ? '^'+val+'$' : '', true, false ).draw();
            });            
        });

        function toggle(source) {
            checkboxes = document.getElementsByClassName('permission-item');
            for(var i=0, n=checkboxes.length;i<n;i++) {
                checkboxes[i].checked = source.checked;
            }
        }
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
                <div class="col s12">
                <ul class="tabs tab-demo-active z-depth-1 cyan" style="width: 100%;">
                    <li class="tab col s3"><a class="white-text waves-effect waves-light" href="#sabtu-container">SABTU</a></li>
                    <li class="tab col s3"><a class="white-text waves-effect waves-light" href="#ahad-container">AHAD</a></li>
                    <div class="indicator" style="right: 0px; left: 588px;"></div><div class="indicator" style="right: 0px; left: 588px;"></div>
                </ul>
            </div>

            <div class="col s12" style="padding: 10px">
              <div id="sabtu-container" class="col s12" style="display: block;">
                
                    @foreach($program as $o)
                    <div class="col s6 m4 l3">
                        
                        <div class="cyan white-text" style="width:100%; padding:15px;">
                            <h6 class="mb-3" style="font-weight:300;">{{ $o->name }}</h6>
                            <small class="mb-3" style="font-weight:300;">@if(!empty($data['SABTU'][$o->id])) {{ count($data['SABTU'][$o->id]) }} @else 0 @endif Halaqoh</small>
                            <a class="btn-floating activator btn-move-up waves-effect waves-light red accent-2 z-depth-4 right" href="/halaqoh/add?hari=sabtu&program={{ $o->id }}&ref=/halaqoh/manage">
                                <i class="mdi-social-person-add"></i>
                            </a>
                        </div>

                        <ul class="collection" style="width:100%;height:270px;overflow-y:scroll">

                            @isset($data['SABTU'][$o->id])
                                @foreach($data['SABTU'][$o->id] as $p)
                                <li class="collection-item">
                                    <div class="row">
                                        <div class="col s10">
                                            <label for="task">{{ $p }}</label>
                                        </div>
                                        <div class="col s2">
                                            <a href="#" class="secondary-content"> <span class="ultra-small">Lihat</span></a>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            @endisset

                        </ul>    
                    </div>
                    @endforeach

              </div>
              <div id="ahad-container" class="col s12" style="display: none;">

                    @foreach($program as $o)
                    <div class="col s6 m4 l3">
                        
                        <div class="cyan white-text" style="width:100%; padding:15px;">
                            <h6 class="mb-3" style="font-weight:300;">{{ $o->name }}</h6>
                            <a class="btn-floating activator btn-move-up waves-effect waves-light red accent-2 z-depth-4 right" href="/halaqoh/add?hari=ahad&program={{ $o->id }}&ref=/halaqoh/manage">
                                <i class="mdi-social-person-add"></i>
                            </a>
                        </div>

                        <ul class="collection" style="width:100%;height:270px;overflow-y:scroll">

                            @isset($data['AHAD'][$o->id])
                                @foreach($data['AHAD'][$o->id] as $p)
                                <li class="collection-item">
                                    <div class="row">
                                        <div class="col s10">
                                            <label for="task">{{ $p }}</label>
                                        </div>
                                        <div class="col s2">
                                            <a href="#" class="secondary-content"> <span class="ultra-small">Lihat</span></a>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            @endisset

                        </ul>    
                    </div>
                    @endforeach

              </div> 
            </div>
          </div>
        </div>
    </div>
    <!--end container-->

@endsection

