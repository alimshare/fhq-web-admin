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

    #profile-card input[disabled] {
      color: #555; 
      cursor: no-drop;
    }
</style>
@endsection

@section('footer-script')
    <script>
      $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15, // Creates a dropdown of 15 years to control year
        format: 'yyyy-mm-dd',
      });
    </script>
@endsection

@section('content')



<div class="row">
  <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
     <div class="container">
        <div class="row">
           <div class="col s10 m6 l6">
              <h5 class="breadcrumbs-title mt-0 mb-0">
                 <span>Profil <small>Edit</small></span>
              </h5>
              <ol class="breadcrumbs mb-0">
                 <li class="breadcrumb-item "><a href="{{ route('home') }}">Home</a></li>
                 <li class="breadcrumb-item "><a href="{{ route('profile') }}">Profile</a></li>
                 <li class="breadcrumb-item active">Edit</li>
              </ol>
           </div>
        </div>
     </div>
  </div>
  <div class="col s12">
     <div class="container">
        <div class="section users-view">
           <div class="row">
              <div class="col s12">
                 <form action="{{ route('profile.edit.save') }}" method="post">
                  @csrf
                    <div class="card-panel" id="profile-card">
                       <div class="card-content">
                          <input type="hidden" name="profile_id" value="{{ Auth::user()->profile_id }}">
                          <input type="hidden" name="profile_type" value="{{ Auth::user()->profile_type }}">
                          <div id="input-fields">
                             <h4 class="header">Pribadi</h4>
                             <div class="row">
                                <div class="col s12 m4 l3">
                                   <p>Informasi Pribadi Pengajar</p>
                                </div>
                                <div class="col s12 m8 l9">
                                   <div class="row">
                                      <div class="input-field col s12">
                                         <input id="text" type="text" class="validate" disabled="" value="{{ Auth::user()->username }}">
                                         <label for="email">Username</label>
                                      </div>
                                   </div>
                                   <div class="row">
                                      <div class="input-field col s12">
                                         <input id="name" type="text" class="validate" name="name" required="" value="{{ $profile->name }}">
                                         <label for="name">Nama Lengkap</label>
                                      </div>
                                   </div>
                                   <div class="row">
                                      <div class="input-field col s12">
                                         <input id="father_name" type="text" class="validate" name="father_name" value="{{ $profile->father_name }}" placeholder="Nama Ayah Kandung">
                                         <label for="father_name">Nama Ayah</label>
                                      </div>
                                   </div>
                                   <div class="row">
                                      <div class="input-field col s12">
                                         <input id="gender" type="text" class="validate" disabled="" value="{{ $profile->gender == 'MALE' ? 'Laki-laki' : 'Perempuan' }}">
                                         <label for="gender">Jenis Kelamin</label>
                                      </div>
                                   </div>
                                   <div class="row">
                                      <div class="input-field col s12">
                                         <input id="birth_place" type="text" class="validate" name="birth_place" value="{{ $profile->birth_place }}" placeholder="Tempat Lahir">
                                         <label for="birth_place">Tempat Lahir</label>
                                      </div>
                                   </div>
                                   <div class="row">
                                      <div class="input-field col s12">
                                         <input id="birth_date" type="text" class="datepicker picker__input picker__input--active" name="birth_date" value="{{ $profile->birth_date }}" placeholder="Tanggal Lahir" data-formatSubmit="yyyy-mm-dd">
                                         <label for="birth_date">Tanggal Lahir</label>
                                      </div>
                                   </div>
                                   <div class="row">
                                      <div class="input-field col s12">
                                         <input id="phone" type="text" class="validate" name="phone" value="{{ $profile->phone }}" placeholder="Nomor Handphone" required="">
                                         <label for="phone">Nomor Handphone</label>
                                      </div>
                                   </div>
                                   <div class="row">
                                      <div class="input-field col s12">
                                         <input id="email" type="email" class="validate" name="email" value="{{ $profile->email }}" placeholder="contoh: alan@gmail.com">
                                         <label for="email">Email</label>
                                      </div>
                                   </div>
                                   <div class="row">
                                      <div class="input-field col s12">
                                         <select class="" id="marital_status" name="marital_status">
                                            <option value="" disabled="">Choose your option</option>
                                            @foreach ($lookup['marital_status'] as $status)
                                            <option value="{{ $status['value'] }}" {{ $profile->marital_status == $status['value'] ? 'selected=""':'' }}>{{$status['name']}}</option>                                            
                                            @endforeach
                                         </select>
                                         <label for="marital_status">Status Pernikahan</label>
                                      </div>
                                   </div>
                                   <div class="row">
                                      <div class="input-field col s12">
                                         <input id="spouse" type="text" class="validate" name="spouse" value="{{ $profile->spouse }}">
                                         <label for="spouse">Nama Pasangan</label>
                                      </div>
                                   </div>
                                </div>
                             </div>
                          </div>
                          <div class="divider"></div>
                          <div id="input-fields">
                             <h4 class="header">Tempat Tinggal</h4>
                             <div class="row">
                                <div class="col s12 m4 l3">
                                   <p>Informasi Tempat Tinggal</p>
                                </div>
                                <div class="col s12 m8 l9">
                                   <div class="row">
                                      <div class="input-field col s12">
                                         <textarea id="address" type="text" class="materialize-textarea" name="address">{{ $profile->address }}</textarea>
                                         <label for="address">Alamat</label>
                                      </div>
                                   </div>
                                   <div class="row">
                                      <div class="input-field col s12">
                                         <input id="city" type="text" class="validate" name="city" value="{{ $profile->city }}">
                                         <label for="city">Kota/Kabupaten</label>
                                      </div>
                                   </div>
                                   <div class="row">
                                      <div class="input-field col s12">
                                         <input id="district" type="text" class="validate" name="district" value="{{ $profile->district }}">
                                         <label for="district">Kecamatan</label>
                                      </div>
                                   </div>
                                   <div class="row">
                                      <div class="input-field col s12">
                                         <input id="village" type="text" class="validate" name="village" value="{{ $profile->village }}">
                                         <label for="village">Kelurahan</label>
                                      </div>
                                   </div>
                                </div>
                             </div>
                          </div>
                          <div class="divider"></div>
                          <div id="input-fields">
                             <h4 class="header">Pekerjaan & Pendidikan</h4>
                             <div class="row">
                                <div class="col s12 m4 l3">
                                   <p>Informasi Pekerjaan, Bidang Keilmuan & Pendidikan</p>
                                </div>
                                <div class="col s12 m8 l9">
                                   <div class="row">
                                      <div class="input-field col s12">
                                        <select class="" id="educational_background" name="educational_background">
                                           <option value="" disabled="">Choose your option</option>
                                           @foreach ($lookup['educational_background'] as $d)
                                           <option value="{{ $d['value'] }}" {{ $profile->educational_background == $d['value'] ? 'selected=""':'' }}>{{$d['name']}}</option>                                            
                                           @endforeach
                                        </select>
                                         <label for="educational_background">Pendidikan Terakhir</label>
                                      </div>
                                   </div>
                                   <div class="row">
                                      <div class="input-field col s12">
                                         <input id="educational_field" type="text" class="validate" name="educational_field" value="{{ $profile->educational_field }}">
                                         <label for="educational_field">Jurusan</label>
                                      </div>
                                   </div>
                                   <div class="row">
                                      <div class="input-field col s12">
                                         <input id="occupation" type="text" class="validate" name="occupation" value="{{ $profile->occupation }}">
                                         <label for="occupation">Profesi / Pekerjaan</label>
                                      </div>
                                   </div>
                                </div>
                             </div>
                          </div>
                          <div class="divider"></div>
                          <div class="card-footer" style="margin-top: 2rem;">
                             <div class="row">
                                <div class="col s6 text-left">
                                   <a href="{{ route('profile') }}" class="btn">Kembali</a>
                                   <button type="reset" class="btn">Reset</button>
                                </div>
                                <div class="col s6 text-right">
                                   <button type="submit" class="btn green">Simpan</button>
                                </div>
                             </div>
                          </div>
                       </div>
                    </div>
                 </form>
              </div>
           </div>
        </div>
     </div>
  </div>
</div>



@endsection

