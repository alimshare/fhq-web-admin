<header class="sticky top-0 z-30 bg-white border-b border-gray-200">
    <div class="flex h-16 items-center justify-between px-4 sm:px-6 lg:px-8">

        {{-- Mobile menu button --}}
        <button @click="sidebarOpen = !sidebarOpen"
                type="button"
                class="lg:hidden -m-2.5 p-2.5 text-gray-700 hover:text-gray-900">
            <span class="sr-only">Open sidebar</span>
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>

        {{-- Left side --}}
        <div class="flex items-center gap-x-4">
            <h1 class="text-lg font-semibold text-gray-900 hidden sm:block">
                @yield('page-title', 'Dashboard')
            </h1>
        </div>

        {{-- Right side --}}
        <div class="flex items-center gap-x-4">
            @if(Session::has('semesterActive'))
                <span class="badge-info">
                    Semester {{ Session::get('semesterActive')->name }}
                </span>
            @endif

            {{-- User dropdown --}}
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="flex items-center gap-x-2 text-sm text-gray-700 hover:text-gray-900">
                    <img src="/images/user-default.png" alt="avatar" class="h-8 w-8 rounded-full bg-gray-100 object-cover">
                    <span class="hidden sm:block font-medium">{{ Auth::user()->name }}</span>
                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>

                <div x-show="open"
                     @click.away="open = false"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-48 origin-top-right rounded-lg bg-white py-1 shadow-lg ring-1 ring-gray-900/5">
                    <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profile</a>
                    <a href="/change-password" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Ubah Password</a>
                    <div class="border-t border-gray-100"></div>
                    <a href="#" onclick="logout(); return false;" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-50">Log Out</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                </div>
            </div>
        </div>

    </div>
</header>
