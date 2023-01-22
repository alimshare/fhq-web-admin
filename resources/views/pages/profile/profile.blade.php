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
						<span>Profil</span>
					</h5>
					<ol class="breadcrumbs mb-0">
						<li class="breadcrumb-item "><a href="/">Home</a></li>
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
                        <div class="card-panel" id="profile-card" style="overflow-x: scroll">
                            <div class="display-flex media">
                                <a href="#" class="avatar">
                                    <img src="/images/user-default.png" alt="users view avatar" class="z-depth-1 circle" width="64" height="64">
                                </a>
                                <div class="media-body">
                                    <h6 class="media-heading">
                                    <span class="users-view-name">{{  $profile->name }}</span>
                                    </h6>
                                    <span>NIP :</span>
                                    <span class="users-view-id">{{ $profile->nip }}</span>
                                </div>
                            </div>

                            <div class="row" style="margin-top: 0.8rem";>
                                <div class="col s12">
                                <table class="striped">
                                    <tbody>
                                      <tr>
                                        <td width="30%">Jenis Kelamin:</td>
                                        <td>{{ $profile->gender == 'MALE' ? 'Laki-laki' : 'Perempuan' }}</td>
                                      </tr>
                                      <tr>
                                        <td>Telepon:</td>
                                        <td class="">{{ $profile->phone }}</td>
                                      </tr>
                                      <tr>
                                        <td>Email:</td>
                                        <td class="">{{ $profile->email }}</td>
                                      </tr>
                                      <tr>
                                        <td>Alamat:</td>
                                        <td class="">{{ $profile->address }}</td>
                                      </tr>
                                      <tr>
                                        <td>Role:</td>
                                        <td class="users-view-role">
                                            {{ implode(", ", $roles) }}
                                        </td>
                                      </tr>
                                      {{-- <tr>
                                        <td width="30%">Join Date</td>
                                        <td>{{ date('d/m/Y', strtotime($profile->join_date)) }}</td>
                                      </tr> --}}
                                      <tr>
                                        <td>Status:</td>
                                        <td><span class=" users-view-status chip green lighten-5 green-text">Active</span></td>
                                      </tr>
                                    </tbody>
                                  </table>
                                    
                                </div>
                            </div>
                            <div class="card-footer text-right" style="margin-top: 1rem;">
                            <a href="{{ route('profile.edit') }}" class="btn green">Edit</a>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 l8">
                        <div class="card-panel table-responsive" id="card-halaqoh-active">
                            <h5 class="h5">Daftar Halaqoh Aktif</h5>
                            <table id="daftar_halaqoh_aktif" class="bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr class="cyan darken-3 white-text" class="row-header">
                                        <th>Semester</th>
                                        <th>Hari</th>
                                        <th>Program</th>
                                        <th>Jumlah Santri</th>
                                        @allow('detail-halaqoh')
                                        <th>Action</th>
                                        @endallow
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($halaqoh_aktif as $n)
                                        <tr>
                                            <td>{{ $n->semester_name }}</td>
                                            <td>{{ $n->day }}</td>
                                            <td>{{ $n->program_name }}</td>
                                            <td>{{ $n->peserta_count }}</td>
                                            @allow('detail-halaqoh')
                                            <td class="text-center">
                                                <a href="/halaqoh/{{ $n->halaqoh_reference }}?referer=/profile" class="btn-floating waves-effect waves-light primary tooltipped" data-position="bottom" data-tooltip="Detail"><i class="mdi-action-search"></i></a>
                                                <a href="/absensi?halaqohRef={{ $n->halaqoh_reference }}" class="btn-floating green waves-effect waves-light primary tooltipped" data-position="bottom" data-tooltip="Absensi"><i class="mdi-action-assignment"></i></a>
                                            </td>
                                            @endallow
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                        </div>

                        <div class="card-panel table-responsive" id="card-halaqoh-history">
                            <h5 class="h5">Daftar Halaqoh Lampau</h5>

                            <table id="daftar_halaqoh_lampau" class="bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr class="cyan darken-3 white-text" class="row-header">
                                        <th>Semester</th>
                                        <th>Hari</th>
                                        <th>Program</th>
                                        <th>Jumlah Santri</th>
                                        @allow('detail-halaqoh')
                                        <th>Action</th>
                                        @endallow
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($halaqoh_lampau as $n)
                                        <tr>
                                            <td>{{ $n->semester_name }}</td>
                                            <td>{{ $n->day }}</td>
                                            <td>{{ $n->program_name }}</td>
                                            <td>{{ $n->peserta_count }}</td>
                                            @allow('detail-halaqoh')
                                            <td class="text-center">
                                                <a href="/halaqoh/{{ $n->halaqoh_reference }}?referer=/profile" class="btn-floating waves-effect waves-light primary tooltipped" data-position="bottom" data-tooltip="Detail"><i class="mdi-action-search"></i></a>
                                            </td>
                                            @endallow
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
    </div>
    
</div>

@endsection

