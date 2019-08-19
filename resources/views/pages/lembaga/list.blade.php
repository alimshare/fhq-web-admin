@extends('layouts.materialized')

@section('content')

        <!--breadcrumbs start-->
        <div id="breadcrumbs-wrapper">
            <!-- Search for small screen -->
            <!-- <div class="header-search-wrapper grey hide-on-large-only">
                <i class="mdi-action-search active"></i>
                <input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Explore Materialize">
            </div> -->
          <div class="container">
            <div class="row">
              <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">Lembaga</h5>
                <ol class="breadcrumbs">
                    <li><a href="/">Dashboard</a></li>
                    <li class="active">Lembaga</li>
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
                    <?php foreach ($list as $n): ?>
                        <div class="col s12 m6 l4 xl3">
                            <div class="card">                          
                                <div class="card-image"><img src="/assets/images/mountains1.png" alt="Masjid Raya Bintaro Jaya">
                                    <!-- <span class="card-title">{{ $n->name }}</span> -->
                                </div>

                                <div class="card-action center-align">
                                    <a class="btn waves-effect waves-light cyan darken-2">{{ $n->name }}</a>
                                </div>
                            </div>
                        </div>                        
                    <?php endforeach ?>
                </div>
            </div>
        </div>
        <!--end container-->

@endsection
