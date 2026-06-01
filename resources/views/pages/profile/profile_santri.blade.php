@extends('layouts.tailwind')

@section('title', 'Profil Santri')
@section('page-title', 'Profil Santri')

@section('content')

{{-- Breadcrumb --}}
<nav class="mb-6">
    <ol class="flex items-center gap-x-2 text-sm text-gray-500">
        <li><a href="/" class="hover:text-primary-600">Home</a></li>
        <li><span class="text-gray-300">/</span></li>
        <li><a href="/santri" class="hover:text-primary-600">Santri</a></li>
        <li><span class="text-gray-300">/</span></li>
        <li class="text-gray-900 font-medium">Profile</li>
    </ol>
</nav>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Profile Card --}}
    <div class="lg:col-span-1">
        <div class="card">
            <dl class="divide-y divide-gray-100">
                <div class="py-3 flex justify-between gap-x-4">
                    <dt class="text-sm text-gray-500">NIS</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $profile->nis }}</dd>
                </div>
                <div class="py-3 flex justify-between gap-x-4">
                    <dt class="text-sm text-gray-500">Nama</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $profile->name }}</dd>
                </div>
                <div class="py-3 flex justify-between gap-x-4">
                    <dt class="text-sm text-gray-500">Jenis Kelamin</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $profile->gender == 'MALE' ? 'Laki-laki' : 'Perempuan' }}</dd>
                </div>
                <div class="py-3 flex justify-between gap-x-4">
                    <dt class="text-sm text-gray-500">Telepon</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $profile->phone }}</dd>
                </div>
            </dl>

            @if (Request::input('referer'))
                <div class="mt-4">
                    <a href="{{ Request::input('referer') }}" class="btn-secondary">
                        <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                        </svg>
                        Kembali
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- Tables --}}
    <div class="lg:col-span-2 space-y-6">

        {{-- Catatan Pekanan --}}
        @isset($mutabaah)
        <div class="card">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Catatan Pekanan</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-primary-600">
                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Kehadiran</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Catatan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($mutabaah as $m)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $m->activity->tgl }}</td>
                                <td class="px-4 py-3 text-sm">
                                    @if($m->status == 1)
                                        <span class="badge-success">Hadir</span>
                                    @else
                                        <span class="badge-danger">Tidak Hadir</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $m->note }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-8 text-center text-sm text-gray-500">Belum ada catatan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endisset

        {{-- Riwayat Halaqoh --}}
        @isset($halaqoh)
        <div class="card">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Daftar Riwayat Halaqoh</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-primary-600">
                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Semester</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Hari</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Program</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Pengajar</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($halaqoh as $n)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $n->semester_name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $n->day }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $n->program_name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $n->pengajar_name }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-sm text-gray-500">Belum ada riwayat halaqoh</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endisset

    </div>
</div>

@endsection

