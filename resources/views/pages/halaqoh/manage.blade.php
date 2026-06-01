@extends('layouts.tailwind')

@section('title', 'Manage Halaqoh')

@section('content')

{{-- Breadcrumb --}}
<nav class="mb-6">
    <ol class="flex items-center gap-x-2 text-sm text-gray-500">
        <li><a href="/" class="hover:text-primary-600">Dashboard</a></li>
        <li><span class="text-gray-300">/</span></li>
        <li class="text-gray-900 font-medium">Manage Halaqoh</li>
    </ol>
</nav>

<div x-data="manageHalaqoh()" class="space-y-6">

    {{-- Semester Filter --}}
    <div class="card">
        <form action="" method="get" class="flex flex-col sm:flex-row items-stretch sm:items-end gap-3">
            <div class="flex-1 max-w-xs">
                <label for="filter-semester" class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                <select name="semester_id" id="filter-semester" class="input-field">
                    <option value="">- Pilih Semester -</option>
                    @foreach ($semesterList as $item)
                        <option value="{{ $item->id }}" {{ request('semester_id') == $item->id ? 'selected' : '' }}>Semester {{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn-primary self-start sm:self-auto">Pilih</button>
        </form>
    </div>

    {{-- Day Tabs --}}
    <div>
        {{-- Tab Navigation --}}
        <div class="border-b border-gray-200 overflow-x-auto">
            <nav class="flex -mb-px space-x-1 min-w-max" aria-label="Tabs">
                @foreach ($days as $d)
                    <button type="button"
                            @click="activeTab = '{{ $d }}'"
                            :class="activeTab === '{{ $d }}'
                                ? 'border-primary-500 text-primary-600 bg-primary-50'
                                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="whitespace-nowrap border-b-2 px-4 py-3 text-sm font-medium transition-colors">
                        {{ $d }}
                    </button>
                @endforeach
            </nav>
        </div>

        {{-- Tab Content --}}
        @foreach ($data as $day => $halaqoh)
            <div x-show="activeTab === '{{ $day }}'" x-cloak class="pt-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($program as $o)
                        @if(!empty($halaqoh[$o->id]))
                        <div class="rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                            {{-- Program Header --}}
                            <div class="bg-primary-600 text-white px-4 py-3">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="font-medium text-sm leading-relaxed">{{ $o->name }}</h4>
                                        <p class="text-xs text-primary-100 mt-0.5">{{ count($halaqoh[$o->id]) }} Halaqoh</p>
                                    </div>
                                    @allow('add-halaqoh')
                                    <a href="/halaqoh/add?hari={{ $day }}&program={{ $o->id }}&ref=/halaqoh/manage" class="flex items-center justify-center h-8 w-8 rounded-full bg-red-400 hover:bg-red-500 text-white transition-colors" title="Tambah Halaqoh">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                                    </a>
                                    @endallow
                                </div>
                            </div>

                            {{-- Halaqoh List --}}
                            <ul class="divide-y divide-gray-100 max-h-[270px] overflow-y-auto">
                                @foreach($halaqoh[$o->id] as $h)
                                <li class="px-4 py-2 hover:bg-gray-50">
                                    <div class="flex items-center justify-between gap-2">
                                        <div class="min-w-0">
                                            <p class="text-sm font-medium {{ @$h->gender == 'FEMALE' ? 'text-pink-600' : 'text-gray-900' }} truncate">
                                                {{ $h->pengajar ?? "Belum Ditentukan" }}
                                            </p>
                                            @if(strtoupper($h->jenis_kbm) == "ONLINE")
                                                <span class="badge bg-green-100 text-green-800 text-[10px] mt-0.5">Online</span>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-1.5 shrink-0">
                                            @allow('admin::manage::halaqoh')
                                                <span class="text-xs font-semibold text-blue-600">{{ $h->peserta_count ?? "" }}</span>
                                                <a href="/halaqoh/{{ $h->reference }}" class="text-xs text-primary-600 hover:text-primary-700 font-medium">Lihat</a>
                                                <a href="/halaqoh/{{ $h->reference }}/edit-data" class="text-xs text-gray-500 hover:text-gray-700 font-medium">Edit</a>
                                            @else
                                                <span class="text-xs font-semibold text-blue-600">{{ $h->peserta_count ?? "" }}</span>
                                            @endallow
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endforeach
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
                        <span class="badge bg-primary-100 text-primary-800" x-text="modalDay"></span>
                        <span class="badge bg-primary-100 text-primary-800" x-text="modalProgram"></span>
                        <span class="badge bg-primary-100 text-primary-800" x-text="modalKbm"></span>
                        <span class="badge bg-primary-100 text-primary-800" x-text="modalPengajar"></span>
                    </div>
                </div>
                <div class="px-6 py-4 max-h-80 overflow-y-auto">
                    <ul class="divide-y divide-gray-100">
                        <template x-for="p in pesertaList" :key="p.santri_name">
                            <li class="py-3 flex items-center justify-between">
                                <span class="text-sm text-gray-900" x-text="p.santri_name"></span>
                                <span class="badge" :class="p.gender === 'FEMALE' ? 'bg-pink-100 text-pink-800' : 'bg-blue-100 text-blue-800'" x-text="p.umur + ' Thn'"></span>
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
<script>
function manageHalaqoh() {
    return {
        activeTab: '{{ $days[0] ?? '' }}',
        showModal: false,
        modalDay: '',
        modalProgram: '',
        modalKbm: '',
        modalPengajar: '',
        pesertaList: [],

        loadPeserta(reference, day, program, kbm, pengajar) {
            this.modalDay = day;
            this.modalProgram = program;
            this.modalKbm = kbm;
            this.modalPengajar = pengajar;
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
