<!DOCTYPE html>
<html lang="en">

<!--================================================================================
    Item Name: Materialize - Material Design Admin Template
    Version: 3.0
    Author: GeeksLabs
    Author URL: http://www.themeforest.net/user/geekslabs
================================================================================ -->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="description" content="Daftar Halaqoh dan Peserta Forum Halaqoh Qur'an Semester 27">
    <meta name="keywords" content="fhq, forum halaqoh qur'an, mrbj, masjid raya bintaro jaya, halaqoh, fhq_annashr, tahsin, tahfidz">
    <title>Daftar Halaqoh & Peserta | FHQ </title>

    <!-- Favicons-->
    <link rel="icon" href="/images/fhq-logo.png" sizes="32x32">
    <!-- Favicons-->

    <!-- CORE CSS-->
    <link href="/materialized/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="/materialized/css/style.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="/materialized/js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
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
</head>

<body>

  <!-- START MAIN -->
  <div id="">
    <!-- START WRAPPER -->
    <div class="wrapper">

      <!-- START CONTENT -->
      <section id="content">        

        <!--start container-->
        <div class="" style="margin-bottom: 10px">
            <div class="">
                <div class="row">
                    <div class="col s12" style="padding:0">
                        <div style="">
                            <table id="daftarHalaqoh" class="cell-border" cellspacing="0" width="100%">
                                <thead>
                                    <tr class="cyan darken-3 white-text" class="row-header">
                                        <th>NIS</th>
                                        <th>Santri</th>
                                        <th>Pengajar</th>
                                        <th>Program</th>
                                        <th>Hari</th>
                                        <th>Jenis Kelamin</th>
                                    </tr>
                                    <tr class="row-filter">
                                        <th><input type="text" placeholder="Search NIS" id="paramNIS" class="input-text"></th>
                                        <th><input type="text" placeholder="Search Santri" id="paramSantri" class="input-text"></th>
                                        <th><input type="text" placeholder="Search Pengajar" id="paramPengajar" class="input-text"></th>
                                        <th><input type="text" placeholder="Search Program" id="paramProgram" class="input-text"></th>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list as $n)
                                        <tr>
                                            <td>{{ $n->nis }}</td>
                                            <td>{{ strtoupper($n->santri_name) }}</td>
                                            <td>{{ strtoupper($n->pengajar_name) }}</td>
                                            <td>{{ strtoupper($n->program_name) }}</td>
                                            <td>{{ strtoupper($n->day) }}</td>
                                            <td>{{ $n->gender_santri == "MALE" ? "IKHWAN" : "AKHWAT" }}</td>
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

      </section>

    </div>

  </div>

    <script type="text/javascript" src="/materialized/js/plugins/jquery-1.11.2.min.js"></script>
    <script type="text/javascript" src="/materialized/js/materialize.js"></script>
    <script type="text/javascript" src="/materialized/js/plugins.js"></script>
    <script type="text/javascript" src="/materialized/js/custom-script.js"></script>
    
    <script src="{{ asset('assets/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript">
        let table = $('#daftarHalaqoh').DataTable({
            "lengthChange": false,
            "pageLength" : 15,
            "order" : [[1,'asc'],[2,'asc'],[3,'asc'],[4,'asc']],
            "columnDefs": [
                {
                    targets : [0,1,2,3,4], 
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
        
    </script>
</body>

</html>