@extends('layouts.tailwind')

@section('title', 'Detail Halaqoh')

@section('content')

{{-- Breadcrumb --}}
<nav class="mb-6">
    <ol class="flex items-center gap-x-2 text-sm text-gray-500">
        <li><a href="/" class="hover:text-primary-600">Dashboard</a></li>
        <li><span class="text-gray-300">/</span></li>
        <li><a href="{{ Request::get('referer') ? '#' : '/halaqoh' }}" class="hover:text-primary-600">Halaqoh</a></li>
        <li><span class="text-gray-300">/</span></li>
        <li class="text-gray-900 font-medium">Detail</li>
    </ol>
</nav>

{{-- Info Chips --}}
<div class="flex flex-wrap gap-2 mb-4">
    <span class="badge bg-primary-100 text-primary-800">Semester {{ $halaqoh->semester_name }}</span>
    <span class="badge bg-primary-100 text-primary-800">{{ $halaqoh->day }}</span>
    <span class="badge bg-primary-100 text-primary-800">{{ $halaqoh->program_name }}</span>
    <span class="badge bg-primary-100 text-primary-800">{{ $halaqoh->pengajar_name }}</span>
</div>

{{-- Action Buttons --}}
<div class="flex flex-wrap items-center gap-2 mb-4">
    @if (Auth::user()->isPengajar())
        <a href="{{ route('profile') }}" class="btn-secondary text-sm">Profile</a>
    @endif
    @allow('input-nilai')
        <a href="/halaqoh/{{ $halaqoh->halaqoh_reference }}/edit" class="inline-flex items-center px-4 py-2 bg-green-500 text-white text-sm font-medium rounded-lg hover:bg-green-600 transition-colors">
            <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" /></svg>
            Edit
        </a>
    @endallow
</div>

{{-- Nilai Table --}}
<div class="card mb-4">
    <h3 class="text-base font-semibold text-gray-900 mb-3">Nilai Peserta</h3>

    {{-- Mobile card view --}}
    <div class="block xl:hidden space-y-4">
        @php $countDU = 0; @endphp
        @foreach ($peserta as $santri)
            <div class="rounded-lg border border-gray-200 p-4">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="font-medium text-gray-900">
                            @allow('detail-santri')
                                <a href="{{ route('santri.mutabaah', ['pesertaId'=> $santri->peserta_id]) }}?referer=/halaqoh/{{ $halaqoh->halaqoh_reference }}" class="text-primary-600 hover:text-primary-700">{{ $santri->santri_name }}</a>
                            @else
                                {{ $santri->santri_name }}
                            @endallow
                        </p>
                        <p class="text-xs text-gray-500 mt-0.5">NIS: {{ $santri->nis }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        @if (!empty($santri->daftarUlang))
                            @php $countDU++; @endphp
                            @if(@$santri->daftarUlang->jenis_kbm == "CUTI" || @$santri->daftarUlang->hari == "CUTI")
                                <span class="badge bg-gray-800 text-white">CUTI</span>
                            @else
                                <span class="badge-success">DU</span>
                            @endif
                        @endif
                        <a href="{{ route('peserta.raport.print', ['peserta_id'=> $santri->peserta_id]) }}" target="_blank" class="inline-flex items-center rounded-md bg-purple-50 px-2 py-1 text-xs font-medium text-purple-700 hover:bg-purple-100">Rapot</a>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-x-4 gap-y-2 mt-3 text-sm">
                    @if(in_array($halaqoh->program_id, explode(",", env('TAKHOSSUS_IDS', ''))))
                        <div><span class="text-gray-500">UTS Tadribat:</span> <span class="font-medium">{{ $santri->nilai_uts_teori }}</span></div>
                        <div><span class="text-gray-500">UTS Tahfidz:</span> <span class="font-medium">{{ $santri->nilai_uts_praktek }}</span></div>
                        <div><span class="text-gray-500">UAS Tadribat:</span> <span class="font-medium">{{ $santri->nilai_uas_teori }}</span></div>
                        <div><span class="text-gray-500">UAS Tahfidz:</span> <span class="font-medium">{{ $santri->nilai_uas_praktek }}</span></div>
                    @else
                        <div><span class="text-gray-500">UTS Teori:</span> <span class="font-medium">{{ $santri->nilai_uts_teori }}</span></div>
                        <div><span class="text-gray-500">UTS Praktek:</span> <span class="font-medium">{{ $santri->nilai_uts_praktek }}</span></div>
                        <div><span class="text-gray-500">UAS Teori:</span> <span class="font-medium">{{ $santri->nilai_uas_teori }}</span></div>
                        <div><span class="text-gray-500">UAS Praktek:</span> <span class="font-medium">{{ $santri->nilai_uas_praktek }}</span></div>
                    @endif
                    <div><span class="text-gray-500">Khatam:</span> <span class="font-medium">{{ $santri->khatam }}</span></div>
                    <div><span class="text-gray-500">Kehadiran:</span> <span class="font-medium">{{ $santri->kehadiran }}</span></div>
                    <div><span class="text-gray-500">Status:</span> <span class="font-medium">{{ $santri->status }}</span></div>
                </div>

                @if ($santri->catatan)
                    <p class="mt-2 text-xs text-gray-500"><span class="font-medium">Catatan:</span> {{ $santri->catatan }}</p>
                @endif
                @if ($santri->catatan_manajemen)
                    <p class="mt-1 text-xs text-gray-500"><span class="font-medium">Catatan Manajemen:</span> {{ $santri->catatan_manajemen }}</p>
                @endif
            </div>
        @endforeach
        <p class="text-sm text-gray-500 text-right">Daftar Ulang: {{ $countDU }} / {{ count($peserta) }}</p>
    </div>

    {{-- Desktop table view --}}
    <div class="hidden xl:block overflow-x-auto rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr class="bg-primary-600">
                    <th rowspan="2" class="px-3 py-2 text-left text-xs font-medium text-white uppercase">Rapot</th>
                    <th rowspan="2" class="px-3 py-2 text-left text-xs font-medium text-white uppercase">NIS</th>
                    <th rowspan="2" class="px-3 py-2 text-left text-xs font-medium text-white uppercase">Nama Santri</th>
                    <th colspan="2" class="px-3 py-2 text-center text-xs font-medium text-white uppercase border-b border-primary-400">UTS</th>
                    <th colspan="2" class="px-3 py-2 text-center text-xs font-medium text-white uppercase border-b border-primary-400">UAS</th>
                    <th rowspan="2" class="px-3 py-2 text-center text-xs font-medium text-white uppercase">Khatam</th>
                    <th rowspan="2" class="px-3 py-2 text-center text-xs font-medium text-white uppercase">Kehadiran</th>
                    <th rowspan="2" class="px-3 py-2 text-center text-xs font-medium text-white uppercase">Status</th>
                    <th rowspan="2" class="px-3 py-2 text-center text-xs font-medium text-white uppercase">Catatan</th>
                    <th rowspan="2" class="px-3 py-2 text-center text-xs font-medium text-white uppercase">Catatan Mgmt</th>
                    <th rowspan="2" class="px-3 py-2 text-center text-xs font-medium text-white uppercase">DU</th>
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
                @php $countDU = 0; @endphp
                @foreach ($peserta as $santri)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center">
                            <a href="{{ route('peserta.raport.print', ['peserta_id'=> $santri->peserta_id]) }}" target="_blank" class="inline-flex items-center rounded-md bg-purple-50 px-2 py-1 text-xs font-medium text-purple-700 hover:bg-purple-100" title="Cetak Rapot">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                            </a>
                        </td>
                        <td class="px-3 py-2 text-sm text-gray-700">{{ $santri->nis }}</td>
                        <td class="px-3 py-2 text-sm text-gray-900">
                            @allow('detail-santri')
                                <a href="{{ route('santri.mutabaah', ['pesertaId'=> $santri->peserta_id]) }}?referer=/halaqoh/{{ $halaqoh->halaqoh_reference }}" class="text-primary-600 hover:text-primary-700">{{ $santri->santri_name }}</a>
                            @else
                                {{ $santri->santri_name }}
                            @endallow
                        </td>
                        <td class="px-3 py-2 text-sm text-right text-gray-700">{{ $santri->nilai_uts_teori }}</td>
                        <td class="px-3 py-2 text-sm text-right text-gray-700">{{ $santri->nilai_uts_praktek }}</td>
                        <td class="px-3 py-2 text-sm text-right text-gray-700">{{ $santri->nilai_uas_teori }}</td>
                        <td class="px-3 py-2 text-sm text-right text-gray-700">{{ $santri->nilai_uas_praktek }}</td>
                        <td class="px-3 py-2 text-sm text-right text-gray-700">{{ $santri->khatam }}</td>
                        <td class="px-3 py-2 text-sm text-right text-gray-700">{{ $santri->kehadiran }}</td>
                        <td class="px-3 py-2 text-sm text-center text-gray-700">{{ $santri->status }}</td>
                        <td class="px-3 py-2 text-sm text-center text-gray-500 max-w-[120px] truncate" title="{{ $santri->catatan }}">{{ $santri->catatan }}</td>
                        <td class="px-3 py-2 text-sm text-center text-gray-500 max-w-[120px] truncate" title="{{ $santri->catatan_manajemen }}">{{ $santri->catatan_manajemen }}</td>
                        <td class="px-3 py-2 text-center">
                            @if (!empty($santri->daftarUlang))
                                @php $countDU++; @endphp
                                @if(@$santri->daftarUlang->jenis_kbm == "CUTI" || @$santri->daftarUlang->hari == "CUTI")
                                    <span class="badge bg-gray-800 text-white">CUTI</span>
                                @else
                                    <span class="badge-success">DU</span>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="bg-gray-50">
                    <td colspan="12" class="px-3 py-2"></td>
                    <td class="px-3 py-2 text-sm font-medium text-center text-gray-900">{{ $countDU }} / {{ count($peserta) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

{{-- Kehadiran Peserta --}}
<div class="card">
    <h3 class="text-base font-semibold text-gray-900 mb-3">Kehadiran Peserta</h3>

    <div class="overflow-x-auto rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr class="bg-primary-600">
                    <th class="px-3 py-2 text-left text-xs font-medium text-white uppercase">No.</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-white uppercase">Nama Santri</th>
                    <th class="px-3 py-2 text-center text-xs font-medium text-white uppercase">Total</th>
                    @foreach ($halaqoh->kbm as $kbm)
                        <th class="px-2 py-1.5 text-center text-xs font-medium text-white">
                            @php $time = strtotime($kbm->tgl); @endphp
                            {{ date("d/m", $time) }}<br><span class="text-[10px] opacity-75">{{ date("Y", $time) }}</span>
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @php $i = 1; @endphp
                @foreach($peserta as $santri)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-1.5 text-sm text-gray-500">{{ $i++ }}</td>
                        <td class="px-3 py-1.5 text-sm text-gray-900 whitespace-nowrap">
                            <a href="{{ route('santri.mutabaah',['pesertaId'=>$santri->peserta_id]) }}?referer=/halaqoh/{{ $halaqoh->halaqoh_reference }}" class="text-primary-600 hover:text-primary-700">{{ $santri->santri_name }}</a>
                        </td>
                        <td class="px-3 py-1.5 text-sm text-center font-medium text-gray-900">{{ $total_kehadiran[$santri->peserta_id] ?? "" }}</td>
                        @foreach ($halaqoh->kbm as $kbm)
                            @php $pesertaHadir = $kbm->attendances->pluck('status','peserta_id'); @endphp
                            <td class="px-2 py-1.5 text-center">
                                @if(!empty($pesertaHadir[$santri->peserta_id]) && $pesertaHadir[$santri->peserta_id] == 1)
                                    <svg class="h-5 w-5 text-green-500 mx-auto" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                @else
                                    <svg class="h-5 w-5 text-red-400 mx-auto" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
