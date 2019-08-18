@extends('layouts.materialized')

@section('header-script')
<style type="text/css">
  table tr td, table tr th {
    border : 1px solid #ddd;
  }  
</style>
@endsection

@section('footer-script')
  <!-- chartjs -->
<script type="text/javascript" src="/materialized/js/plugins/chartjs/chart.min.js"></script>
<script type="text/javascript">
window.onload = function() {

    //Sampel Pie Doughnut Chart

    // var chartDataHalaqoh = [
    //     @foreach($data->count_peserta as $o)
    //       {
    //         value : {{ $o->halaqoh }},
    //         label: '{{ $o->program_name }}',
    //         color : '{{ $o->color }}',
    //         highlight: '#69f0ae',
    //       },
    //     @endforeach
    // ];

    // var chartDataPeserta = [
    //     @foreach($data->count_peserta as $o)
    //       {
    //         value : {{ $o->peserta }},
    //         label: '{{ $o->program_name }}',
    //         color : '{{ $o->color }}',
    //         highlight: '#69f0ae',
    //       },
    //     @endforeach
    // ];

    // window.PieChartSample = new Chart(document.getElementById("pie-chart-sample").getContext("2d")).Pie(chartDataHalaqoh,{ responsive:true });
    // window.PieChartSample = new Chart(document.getElementById("pie-chart-sample-2").getContext("2d")).Pie(chartDataPeserta,{ responsive:true });

 };
</script>
@endsection

@section('content')

        <!--breadcrumbs start-->
        <div id="breadcrumbs-wrapper">
            <!-- Search for small screen -->
            <div class="header-search-wrapper grey hide-on-large-only">
                <i class="mdi-action-search active"></i>
                <input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Explore Materialize">
            </div>
          <div class="container">
            <div class="row">
              <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">Dashboard</h5>
                <ol class="breadcrumbs">
                    <li><a href="/">Dashboard</a></li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!--breadcrumbs end-->
        

        <!--start container-->
        <div class="container">
          <div class="section">

              <div class="row">
                  <div class="col s12 m6 l3">
                      <div class="card teal darken-3">
                        <div class="card-content white-text center-align">
                          <p class="card-title">{{ $data->count_halaqoh }}</p>
                          <p>Halaqoh</p>
                        </div>                  
                      </div>
                  </div>
                  <div class="col s12 m6 l3">
                      <div class="card cyan darken-2">
                        <div class="card-content white-text center-align">
                          <p class="card-title">{{ $data->count_pengajar }}</p>
                          <p>Pengajar</p>
                        </div>                  
                      </div>
                  </div>
                  <div class="col s12 m6 l3">
                      <div class="card pink darken-2">
                        <div class="card-content white-text center-align">
                          <p class="card-title">{{ $data->count_santri }}</p>
                          <p>Santri</p>
                        </div>                  
                      </div>
                  </div>
                  <div class="col s12 m6 l3">
                      <div class="card indigo darken-3">
                        <div class="card-content white-text center-align">
                          <p class="card-title">{{ $data->count_program }}</p>
                          <p>Program</p>
                        </div>                  
                      </div>
                  </div>
              </div>

              <div class="row">
                <div class="col s12">
                  <h4 class="header">Halaqoh</h4>
                  <div class="card">
                    <div class="card-content center-align">
                      <!-- <div class="row">
                        <div class="col s12 l6">
                          <div class="sample-chart-wrapper">
                            <canvas id="pie-chart-sample" style="width: 100%; height: 100%;"></canvas>
                          </div> 
                        </div>    
                        <div class="col s12 l6">
                          <div class="sample-chart-wrapper">
                            <canvas id="pie-chart-sample-2" style="width: 100%; height: 100%;"></canvas>
                          </div>                          
                        </div>
                      </div> -->
                      <div class="row">
                           @foreach($data->count_peserta as $o)
                            <div class="col s6 l4">
                              <div class="card white-text" style="background-color: {{ $o->color }}">
                                <div class="card-content white-text center-align">
                                  <p class="card-title">{{ $o->program_name }}</p>
                                  <p>{{ $o->halaqoh }} Halaqoh</p>
                                  <p>{{ $o->peserta }} Peserta</p>
                                </div>                  
                              </div>
                            </div>
                            @endforeach
                      </div>
                    </div>                  
                  </div>
                </div>
              </div>
          
          </div>
        </div>
        <!--end container-->
@endsection