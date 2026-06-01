{{-- Mobile sidebar --}}
<aside x-show="sidebarOpen"
       x-transition:enter="transition ease-in-out duration-300 transform"
       x-transition:enter-start="-translate-x-full"
       x-transition:enter-end="translate-x-0"
       x-transition:leave="transition ease-in-out duration-300 transform"
       x-transition:leave-start="translate-x-0"
       x-transition:leave-end="-translate-x-full"
       class="fixed inset-y-0 left-0 z-50 w-64 lg:hidden flex flex-col overflow-y-auto">
    @include('layouts.tailwind.sidebar-content')
</aside>

{{-- Desktop sidebar --}}
<aside class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-64 lg:flex-col">
    @include('layouts.tailwind.sidebar-content')
</aside>
