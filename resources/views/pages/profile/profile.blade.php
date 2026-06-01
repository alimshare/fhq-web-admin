@extends('layouts.tailwind')

@section('title', 'Profil')
@section('page-title', 'Profil')

@section('content')

{{-- Breadcrumb --}}
<nav class="mb-6">
    <ol class="flex items-center gap-x-2 text-sm text-gray-500">
        <li><a href="/" class="hover:text-primary-600">Home</a></li>
        <li><span class="text-gray-300">/</span></li>
        <li class="text-gray-900 font-medium">Profile</li>
    </ol>
</nav>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Profile Card --}}
    <div class="lg:col-span-1">
        <div class="card">
            {{-- Avatar & Name --}}
            <div class="flex items-center gap-x-4 mb-6">
                <img src="/images/user-default.png" alt="avatar" class="h-16 w-16 rounded-full bg-gray-100 object-cover ring-2 ring-gray-200">
                <div class="min-w-0">
                    <h2 class="text-lg font-semibold text-gray-900 truncate">{{ $profile->name }}</h2>
                    <p class="text-sm text-gray-500">NIP: {{ $profile->nip }}</p>
                </div>
            </div>

            {{-- Info Table --}}
            <dl class="divide-y divide-gray-100">
                <div class="py-3 flex justify-between gap-x-4">
                    <dt class="text-sm text-gray-500">Jenis Kelamin</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $profile->gender == 'MALE' ? 'Laki-laki' : 'Perempuan' }}</dd>
                </div>
                <div class="py-3 flex justify-between gap-x-4">
                    <dt class="text-sm text-gray-500">Telepon</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $profile->phone }}</dd>
                </div>
                <div class="py-3 flex justify-between gap-x-4">
                    <dt class="text-sm text-gray-500">Email</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $profile->email }}</dd>
                </div>
                <div class="py-3 flex justify-between gap-x-4">
                    <dt class="text-sm text-gray-500">Alamat</dt>
                    <dd class="text-sm font-medium text-gray-900 text-right">{{ $profile->address }}</dd>
                </div>
                <div class="py-3 flex justify-between gap-x-4">
                    <dt class="text-sm text-gray-500">Role</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ implode(', ', $roles) }}</dd>
                </div>
                <div class="py-3 flex justify-between gap-x-4">
                    <dt class="text-sm text-gray-500">Status</dt>
                    <dd><span class="badge-success">Active</span></dd>
                </div>
            </dl>

            {{-- Edit Button --}}
            <div class="mt-6 text-right">
                <a href="{{ route('profile.edit') }}" class="btn-primary">
                    <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                    Edit Profile
                </a>
            </div>
        </div>
    </div>

    {{-- Halaqoh Tables --}}
    <div class="lg:col-span-2 space-y-6">

        {{-- Halaqoh Aktif --}}
        <div class="card">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Daftar Halaqoh Aktif</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-primary-600">
                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Semester</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Hari</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Program</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Jumlah Santri</th>
                            @allow('detail-halaqoh')
                            <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">Action</th>
                            @endallow
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($halaqoh_aktif as $n)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $n->semester_name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $n->day }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $n->program_name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $n->peserta_count }}</td>
                                @allow('detail-halaqoh')
                                <td class="px-4 py-3 text-center">
                                    <div class="flex items-center justify-center gap-x-2">
                                        <a href="/halaqoh/{{ $n->halaqoh_reference }}?referer=/profile" class="inline-flex items-center rounded-md bg-primary-50 px-2 py-1 text-xs font-medium text-primary-700 hover:bg-primary-100" title="Detail">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                                        </a>
                                        <a href="/absensi?halaqohRef={{ $n->halaqoh_reference }}" class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 hover:bg-green-100" title="Absensi">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15a2.25 2.25 0 012.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" /></svg>
                                        </a>
                                    </div>
                                </td>
                                @endallow
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-sm text-gray-500">Belum ada halaqoh aktif</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Halaqoh Lampau --}}
        <div class="card">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Daftar Halaqoh Lampau</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-primary-600">
                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Semester</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Hari</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Program</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Jumlah Santri</th>
                            @allow('detail-halaqoh')
                            <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">Action</th>
                            @endallow
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($halaqoh_lampau as $n)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $n->semester_name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $n->day }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $n->program_name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $n->peserta_count }}</td>
                                @allow('detail-halaqoh')
                                <td class="px-4 py-3 text-center">
                                    <a href="/halaqoh/{{ $n->halaqoh_reference }}?referer=/profile" class="inline-flex items-center rounded-md bg-primary-50 px-2 py-1 text-xs font-medium text-primary-700 hover:bg-primary-100" title="Detail">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                                    </a>
                                </td>
                                @endallow
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-sm text-gray-500">Belum ada halaqoh lampau</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@endsection

