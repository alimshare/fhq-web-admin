@extends('layouts.tailwind')

@section('title', 'Halaqoh')

@section('content')

{{-- Breadcrumb --}}
<nav class="mb-6">
    <ol class="flex items-center gap-x-2 text-sm text-gray-500">
        <li><a href="/" class="hover:text-primary-600">Dashboard</a></li>
        <li><span class="text-gray-300">/</span></li>
        <li class="text-gray-900 font-medium">Halaqoh</li>
    </ol>
</nav>

<div x-data="halaqohList()" class="space-y-4">

    {{-- Filters --}}
    <div class="card">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label for="orderBy" class="block text-sm font-medium text-gray-700 mb-1">Order By</label>
                <select id="orderBy" x-model="orderBy" @change="applyOrder()" class="input-field">
                    <option value="0">Semester</option>
                    <option value="1">Hari</option>
                    <option value="2">Gender</option>
                    <option value="3">Program</option>
                    <option value="4">Pengajar</option>
                </select>
            </div>
            <div>
                <label for="orderType" class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                <select id="orderType" x-model="orderType" @change="applyOrder()" class="input-field">
                    <option value="asc">ASC</option>
                    <option value="desc">DESC</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Daftar Halaqoh --}}
    <div class="card">
        <h3 class="text-base font-semibold text-gray-900 mb-3">Daftar Halaqoh</h3>

        {{-- Mobile card view --}}
        <div class="block lg:hidden space-y-3">
            @forelse ($list as $n)
                <div class="rounded-lg border border-gray-200 p-4">
                    <div class="flex items-start justify-between">
                        <div class="min-w-0">
                            <p class="font-medium text-gray-900">{{ $n->pengajar_name }}</p>
                            <p class="text-sm text-gray-500 mt-1">{{ $n->program_name }}</p>
                        </div>
                        <span class="badge {{ ($n->gender == 'FEMALE') ? 'bg-pink-100 text-pink-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ ($n->gender == "FEMALE") ? "AKHWAT" : "IKHWAN" }}
                        </span>
                    </div>
                    <div class="flex items-center gap-2 mt-2 text-xs text-gray-500">
                        <span>{{ $n->semester_name }}</span>
                        <span>&middot;</span>
                        <span>{{ $n->day }}</span>
                    </div>
                    <div class="flex items-center gap-2 mt-3">
                        <a href="/halaqoh/{{ $n->halaqoh_reference }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg bg-primary-50 text-primary-700 hover:bg-primary-100">
                            Detail
                        </a>
                        <button type="button" @click="loadPeserta('{{ $n->day }}','{{ $n->gender }}','{{ $n->program_name }}','{{ $n->pengajar_name }}','{{ $n->halaqoh_reference }}','{{ $n->semester_name }}')" class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg bg-green-50 text-green-700 hover:bg-green-100">
                            Peserta
                        </button>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500 text-center py-4">Belum ada data halaqoh</p>
            @endforelse
        </div>

        {{-- Desktop table view --}}
        <div class="hidden lg:block overflow-x-auto rounded-lg border border-gray-200">
            <table id="example" class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-primary-600">
                        <th class="px-3 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Semester</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Hari</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Gender</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Program</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Pengajar</th>
                        <th class="px-3 py-2 text-center text-xs font-medium text-white uppercase tracking-wider">Action</th>
                    </tr>
                    <tr class="bg-gray-50">
                        <th class="px-2 py-2"><input type="text" placeholder="Cari Semester" id="paramSemester" class="input-field text-xs"></th>
                        <th class="px-2 py-2">
                            <select id="paramHari" class="input-field text-xs">
                                <option value="">Semua</option>
                                @foreach ($days as $day)
                                    <option value="{{ $day }}">{{ $day }}</option>
                                @endforeach
                            </select>
                        </th>
                        <th class="px-2 py-2">
                            <select id="paramGender" class="input-field text-xs">
                                <option value="">Semua</option>
                                <option value="IKHWAN">IKHWAN</option>
                                <option value="AKHWAT">AKHWAT</option>
                            </select>
                        </th>
                        <th class="px-2 py-2"><input type="text" placeholder="Cari Program" id="paramProgram" class="input-field text-xs"></th>
                        <th class="px-2 py-2"><input type="text" placeholder="Cari Pengajar" id="paramPengajar" class="input-field text-xs"></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($list as $n)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 text-sm text-gray-900">{{ $n->semester_name }}</td>
                            <td class="px-3 py-2 text-sm text-gray-700">{{ $n->day }}</td>
                            <td class="px-3 py-2 text-sm">
                                <span class="badge {{ ($n->gender == 'FEMALE') ? 'bg-pink-100 text-pink-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ ($n->gender == "FEMALE") ? "AKHWAT" : "IKHWAN" }}
                                </span>
                            </td>
                            <td class="px-3 py-2 text-sm text-gray-700">{{ $n->program_name }}</td>
                            <td class="px-3 py-2 text-sm text-gray-700">{{ $n->pengajar_name }}</td>
                            <td class="px-3 py-2 text-center">
                                <div class="flex items-center justify-center gap-x-2">
                                    <a href="/halaqoh/{{ $n->halaqoh_reference }}" class="inline-flex items-center rounded-md bg-primary-50 px-2 py-1 text-xs font-medium text-primary-700 hover:bg-primary-100" title="Detail">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                                    </a>
                                    <button type="button" @click="loadPeserta('{{ $n->day }}','{{ $n->gender }}','{{ $n->program_name }}','{{ $n->pengajar_name }}','{{ $n->halaqoh_reference }}','{{ $n->semester_name }}')" class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 hover:bg-green-100" title="Daftar Peserta">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-1.053M18 6.75a3 3 0 11-6 0 3 3 0 016 0zm-8.25 6a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" /></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Daftar Peserta Halaqoh --}}
    <div class="card">
        <h3 class="text-base font-semibold text-gray-900 mb-3">Daftar Peserta Halaqoh</h3>

        {{-- Mobile card view --}}
        <div class="block lg:hidden space-y-3">
            @forelse ($peserta as $n)
                <div class="rounded-lg border border-gray-200 p-4">
                    <div class="flex items-start justify-between">
                        <div class="min-w-0">
                            <p class="font-medium text-gray-900">{{ $n->santri_name }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">NIS: {{ $n->nis }}</p>
                        </div>
                        <span class="badge {{ ($n->gender_santri == 'FEMALE') ? 'bg-pink-100 text-pink-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ ($n->gender_santri == "FEMALE") ? "AKHWAT" : "IKHWAN" }}
                        </span>
                    </div>
                    <div class="mt-2 space-y-1 text-sm text-gray-500">
                        <p>{{ $n->program_name }} &middot; {{ $n->day }}</p>
                        <p>Semester: {{ $n->semester_name }}</p>
                        <div class="flex items-center justify-between">
                            <span>Pengajar: {{ $n->pengajar_name }}</span>
                            <a href="/halaqoh/{{ $n->halaqoh_reference }}" class="text-primary-600 hover:text-primary-700 text-xs font-medium">Lihat</a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500 text-center py-4">Belum ada data peserta</p>
            @endforelse
        </div>

        {{-- Desktop table view --}}
        <div class="hidden lg:block overflow-x-auto rounded-lg border border-gray-200">
            <table id="tblPeserta" class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-primary-600">
                        <th class="px-3 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Semester</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Hari</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Gender</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Program</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Pengajar</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">NIS</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Santri</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($peserta as $n)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 text-sm text-gray-900">{{ $n->semester_name }}</td>
                            <td class="px-3 py-2 text-sm text-gray-700">{{ $n->day }}</td>
                            <td class="px-3 py-2 text-sm">
                                <span class="badge {{ ($n->gender_santri == 'FEMALE') ? 'bg-pink-100 text-pink-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ ($n->gender_santri == "FEMALE") ? "AKHWAT" : "IKHWAN" }}
                                </span>
                            </td>
                            <td class="px-3 py-2 text-sm text-gray-700">{{ $n->program_name }}</td>
                            <td class="px-3 py-2 text-sm text-gray-700">
                                <div class="flex items-center justify-between">
                                    <span>{{ $n->pengajar_name }}</span>
                                    <a href="/halaqoh/{{ $n->halaqoh_reference }}" class="text-primary-600 hover:text-primary-700">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                                    </a>
                                </div>
                            </td>
                            <td class="px-3 py-2 text-sm text-gray-700">{{ $n->nis }}</td>
                            <td class="px-3 py-2 text-sm text-gray-700">
                                <div class="flex items-center justify-between">
                                    <span>{{ $n->santri_name }}</span>
                                    <a href="/peserta/{{ $n->peserta_reference }}" class="text-primary-600 hover:text-primary-700">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Peserta --}}
    <div x-show="showModal" x-cloak
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="fixed inset-0 bg-gray-500/75" @click="showModal = false"></div>
            <div class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-xl transition-all w-full sm:max-w-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Daftar Peserta Halaqoh</h3>
                    <div class="flex flex-wrap gap-2 mt-3">
                        <span class="badge bg-primary-100 text-primary-800" x-text="modalSemester"></span>
                        <span class="badge bg-primary-100 text-primary-800" x-text="modalDay"></span>
                        <span class="badge bg-primary-100 text-primary-800" x-text="modalProgram"></span>
                        <span class="badge bg-primary-100 text-primary-800" x-text="modalPengajar"></span>
                    </div>
                </div>
                <div class="px-6 py-4 max-h-80 overflow-y-auto">
                    <ul class="divide-y divide-gray-100" id="modal-peserta-list">
                        <template x-for="p in pesertaList" :key="p.peserta_reference">
                            <li class="py-3 flex items-center justify-between">
                                <span class="text-sm text-gray-900" x-text="p.santri_name"></span>
                                <a :href="'/peserta/' + p.peserta_reference + '?referer=/halaqoh/' + currentRef" class="text-primary-600 hover:text-primary-700">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
                                </a>
                            </li>
                        </template>
                    </ul>
                </div>
                <div class="px-6 py-3 border-t border-gray-200 flex justify-end">
                    <button @click="showModal = false" class="btn-secondary text-sm">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('header-style')
<style>[x-cloak] { display: none !important; }</style>
@endsection

@section('footer-script')
<script src="{{ asset('assets/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
<link href="{{ asset('assets/plugins/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<script>
function halaqohList() {
    return {
        orderBy: '0',
        orderType: 'asc',
        showModal: false,
        modalSemester: '',
        modalDay: '',
        modalProgram: '',
        modalPengajar: '',
        pesertaList: [],
        currentRef: '',
        table: null,

        init() {
            this.table = $('#example').DataTable({
                lengthChange: false,
                searching: true,
                dom: 'lrtip',
                order: [[0, 'asc'],[1,'asc'],[3,'asc'],[4,'asc']],
                columnDefs: [{ targets: [0,1,2,3,4,5], orderable: false }]
            });

            $("#tblPeserta").DataTable();

            let self = this;
            this.table.columns().every(function() {
                var that = this;
                $('input', this.header()).on('keyup change clear', function() {
                    if (that.search() !== this.value) {
                        that.search(this.value).draw();
                    }
                });
                $('select', this.header()).on('change', function() {
                    let val = $.fn.dataTable.util.escapeRegex($(this).val());
                    that.search(val ? '^' + val + '$' : '', true, false).draw();
                });
            });
        },

        applyOrder() {
            if (this.table) {
                this.table.order([parseInt(this.orderBy), this.orderType]).draw();
            }
        },

        loadPeserta(day, gender, program, pengajar, reference, semester) {
            this.modalSemester = semester;
            this.modalDay = day;
            this.modalProgram = program;
            this.modalPengajar = pengajar;
            this.currentRef = reference;
            this.pesertaList = [];
            this.showModal = true;

            fetch("/api/halaqoh/" + reference + "/peserta")
                .then(res => res.json())
                .then(data => { this.pesertaList = data; });
        }
    };
}
</script>
@endsection
