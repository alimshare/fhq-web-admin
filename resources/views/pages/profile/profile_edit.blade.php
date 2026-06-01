@extends('layouts.tailwind')

@section('title', 'Edit Profil')
@section('page-title', 'Edit Profil')

@section('content')

{{-- Breadcrumb --}}
<nav class="mb-6">
    <ol class="flex items-center gap-x-2 text-sm text-gray-500">
        <li><a href="{{ route('home') }}" class="hover:text-primary-600">Home</a></li>
        <li><span class="text-gray-300">/</span></li>
        <li><a href="{{ route('profile') }}" class="hover:text-primary-600">Profile</a></li>
        <li><span class="text-gray-300">/</span></li>
        <li class="text-gray-900 font-medium">Edit</li>
    </ol>
</nav>

<form action="{{ route('profile.edit.save') }}" method="post">
    @csrf
    <input type="hidden" name="profile_id" value="{{ Auth::user()->profile_id }}">
    <input type="hidden" name="profile_type" value="{{ Auth::user()->profile_type }}">

    <div class="space-y-8">

        {{-- Section: Pribadi --}}
        <div class="card">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <h3 class="text-lg font-semibold text-gray-900">Pribadi</h3>
                    <p class="mt-1 text-sm text-gray-500">Informasi Pribadi Pengajar</p>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2 space-y-4">
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                        <input type="text" id="username" value="{{ Auth::user()->username }}" disabled class="input-field mt-1 bg-gray-50 text-gray-500 cursor-not-allowed">
                    </div>
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ $profile->name }}" required class="input-field mt-1">
                    </div>
                    <div>
                        <label for="father_name" class="block text-sm font-medium text-gray-700">Nama Ayah</label>
                        <input type="text" id="father_name" name="father_name" value="{{ $profile->father_name }}" placeholder="Nama Ayah Kandung" class="input-field mt-1">
                    </div>
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                        <input type="text" id="gender" value="{{ $profile->gender == 'MALE' ? 'Laki-laki' : 'Perempuan' }}" disabled class="input-field mt-1 bg-gray-50 text-gray-500 cursor-not-allowed">
                    </div>
                    <div>
                        <label for="birth_place" class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                        <input type="text" id="birth_place" name="birth_place" value="{{ $profile->birth_place }}" placeholder="Tempat Lahir" class="input-field mt-1">
                    </div>
                    <div>
                        <label for="birth_date" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                        <input type="date" id="birth_date" name="birth_date" value="{{ $profile->birth_date }}" max="{{ date('Y-m-d') }}" class="input-field mt-1">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Handphone <span class="text-red-500">*</span></label>
                        <input type="text" id="phone" name="phone" value="{{ $profile->phone }}" placeholder="Nomor Handphone" required class="input-field mt-1">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email" value="{{ $profile->email }}" placeholder="contoh: alan@gmail.com" class="input-field mt-1">
                    </div>
                    <div>
                        <label for="marital_status" class="block text-sm font-medium text-gray-700">Status Pernikahan</label>
                        <select id="marital_status" name="marital_status" class="input-field mt-1">
                            <option value="" disabled>Pilih opsi</option>
                            @foreach ($lookup['marital_status'] as $status)
                                <option value="{{ $status['value'] }}" {{ $profile->marital_status == $status['value'] ? 'selected' : '' }}>{{ $status['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="spouse" class="block text-sm font-medium text-gray-700">Nama Pasangan</label>
                        <input type="text" id="spouse" name="spouse" value="{{ $profile->spouse }}" class="input-field mt-1">
                    </div>
                </div>
            </div>
        </div>

        {{-- Section: Tempat Tinggal --}}
        <div class="card">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <h3 class="text-lg font-semibold text-gray-900">Tempat Tinggal</h3>
                    <p class="mt-1 text-sm text-gray-500">Informasi Tempat Tinggal</p>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2 space-y-4">
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                        <textarea id="address" name="address" rows="3" class="input-field mt-1">{{ $profile->address }}</textarea>
                    </div>
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700">Kota/Kabupaten</label>
                        <input type="text" id="city" name="city" value="{{ $profile->city }}" class="input-field mt-1">
                    </div>
                    <div>
                        <label for="district" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                        <input type="text" id="district" name="district" value="{{ $profile->district }}" class="input-field mt-1">
                    </div>
                    <div>
                        <label for="village" class="block text-sm font-medium text-gray-700">Kelurahan</label>
                        <input type="text" id="village" name="village" value="{{ $profile->village }}" class="input-field mt-1">
                    </div>
                </div>
            </div>
        </div>

        {{-- Section: Pekerjaan & Pendidikan --}}
        <div class="card">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <h3 class="text-lg font-semibold text-gray-900">Pekerjaan & Pendidikan</h3>
                    <p class="mt-1 text-sm text-gray-500">Informasi Pekerjaan, Bidang Keilmuan & Pendidikan</p>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2 space-y-4">
                    <div>
                        <label for="educational_background" class="block text-sm font-medium text-gray-700">Pendidikan Terakhir</label>
                        <select id="educational_background" name="educational_background" class="input-field mt-1">
                            <option value="" disabled>Pilih opsi</option>
                            @foreach ($lookup['educational_background'] as $d)
                                <option value="{{ $d['value'] }}" {{ $profile->educational_background == $d['value'] ? 'selected' : '' }}>{{ $d['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="educational_field" class="block text-sm font-medium text-gray-700">Jurusan</label>
                        <input type="text" id="educational_field" name="educational_field" value="{{ $profile->educational_field }}" class="input-field mt-1">
                    </div>
                    <div>
                        <label for="occupation" class="block text-sm font-medium text-gray-700">Profesi / Pekerjaan</label>
                        <input type="text" id="occupation" name="occupation" value="{{ $profile->occupation }}" class="input-field mt-1">
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-between">
            <div class="flex gap-x-3">
                <a href="{{ route('profile') }}" class="btn-secondary">Kembali</a>
                <button type="reset" class="btn-secondary">Reset</button>
            </div>
            <button type="submit" class="btn-primary">
                <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
                Simpan
            </button>
        </div>

    </div>
</form>

@endsection

