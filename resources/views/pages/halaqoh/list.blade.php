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
    .chip {
        margin-bottom: 0.5rem;
    }

    #tblPeserta_wrapper .dataTables_filter {
        display: block !important;
    }
</style>
@endsection

@section('footer-script')
<script src="{{ asset('assets/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript">
    let table = $('#example').DataTable({
        "lengthChange": false,
        "order" : [[0, 'asc'],[1,'asc'],[3,'asc'],[4,'asc']],
        "columnDefs": [
            {
                targets : [0,1,2,3,4,5], 
                orderable : false
            }
        ]
    });

    $("#tblPeserta").DataTable();

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

    function loadPeserta(day, gender, program, pengajar, reference, semester) {

        $("#modalSemester").html(semester);
        $("#modalDay").html(day);
        $("#modalProgram").html(program);
        $("#modalPengajar").html(pengajar);

        if (gender == "FEMALE") { 
            // pink color for halaqoh akhwat
            $(".chip").removeClass('cyan');
            $(".chip").addClass('pink accent-2');
        } else {
            $(".chip").removeClass('pink accent-2');
            $(".chip").addClass('cyan');
        }

        $.get("/api/halaqoh/"+reference+"/peserta", function(res){
            console.log(res);
            $('.collection-item').remove();
            res.forEach(function(obj){
                let elem = `<div class='collection-item'><div>`+ obj.santri_name +`<a href="#!" class="secondary-content"><i class="mdi-content-send"></i></a></diV></div>`;
                $(".collection").append(elem);
            });
        });

        $('#modal').openModal();

    }
    
</script>
@endsection

@section('content')

        <!--breadcrumbs start-->
        <div id="breadcrumbs-wrapper">
          <div class="container">
            <div class="row">
              <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">Halaqoh</h5>
                <ol class="breadcrumbs">
                    <li><a href="/" class="cyan-text">Dashboard</a></li>
                    <li class="active">Halaqoh</li>
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
                          <option value="0" selected="">Semester</option>
                          <option value="1" selected="">Hari</option>
                          <option value="2">Gender</option>
                          <option value="3">Program</option>
                          <option value="4">Pengajar</option>
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
                  </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <div id="modal" class="modal modal-fixed-footer" >
                          <div class="modal-content" style="padding: 0">
                              <ul class="collection with-header" style="margin-top: 0">
                                <li class="collection-header">
                                  <h5>Daftar Peserta Halaqoh</h5>
                                  <p>
                                    <div class="chip cyan white-text"> <i class="mdi-action-event"></i> <span id="modalSemester"></span> </div>
                                    <div class="chip cyan white-text"> <i class="mdi-action-event"></i> <span id="modalDay"></span> </div>
                                    <div class="chip cyan white-text"> <i class="mdi-content-flag"></i> <span id="modalProgram"></span> </div>
                                    <div class="chip cyan white-text"> <i class="mdi-social-person-outline"></i> <span id="modalPengajar"></span> </div>
                                  </p>
                                </li>
                                <!-- <li class="collection-item"><div>Alvin<a href="#!" class="secondary-content"><i class="mdi-content-send"></i></a></div></li> -->
                              </ul>
                          </div>
                          <div class="modal-footer">
                            <a href="#" class="waves-effect waves-green btn-flat modal-action modal-close">Cancel</a>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <div style="overflow-x: scroll;">
                            <table id="example" class="cell-border" cellspacing="0" width="100%">
                                <thead>
                                    <tr class="cyan darken-3 white-text" class="row-header">
                                        <th>Semester</th>
                                        <th>Hari</th>
                                        <th>Gender</th>
                                        <th>Program</th>
                                        <th>Pengajar</th>
                                        <th>Action</th>
                                    </tr>
                                    <tr class="row-filter">
                                        <th>
                                            <select id="paramHari">
                                                <option value=""></option>
                                                <option value="XXV">XXV</option>
                                                <option value="XXVI">XXVI</option>
                                            </select>
                                        </th>
                                        <th>
                                            <select id="paramHari">
                                                <option value=""></option>
                                                <option value="SABTU">SABTU</option>
                                                <option value="AHAD">AHAD</option>
                                            </select>
                                        </th>
                                        <th>
                                            <select id="paramGender">
                                                <option value=""></option>
                                                <option value="IKHWAN">IKHWAN</option>
                                                <option value="AKHWAT">AKHWAT</option>
                                            </select>
                                        </th>
                                        <th><input type="text" placeholder="Search Program" id="paramProgram" class="input-text"></th>
                                        <th><input type="text" placeholder="Search Pengajar" id="paramPengajar" class="input-text"></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list as $n)
                                        <tr>
                                            <td>{{ $n->semester_name }}</td>
                                            <td>{{ $n->day }}</td>
                                            <td>{{ ($n->gender=="FEMALE") ? "AKHWAT" : "IKHWAN" }}</td>
                                            <td>{{ $n->program_name }}</td>
                                            <td>{{ $n->pengajar_name }}</td>
                                            <td class="text-center">
                                                <a href="/halaqoh/{{ $n->halaqoh_reference }}" class="btn-floating waves-effect waves-light primary tooltipped" data-position="bottom" data-tooltip="Detail"><i class="mdi-action-search"></i></a>
                                                <a onclick="loadPeserta(`{{ $n->day }}`,`{{ $n->gender }}`,`{{ $n->program_name }}`,`{{ $n->pengajar_name }}`,`{{ $n->halaqoh_reference }}`,`{{ $n->semester_name }}`)" class="btn-floating waves-effect waves-light green tooltipped modal-triggers" data-position="bottom" data-tooltip="Daftar Peserta"><i class="mdi-social-people"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>                            
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 25px">
                    <div class="col s12">
                        <h4>Daftar Peserta Halaqoh</h4>
                        <div style="overflow-x: scroll;">
                            <table id="tblPeserta" class="cell-border" cellspacing="0" width="100%">
                                <thead>
                                    <tr class="cyan darken-3 white-text" class="row-header">
                                        <th>Semester</th>
                                        <th>Hari</th>
                                        <th>Gender</th>
                                        <th>Program</th>
                                        <th>Pengajar</th>
                                        <th>NIS</th>
                                        <th>Santri</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($peserta as $n)
                                        <tr>
                                            <td>{{ $n->semester_name }}</td>
                                            <td>{{ $n->day }}</td>
                                            <td>{{ ($n->gender=="FEMALE") ? "AKHWAT" : "IKHWAN" }}</td>
                                            <td>{{ $n->program_name }}</td>
                                            <td>{{ $n->pengajar_name }}</td>
                                            <td>{{ $n->nis }}</td>
                                            <td>{{ $n->santri_name }}</td>
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