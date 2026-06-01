@extends('layouts.tailwind')

@section('title', 'Tambah Halaqoh')

@section('content')

{{-- Breadcrumb --}}
<nav class="mb-6">
    <ol class="flex items-center gap-x-2 text-sm text-gray-500">
        <li><a href="/" class="hover:text-primary-600">Beranda</a></li>
        <li><span class="text-gray-300">/</span></li>
        <li class="text-gray-900 font-medium">Tambah Halaqoh</li>
    </ol>
</nav>

<div class="max-w-lg mx-auto">
    <div class="card">
        <h2 class="text-lg font-semibold text-gray-900 mb-6">Tambah Halaqoh</h2>

        <form action="{{ route('halaqoh.addPost') }}" method="POST" autocomplete="off">
            @csrf
            <input type="hidden" name="redirectTo" value="{{ $redirectTo }}">

            <div class="space-y-6">
                {{-- Hari --}}
                <div>
                    <label for="day" class="block text-sm font-medium text-gray-700 mb-1.5">Hari</label>
                    <select name="day" id="day" class="input-field">
                        <option disabled selected>-- Pilih Hari --</option>
                        @foreach ($days as $day)
                            <option value="{{ trim($day) }}" {{ strtolower($hari) == strtolower($day) ? 'selected' : '' }}>{{ $day }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Program --}}
                <div>
                    <label for="program" class="block text-sm font-medium text-gray-700 mb-1.5">Program</label>
                    <select name="program" id="program" class="input-field">
                        <option disabled selected>-- Pilih Program --</option>
                        @foreach($program as $p)
                            <option value="{{ $p->id }}" {{ (!empty($program_id) && $program_id == $p->id) ? 'selected' : '' }}>{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Jenis KBM --}}
                <div>
                    <label for="jenis_kbm" class="block text-sm font-medium text-gray-700 mb-1.5">Jenis KBM</label>
                    <select name="jenis_kbm" id="jenis_kbm" class="input-field">
                        <option disabled selected>-- Pilih Jenis KBM --</option>
                        <option value="OFFLINE" {{ strtoupper($kbm ?? '') == 'OFFLINE' ? 'selected' : '' }}>OFFLINE</option>
                        <option value="ONLINE" {{ strtoupper($kbm ?? '') == 'ONLINE' ? 'selected' : '' }}>ONLINE</option>
                    </select>
                </div>

                {{-- Pengajar --}}
                <div>
                    <label for="pengajar" class="block text-sm font-medium text-gray-700 mb-1.5">Pengajar</label>
                    <select name="pengajar" id="pengajar" class="input-field">
                        <option disabled selected>-- Pilih Pengajar --</option>
                        @foreach($pengajar as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Gender --}}
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-1.5">Jenis Kelamin</label>
                    <select name="gender" id="gender" class="input-field">
                        <option disabled selected>-- Pilih Jenis Kelamin --</option>
                        <option value="MALE" {{ strtoupper($gender ?? '') == 'MALE' ? 'selected' : '' }}>IKHWAN</option>
                        <option value="FEMALE" {{ strtoupper($gender ?? '') == 'FEMALE' ? 'selected' : '' }}>AKHWAT</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 mt-10 pt-6 border-t border-gray-100">
                <button type="reset" class="btn-secondary">Batal</button>
                <button type="submit" class="btn-primary">Tambah</button>
            </div>
        </form>
    </div>
</div>

@endsection
