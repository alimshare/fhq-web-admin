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
</style>
@endsection

@section('footer-script')
<script src="{{ asset('assets/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript">
    let table = $('#example').DataTable({
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

    $("#orderBy").on('change', function(){
        let colIdx = $("#orderBy").val();
        let orderType = $("#orderType").val();
        order(colIdx, orderType);
    });

    $("#orderType").on('change', function(){
        let colIdx = $("#orderBy").val();
        let orderType = $("#orderType").val();
        order(colIdx, orderType); 
    });

    function order(columnIndex, type){
        table.order([columnIndex, type]).draw();
    }
</script>
@endsection

@section('content')

        <!--breadcrumbs start-->
        <div id="breadcrumbs-wrapper">
          <div class="container">
            <div class="row">
              <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">Santri</h5>
                <ol class="breadcrumbs">
                    <li><a href="/" class="cyan-text">Dashboard</a></li>
                    <li class="active">Santri</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!--breadcrumbs end-->
        

        <!--start container-->
        <div class="container" style="margin-bottom: 25px">
            <div class="section">
                <div class="row" id="input-select">
                    <div class="col s12 l3">                        
                        <label>Order By</label>
                        <select id="orderBy">
                          <option value="" disabled selected>Choose your option</option>
                          <option value="1" selected="">NIS</option>
                          <option value="2">Name</option>
                          <option value="0">Gender</option>
                        </select>
                    </div>
                    <div class="col s12 l3">                        
                        <label>&nbsp;</label>
                        <select id="orderType">
                          <option value="" disabled selected>Choose your option</option>
                          <option value="asc" selected="">ASC</option>
                          <option value="desc">DESC</option>
                        </select>
                    </div>
					<div align="right" style="margin-right:12px">      
						</br>
						<button class="btn waves-effect cyan" type="submit"><i class="mdi-social-person-outline"></i><i class="mdi-content-add"></i></button> 
					</div>
                  </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <div style="overflow-x: scroll;">
                            <table id="example" class="cell-border" cellspacing="0" width="100%">
                                <thead>
                                    <tr class="cyan darken-3 white-text" class="row-header">
                                        <th>Gender</th>
                                        <th>NIS</th>
                                        <th>Name</th>
                                    </tr>
                                    <tr class="row-filter">
                                        <th>
                                            <select id="paramGender">
                                                <option value=""></option>
                                                <option value="IKHWAN">IKHWAN</option>
                                                <option value="AKHWAT">AKHWAT</option>
                                            </select>
                                        </th>
                                        <th><input type="text" placeholder="Search NIP" id="paramNip" class="input-text"></th>
                                        <th><input type="text" placeholder="Search Name" id="paramName" class="input-text"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list as $n)
                                        <tr>
                                            <td>{{ ($n->gender=="FEMALE") ? "AKHWAT" : "IKHWAN" }}</td>
                                            <td>{{ $n->nis }}</td>
                                            <td>{{ $n->name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end container-->

@endsection

