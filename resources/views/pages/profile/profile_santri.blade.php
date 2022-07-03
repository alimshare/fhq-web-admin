@extends('layouts.materialized')

@section('header-script')
<style>
    .display-flex {
        display: flex
    }
    .users-view .media .avatar {
        margin-right: 2.6rem;
    }
    h6 {
        font-size: 1.15rem;
        margin: .575rem 0 .46rem;
    }
    h5, h6 {
        line-height: 110%;
        font-family: Muli,sans-serif;
    }
    table.bordered td, table.bordered th {
        border: 1px solid rgba(0,0,0,.12) !important;
        padding: 15px !important;
    }

    @media(max-width: 430px) {
        .table-responsive {
            overflow-x: scroll;
            scroll-behavior: smooth;
        }
    }
</style>
@endsection

@section('footer-script')
    <script>

    </script>
@endsection

@section('content')

<div class="row">

    <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
		<div class="container">
			<div class="row">
				<div class="col s10 m6 l6">
					<h5 class="breadcrumbs-title mt-0 mb-0">
						<span>Santri <small>Profile</small></span>
					</h5>
					<ol class="breadcrumbs mb-0">
						<li class="breadcrumb-item "><a href="/">Home</a></li>
						<li class="breadcrumb-item active">Santri</li>
						<li class="breadcrumb-item active">Profile</li>
					</ol>
				</div>
			</div>
		</div>
    </div>

    <div class="col s12">
        <div class="container">
            <div class="section users-view">
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="card-panel" id="profile-card">

                            <div class="row" style="margin-top: 0.8rem">
                                <div class="col s12">
                                <table class="striped bordered">
                                    <tbody>
                                        <tr>
                                          <td width="30%">NIS:</td>
                                          <td class="">{{ $profile->nis }}</td>
                                        </tr>
                                        <tr>
                                            <td>Nama:</td>
                                            <td class="">{{ $profile->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Jenis Kelamin:</td>
                                            <td>{{ $profile->gender == 'MALE' ? 'Laki-laki' : 'Perempuan' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Telepon:</td>
                                            <td class="">{{ $profile->phone }}</td>
                                        </tr>
                                    </tbody>
                                  </table>

                                  <br>
                                  @if (Request::input('referer'))
                                    <a href="{{ Request::input('referer') }}" class="waves-effect waves-light btn btn-small">Kembali</a>
                                  @endif

                                </div>
                            </div>
                            <div class="card-footer text-right" style="margin-top: 1rem;">
                            </div>
                        </div>
                    </div>

                    @isset($halaqoh)
                    <div class="col s12 l8">
                        <div class="card-panel table-responsive" id="card-halaqoh-active">
                            <h5 class="h5">Daftar halaqoh</h5>
                            <table id="daftar_halaqoh_aktif" class="bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr class="cyan darken-3 white-text" class="row-header">
                                        <th>Semester</th>
                                        <th>Hari</th>
                                        <th>Program</th>
                                        <th>Pengajar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($halaqoh as $n)
                                        <tr>
                                            <td>{{ $n->semester_name }}</td>
                                            <td>{{ $n->day }}</td>
                                            <td>{{ $n->program_name }}</td>
                                            <td>{{ $n->pengajar_name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                        </div>
                        
                    </div>
                    @endisset

                    @isset($mutabaah)
                    <div class="col s12 l8">

                        <div class="card-panel table-responsive" id="card-halaqoh-active">
                            <h5 class="h5">Catatan Pekanan</h5>
                            <table id="daftar_mutabaah" class="bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr class="cyan darken-3 white-text" class="row-header">
                                        <th>Tanggal</th>
                                        <th>Kehadiran</th>
                                        <th>Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mutabaah as $m)
                                        <tr>
                                            <td>{{ $m->activity->tgl }}</td>
                                            <td>{{ ($m->status == 1) ? "Hadir" : "Tidak Hadir"  }}</td>
                                            <td>{{ $m->note }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                        </div>
                        
                    </div>
                    @endisset
                </div>

            </div>
        </div>
    </div>
    
</div>

@endsection

