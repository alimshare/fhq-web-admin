@extends('layouts.tailwind')

@section('title', 'Edit Nilai Halaqoh')

@section('content')

{{-- Breadcrumb --}}
<nav class="mb-6">
    <ol class="flex items-center gap-x-2 text-sm text-gray-500">
        <li><a href="/" class="hover:text-primary-600">Dashboard</a></li>
        <li><span class="text-gray-300">/</span></li>
        <li><a href="/halaqoh" class="hover:text-primary-600">Halaqoh</a></li>
        <li><span class="text-gray-300">/</span></li>
        <li class="text-gray-900 font-medium">Edit Nilai</li>
    </ol>
</nav>

{{-- Info Chips --}}
<div class="flex flex-wrap gap-2 mb-4">
    <span class="badge bg-primary-100 text-primary-800">{{ $halaqoh->day }}</span>
    <span class="badge bg-primary-100 text-primary-800">{{ $halaqoh->program_name }}</span>
    <span class="badge bg-primary-100 text-primary-800">{{ $halaqoh->pengajar_name }}</span>
</div>

<form action="/halaqoh-detail/save" method="POST" name="form-input-nilai">
    @csrf
    <input type="hidden" name="halaqohReference" value="{{ $halaqoh->halaqoh_reference }}">

    <div class="card mb-4">
        <h3 class="text-base font-semibold text-gray-900 mb-3">Input Nilai</h3>

        {{-- Mobile card view --}}
        <div class="block xl:hidden space-y-4">
            @php $no = 1; @endphp
            @foreach ($peserta as $santri)
                <div class="rounded-lg border border-gray-200 p-4">
                    <p class="font-medium text-gray-900">{{ $no++ }}. {{ $santri->santri_name }}</p>
                    <p class="text-xs text-gray-500 mb-3">NIS: {{ $santri->nis }}</p>

                    <div class="grid grid-cols-2 gap-3">
                        @if(in_array($halaqoh->program_id, explode(",", env('TAKHOSSUS_IDS', ''))))
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">UTS Tadribat</label>
                                <input type="number" step="0.1" name="data[{{$santri->peserta_id}}][nilai_uts_teori]" value="{{ $santri->nilai_uts_teori }}" class="input-field text-sm">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">UTS Tahfidz</label>
                                <input type="number" step="0.1" name="data[{{$santri->peserta_id}}][nilai_uts_praktek]" value="{{ $santri->nilai_uts_praktek }}" class="input-field text-sm">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">UAS Tadribat</label>
                                <input type="number" step="0.1" name="data[{{$santri->peserta_id}}][nilai_uas_teori]" value="{{ $santri->nilai_uas_teori }}" class="input-field text-sm">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">UAS Tahfidz</label>
                                <input type="number" step="0.1" name="data[{{$santri->peserta_id}}][nilai_uas_praktek]" value="{{ $santri->nilai_uas_praktek }}" class="input-field text-sm">
                            </div>
                        @else
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">UTS Teori</label>
                                <input type="number" step="0.1" name="data[{{$santri->peserta_id}}][nilai_uts_teori]" value="{{ $santri->nilai_uts_teori }}" class="input-field text-sm">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">UTS Praktek</label>
                                <input type="number" step="0.1" name="data[{{$santri->peserta_id}}][nilai_uts_praktek]" value="{{ $santri->nilai_uts_praktek }}" class="input-field text-sm">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">UAS Teori</label>
                                <input type="number" step="0.1" name="data[{{$santri->peserta_id}}][nilai_uas_teori]" value="{{ $santri->nilai_uas_teori }}" class="input-field text-sm">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">UAS Praktek</label>
                                <input type="number" step="0.1" name="data[{{$santri->peserta_id}}][nilai_uas_praktek]" value="{{ $santri->nilai_uas_praktek }}" class="input-field text-sm">
                            </div>
                        @endif
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Khatam</label>
                            <input type="number" step="0.1" name="data[{{$santri->peserta_id}}][khatam]" value="{{ $santri->khatam }}" class="input-field text-sm">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Kehadiran</label>
                            <input type="number" step="0.1" name="data[{{$santri->peserta_id}}][kehadiran]" value="{{ $santri->kehadiran }}" class="input-field text-sm">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Status</label>
                            <select name="data[{{$santri->peserta_id}}][status]" class="input-field text-sm">
                                <option value=""></option>
                                <option value="TETAP" {{ ($santri->status == 'TETAP') ? 'selected' : '' }}>TETAP</option>
                                <option value="NAIK" {{ ($santri->status == 'NAIK') ? 'selected' : '' }}>NAIK</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-3 space-y-3">
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Catatan</label>
                            <textarea name="data[{{$santri->peserta_id}}][note]" rows="2" class="input-field text-sm">{{ $santri->catatan }}</textarea>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Catatan Manajemen</label>
                            <textarea name="data[{{$santri->peserta_id}}][management_note]" rows="2" class="input-field text-sm">{{ $santri->catatan_manajemen }}</textarea>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Desktop table view --}}
        <div class="hidden xl:block overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-primary-600">
                        <th rowspan="2" class="px-3 py-2 text-left text-xs font-medium text-white uppercase">No</th>
                        <th rowspan="2" class="px-3 py-2 text-left text-xs font-medium text-white uppercase">NIS</th>
                        <th rowspan="2" class="px-3 py-2 text-left text-xs font-medium text-white uppercase">Nama Santri</th>
                        <th colspan="2" class="px-3 py-2 text-center text-xs font-medium text-white uppercase border-b border-primary-400">UTS</th>
                        <th colspan="2" class="px-3 py-2 text-center text-xs font-medium text-white uppercase border-b border-primary-400">UAS</th>
                        <th rowspan="2" class="px-3 py-2 text-center text-xs font-medium text-white uppercase">Khatam</th>
                        <th rowspan="2" class="px-3 py-2 text-center text-xs font-medium text-white uppercase">Kehadiran</th>
                        <th rowspan="2" class="px-3 py-2 text-center text-xs font-medium text-white uppercase">Status</th>
                        <th rowspan="2" class="px-3 py-2 text-center text-xs font-medium text-white uppercase">Catatan</th>
                        <th rowspan="2" class="px-3 py-2 text-center text-xs font-medium text-white uppercase">Catatan Mgmt</th>
                    </tr>
                    @if(in_array($halaqoh->program_id, explode(",", env('TAKHOSSUS_IDS', ''))))
                        <tr class="bg-primary-600">
                            <th class="px-3 py-2 text-center text-xs font-medium text-white">Tadribat</th>
                            <th class="px-3 py-2 text-center text-xs font-medium text-white">Tahfidz</th>
                            <th class="px-3 py-2 text-center text-xs font-medium text-white">Tadribat</th>
                            <th class="px-3 py-2 text-center text-xs font-medium text-white">Tahfidz</th>
                        </tr>
                    @else
                        <tr class="bg-primary-600">
                            <th class="px-3 py-2 text-center text-xs font-medium text-white">Teori</th>
                            <th class="px-3 py-2 text-center text-xs font-medium text-white">Praktek</th>
                            <th class="px-3 py-2 text-center text-xs font-medium text-white">Teori</th>
                            <th class="px-3 py-2 text-center text-xs font-medium text-white">Praktek</th>
                        </tr>
                    @endif
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php $no = 1; @endphp
                    @foreach ($peserta as $santri)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 text-sm text-gray-500">{{ $no++ }}</td>
                            <td class="px-3 py-2 text-sm text-gray-700">{{ $santri->nis }}</td>
                            <td class="px-3 py-2 text-sm text-gray-900 whitespace-nowrap">{{ $santri->santri_name }}</td>
                            <td class="px-1 py-2"><input type="number" step="0.1" name="data[{{$santri->peserta_id}}][nilai_uts_teori]" value="{{ $santri->nilai_uts_teori }}" class="input-field text-xs w-20"></td>
                            <td class="px-1 py-2"><input type="number" step="0.1" name="data[{{$santri->peserta_id}}][nilai_uts_praktek]" value="{{ $santri->nilai_uts_praktek }}" class="input-field text-xs w-20"></td>
                            <td class="px-1 py-2"><input type="number" step="0.1" name="data[{{$santri->peserta_id}}][nilai_uas_teori]" value="{{ $santri->nilai_uas_teori }}" class="input-field text-xs w-20"></td>
                            <td class="px-1 py-2"><input type="number" step="0.1" name="data[{{$santri->peserta_id}}][nilai_uas_praktek]" value="{{ $santri->nilai_uas_praktek }}" class="input-field text-xs w-20"></td>
                            <td class="px-1 py-2"><input type="number" step="0.1" name="data[{{$santri->peserta_id}}][khatam]" value="{{ $santri->khatam }}" class="input-field text-xs w-20"></td>
                            <td class="px-1 py-2"><input type="number" step="0.1" name="data[{{$santri->peserta_id}}][kehadiran]" value="{{ $santri->kehadiran }}" class="input-field text-xs w-20"></td>
                            <td class="px-1 py-2">
                                <select name="data[{{$santri->peserta_id}}][status]" class="input-field text-xs w-24">
                                    <option value=""></option>
                                    <option value="TETAP" {{ ($santri->status == 'TETAP') ? 'selected' : '' }}>TETAP</option>
                                    <option value="NAIK" {{ ($santri->status == 'NAIK') ? 'selected' : '' }}>NAIK</option>
                                </select>
                            </td>
                            <td class="px-1 py-2"><textarea name="data[{{$santri->peserta_id}}][note]" rows="1" class="input-field text-xs w-28">{{ $santri->catatan }}</textarea></td>
                            <td class="px-1 py-2"><textarea name="data[{{$santri->peserta_id}}][management_note]" rows="1" class="input-field text-xs w-28">{{ $santri->catatan_manajemen }}</textarea></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-end">
        <button type="submit" class="btn-primary">
            <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" /></svg>
            Simpan
        </button>
    </div>
</form>

@endsection
