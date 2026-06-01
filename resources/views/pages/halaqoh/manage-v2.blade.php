@extends('layouts.tailwind')

@section('title', 'Manage Peserta')

@section('content')

{{-- Breadcrumb --}}
<nav class="mb-6">
    <ol class="flex items-center gap-x-2 text-sm text-gray-500">
        <li><a href="/" class="hover:text-primary-600">Dashboard</a></li>
        <li><span class="text-gray-300">/</span></li>
        <li class="text-gray-900 font-medium">Manage Peserta</li>
    </ol>
</nav>

<div x-data="managePeserta()" class="space-y-6">

    {{-- Filters --}}
    <div class="card">
        <form action="" method="get" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 items-end">
            <div>
                <label for="filter-semester" class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                <select name="semester_id" id="filter-semester" class="input-field">
                    <option value="">- Pilih Semester -</option>
                    @foreach ($semesterList as $item)
                        <option value="{{ $item->id }}" {{ request('semester_id') == $item->id ? 'selected' : '' }}>Semester {{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="filter-gender" class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                <select name="gender" id="filter-gender" class="input-field">
                    <option value="">- Pilih Jenis Kelamin -</option>
                    <option value="MALE" {{ request('gender') == 'MALE' ? 'selected' : '' }}>IKHWAN</option>
                    <option value="FEMALE" {{ request('gender') == 'FEMALE' ? 'selected' : '' }}>AKHWAT</option>
                </select>
            </div>
            <div>
                <label for="filter-kbm" class="block text-sm font-medium text-gray-700 mb-1">Jenis KBM</label>
                <select name="kbm" id="filter-kbm" class="input-field">
                    <option value="">- Pilih Jenis KBM -</option>
                    <option value="OFFLINE" {{ request('kbm') == 'OFFLINE' ? 'selected' : '' }}>OFFLINE</option>
                    <option value="ONLINE" {{ request('kbm') == 'ONLINE' ? 'selected' : '' }}>ONLINE</option>
                </select>
            </div>
            <div>
                <label for="filter-program" class="block text-sm font-medium text-gray-700 mb-1">Program</label>
                <select name="program" id="filter-program" class="input-field">
                    <option value="">- Pilih Program -</option>
                    @foreach ($programList as $item)
                        <option value="{{ $item->id }}" {{ request('program') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" class="btn-primary w-full sm:w-auto">Pilih</button>
            </div>
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
                        @isset($halaqoh[$o->id])
                            @foreach($halaqoh[$o->id] as $h)
                            <div class="rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                                {{-- Header --}}
                                <div class="{{ @$h->gender == 'FEMALE' ? 'bg-pink-500' : 'bg-primary-600' }} text-white px-4 py-3">
                                    <div class="flex items-start justify-between gap-2">
                                        <div class="min-w-0">
                                            <h4 class="font-medium text-sm leading-relaxed truncate">{{ $o->name }} - {{ $h->pengajar ?? "Belum Ditentukan" }}</h4>
                                            <p class="text-xs mt-0.5 opacity-80">{{ $h->peserta_count ?? 0 }} Peserta</p>
                                        </div>
                                        @allow('admin::manage::halaqoh')
                                        <div class="flex items-center gap-1 shrink-0">
                                            <a href="/halaqoh/{{ $h->reference }}" class="flex items-center justify-center h-7 w-7 rounded-full bg-white/20 hover:bg-white/30 transition-colors" title="Lihat">
                                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                                            </a>
                                            <a href="/halaqoh/add?hari={{ $day }}&program={{ $o->id }}&kbm={{ $h->jenis_kbm }}&gender={{ $h->gender }}&ref=/halaqoh/manage/v2" class="flex items-center justify-center h-7 w-7 rounded-full bg-white/20 hover:bg-white/30 transition-colors" title="Tambah">
                                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" /></svg>
                                            </a>
                                            <a href="/halaqoh/{{ $h->reference }}/edit-data?ref=halaqoh.manage.v2" class="flex items-center justify-center h-7 w-7 rounded-full bg-white/20 hover:bg-white/30 transition-colors" title="Setting">
                                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                            </a>
                                        </div>
                                        @endallow
                                    </div>
                                    @if(strtoupper($h->jenis_kbm) == "ONLINE")
                                        <span class="inline-flex items-center mt-1 px-2 py-0.5 rounded text-[10px] font-medium bg-green-400 text-white">Online</span>
                                    @endif
                                </div>

                                {{-- Peserta List --}}
                                <ul class="divide-y divide-gray-100 max-h-[270px] overflow-y-auto"
                                    id="collection-{{ $h->reference }}"
                                    data-ref="{{ $h->reference }}">
                                    @foreach($h->peserta as $peserta)
                                    <li class="px-4 py-2 hover:bg-gray-50"
                                        @allow('admin::manage::halaqoh') draggable="true" @endallow
                                        id="collection-item-{{ $peserta->peserta_reference }}"
                                        data-ref="{{ $peserta->peserta_reference }}">
                                        <div class="flex items-center justify-between gap-2">
                                            <span class="text-sm text-gray-700 truncate">{{ $peserta->santri_name }}</span>
                                            @allow('rekap-nilai.view')
                                            <span class="badge shrink-0 {{ $peserta->gender == 'FEMALE' ? 'bg-pink-100 text-pink-800' : 'bg-blue-100 text-blue-800' }}">
                                                {{ $peserta->umur }} Thn
                                            </span>
                                            @endallow
                                        </div>
                                    </li>
                                    @endforeach

                                    @allow('admin::manage::halaqoh')
                                    <li class="px-4 py-2 text-center">
                                        <a href="{{ route('halaqoh.peserta.add', ['halaqohId' => $h->reference]) }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">(+) Tambah Peserta</a>
                                    </li>
                                    @endallow
                                </ul>
                            </div>
                            @endforeach
                        @endisset
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection

@section('header-style')
<style>
    [x-cloak] { display: none !important; }
    .drag-over { outline: 2px dashed #00bcd4; outline-offset: -2px; }
</style>
@endsection

@section('footer-script')
<script>
function managePeserta() {
    return {
        activeTab: '{{ $days[0] ?? '' }}',

        init() {
            this.setupDragDrop();
        },

        setupDragDrop() {
            let draggedItem = null;

            document.querySelectorAll('[draggable="true"]').forEach(item => {
                item.addEventListener('dragstart', (e) => {
                    draggedItem = item;
                    setTimeout(() => item.style.opacity = '0.4', 0);
                });

                item.addEventListener('dragend', () => {
                    setTimeout(() => {
                        if (draggedItem) draggedItem.style.opacity = '1';
                        draggedItem = null;
                    }, 0);
                });
            });

            document.querySelectorAll('ul[data-ref]').forEach(list => {
                list.addEventListener('dragover', (e) => e.preventDefault());
                list.addEventListener('dragenter', (e) => {
                    e.preventDefault();
                    list.classList.add('drag-over');
                });
                list.addEventListener('dragleave', () => list.classList.remove('drag-over'));
                list.addEventListener('drop', () => {
                    list.classList.remove('drag-over');
                    if (draggedItem) {
                        let pesertaRef = draggedItem.getAttribute("data-ref");
                        let halaqohRef = list.getAttribute("data-ref");

                        let btn = document.createElement("button");
                        btn.innerHTML = "Save";
                        btn.className = "ml-2 inline-flex items-center px-2 py-1 text-xs font-medium rounded bg-green-500 text-white hover:bg-green-600";
                        btn.setAttribute("data-peserta-ref", pesertaRef);
                        btn.setAttribute("data-halaqoh-ref", halaqohRef);
                        btn.addEventListener('click', (el) => {
                            fetch("/api/peserta/" + el.target.getAttribute("data-peserta-ref") + "/pindah/" + el.target.getAttribute("data-halaqoh-ref"))
                                .then(res => res.json())
                                .then(() => { btn.style.display = "none"; });
                        });

                        draggedItem.querySelector('div').appendChild(btn);
                        list.appendChild(draggedItem);
                    }
                });
            });
        }
    };
}
</script>
@endsection
