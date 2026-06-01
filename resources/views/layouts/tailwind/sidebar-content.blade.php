<div class="flex h-full grow flex-col overflow-y-auto bg-sidebar px-4 pb-4">

    {{-- Logo --}}
    <div class="flex h-16 shrink-0 items-center gap-x-3 border-b border-white/10 px-2">
        <img src="{{ env('APP_SETTING_LOGO', '/images/logo_web.png') }}" alt="logo" class="h-8 w-auto">
        <span class="text-white font-bold text-lg">{{ env('APP_NAME', 'FHQ') }}</span>
    </div>

    {{-- User info --}}
    <div class="flex items-center gap-x-3 px-2 py-4 border-b border-white/10">
        <img src="/images/user-default.png" alt="avatar" class="h-10 w-10 rounded-full bg-white/10 object-cover">
        <div class="min-w-0">
            <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
            <p class="text-xs text-gray-400 truncate">NIP: {{ Auth::user()->profile->nip }}</p>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="mt-4 flex flex-1 flex-col">
        <ul role="list" class="flex flex-1 flex-col gap-y-1">

            {{-- Profile --}}
            <li>
                <a href="/profile"
                   class="group flex items-center gap-x-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-300 hover:bg-sidebar-hover hover:text-white {{ request()->is('profile*') ? 'bg-sidebar-hover text-white' : '' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                    Profile
                </a>
            </li>

            {{-- Absensi --}}
            <li>
                <a href="/absensi"
                   class="group flex items-center gap-x-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-300 hover:bg-sidebar-hover hover:text-white {{ request()->is('absensi*') ? 'bg-sidebar-hover text-white' : '' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15a2.25 2.25 0 012.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                    </svg>
                    Absensi
                </a>
            </li>

            {{-- Riwayat Halaqoh --}}
            @allow('list-halaqoh')
            <li>
                <a href="/halaqoh"
                   class="group flex items-center gap-x-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-300 hover:bg-sidebar-hover hover:text-white {{ request()->is('halaqoh') ? 'bg-sidebar-hover text-white' : '' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                    Riwayat Halaqoh
                </a>
            </li>
            @endallow

            {{-- Halaqoh Aktif --}}
            <li>
                <a href="/halaqoh/manage"
                   class="group flex items-center gap-x-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-300 hover:bg-sidebar-hover hover:text-white {{ request()->is('halaqoh/manage') ? 'bg-sidebar-hover text-white' : '' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                    </svg>
                    Halaqoh Aktif
                </a>
            </li>

            @allow('edit-halaqoh')
            {{-- Peserta Aktif --}}
            <li>
                <a href="/halaqoh/manage/v2"
                   class="group flex items-center gap-x-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-300 hover:bg-sidebar-hover hover:text-white {{ request()->is('halaqoh/manage/v2') ? 'bg-sidebar-hover text-white' : '' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                    Peserta Aktif
                </a>
            </li>

            {{-- Manajemen Halaqoh (collapsible) --}}
            <li x-data="{ expanded: {{ request()->is('halaqoh/add*') || request()->is('halaqoh/peserta*') || request()->is('halaqoh/pindah*') ? 'true' : 'false' }} }">
                <button @click="expanded = !expanded"
                        class="group flex w-full items-center justify-between rounded-lg px-3 py-2 text-sm font-medium text-gray-300 hover:bg-sidebar-hover hover:text-white">
                    <span class="flex items-center gap-x-3">
                        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                        </svg>
                        Manajemen Halaqoh
                    </span>
                    <svg :class="expanded ? 'rotate-90' : ''" class="h-4 w-4 shrink-0 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </button>
                <ul x-show="expanded" x-collapse class="mt-1 space-y-1 pl-10">
                    <li><a href="{{ route('halaqoh.add') }}" class="block rounded-lg px-3 py-1.5 text-sm text-gray-400 hover:bg-sidebar-hover hover:text-white">Tambah Halaqoh</a></li>
                    <li><a href="{{ route('halaqoh.peserta.add') }}" class="block rounded-lg px-3 py-1.5 text-sm text-gray-400 hover:bg-sidebar-hover hover:text-white">Tambah Peserta</a></li>
                    <li><a href="{{ route('halaqoh.pindah') }}" class="block rounded-lg px-3 py-1.5 text-sm text-gray-400 hover:bg-sidebar-hover hover:text-white">Pindah Halaqoh</a></li>
                    <li><a href="{{ route('halaqoh.peserta.cuti') }}" class="block rounded-lg px-3 py-1.5 text-sm text-gray-400 hover:bg-sidebar-hover hover:text-white">Santri Cuti</a></li>
                </ul>
            </li>
            @endallow

            {{-- Manajemen Semester --}}
            @allow('list-semester')
            <li x-data="{ expanded: {{ request()->is('semester*') ? 'true' : 'false' }} }">
                <button @click="expanded = !expanded"
                        class="group flex w-full items-center justify-between rounded-lg px-3 py-2 text-sm font-medium text-gray-300 hover:bg-sidebar-hover hover:text-white">
                    <span class="flex items-center gap-x-3">
                        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                        Manajemen Semester
                    </span>
                    <svg :class="expanded ? 'rotate-90' : ''" class="h-4 w-4 shrink-0 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </button>
                <ul x-show="expanded" x-collapse class="mt-1 space-y-1 pl-10">
                    <li><a href="{{ route('semester') }}" class="block rounded-lg px-3 py-1.5 text-sm text-gray-400 hover:bg-sidebar-hover hover:text-white">Semester</a></li>
                </ul>
            </li>
            @endallow

            {{-- DU & PSB --}}
            @if(env('ENABLE_PSB_DU'))
                @allow('rekap-nilai.view')
                <li x-data="{ expanded: {{ request()->is('du*') || request()->is('psb*') ? 'true' : 'false' }} }">
                    <button @click="expanded = !expanded"
                            class="group flex w-full items-center justify-between rounded-lg px-3 py-2 text-sm font-medium text-gray-300 hover:bg-sidebar-hover hover:text-white">
                        <span class="flex items-center gap-x-3">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                            Manajemen DU & PSB
                        </span>
                        <svg :class="expanded ? 'rotate-90' : ''" class="h-4 w-4 shrink-0 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </button>
                    <ul x-show="expanded" x-collapse class="mt-1 space-y-1 pl-10">
                        <li><a href="{{ route('du') }}" class="block rounded-lg px-3 py-1.5 text-sm text-gray-400 hover:bg-sidebar-hover hover:text-white">Peserta Daftar Ulang</a></li>
                        @if(Session::has('semesterActive'))
                            <li><a target="_blank" href="{{ route('public.du.form', ['semester'=> Session::get('semesterActive')->id, 'hash'=> env('PSB_SECURITY_HASH') ]) }}" class="block rounded-lg px-3 py-1.5 text-sm text-gray-400 hover:bg-sidebar-hover hover:text-white">Form Daftar Ulang</a></li>
                        @endif
                        <li><a href="{{ route('psb') }}" class="block rounded-lg px-3 py-1.5 text-sm text-gray-400 hover:bg-sidebar-hover hover:text-white">Daftar Calon Santri</a></li>
                    </ul>
                </li>
                @endallow
            @endif

            {{-- Divider --}}
            <li class="my-2"><div class="border-t border-white/10"></div></li>

            {{-- Pengajar --}}
            @allow('list-pengajar')
            <li>
                <a href="/pengajar"
                   class="group flex items-center gap-x-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-300 hover:bg-sidebar-hover hover:text-white {{ request()->is('pengajar*') ? 'bg-sidebar-hover text-white' : '' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                    </svg>
                    Pengajar
                </a>
            </li>
            @endallow

            {{-- Santri --}}
            @allow('list-santri')
            <li>
                <a href="/santri"
                   class="group flex items-center gap-x-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-300 hover:bg-sidebar-hover hover:text-white {{ request()->is('santri*') ? 'bg-sidebar-hover text-white' : '' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                    Santri
                </a>
            </li>
            @endallow

            {{-- Program --}}
            @allow('list-program')
            <li>
                <a href="/program"
                   class="group flex items-center gap-x-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-300 hover:bg-sidebar-hover hover:text-white {{ request()->is('program*') ? 'bg-sidebar-hover text-white' : '' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                    </svg>
                    Program
                </a>
            </li>
            @endallow

            {{-- Lembaga --}}
            @allow('list-lembaga')
            <li>
                <a href="/lembaga"
                   class="group flex items-center gap-x-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-300 hover:bg-sidebar-hover hover:text-white {{ request()->is('lembaga*') ? 'bg-sidebar-hover text-white' : '' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5M3.75 3v18m16.5-18v18M5.25 3h13.5M5.25 21V7.5M18.75 21V7.5m-13.5 0h13.5m-13.5 0v6m13.5-6v6M9 10.5h.008v.008H9V10.5zm3 0h.008v.008H12V10.5zm3 0h.008v.008H15V10.5z" />
                    </svg>
                    Lembaga
                </a>
            </li>
            @endallow

            {{-- Divider --}}
            <li class="my-2"><div class="border-t border-white/10"></div></li>

            {{-- Role --}}
            @allow('list-role')
            <li>
                <a href="/role"
                   class="group flex items-center gap-x-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-300 hover:bg-sidebar-hover hover:text-white {{ request()->is('role*') ? 'bg-sidebar-hover text-white' : '' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                    </svg>
                    Role
                </a>
            </li>
            @endallow

            {{-- Users --}}
            @allow('users')
            <li>
                <a href="{{ route('users') }}"
                   class="group flex items-center gap-x-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-300 hover:bg-sidebar-hover hover:text-white {{ request()->is('users*') ? 'bg-sidebar-hover text-white' : '' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                    Users
                </a>
            </li>
            @endallow

            {{-- Divider --}}
            <li class="my-2"><div class="border-t border-white/10"></div></li>

            {{-- Monitor --}}
            @allow('rekap-nilai.view')
            <li x-data="{ expanded: {{ request()->is('rekap*') ? 'true' : 'false' }} }">
                <button @click="expanded = !expanded"
                        class="group flex w-full items-center justify-between rounded-lg px-3 py-2 text-sm font-medium text-gray-300 hover:bg-sidebar-hover hover:text-white">
                    <span class="flex items-center gap-x-3">
                        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                        </svg>
                        Monitor
                    </span>
                    <svg :class="expanded ? 'rotate-90' : ''" class="h-4 w-4 shrink-0 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </button>
                <ul x-show="expanded" x-collapse class="mt-1 space-y-1 pl-10">
                    <li><a href="{{ route('rekap.nilai') }}" class="block rounded-lg px-3 py-1.5 text-sm text-gray-400 hover:bg-sidebar-hover hover:text-white">Rekap Nilai</a></li>
                    <li><a href="{{ route('rekap.kbm') }}" class="block rounded-lg px-3 py-1.5 text-sm text-gray-400 hover:bg-sidebar-hover hover:text-white">Rekap KBM</a></li>
                    <li><a href="{{ route('rekap.kehadiran') }}" class="block rounded-lg px-3 py-1.5 text-sm text-gray-400 hover:bg-sidebar-hover hover:text-white">Rekap Kehadiran</a></li>
                </ul>
            </li>
            @endallow

            {{-- Divider --}}
            <li class="my-2"><div class="border-t border-white/10"></div></li>

            {{-- Ubah Password --}}
            @allow('change-password')
            <li>
                <a href="/change-password"
                   class="group flex items-center gap-x-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-300 hover:bg-sidebar-hover hover:text-white">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                    </svg>
                    Ubah Password
                </a>
            </li>
            @endallow

            {{-- Panduan --}}
            @if(!empty(env('GUIDE_URL')))
            <li>
                <a href="{{ env('GUIDE_URL', '#') }}" target="_blank"
                   class="group flex items-center gap-x-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-300 hover:bg-sidebar-hover hover:text-white">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
                    Panduan
                </a>
            </li>
            @endif

            {{-- Logout --}}
            <li class="mt-auto">
                <a href="#" onclick="logout(); return false;"
                   class="group flex items-center gap-x-3 rounded-lg px-3 py-2 text-sm font-medium text-red-400 hover:bg-red-500/10 hover:text-red-300">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                    </svg>
                    Log Out
                </a>
                <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
            </li>

        </ul>
    </nav>

</div>
